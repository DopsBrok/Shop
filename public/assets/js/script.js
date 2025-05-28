  const accountBtn   = document.getElementById('accountBtn');
  const overlay      = document.getElementById('popupOverlay');
  const authPopup    = document.getElementById('authPopup');
  const popupClose   = document.getElementById('popupClose');
  const registerForm = document.getElementById('registerForm');
  const loginInput   = document.getElementById('regLogin');
  const emailInput   = document.getElementById('regEmail');
  const passInput    = document.getElementById('regPassword');
  const showRegister = document.getElementById('showRegister');
  const showLogin    = document.getElementById('showLogin');

  accountBtn.addEventListener('click', () => {
  // Показываем фильтр
  overlay.classList.remove('hidden');
  overlay.classList.add('show');
  // Показываем сам поп-ап
  authPopup.classList.remove('hidden');
  authPopup.classList.add('show');
  // По умолчанию показываем форму входа
  loginForm.classList.add('active-form');
  registerForm.classList.remove('active-form');
});

const closePopup = () => {
  // скрываем анимационно
  authPopup.classList.remove('show');
  overlay.classList.remove('show');
  // после 250ms (длительность transition) полностью скрываем
  setTimeout(() => {
    authPopup.classList.add('hidden');
    overlay.classList.add('hidden');
  }, 250);
};

popupClose.addEventListener('click', closePopup);
overlay.addEventListener('click', closePopup);

showRegister.addEventListener('click', e => {
  e.preventDefault();
  loginForm.classList.remove('active-form');
  registerForm.classList.add('active-form');
});
showLogin.addEventListener('click', e => {
  e.preventDefault();
  registerForm.classList.remove('active-form');
  loginForm.classList.add('active-form');
});

function showError(input, message) {
  // Убираем предыдущую ошибку (если была)
  const prev = input.nextElementSibling;
  if (prev && prev.classList.contains('validation-error')) {
    prev.remove();
  }
  // Помечаем поле
  input.classList.add('input-error');
  // Вставляем блок с сообщением
  const err = document.createElement('div');
  err.className = 'validation-error';
  err.innerText = message;
  input.insertAdjacentElement('afterend', err);
}

function clearErrors(form) {
  // Удаляем все сообщения
  form.querySelectorAll('.validation-error').forEach(el => el.remove());
  // Сбрасываем бордеры
  form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
}

// Привязываем обработчик на сабмит формы
registerForm.addEventListener('submit', function(e) {
  clearErrors(registerForm);
  let valid = true;

  const loginVal = loginInput.value.trim();

  if (!/^[A-Za-z_]{1,10}$/.test(loginVal)) {
    valid = false;
    showError(loginInput,
      'Логин введён не верно! Возможно написать только от 1 до 10 латинских букв и _.'
    );

  } else {
    const existingLogins = ['User_1'];
    if (existingLogins.includes(loginVal)) {
      valid = false;
      showError(loginInput, 'Этот логин уже занят! Укажите другой.');
    }
  }
  // Валидация ПОЧТЫ: name@domain.com, только латинские буквы + @ + точка
  const emailVal = emailInput.value.trim();
  if (!/^[A-Za-z]+@[A-Za-z]+\.[A-Za-z]+$/.test(emailVal)) {
    valid = false;
    showError(emailInput, ' Почта введена неверно! Пример написания: name@domain.com (только латинские буквы)');
  } else {
    const existingEmails = ['user@gmail.com']
      if (existingEmails.includes(emailVal)) {
    valid = false;
    showError(emailInput, 'Эта почта уже зарегистрирована! Укажите другую.');
  }
}


  if (!valid) {
    // Блокируем отправку, пока есть ошибки
    e.preventDefault();
  }
});