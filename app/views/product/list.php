<?php include 'app/views/shares/header.php'; ?>
<h1>Danh sách sản phẩm</h1>
<a href="/webbanhang/Product/add" class="btn btn-success mb-2">Thêm sản phẩm mới</a>
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
                <td>
                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </td>
                <td><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <?php if (!empty($product->image)): ?>
                        <?php $image_url = "http://localhost:81/webbanhang/" . htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>
                        <p>URL ảnh: <?php echo $image_url; ?></p>
                        <img src="<?php echo $image_url; ?>" alt="Product Image" width="100">
                    <?php else: ?>
                        <p>URL ảnh: http://localhost:81/webbanhang/default-image.jpg</p>
                        <img src="http://localhost:81/webbanhang/default-image.jpg" alt="Default Image" width="100">
                    <?php endif; ?>
                </td>



                <td><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'app/views/shares/footer.php'; ?>