<?php
use OTPHP\TOTP;
class AuthController {
  private function generateCsrf() {
    if (empty($_SESSION['csrf'])) {
      $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
  }
  private function validateCsrf() {
    if (empty($_POST['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
      throw new Exception('Invalid CSRF token');
    }
  }
  public function register() {
    $this->generateCsrf();
    \$errors = [];
    if (\$_SERVER['REQUEST_METHOD']==='POST') {
      try {
        \$this->validateCsrf();
        \$login = trim(\$_POST['login']);
        \$email = trim(\$_POST['email']);
        \$pass  = \$_POST['password'];
        // login validation
        if (!preg_match('/^[A-Za-z_]{1,10}$/', \$login)) {
          \$errors['login']='Логин: 1–10 лат. букв или _.';
        } elseif (User::exists('login',\$login)) {
          \$errors['login']='Этот логин уже существует.';
        }
        // email
        if (!filter_var(\$email, FILTER_VALIDATE_EMAIL)) {
          \$errors['email']='Неверный формат почты.';
        } elseif (User::exists('email',\$email)) {
          \$errors['email']='Эта почта уже зарегистрирована.';
        }
        // password
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])[A-Za-z_]{10,15}\$/',\$pass)) {
          \$errors['password']='Пароль: 10–15 A-Z/a-z/_, с загл. и строч. буквами.';
        }
        if (empty(\$errors)) {
          \$user=new User();
          \$user->login=\$login;
          \$user->email=\$email;
          \$user->password=password_hash(\$pass, PASSWORD_ARGON2ID);
          // MFA secret
          \$totp=TOTP::create();
          \$user->mfa_secret=\$totp->getSecret();
          \$user->save();
          header('Location:/login?registered=1');exit;
        }
      } catch(Exception \$e) {
        \$errors['csrf']=\$e->getMessage();
      }
    }
    View::render('auth/register',['errors'=>\$errors]);
  }
  public function login() {
    \$limiter=new RateLimiter(Database::get());
    \$ip=\$_SERVER['REMOTE_ADDR'];
    if (\$limiter->tooManyAttempts(\$ip)) {
      View::render('auth/login',['errors'=>['auth'=>'Слишком много попыток.']]);return;
    }
    \$this->generateCsrf();\$errors=[];
    if (\$_SERVER['REQUEST_METHOD']==='POST') {
      try {
        \$this->validateCsrf();
        \$ident=trim(\$_POST['login_or_email']);
        \$pass=\$_POST['password'];
        \$user=User::findByLoginOrEmail(\$ident);
        if (\$user && password_verify(\$pass,\$user->password)) {
          \$limiter->clearAttempts(\$ip);
          // if MFA enabled
          if (!empty(\$user->mfa_secret)) {
            if (!TOTP::create(\$user->mfa_secret)->verify(\$_POST['mfa'])) {
              \$errors['mfa']='Неверный код 2FA.';
            }
          }
          if (empty(\$errors)) {
            session_regenerate_id(true);
            \$_SESSION['user_id']=\$user->id;
            \$_SESSION['role']=\$user->role;
            Logger::get()->info('User login',['id'=>\$user->id]);
            header('Location:/');exit;
          }
        } else {
          \$limiter->hit(\$ip);
          \$errors['auth']='Неверный логин или пароль.';
        }
      } catch(Exception \$e) {
        \$errors['csrf']=\$e->getMessage();
      }
    }
    View::render('auth/login',['errors'=>\$errors]);
  }
  public function logout() {
    session_destroy();header('Location:/');exit;
  }
}
?>