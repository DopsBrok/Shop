<!-- views/home.php -->
<?php
// Если контроллер передаёт динамический массив $products, он будет использован.
// Иначе можно задать статичный пример:
$products = $products ?? [
    ['id'=>1, 'name'=>'iPhone 16 Pro',   'price'=>'119 900', 'image'=>'iphone16pro.png'],
    ['id'=>2, 'name'=>'MacBook Air M2',  'price'=>'94 990',  'image'=>'macbookair.png'],
    ['id'=>3, 'name'=>'AirPods Pro 2',   'price'=>'19 990',  'image'=>'airpodspro2.png'],
];
?>
<div class="hero">
  <div class="hero__item hero__item--large">
    <h2 class="hero__title">iPhone 16 Pro</h2>
    <div class="hero__buttons">
      <button id="buy" class="btn primary">Купить</button>
      <button id="learn" class="btn outline">Узнать подробнее</button>
    </div>
  </div>
</div>

<section class="catalog container">
  <?php foreach ($products as $product): ?>
    <div class="card">
      <img
        src="/assets/images/<?= htmlspecialchars($product['image']) ?>"
        alt="<?= htmlspecialchars($product['name']) ?>"
        class="card__image"
      >
      <h3 class="card__title"><?= htmlspecialchars($product['name']) ?></h3>
      <p class="card__price"><?= htmlspecialchars($product['price']) ?> ₽</p>
      <div class="card__actions">
        <button
          data-id="<?= (int)$product['id'] ?>"
          class="btn primary add-to-cart"
        >В корзину</button>
        <button
          data-id="<?= (int)$product['id'] ?>"
          class="btn outline view-details"
        >Подробнее</button>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<!-- Модальное окно авторизации/регистрации -->
<div id="auth-modal" class="modal hidden">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <button id="popupClose" class="modal-close" aria-label="Закрыть">×</button>

    <!-- Форма входа -->
    <form id="login-form" class="auth-form">
      <h2>Вход</h2>
      <input
        type="text"
        name="login_or_email"
        placeholder="Логин или почта"
        required
      >
      <input
        type="password"
        name="password"
        placeholder="Пароль"
        required
      >
      <button type="submit" class="btn primary">Войти</button>
      <p class="switch-text">
        Нет аккаунта?
        <a href="#" id="showRegister">Зарегистрироваться</a>
      </p>
    </form>

    <!-- Форма регистрации -->
    <form id="register-form" class="auth-form hidden">
      <h2>Регистрация</h2>
      <input
        type="text"
        name="login"
        placeholder="Логин (латинские буквы и _ , до 10 символов)"
        required
      >
      <input
        type="email"
        name="email"
        placeholder="Почта (например name@domain.com)"
        required
      >
      <input
        type="password"
        name="password"
        placeholder="Пароль (10–15 символов, A–Z/a–z/_)"
        required
      >
      <button type="submit" class="btn primary">Зарегистрироваться</button>
      <p class="switch-text">
        Уже есть аккаунт?
        <a href="#" id="showLogin">Войти</a>
      </p>
    </form>
  </div>
</div>
