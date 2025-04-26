<?php
session_start();

include('admincp/modules/config.php');

// Đăng xuất
if (isset($_GET['thoat']) && $_GET['thoat'] == 1) {
    unset($_SESSION['dangnhap']);
    header('Location: index.php?quanly=dathang');
    exit();
}

// Trừ số lượng sản phẩm
if (isset($_GET['tru'])) {
    $id = intval($_GET['tru']); // Chuyển id thành số nguyên để tăng bảo mật
    $product = [];
    foreach ($_SESSION['product'] as $cart_item) {
        if ($cart_item['id'] == $id) {
            $giam = max(1, $cart_item['soluong'] - 1); // Đảm bảo số lượng không nhỏ hơn 1
            $product[] = [
                'tensp' => $cart_item['tensp'],
                'id' => $cart_item['id'],
                'soluong' => $giam,
                'gia' => $cart_item['gia']
            ];
        } else {
            $product[] = $cart_item;
        }
    }
    $_SESSION['product'] = $product;
    header('Location: index.php?quanly=dathang');
    exit();
}

// Cộng số lượng sản phẩm
if (isset($_GET['cong'])) {
    $id = intval($_GET['cong']);
    $product = [];
    foreach ($_SESSION['product'] as $cart_item) {
        if ($cart_item['id'] == $id) {
            $tang = $cart_item['soluong'] + 1;
            $tang = min(9, $tang); // Giới hạn tối đa số lượng là 9
            $product[] = [
                'tensp' => $cart_item['tensp'],
                'id' => $cart_item['id'],
                'soluong' => $tang,
                'gia' => $cart_item['gia']
            ];
        } else {
            $product[] = $cart_item;
        }
    }
    $_SESSION['product'] = $product;
    header('Location: index.php?quanly=dathang');
    exit();
}

// Xóa sản phẩm
if (isset($_SESSION['product']) && isset($_GET['xoa'])) {
    $id = intval($_GET['xoa']);
    $product = [];
    foreach ($_SESSION['product'] as $cart_item) {
        if ($cart_item['id'] != $id) {
            $product[] = $cart_item;
        }
    }
    $_SESSION['product'] = $product;
    header('Location: index.php?quanly=dathang');
    exit();
}

// Xóa toàn bộ giỏ hàng
if (isset($_GET['xoatoanbo']) && $_GET['xoatoanbo'] == 1) {
    unset($_SESSION['product']);
    header('Location: index.php?quanly=dathang');
    exit();
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Lấy id từ GET và chuyển thành số nguyên
    $soluong = isset($_POST['soluong']) ? max(1, intval($_POST['soluong'])) : 1; // Đảm bảo số lượng >= 1

    // Truy vấn thông tin sản phẩm sử dụng prepared statement
    $sql = "SELECT * FROM sanpham WHERE idsanpham = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dong = $result->fetch_assoc();

    if ($dong) {
        $new_product = [
            [
                'tensp' => $dong['tensp'],
                'id' => $id,
                'soluong' => $soluong,
                'gia' => $dong['giadexuat']
            ]
        ];

        if (isset($_SESSION['product'])) {
            $found = false;
            $product = [];
            foreach ($_SESSION['product'] as $cart_item) {
                if ($cart_item['id'] == $id) {
                    $product[] = [
                        'tensp' => $cart_item['tensp'],
                        'id' => $cart_item['id'],
                        'soluong' => $soluong, // Cập nhật số lượng mới
                        'gia' => $cart_item['gia']
                    ];
                    $found = true;
                } else {
                    $product[] = $cart_item;
                }
            }
            if (!$found) {
                $_SESSION['product'] = array_merge($product, $new_product);
            } else {
                $_SESSION['product'] = $product;
            }
        } else {
            $_SESSION['product'] = $new_product;
        }
    }

    header('Location: index.php?quanly=dathang');
    exit();
}

// Đóng kết nối
$conn->close();
?>