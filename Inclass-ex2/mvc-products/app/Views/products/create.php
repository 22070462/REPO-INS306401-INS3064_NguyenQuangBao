<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo sản phẩm mới</title>
    <style> body { font-family: Arial; margin: 40px; } </style>
</head>
<body>
    <h1>Tạo sản phẩm mới</h1>
    
    <form method="POST" action="/products/create">
        <label>Tên sản phẩm:<br>
            <input type="text" name="name" required style="width:300px"><br><br>
        </label>
        
        <label>Giá (VND):<br>
            <input type="number" name="price" required style="width:300px"><br><br>
        </label>
        
        <button type="submit">Tạo sản phẩm</button>
    </form>
    
    <br>
    <a href="/products">← Quay lại danh sách</a>
</body>
</html>
