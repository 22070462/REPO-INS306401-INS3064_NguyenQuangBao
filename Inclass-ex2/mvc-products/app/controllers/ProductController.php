<?php

class ProductController {
    public function index() {
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [
                ['id' => 1, 'name' => 'Sản phẩm 1', 'price' => 100000],
                ['id' => 2, 'name' => 'Sản phẩm 2', 'price' => 200000],
            ];
        }

        $products = $_SESSION['products'];
        require_once __DIR__ . '/../Views/products/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../Views/products/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name  = trim($_POST['name'] ?? '');
            $price = (int)($_POST['price'] ?? 0);

            if ($name !== '') {
                if (!isset($_SESSION['products'])) {
                    $_SESSION['products'] = [];
                }

                $id = count($_SESSION['products']) + 1;
                $_SESSION['products'][] = [
                    'id'    => $id,
                    'name'  => $name,
                    'price' => $price
                ];
            }
        }

        // Chuyển hướng về danh sách sau khi tạo
        header('Location: /products');
        exit;
    }
}
