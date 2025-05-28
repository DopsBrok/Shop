<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apple Shop</title>
  <!-- Подключаем стили от корня public/ -->
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <header>
    <div class="container" style="
         display: flex;
         justify-content: space-between;
         align-items: center;
         height: 50px;
         position: relative;
         bottom: 13px;
      ">
      <div class="header__logo" role="img" aria-label="Логотип">
        <a href="/"><img src="/assets/images/svg/Logo.svg" alt="Логотип"></a>
      </div>
      <nav class="header__nav" aria-label="Главная навигация" style="display: flex; gap: 20px;">
        <a href="/"            class="nav__link">Магазин</a>
        <a href="/mac"         class="nav__link">Mac</a>
        <a href="/iphone"      class="nav__link">iPhone</a>
        <a href="/ipad"        class="nav__link">iPad</a>
        <a href="/watch"       class="nav__link">Watch</a>
        <a href="/airpods"     class="nav__link">AirPods</a>
        <a href="/accessories" class="nav__link">Аксессуары</a>
        <a href="/support"     class="nav__link">Поддержка</a>
        <!-- Иконки поисковика, корзины и аккаунта -->
        <a href="#" class="nav__icon" aria-label="Поиск">
          <img src="/assets/images/svg/search.svg" alt="Поиск">
        </a>
        <a href="/cart" class="nav__icon" aria-label="Корзина">
          <img src="/assets/images/svg/cart.svg" alt="Корзина">
        </a>
        <a href="#" id="authTrigger" class="nav__icon" aria-label="Аккаунт">
          <img src="/assets/images/svg/user.svg" alt="Аккаунт">
        </a>
      </nav>
    </div>
  </header>

  <main>
    <?= $content ?>
  </main>

  <footer>
    <div class="footer__top container">
      <a href="/" class="footer__logo"><img src="/assets/images/svg/Logo.svg" alt="Логотип"></a>
      <nav class="footer__nav">
        <a href="/mac"         class="footer__link">Mac</a>
        <a href="/iphone"      class="footer__link">iPhone</a>
        <a href="/ipad"        class="footer__link">iPad</a>
        <a href="/watch"       class="footer__link">Watch</a>
        <a href="/airpods"     class="footer__link">AirPods</a>
        <a href="/accessories" class="footer__link">Аксессуары</a>
        <a href="/support"     class="footer__link">Поддержка</a>
      </nav>
    </div>
    <div class="footer__bottom container">
      <p>© 2025 Apple Shop. Все права защищены.</p>
      <nav class="footer__social">
        <a href="#" class="social__link"><img src="/assets/images/svg/vk.svg" alt="VK"></a>
        <a href="#" class="social__link"><img src="/assets/images/svg/instagram.svg" alt="Instagram"></a>
        <a href="#" class="social__link"><img src="/assets/images/svg/youtube.svg" alt="YouTube"></a>
      </nav>
    </div>
  </footer>

  <!-- Подключаем скрипт модалки и остальной JS -->
  <script src="/assets/js/script.js"></script>
</body>
</html>