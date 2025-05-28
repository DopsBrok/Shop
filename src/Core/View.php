<?php
class View {
  public static function render(string $template, array $vars = []) {
    extract($vars);
    ob_start();
    include __DIR__ . "/../../views/{$template}.php";
    $content = ob_get_clean();
    include __DIR__ . "/../../views/layouts/main.php";
  }
}
?>