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
        // Kiểm tra giỏ hàng
        $cartItems = $this->cartModel->getCartItems($_SESSION['cart_id']);  // Lấy danh sách sản phẩm trong giỏ hàng

        // Bao gồm file view giỏ hàng
        include 'app/views/cart/view.php';
    }
}
