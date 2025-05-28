<?php
class User {
  public $id, $login, $email, $password, $role, $mfa_secret;
  public static function findByLoginOrEmail(string $value) {
    $pdo = Database::get();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :v OR email = :v LIMIT 1");
    $stmt->execute(['v' => $value]);
    $data = $stmt->fetch();
    if (!$data) return null;
    $u = new User();
    foreach ($data as $k => $v) $u->{$k} = $v;
    return $u;
  }
  public static function exists(string $field, string $value): bool {
    $pdo = Database::get();
    $stmt = $pdo->prepare("SELECT 1 FROM users WHERE {$field} = :v LIMIT 1");
    $stmt->execute(['v' => $value]);
    return (bool)$stmt->fetch();
  }
  public function save(): bool {
    $pdo = Database::get();
    $stmt = $pdo->prepare(
      "INSERT INTO users (login, email, password, role, mfa_secret) VALUES (:login, :email, :pwd, 'user', :mfa)"
    );
    return $stmt->execute([
      'login' => $this->login,
      'email' => $this->email,
      'pwd'   => $this->password,
      'mfa'   => $this->mfa_secret
    ]);
  }
}
?>