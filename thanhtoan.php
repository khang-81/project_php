<?php
@session_start();

include('admincp/modules/config.php');

// Kiểm tra session đăng nhập
if (!isset($_SESSION['dangnhap'])) {
    header('Location: index.php?quanly=dangnhap');
    exit();
}

// Lấy tên người dùng từ session
$name = htmlspecialchars($_SESSION['dangnhap']); // Bảo vệ chống XSS

// Kiểm tra giỏ hàng
if (!isset($_SESSION['product']) || empty($_SESSION['product'])) {
    header('Location: index.php?quanly=dathang');
    exit();
}

// Thêm dữ liệu vào bảng cart
$insert_cart = "INSERT INTO cart (fullname) VALUES (?)";
$stmt_cart = $conn->prepare($insert_cart);
$stmt_cart->bind_param("s", $name); // "s" là kiểu string
$ketqua = $stmt_cart->execute();

if ($ketqua) {
    // Lấy ID của bản ghi vừa thêm vào bảng cart
    $cart_id = $conn->insert_id; // Lấy ID tự động tăng, thay vì SELECT MAX(id)

    // Thêm chi tiết giỏ hàng vào bảng cart_detail
    $insert_cart_detail = "INSERT INTO cart_detail (cart_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_detail = $conn->prepare($insert_cart_detail);

    foreach ($_SESSION['product'] as $cart_item) {
        $product_id = intval($cart_item['id']); // Chuyển id thành số nguyên
        $quantity = max(1, intval($cart_item['soluong'])); // Đảm bảo số lượng >= 1
        $price = floatval($cart_item['gia']); // Chuyển giá thành số thực

        // Liên kết tham số với prepared statement
        $stmt_detail->bind_param("iiid", $cart_id, $product_id, $quantity, $price); // "iiid" là kiểu: int, int, int, double
        $stmt_detail->execute();

        if ($stmt_detail->error) {
            echo "Lỗi khi thêm chi tiết giỏ hàng: " . $stmt_detail->error;
            exit();
        }
    }

    $stmt_detail->close();
} else {
    echo "Lỗi khi thêm giỏ hàng: " . $stmt_cart->error;
    exit();
}

// Xóa giỏ hàng sau khi lưu vào cơ sở dữ liệu
unset($_SESSION['product']);

// Chuyển hướng đến trang cảm ơn
header('Location: index.php?quanly=camon');
exit();

// Đóng statement và kết nối
$stmt_cart->close();
$conn->close();
?>