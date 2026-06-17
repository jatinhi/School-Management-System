<?php
include("../config/connection.php");

$msg = "";

if(isset($_POST['register'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = "user";

    // check if student already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if(mysqli_num_rows($check) > 0){
        $msg = "Student ID already registered!";
    } else {
        $insert = mysqli_query($conn, 
            "INSERT INTO users(username, password) 
             VALUES('$username','$hashed_password')"
        );

        if($insert){
            $msg = "Registration Successful! Go to Login.";
        } else {
            $msg = "Error! Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #43e97b, #38f9d7);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.register-container {
    background: #fff;
    padding: 40px;
    width: 350px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
}

.register-container h2 {
    margin-bottom: 20px;
    color: #333;
}

.input-box {
    width: 100%;
    margin-bottom: 15px;
}

.input-box input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: 0.3s;
}

.input-box input:focus {
    border-color: #43e97b;
    box-shadow: 0 0 5px #43e97b;
}

button {
    width: 100%;
    padding: 10px;
    background: #43e97b;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #2ecc71;
}

.msg {
    margin-bottom: 10px;
    color: red;
}

.logo {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #43e97b;
}
</style>

</head>

<body>

<div class="register-container">
    <div class="logo">🏫 School Portal</div>
    <h2>Student Registration</h2>

    <?php if($msg != "") { ?>
        <div class="msg"><?php echo $msg; ?></div>
    <?php } ?>

    <form method="POST">
        <div class="input-box">
            <input type="text" name="student_id" placeholder="Student ID">
        </div>

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button name="register">Register</button>
    </form>

    <p style="margin-top:15px;">
        Already have an account? 
        <a href="login.php" style="color:#43e97b; font-weight:bold; text-decoration:none;">
            Login Here
        </a>
    </p>

</div>

</body>
</html>