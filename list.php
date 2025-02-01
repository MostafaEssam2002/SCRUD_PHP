<?php
$conn=mysqli_connect("localhost","root","","test");
if(!$conn){
    echo mysqli_connect_error($con);
    exit();
}
$sql = "SELECT * FROM user";  // Ensure there is a space before WHERE

if (isset($_GET['search'])) {
    $word = mysqli_real_escape_string($conn, $_GET['search']);
    $sql .= " WHERE name LIKE '%$word%' OR email LIKE '%$word%'";  // Fix LIKE syntax
}
$result=mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/list.css">
</head>

<body>
    <form action="" method="GET" class="search-form">
        <input type="text" name="search" id="" placeholder="Enter {name} or {email} to search ">
        <input type="submit" value="Search">
    </form>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Admin</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row=mysqli_fetch_assoc($result)) {?>
            <tr>
                <td><?= $row['id']?></td>
                <td><?= stripslashes($row['name'])?></td>
                <td><?= stripslashes($row['email'])?></td>
                <td><?= $row['gender']?></td>
                <td><?= $row['admin']? "Yes":"no" ?></td>
                <td><img src="<?= !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : 'default.png' ?>" alt="User Image" width="100" height="100"></td>
                <td>
                    <a  href="user.php?id=<?= $row['id']?>">Show</a>
                    <a id="show" href="edit.php?id=<?= $row['id']?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id']?>">Delete</a>
                </td>
            </tr>
            <?php }?>
            <tfoot>
                <tr>
                    <td colspan="4">Total = <?= mysqli_num_rows($result) ?> users</td>
                    <td colspan="3"><a href="add.php" class="add_user" style="background-color: blue;"  >➕ Add User</a></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
    <?php
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</body>
</html>