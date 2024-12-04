<?php
class CartModel
{
    private $conn;
    private $table_name = "cart";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addProductToCart($sessionId, $productId, $quantity)
    {
        $query = "INSERT INTO " . $this->table_name . " (session_id, product_id, quantity) VALUES (:session_id, :product_id, :quantity)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateProductInCart($sessionId, $productId, $quantity)
    {
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE session_id = :session_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    // Lấy sản phẩm trong giỏ hàng
    public function getProductInCart($sessionId, $productId)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE session_id = :session_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);  // Trả về sản phẩm nếu có
    }

    // Lấy tất cả sản phẩm trong giỏ hàng
    public function getCartItems($sessionId)
    {
        $query = "SELECT p.id, p.name, p.image, p.price, c.quantity
                  FROM " . $this->table_name . " c
                  LEFT JOIN product p ON c.product_id = p.id
                  WHERE c.session_id = :session_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
