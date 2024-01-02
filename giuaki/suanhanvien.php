<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbluong";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Xử lý lấy thông tin nhân viên để hiển thị form sửa
if (isset($_GET['manv'])) {
    $manvToEdit = $_GET['manv'];
    $sqlGetInfo = "SELECT * FROM nv WHERE manv = '$manvToEdit'";
    $resultInfo = $conn->query($sqlGetInfo);

    if ($resultInfo->num_rows > 0) {
        $rowInfo = $resultInfo->fetch_assoc();
        $manv = $rowInfo['manv'];
        $hoten = $rowInfo['hoten'];
        $phongban = $rowInfo['phongban'];
        $luongngay = $rowInfo['luongngay'];
    } else {
        echo "Không tìm thấy thông tin nhân viên.";
        exit();
    }
}

// Xử lý cập nhật thông tin nhân viên
if (isset($_POST['update'])) {
    $manv = $_POST['manv'];
    $hoten = $_POST['hoten'];
    $phongban = $_POST['phongban'];
    $luongngay = $_POST['luongngay'];

    $sqlUpdate = "UPDATE nv SET hoten='$hoten', phongban='$phongban', luongngay=$luongngay WHERE manv='$manv'";
    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Cập nhật thông tin nhân viên thành công.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
</head>
<body>
    <h2>Sửa Nhân Viên</h2>
    <form method="post" action="">
        Mã NV: <input type="text" name="manv" value="<?php echo $manv; ?>" readonly><br>
        Họ Tên: <input type="text" name="hoten" value="<?php echo $hoten; ?>" required><br>
        Phòng Ban: <input type="text" name="phongban" value="<?php echo $phongban; ?>" required><br>
        Lương Ngày: <input type="text" name="luongngay" value="<?php echo $luongngay; ?>" required><br>
        <input type="submit" name="update" value="Cập Nhật">
        <a href="danhsachnhanvien.php">Quay lại danh sách</a>
    </form>
</body>
</html>