<?php
// Kiểm tra và lấy giá trị id từ GET, đảm bảo an toàn
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Chuyển id thành số nguyên để tăng bảo mật

// Truy vấn sản phẩm theo loại sử dụng prepared statement
$sql_loaisp = "SELECT * FROM sanpham WHERE loaisp = ?";
$stmt_loaisp = $conn->prepare($sql_loaisp);
$stmt_loaisp->bind_param("i", $id); // "i" là kiểu integer
$stmt_loaisp->execute();
$result_loaisp = $stmt_loaisp->get_result(); // Lấy kết quả
$count = $result_loaisp->num_rows; // Đếm số dòng trả về (thay mysql_num_rows)

?>

<?php
// Truy vấn tên loại sản phẩm sử dụng prepared statement
$sql_tenloaisp = "SELECT tenloaisp FROM loaisp WHERE idloaisp = ?";
$stmt_tenloaisp = $conn->prepare($sql_tenloaisp);
$stmt_tenloaisp->bind_param("i", $id);
$stmt_tenloaisp->execute();
$result_tenloaisp = $stmt_tenloaisp->get_result();
$dong = $result_tenloaisp->fetch_assoc(); // Thay mysql_fetch_array
?>

<div class="tieude"><?php echo htmlspecialchars($dong['tenloaisp']); // Bảo vệ chống XSS ?></div>
<ul class="product">
    <?php
    if ($count > 0) {
        while ($dong_loaisp = $result_loaisp->fetch_assoc()) { // Thay mysql_fetch_array
    ?>
            <li>
                <a href="?quanly=chitietsp&idloaisp=<?php echo htmlspecialchars($dong_loaisp['loaisp']); ?>&id=<?php echo htmlspecialchars($dong_loaisp['idsanpham']); ?>">
                    <img src="admincp/modules/quanlysanpham/uploads/<?php echo htmlspecialchars($dong_loaisp['hinhanh']); ?>" width="150" height="150" />
                    <p><?php echo htmlspecialchars($dong_loaisp['tensp']); ?></p>
                    <p><?php echo number_format($dong_loaisp['giadexuat']) . ' VNĐ'; // Định dạng giá tiền ?></p>
                    <p>Chi tiết</p>
                </a>
            </li>
    <?php
        }
    } else {
        echo 'Hiện chưa có sản phẩm...';
    }
    ?>
</ul>

</div>

<?php
// Đóng các statement và kết nối
$stmt_loaisp->close();
$stmt_tenloaisp->close();
$conn->close();
?>