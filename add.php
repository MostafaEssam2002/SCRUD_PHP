<?php
$errors = array();
$mysql_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["name"]) || empty($_POST["name"])) {
        $errors["name"] = "name";
    }
    if (!isset($_POST["email"]) || empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "email";
    }
    if (!isset($_POST["password"]) || empty($_POST["password"]) || strlen($_POST["password"]) < 5) {
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
            try {
                $name = mysqli_real_escape_string($conn, addslashes(trim($_POST["name"])));
                // $pattern="/^[a-z0-9-]+[_a-z0-9-]*[a-z0-9-]+@[a-z0-9]+\.([a-z]{2,4})$/";
                $email = mysqli_real_escape_string($conn, addslashes(trim($_POST["email"])));
                $password = sha1($_POST["password"]);
                $admin = isset($_POST["admin"]) ? 1 : 0;
                $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
                $uploads_dir = $_SERVER["DOCUMENT_ROOT"] . "/scrud/uploads";
                $image_path = "";
                if (isset($_FILES["avatar"]) && $_FILES["avatar"]['error'] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["avatar"]["tmp_name"];
                    $extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array(strtolower($extension), $allowed_extensions)) {
                        throw new Exception("❌ Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.");
                    }
                    $avatar = date("Ymd_His") . "." . $extension;
                    $destination = $uploads_dir . "/" . $avatar;
                    if (move_uploaded_file($tmp_name, $destination)) {
                        $image_path = "/scrud/uploads/" . $avatar;
                    } else {
                        throw new Exception("❌ Error uploading image.");
                    }
                }
                $query = "INSERT INTO user (`name`, `email`, `password`, `admin`, `gender`, `image_path`) VALUES ('$name', '$email', '$password', '$admin', '$gender', '$image_path');";
                
                if (!mysqli_query($conn, $query)) {
                    throw new Exception(mysqli_error($conn));
                } else {
                    header("Location: list.php");
                    exit();
                }
            } catch (Exception $e) {
                $mysql_error = "⚠️ Error: " . $e->getMessage();
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
    <title>Add User</title>
    <link rel="stylesheet" href="style/add.css">
</head>
<body>
    <div class="form-container">
        <h2>Add User Form</h2>
        <?php if (!empty($mysql_error)): ?>
            <div class="error-message" style="background: #ffdddd; color: #a94442; padding: 10px; border: 1px solid #a94442; margin-bottom: 10px;top: 0;">
                <?php echo $mysql_error; ?>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php if(!empty($_POST['name'])) {echo $_POST['name'];}?>" placeholder="Enter your name">
            <?php if (!empty($errors["name"])) echo '<div class="error-message">Enter a valid name</div>'; ?>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];}?>" placeholder="Enter your email">
            <?php if (!empty($errors["email"])) echo '<div class="error-message">Enter a valid email</div>'; ?>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password">
            <?php if (!empty($errors["password"])) echo '<div class="error-message">Password must be at least 5 characters</div>'; ?>
            <label for="avatar">Upload Image</label>
            <input type="file" name="avatar" id="avatar">
            <div class="checkbox-group">
                <input type="checkbox" id="admin" name="admin" value="1" <?php if (!empty($_POST['admin'])) { echo 'checked'; } ?>>
                <label for="admin">Admin</label>
            </div>
            <div class="radio-group">
                <input type="radio" name="gender" value="male"<?php if(!empty($_POST['gender']) && $_POST['gender']=='male' ){echo "checked";}?> id="male">
                <label for="male">Male</label>
                <input type="radio" name="gender" value="female" <?php if(!empty($_POST['gender']) && $_POST['gender']=='female' ){echo "checked";}?> id="female">
                <label for="female">Female</label>
                <?php if (!empty($errors["gender"])) echo '<div class="error-message">Choose a gender</div>'; ?>
            </div>
            <input type="submit" value="Submit" class="submit-btn">
        </form>
    </div>
</body>
</html>
