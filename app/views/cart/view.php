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
                    <td><a href="/cart/remove/<?php echo $item->product_id; ?>">Xóa</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Giỏ hàng của bạn hiện tại không có sản phẩm nào.</p>
<?php endif; ?>