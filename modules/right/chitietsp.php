<?php
// Kiểm tra và lấy giá trị id từ GET, đảm bảo an toàn
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Chuyển id thành số nguyên để tăng bảo mật

// Truy vấn chi tiết sản phẩm sử dụng prepared statement
$sql = "SELECT * FROM sanpham WHERE idsanpham = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // "i" là kiểu integer
$stmt->execute();
$result = $stmt->get_result(); // Lấy kết quả
$dong = $result->fetch_assoc(); // Thay mysql_fetch_array
?>

<div class="tieude">Chi tiết sản phẩm</div>

<div class="box_chitietsp">
    <div class="box_hinhanh">
        <img src="admincp/modules/quanlysanpham/uploads/<?php echo htmlspecialchars($dong['hinhanh']); ?>" data-zoom-image="imgs/op-lung-sony-z3-pelosi-50.jpg" width="200" height="200" />
        <?php
        // Truy vấn gallery ảnh sử dụng prepared statement
        $sql_gallery = "SELECT * FROM gallery WHERE id_sp = ? LIMIT 3";
        $stmt_gallery = $conn->prepare($sql_gallery);
        $stmt_gallery->bind_param("i", $id);
        $stmt_gallery->execute();
        $result_gallery = $stmt_gallery->get_result();
        $row_gallery = $result_gallery->num_rows; // Thay mysql_num_rows
        ?>
        <ul class="hinhanhphongto">
            <?php
            if ($row_gallery > 0) {
                while ($dong_gallery = $result_gallery->fetch_assoc()) { // Thay mysql_fetch_array
            ?>
                    <li><img src="admincp/modules/gallery/uploads/<?php echo htmlspecialchars($dong_gallery['hinhanhsp']); ?>" id="zoom_01" width="70" height="70" /></li>
            <?php
                }
            } else {
                echo '<li><img src="admincp/modules/quanlysanpham/uploads/' . htmlspecialchars($dong['hinhanh']) . '" id="zoom_01" width="70" height="70" /></li>';
            }
            ?>
        </ul>
    </div>
    <div class="box_info">
        <form action="update_cart.php?id=<?php echo htmlspecialchars($dong['idsanpham']); ?>" method="post" enctype="multipart/form-data">
            <p>
                <strong>Tên sản phẩm: </strong><em style="color:red"><?php echo htmlspecialchars($dong['tensp']); ?></em>
            </p>
            <p><strong>Mã sản phẩm:</strong> <?php echo htmlspecialchars($dong['masp']); ?></p>
            <p><strong>Giá bán:</strong><span style="color:red;"> <?php echo number_format($dong['giadexuat']) . ' VNĐ'; ?></span></p>
            <p style="text-decoration:underline;color:blue;"><strong>Tình trạng:</strong> Còn hàng</p>
            <p><strong>Số lượng:</strong><input type="text" name="soluong" size="3" value="1" /></p>
            <input type="submit" name="add_to_cart" value="Mua hàng" style="margin:10px;width:100px;height:40px;background:#9F6;color:#000;font-size:18px;border-radius:8px;" />
        </form>
    </div><!-- Kết thúc box box_info -->
</div><!-- Kết thúc box chitiet sp -->

<div class="tabs_panel">
    <ul class="tabs">
        <li rel="panel1" class="active">Thông tin sản phẩm</li>
        <li rel="panel2">Hình ảnh sản phẩm</li>
        <li rel="panel3">Khách hàng đánh giá</li>
    </ul>
    <?php
    // Truy vấn thông tin sản phẩm sử dụng prepared statement
    $sql_thongtinsp = "SELECT * FROM sanpham WHERE idsanpham = ?";
    $stmt_thongtinsp = $conn->prepare($sql_thongtinsp);
    $stmt_thongtinsp->bind_param("i", $id);
    $stmt_thongtinsp->execute();
    $result_thongtinsp = $stmt_thongtinsp->get_result();
    $count_thongtinsp = $result_thongtinsp->num_rows; // Thay mysql_num_rows

    if ($count_thongtinsp > 0) {
        $dong_thongtinsp = $result_thongtinsp->fetch_assoc(); // Thay mysql_fetch_array
    ?>
        <div id="panel1" class="panel active">
            <p><?php echo htmlspecialchars($dong_thongtinsp['noidung']); ?></p>
        </div>
    <?php
    } else {
        echo '<p style="padding:30px;">Hiện chưa có thông tin chính thức</p>';
    }
    ?>

    <div id="panel2" class="panel">
        <?php
        // Truy vấn hình ảnh sản phẩm từ gallery
        $sql_hinhanhsp = "SELECT * FROM gallery WHERE id_sp = ?";
        $stmt_hinhanhsp = $conn->prepare($sql_hinhanhsp);
        $stmt_hinhanhsp->bind_param("i", $id);
        $stmt_hinhanhsp->execute();
        $result_hinhanhsp = $stmt_hinhanhsp->get_result();
        $count = $result_hinhanhsp->num_rows; // Thay mysql_num_rows

        if ($count > 0) {
            while ($dong_hinhanhsp = $result_hinhanhsp->fetch_assoc()) { // Thay mysql_fetch_array
        ?>
                <p style="text-align:center;"><img src="admincp/modules/gallery/uploads/<?php echo htmlspecialchars($dong_hinhanhsp['hinhanhsp']); ?>" width="600" height="600" /></p>
        <?php
            }
        } else {
            echo '<p>Chưa có hình ảnh</p>';
        }
        ?>
    </div>

    <div id="panel3" class="panel">
        <p>Hàng chính hãng tốt đẹp</p>
    </div>
</div>

<?php
// Truy vấn sản phẩm liên quan
$idloaisp = isset($_GET['idloaisp']) ? intval($_GET['idloaisp']) : 0; // Lấy idloaisp và bảo mật
$sql_lienquan = "SELECT * FROM sanpham WHERE loaisp = ? AND idsanpham != ?";
$stmt_lienquan = $conn->prepare($sql_lienquan);
$stmt_lienquan->bind_param("ii", $idloaisp, $id); // Liên kết cả idloaisp và id
$stmt_lienquan->execute();
$result_lienquan = $stmt_lienquan->get_result();
$count_lienquan = $result_lienquan->num_rows; // Thay mysql_num_rows

if ($count_lienquan > 0) {
?>
    <div class="sanphamlienquan">
        <div class="tieude">Sản phẩm liên quan</div>
        <ul>
            <?php
            while ($dong_lienquan = $result_lienquan->fetch_assoc()) { // Thay mysql_fetch_array
            ?>
                <li>
                    <a href="?quanly=chitietsp&idloaisp=<?php echo htmlspecialchars($dong_lienquan['loaisp']); ?>&id=<?php echo htmlspecialchars($dong_lienquan['idsanpham']); ?>">
                        <img src="admincp/modules/quanlysanpham/uploads/<?php echo htmlspecialchars($dong_lienquan['hinhanh']); ?>" width="150" height="150" />
                        <p>Tên sp: <?php echo htmlspecialchars($dong_lienquan['tensp']); ?></p>
                        <p style="color:red;">Giá: <?php echo number_format($dong_lienquan['giadexuat']) . ' VNĐ'; ?></p>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div><!-- Kết thúc box sp liên quan -->
<?php
} else {
    echo '<div class="tieude">Sản phẩm liên quan</div>';
    echo '<p style="padding:30px;">Hiện chưa có thêm sản phẩm nào</p>';
}
?>

<div class="clear"></div>

<?php
// Đóng các statement và kết nối
$stmt->close();
$stmt_gallery->close();
$stmt_thongtinsp->close();
$stmt_hinhanhsp->close();
$stmt_lienquan->close();
$conn->close();
?>