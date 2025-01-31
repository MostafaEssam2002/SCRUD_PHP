<?php
$conn = mysqli_connect("localhost", 'root', '', 'test');
if (!$conn) {
    echo mysqli_connect_error();
    exit();
}

$id = $_GET['id'];

// جلب مسار الصورة للمستخدم قبل الحذف
$sql_get_image = "SELECT image_path FROM user WHERE id = $id";
$result = mysqli_query($conn, $sql_get_image);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $image_path = "C:\\xampp\\htdocs" . $row['image_path'];
    if (!empty($image_path) && file_exists($image_path)) {
        unlink($image_path);
    }
    $sql_delete = "DELETE FROM user WHERE id = $id";
    if (mysqli_query($conn, $sql_delete)) {
        echo "User and image deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

// إعادة التوجيه إلى الصفحة الرئيسية
header("Location: list.php");
exit();
?>