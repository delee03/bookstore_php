<?php

class ProductModel
{

    private $conn;
    // private $cartModel;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;

    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.image, p.price, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Xây dựng đường dẫn ảnh đầy đủ
        foreach ($result as $product) {
            $product->image_url = !empty($product->image) ? '/webbanhang/uploads/' . $product->image : '/webbanhang/uploads/default-image.jpg';
        }

        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        // Xây dựng đường dẫn ảnh đầy đủ
        $result->image_url = !empty($result->image) ? '/webbanhang/uploads/' . $result->image : '/webbanhang/uploads/default-image.jpg';

        return $result;
    }

    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image)
                  VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $price, $category_id, $image = null)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, description = :description, price = :price, category_id = :category_id";

        if (!empty($image)) {
            $query .= ", image = :image";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);

        if (!empty($image)) {
            $stmt->bindParam(':image', $image);
        }

        return $stmt->execute();
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
