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

// Xử lý thêm nhân viên
if (isset($_POST['submit'])) {
    $manv = $_POST['manv'];
    $hoten = $_POST['hoten'];
    $phongban = $_POST['phongban'];
    $luongngay = $_POST['luongngay'];

    $sqlAdd = "INSERT INTO nv (manv, hoten, phongban, luongngay) VALUES ('$manv', '$hoten', '$phongban', $luongngay)";
    if ($conn->query($sqlAdd) === TRUE) {
        echo "Thêm nhân viên thành công.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Xử lý xóa nhân viên
if (isset($_GET['delete'])) {
    $manvToDelete = $_GET['delete'];
    $sqlDelete = "DELETE FROM nv WHERE manv = '$manvToDelete'";
    if ($conn->query($sqlDelete) === TRUE) {
        echo "Xóa nhân viên thành công.";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Xử lý tìm kiếm nhân viên
if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'];
    $sqlSearch = "SELECT nv.manv, nv.hoten, nv.phongban, SUM(luong.songaycong) AS tongngaycong, SUM(nv.luongngay * luong.songaycong) AS tongluong
                  FROM nv
                  INNER JOIN luong ON nv.manv = luong.manv
                  WHERE nv.manv LIKE '%$keyword%' OR nv.hoten LIKE '%$keyword%'
                  GROUP BY nv.manv";

    $result = $conn->query($sqlSearch);
} else {
    // Truy vấn dữ liệu
    $sql = "SELECT nv.manv, nv.hoten, nv.phongban, SUM(luong.songaycong) AS tongngaycong, SUM(nv.luongngay * luong.songaycong) AS tongluong
            FROM nv
            INNER JOIN luong ON nv.manv = luong.manv
            GROUP BY nv.manv";

    $result = $conn->query($sql);
}

// Hiển thị dữ liệu
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Phòng Ban</th>
                <th>Tổng Ngày Lương</th>
                <th>Tổng Lương</th>
                <th>Thao Tác</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["manv"] . "</td>
                <td>" . $row["hoten"] . "</td>
                <td>" . $row["phongban"] . "</td>
                <td>" . $row["tongngaycong"] . "</td>
                <td>" . $row["tongluong"] . "</td>
                <td>
                    <a href='?delete=" . $row["manv"] . "'>Xóa</a>
                    <a href='suanhanvien.php?manv=" . $row["manv"] . "'>Sửa</a>
                    <a href='xemthongtin.php?manv=" . $row["manv"] . "'>Xem</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Không có dữ liệu.";
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
</head>
<body>
    <h2>Thêm Nhân Viên</h2>
    <form method="post" action="">
        Mã NV: <input type="text" name="manv" required><br>
        Họ Tên: <input type="text" name="hoten" required><br>
        Phòng Ban: <input type="text" name="phongban" required><br>
        Lương Ngày: <input type="text" name="luongngay" required><br>
        <input type="submit" name="submit" value="Thêm Nhân Viên">
    </form>

    <h2>Tìm Kiếm Nhân Viên</h2>
    <form method="get" action="">
        Từ khóa: <input type="text" name="keyword" required>
        <input type="submit" name="search" value="Tìm Kiếm">
    </form>
</body>
</html>