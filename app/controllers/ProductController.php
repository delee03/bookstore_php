<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/CartModel.php');

class ProductController
{
    private $productModel;
    private $cartModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);

        $this->cartModel = new CartModel($this->db);
    }

    // Thêm action cho giỏ hàng
    // public function cart()
    // {
    //     // Lấy giỏ hàng từ session hoặc cookie
    //     $cartItems = $this->cartModel->getCartItems();  // Giả sử CartModel có hàm getCartItems
    //     include 'app/views/cart/view.php'; // Hiển thị giỏ hàng
    // }


    // Action thêm sản phẩm vào giỏ hàng// Action thêm sản phẩm vào giỏ hàng
    public function addToCart()
    {
        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        // Kiểm tra nếu session chưa bắt đầu, hãy khởi tạo session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Lấy session_id từ session
        $session_id = session_id();

        if ($product_id) {
            // Thêm sản phẩm vào giỏ hàng và truyền thêm session_id
            $this->cartModel->addToCart($session_id, $product_id, $quantity);

            // Chuyển hướng về trang giỏ hàng sau khi thêm thành công
            header('Location: /webbanhang/cart/view'); // Điều hướng đến giỏ hàng
            exit();
        }
    }





    // Action hiển thị giỏ hàng
    public function viewCart()
    {
        // Lấy session_id từ session
        $session_id = session_id();  // Nếu đang dùng session thì lấy ID session hiện tại

        // Lấy sản phẩm trong giỏ hàng
        $cartItems = $this->cartModel->getCartItems($session_id);

        // Bao gồm file view giỏ hàng
        include 'app/views/cart/view.php';
    }



    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // Xử lý upload hình ảnh
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                $image = basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if ($result) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi thêm sản phẩm.";
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            // Xử lý upload hình ảnh
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                $image = basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
            }

            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($result) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi cập nhật sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        $result = $this->productModel->deleteProduct($id);

        if ($result) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    // public function addToCart($productId, $quantity)
    // {
    //     // Tạo một session_id duy nhất nếu chưa có
    //     if (!isset($_SESSION['cart_id'])) {
    //         $_SESSION['cart_id'] = uniqid('cart_', true);  // Tạo một ID giỏ hàng duy nhất cho mỗi session
    //     }

    //     // Kiểm tra nếu sản phẩm đã có trong giỏ hàng, nếu có, cập nhật số lượng
    //     $existingProduct = $this->cartModel->getProductInCart($_SESSION['cart_id'], $productId);
    //     if ($existingProduct) {
    //         // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
    //         $newQuantity = $existingProduct->quantity + $quantity;
    //         $this->cartModel->updateProductInCart($_SESSION['cart_id'], $productId, $newQuantity);
    //     } else {
    //         // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
    //         $this->cartModel->addProductToCart($_SESSION['cart_id'], $productId, $quantity);
    //     }

    //     echo "Sản phẩm đã được thêm vào giỏ hàng!";
    // }
}
