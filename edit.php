<?php
$conn = mysqli_connect("localhost", "root", "", "test");
if (!$conn) {
    echo mysqli_connect_error();
    exit();
}

$errors = array();
$mysql_error = "";
$image_path = ""; // تعريف الصورة افتراضيًا

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT `name`, `email`, `password`, `admin`, `gender`, `image_path` FROM user WHERE id = $id;";
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    
    if ($data) {
        $name = $data["name"];
        $email = $data["email"];
        $admin = $data["admin"];
        $gender = $data["gender"];
        $image_path = $data["image_path"]; // حفظ مسار الصورة الحالي
    } else {
        header("Location: list.php");
        exit();
    }
} else {
    header("Location: list.php");
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $errors["name"] = "name";
    }
    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "email";
    }
    if (strlen($_POST["password"]) < 5 && strlen($_POST["password"]) > 0) {
        $errors["password"] = "password";
    }
    if (!isset($_POST["gender"])) {
        $errors["gender"] = "gender";
    }
    
    if (empty($errors)) {
        $conn = mysqli_connect('localhost', 'root', '', 'test');
        if (!$conn) {
            $mysql_error = "Database Connection Error: " . mysqli_connect_error();
        } else {
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $admin = isset($_POST["admin"]) ? 1 : 0;
            $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
            $uploads_dir = $_SERVER["DOCUMENT_ROOT"] . "/scrud/uploads";
            $new_image_path = $image_path; // افتراضيًا، تبقى الصورة كما هي

            if (isset($_FILES["avatar"]) && $_FILES["avatar"]['error'] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["avatar"]["tmp_name"];
                $extension = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
                
                // التحقق من أن الملف صورة فقط
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($extension, $allowed_extensions)) {
                    echo "❌ Error: Invalid file extension ($extension)";
                    exit();
                }

                // إنشاء اسم جديد للصورة باستخدام التاريخ والوقت
                $avatar = date("Ymd_His") . "." . $extension;
                $destination = $uploads_dir . "/" . $avatar;

                // حذف الصورة القديمة إذا كانت موجودة
                if (!empty($image_path) && file_exists($_SERVER["DOCUMENT_ROOT"] . $image_path)) {
                    unlink($_SERVER["DOCUMENT_ROOT"] . $image_path);
                }

                // نقل الصورة إلى المجلد المحدد
                if (move_uploaded_file($tmp_name, $destination)) {
                    $new_image_path = "/scrud/uploads/" . $avatar; // تخزين المسار النسبي
                } else {
                    echo "❌ Error uploading image.";
                    exit();
                }
            }

            if (!empty($id) && is_numeric($id)) {
                if (empty($_POST["password"])) {
                    $query = "UPDATE user SET `name`='$name', email='$email', admin='$admin', gender='$gender', image_path='$new_image_path' WHERE id='$id';";
                } else {
                    $password = sha1($_POST["password"]);
                    $query = "UPDATE user SET `name`='$name', email='$email', password='$password', admin='$admin', gender='$gender', image_path='$new_image_path' WHERE id='$id';";
                }
                
                if (!mysqli_query($conn, $query)) {
                    $mysql_error = "⚠️ Error: " . mysqli_error($conn);
                } else {
                    header("Location: list.php");
                    exit();
                }
            } else {
                $mysql_error = "⚠️ Invalid user ID!";
            }
            mysqli_close($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style/add.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit User Form</h2>
        <?php if (!empty($mysql_error)): ?>
            <div class="error-message" style="background: #ffdddd; color: #a94442; padding: 10px; border: 1px solid #a94442; margin-bottom: 10px;">
                <?php echo $mysql_error; ?>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" placeholder="Enter your name">
            <?php if (!empty($errors["name"])) echo '<div class="error-message">Enter a valid name</div>'; ?>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" placeholder="Enter your email">
            <?php if (!empty($errors["email"])) echo '<div class="error-message">Enter a valid email</div>'; ?>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password">
            <?php if (!empty($errors["password"])) echo '<div class="error-message">Password must be at least 5 characters</div>'; ?>
            <label for="avatar">Upload Image</label>
            <input type="file" name="avatar" id="avatar" >
            
            <div class="checkbox-group">
                <input type="checkbox" id="admin" name="admin" value="1" <?php if ($admin == 1) { echo 'checked'; } ?>>
                <label for="admin">Admin</label>
            </div>

            <div class="radio-group">
                <input type="radio" name="gender" value="male" <?php if($gender=="male"){echo "checked";}?> id="male">
                <label for="male">Male</label>
                <input type="radio" name="gender" value="female" <?php if($gender=="female"){echo "checked";}?> id="female">
                <label for="female">Female</label>
                <?php if (!empty($errors["gender"])) echo '<div class="error-message">Choose a gender</div>'; ?>
            </div>

            <input type="submit" value="Update" class="submit-btn">
        </form>
    </div>
</body>
</html>

