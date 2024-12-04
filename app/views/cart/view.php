<h1>Giỏ Hàng</h1>

<?php if (!empty($cartItems)): ?>
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
                    <td>
                        <img src="/webbanhang/uploads/<?php echo htmlspecialchars($item->image); ?>"
                            alt="<?php echo htmlspecialchars($item->name); ?>" width="50">
                        <?php echo htmlspecialchars($item->name); ?>
                    </td>
                    <td><?php echo $item->quantity; ?></td>
                    <td><?php echo $item->price; ?> VNĐ</td>
                    <td><a href="/webbanhang/Cart/remove/<?php echo $item->product_id; ?>">Xóa</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Giỏ hàng của bạn hiện tại không có sản phẩm nào.</p>
<?php endif; ?>