<?php
class ProductController {
  private function authorize() {
    if (\$_SESSION['role']!=='admin') {http_response_code(403);exit('Доступ запрещён');}
  }
  public function index() { \$this->authorize(); View::render('admin/products/index',['products'=>Product::all()]); }
  public function create() {
    \$this->authorize();\$errors=[];
    if (\$_SERVER['REQUEST_METHOD']==='POST') {
      try {
        /... валидация .../
        Product::create(\$_POST);header('Location:/admin/products');exit;
      } catch(Exception \$e) { \$errors['save']='Ошибка сохранения'; }
    }
    View::render('admin/products/create',['errors'=>\$errors]);
  }
  public function edit() {
    \$this->authorize();\$errors=[];
    \$id=(int)\$_GET['id'];\$product=Product::find(\$id);
    if (\$_SERVER['REQUEST_METHOD']==='POST') {
      Product::update(\$id,\$_POST);header('Location:/admin/products');exit;
    }
    View::render('admin/products/edit',['product'=>\$product,'errors'=>\$errors]);
  }
  public function delete() {
    \$this->authorize();\$id=(int)\$_GET['id'];Product::delete(\$id);
    header('Location:/admin/products');exit;
  }
}
?>