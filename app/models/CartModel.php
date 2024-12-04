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
    public function getCartItems($cart_id)
    {
        $query = "SELECT ci.product_id, p.name, p.image, ci.quantity, p.price
                  FROM cart ci
                  JOIN product p ON ci.product_id = p.id
                  WHERE ci.id = :cart_id";

        $stmt = $this->conn->prepare($query); // Sử dụng $this->conn thay vì $this->db
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($session_id, $product_id, $quantity)
    {
        // Kiểm tra xem giỏ hàng đã có sản phẩm chưa, nếu có thì chỉ cần cập nhật
        $query = "INSERT INTO cart (session_id, product_id, quantity) VALUES (:session_id, :product_id, :quantity)";

        $stmt = $this->conn->prepare($query);

        // Bind các tham số vào query
        $stmt->bindParam(':session_id', $session_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);

        // Thực thi câu lệnh và kiểm tra nếu thành công
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


}
