<?php
$showerror = "";
$login = false;
// include 'dbconnect.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include '../admin/dbconnect.php';
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $sql = "select * from users where username = '$username' AND password = '$password' AND status = 1";
    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);

    if($num == 1){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
      
        $row = $result->fetch_assoc();
       if($row["role"] == "user"){
        $_SESSION['role'] = $row["role"];
            header("location:../user/home.php");
       }else{
        $_SESSION['role'] = $row["role"];
        header("location:home.php");
       }
    }else {
          echo "<script> alert('Invalid credentials')</script>";
        $showerror = "Invalid credentials";
         $login = false;
        
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System Login</title>
    <link rel="stylesheet" href="../CSS/login.css">
   
</head>
<body>
   
    <div class="login-container">
        <h2>Library Management System</h2>
       
        <form action="login.php" method="POST">
        <div class="input-group">
            <label for="userid">Username</label>
            <input type="text" id="userid" name="uname" placeholder="username">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="pass" placeholder="password">
        </div>
         <div id="error"></div>
        <div class="buttons">
            <button class="cancel-btn">Cancel</button>
            <button>Login</button>
        </div>
        </form>
    </div>
</body>
</html>
<!-- 
<?php

$name = $_POST['uname'];
$password = $_POST['pass'];

?> -->
