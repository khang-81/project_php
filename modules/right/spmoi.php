<?php
// Truy vấn lấy 6 sản phẩm mới nhất
$sql_moinhat = "SELECT * FROM sanpham ORDER BY idsanpham DESC LIMIT 0,6";
$result_moinhat = $conn->query($sql_moinhat); // Thay mysql_query bằng mysqli->query
?>

<div class="tieude">Sản phẩm mới nhất</div>
<ul class="product">
    <?php
    while ($dong_moinhat = $result_moinhat->fetch_assoc()) { // Thay mysql_fetch_array bằng fetch_assoc
    ?>
        <li>
            <a href="?quanly=chitietsp&idloaisp=<?php echo $dong_moinhat['loaisp'] ?>&id=<?php echo $dong_moinhat['idsanpham'] ?>">
                <img src="admincp/modules/quanlysanpham/uploads/<?php echo $dong_moinhat['hinhanh'] ?>" width="150" height="150" />
                <p style="color:skyblue"><?php echo $dong_moinhat['tensp'] ?></p>
                <p style="color:red;font-weight:bold; border:1px solid #d9d9d9; width:150px; height:30px; line-height:30px;margin-left:35px;margin-bottom:5px;">
                    <?php echo number_format($dong_moinhat['giadexuat']) . ' VNĐ' ?>
                </p>
            </a>
        </li>
    <?php
    }
    ?>
</ul>
<div class="clear"></div>

<?php
// Truy vấn lấy danh sách loại sản phẩm
$sql_loai = "SELECT * FROM loaisp";
$result_loai = $conn->query($sql_loai); // Thay mysql_query

while ($dong_loai = $result_loai->fetch_assoc()) { // Thay mysql_fetch_array
    echo '<div class="tieude">' . $dong_loai['tenloaisp'] . '</div>';

    // Truy vấn sản phẩm theo loại
    $sql_loaisp = "SELECT * FROM loaisp INNER JOIN sanpham ON sanpham.loaisp=loaisp.idloaisp WHERE sanpham.loaisp='" . $dong_loai['idloaisp'] . "'";
    $result = $conn->query($sql_loaisp); // Thay mysql_query
    $count = $result->num_rows; // Thay mysql_num_rows

    if ($count > 0) {
    ?>
        <ul class="product">
            <?php
            while ($dong = $result->fetch_assoc()) { // Thay mysql_fetch_array
            ?>
                <li>
                    <a href="?quanly=chitietsp&idloaisp=<?php echo $dong['loaisp'] ?>&id=<?php echo $dong['idsanpham'] ?>">
                        <img src="admincp/modules/quanlysanpham/uploads/<?php echo $dong['hinhanh'] ?>" width="150" height="150" />
                        <p style="color:skyblue"><?php echo $dong['tensp'] ?></p>
                        <p style="color:red;font-weight:bold; border:1px solid #d9d9d9; width:150px; height:30px; line-height:30px;margin-left:35px;margin-bottom:5px;">
                            <?php echo number_format($dong['giadexuat']) . ' VNĐ' ?>
                        </p>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
        <div class="clear"></div>
    <?php
    } else {
        echo '<h3 style="margin:5px;font-style:italic;color:#000">Hiện chưa có sản phẩm...</h3>';
    }
}
?>

<?php
// Đóng kết nối
$conn->close();
?>