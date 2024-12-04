<?php
require_once('app/models/CartModel.php');
require_once('app/config/Database.php');
class CartController
{
    private $cartModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->cartModel = new CartModel((new Database())->getConnection());
    }

    // Hiển thị giỏ hàng
    public function view()
    {
        if (!isset($_SESSION['session_id'])) {
            // Nếu chưa, tạo một session_id ngẫu nhiên hoặc lấy từ cookie
            $_SESSION['session_id'] = session_id();  // Hoặc có thể sử dụng một giá trị ngẫu nhiên khác
        }

        // Lấy danh sách sản phẩm trong giỏ hàng
        $cartItems = $this->cartModel->getCartItems($_SESSION['session_id']);

        // Bao gồm file view giỏ hàng
        include 'app/views/cart/view.php';
    }
}
