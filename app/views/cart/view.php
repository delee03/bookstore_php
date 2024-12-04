<?php
// Giả sử $cartModel đã được khởi tạo
$cartItems = $cartModel->getCartItems($_SESSION['cart_id']);
?>

<h1>Giỏ Hàng</h1>

<?php if (count($cartItems) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><img src="/webbanhang/uploads/<?php echo $item->image; ?>" alt="<?php echo $item->name; ?>" width="50">
                        <?php echo $item->name; ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td><?php echo $item->price; ?> VNĐ</td>
                    <td><a href="remove_from_cart.php?product_id=<?php echo $item->id; ?>">Xóa</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Giỏ hàng của bạn hiện tại không có sản phẩm nào.</p>
<?php endif; ?>