<?php
require_once('app/config/database.php');

class CartModel
{
    private $conn; // Kết nối cơ sở dữ liệu
    private $table_name = "cart"; // Tên bảng chứa giỏ hàng

    // Constructor nhận vào đối tượng kết nối cơ sở dữ liệu
    public function __construct($db)
    {
        $this->conn = $db; // Khởi tạo kết nối cơ sở dữ liệu
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    public function getCartItems($session_id): mixed
    {
        $query = "SELECT ci.product_id, p.name, p.image, ci.quantity, p.price
              FROM cart ci
              JOIN product p ON ci.product_id = p.id
              WHERE ci.session_id = :session_id";  // Sử dụng session_id thay vì ci.id

        $stmt = $this->conn->prepare($query); // Sử dụng $this->conn thay vì $this->db
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($session_id, $product_id, $quantity)
    {
        // Kiểm tra xem sản phẩm này đã có trong giỏ hàng với session_id chưa
        $query = "SELECT quantity FROM cart WHERE session_id = :session_id AND product_id = :product_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':session_id', $session_id);
        $stmt->bindParam(':product_id', $product_id);

        $stmt->execute();

        // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
        if ($stmt->rowCount() > 0) {
            // Lấy số lượng hiện tại
            $existingQuantity = $stmt->fetch(PDO::FETCH_ASSOC)['quantity'];

            // Cập nhật số lượng mới
            $newQuantity = $existingQuantity + $quantity;

            $updateQuery = "UPDATE cart SET quantity = :quantity WHERE session_id = :session_id AND product_id = :product_id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $newQuantity);
            $updateStmt->bindParam(':session_id', $session_id);
            $updateStmt->bindParam(':product_id', $product_id);

            return $updateStmt->execute(); // Cập nhật số lượng
        } else {
            // Nếu sản phẩm chưa có trong giỏ, thêm mới
            $insertQuery = "INSERT INTO cart (session_id, product_id, quantity) VALUES (:session_id, :product_id, :quantity)";
            $insertStmt = $this->conn->prepare($insertQuery);

            $insertStmt->bindParam(':session_id', $session_id);
            $insertStmt->bindParam(':product_id', $product_id);
            $insertStmt->bindParam(':quantity', $quantity);

            return $insertStmt->execute(); // Thêm sản phẩm vào giỏ
        }
    }



}
