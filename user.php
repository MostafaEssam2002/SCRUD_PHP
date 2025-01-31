<?php 
if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $conn=mysqli_connect('localhost','root','','test');
    if(!$conn){
        echo mysqli_connect_error();
        exit();
    }
    $sql="select * from user where id = ".$_GET['id'];
    $result=mysqli_query($conn,$sql);
    $data=mysqli_fetch_assoc($result);
    $name=$data["name"];
    $image_path=$data["image_path"];
    $gender=$data["gender"];
}
else{
    header('Location:list.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frontend Developer Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #0d0d19;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #111;
        }
        .logo {
            color: white;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        .language-switch {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 100px;
        }
        .hero-text {
            max-width: 500px;
        }
        .hero-text h1 {
            font-size: 48px;
            background: linear-gradient(to right, #ff007f, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .blue {
            color: #3b82f6;
        }
        .cta {
            background: linear-gradient(to right, #3b82f6, #ff007f);
            padding: 10px 20px;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .hero-image img {
            max-width: 400px;
            border-radius: 10px;
        }
    </style>
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
            <button class="language-switch">ENG 🌐</button>
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
