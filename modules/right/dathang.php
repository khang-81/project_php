<?php
@session_start();

if (isset($_SESSION['product'])) {
    if (isset($_SESSION['dangnhap'])) {
        echo '<div class="tieude">Giỏ hàng của bạn | <span>Xin chào bạn:<strong><em> ' . htmlspecialchars($_SESSION['dangnhap']) . '</em></strong><a href="update_cart.php?thoat=1" style="text-decoration:underline;color:#fff; margin-left:10px;">Đăng Xuất</a></span></div>';
    } else {
        echo '<div class="tieude">Giỏ hàng của bạn</div>';
    }

    echo '<div class="box_giohang">';
    echo '  <table width="100%" border="1" style="border-collapse:collapse; margin:5px; text-align:center;">';
    echo '  <tr>';
    echo '<td>MÃ SP</td>';
    echo '<td>Tên SP</td>';
    echo '<td>Hình ảnh</td>';
    echo '<td>Giá sp</td>';
    echo '<td>SL</td>';
    echo '<td>Tổng tiền</td>';
    echo '<td>Quản lý</td>';
    echo '</tr>';

    $thanhtien = 0;
    foreach ($_SESSION['product'] as $cart_item) {
        $id = intval($cart_item['id']); // Chuyển id thành số nguyên để tăng bảo mật

        // Truy vấn thông tin sản phẩm sử dụng prepared statement
        $sql = "SELECT * FROM sanpham WHERE idsanpham = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); // "i" là kiểu integer
        $stmt->execute();
        $result = $stmt->get_result();
        $dong = $result->fetch_assoc(); // Thay mysql_fetch_array

        echo '<tr>';
        echo '<td>' . htmlspecialchars($dong['masp']) . '</td>';
        echo '<td>' . htmlspecialchars($dong['tensp']) . '</td>';
        echo '<td><img src="admincp/modules/quanlysanpham/uploads/' . htmlspecialchars($dong['hinhanh']) . '" width="100" height="100" /></td>';
        echo '<td>' . number_format($dong['giadexuat']) . ' VNĐ</td>';

        echo '<td><a href="update_cart.php?cong=' . htmlspecialchars($cart_item['id']) . '" style="margin-right:2px;"><img src="imgs/plus.png" width="20" height="20"></a>' . htmlspecialchars($cart_item['soluong']) . '<a href="update_cart.php?tru=' . htmlspecialchars($cart_item['id']) . '" style="margin-left:2px;"><img src="imgs/subtract.png" width="20" height="20"></a></td>';
        
        $tongtien = 0;
        $tongtien = $cart_item['soluong'] * $cart_item['gia'];
        $thanhtien = $thanhtien + $tongtien;
        
        echo '<td>' . number_format($tongtien) . ' VNĐ</td>';
        echo '<td><a href="update_cart.php?xoa=' . htmlspecialchars($cart_item['id']) . '"><img src="imgs/deletered.png" width="30" height="30"></a></td>';
        echo '</tr>';
    }

    echo '<tr>';
    echo '<td colspan="6"><a href="update_cart.php?xoatoanbo=1" style="text-decoration:none;">Xóa toàn bộ</a></td>';
    echo '<td>Thành tiền: ' . number_format($thanhtien) . ' VNĐ</td>';
    echo '</tr>';

    echo '</table>';
} else {
    echo 'Giỏ hàng của bạn trống';
}
?>

<ul class="control">
    <p><a href="">Tiếp tục mua hàng</a></p>
    <p><a href="?quanly=dangkymoi">Đăng ký mới</a></p>
    <p><a href="?quanly=dangnhap">Bạn đã có tài khoản</a></p>
    <?php
    if (isset($_SESSION['dangnhap']) && isset($_SESSION['product'])) {
    ?>
        <p style="float:right; background:#FF0;text-decoration:none;"><a href="thanhtoan.php" style="color:#000;margin:5px;">Thanh toán</a></p>
    <?php
    }
    ?>
</ul>

</div>

<?php
// Đóng kết nối
$conn->close();
?>