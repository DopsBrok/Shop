<?php
// 1) Подключаем конфиг и автолоадеры
require __DIR__ . '../config.php';
require __DIR__ . '../src/Core/Database.php';
require __DIR__ . '../src/Core/View.php';
require __DIR__ . '../src/Core/RateLimiter.php';
require __DIR__ . '../src/Core/Logger.php';
require __DIR__ . '../src/Model/User.php';
require __DIR__ . '../src/Model/Product.php';
require __DIR__ . '../src/Controller/AuthController.php';
require __DIR__ . '../src/Controller/Admin/ProductController.php';

// 2) Запускаем сессию
session_start();

// 3) Функция, которая встраивает view в layout
function render(string $template, array $vars = []) {
    // Подготавливаем переменные для шаблона
    extract($vars);

    // Захватываем вывод из views/<template>.php
    ob_start();
    include __DIR__ . "/../views/{$template}.php";
    $content = ob_get_clean();

    // Вставляем его в layout
    include __DIR__ . "/../views/layouts/main.php";
}

// 4) Инициализируем контроллеры
$authController    = new AuthController();
$productController = new \Admin\ProductController(); // или полное пространство имён

// 5) Простая маршрутизация на основе URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
    case '':
        render('home', [
          // здесь можно передать данные, например 'products' => Product::all()
        ]);
        break;

    case '/register':
        $authController->register();
        break;

    case '/login':
        $authController->login();
        break;

    case '/logout':
        $authController->logout();
        break;

    // Админка товаров:
    case '/admin/products':
        $productController->index();
        break;
    case '/admin/products/create':
        $productController->create();
        break;
    case '/admin/products/edit':
        $productController->edit();
        break;
    case '/admin/products/delete':
        $productController->delete();
        break;

    default:
        http_response_code(404);
        echo '404 — Страница не найдена';
        break;
}