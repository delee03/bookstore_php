<?php include 'app/views/shares/header.php'; ?>

<h1>Danh sách sản phẩm</h1>
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
<!-- Nút chuyển đến giỏ hàng -->
<a href="cart/view.php" class="view-cart">Xem giỏ hàng</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product->id; ?></td>
                <td><?php echo htmlspecialchars($product->name); ?></td>
                <td><?php echo htmlspecialchars($product->description); ?></td>
                <td><?php echo htmlspecialchars($product->price); ?></td>
                <td>
                    <img src="<?php echo htmlspecialchars($product->image_url); ?>" alt="Product Image" width="100">
                </td>
                <td><?php echo htmlspecialchars($product->category_name); ?></td>
                <td>
                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>

                    <!-- Thêm nút "Thêm vào giỏ hàng" -->
                    <form action="cart/view.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
                        <input type="number" name="quantity" value="1" min="1" style="width: 50px;" />
                        <button type="submit" class="btn btn-primary btn-sm">Thêm vào giỏ</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>