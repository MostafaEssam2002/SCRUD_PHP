<?php 
session_start();
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $name= $_SESSION['name'];
    $email= $_SESSION['email'];
    $name=$_SESSION["name"];
    $image_path=$_SESSION["image_path"];
    $gender=$_SESSION["gender"];
}
else{
    header("Location:login.php");
    echo "no session found";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frontend Developer Portfolio</title>
    <link rel="stylesheet" href="style/user.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">TETIANA ZAPOROHETS</div>
            <ul>
                <li><a href="#services">SERVICES</a></li>
                <li><a href="#technologies">TECHNOLOGIES</a></li>
                <li><a href="#portfolio">PORTFOLIO</a></li>
                <li><a href="#contact">CONTACT</a></li>
            </ul>
            <button class="language-switch"><a href="logout.php">Logout</a></button>
        </nav>
    </header>
    <section class="hero">
        <div class="hero-text">
            <h1><span class="highlight">FRONTEND</span> DEVELOPER</h1>
            <p>I am <?php echo $name?> – <span class="blue">web-developer</span> with a passion for creating beautiful and responsive websites.</p>
            <button class="cta">VIEW MY WORK</button>
        </div>
        <div class="hero-image">
            <img src="<?= $image_path?>" alt="Tatiana Zaporozhets">
        </div>
    </section>
</body>
</html>
