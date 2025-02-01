<?php
$conn = mysqli_connect("localhost", "root", "", "test");
session_start();
if (!$conn) {
    echo mysqli_connect_error($conn);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted
    if (isset($_POST["email"]) && isset($_POST["password"])) { // Check if keys exist
        $email = mysqli_real_escape_string($conn, $_POST["email"]); 
        $password = sha1($_POST["password"]); 
        $query = "SELECT * FROM user WHERE email='$email' AND password='$password' LIMIT 1;"; 
        $result=mysqli_query($conn, $query);
        if($row=mysqli_fetch_assoc($result)) {
            $_SESSION['id']= $row['id'];
            $_SESSION['email']= $row['email'];
            $_SESSION['name']= $row['name'];
            $_SESSION['image_path']= $row['image_path'];
            $_SESSION['gender']= $row['gender'];
            header("Location:user.php");
        }
        else{
            $error="Invalid email or password ";
        }
    mysqli_free_result($result);
    mysqli_close($conn);
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login-container">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User Icon">
        <h2>Login Form</h2>
        <?php
            if(isset($error)){
                echo "<div style='color:red'>".$error."</div>";
            }
        ?>
        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Email" value="sasa@gmail.com">
            <input type="password" name="password" placeholder="Password" value="123456789">
            <button type="submit">Login</button>
            <input type="checkbox" name="chk"> 
            <label for="chk">Remember me</label>
            
            <a href="#">Forgot Password?</a>
            <a href="add.php">Don't have an account?</a>
        </form>
    </div>
</body>
</html>
