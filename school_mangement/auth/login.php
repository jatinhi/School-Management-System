<?php
session_start();
include("../config/connection.php");

$msg = "";

if(isset($_POST['login'])){
    $login_id = trim($_POST['login_id']); // username OR student_id
    $password = trim($_POST['password']);

    if($login_id == "" || $password == ""){
        $msg = "⚠️ All fields are required!";
    } else {

        // Check both username (admin) and student_id (student)
        $query = "SELECT * FROM users 
                  WHERE username='$login_id' 
                  OR student_id='$login_id'";

        $result = mysqli_query($conn, $query);

        if($result && mysqli_num_rows($result) == 1){
            $user = mysqli_fetch_assoc($result);

            if(password_verify($password, $user['password'])){

                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['student_id'] = $user['student_id'];

                // 🔀 Role-based redirect
                if($user['role'] == 'admin'){
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../user/dashboard.php");
                }
                exit();

            } else {
                $msg = "❌ Wrong Password!";
            }

        } else {
            $msg = "❌ User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: linear-gradient(135deg, #667eea, #764ba2);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    background: white;
    padding: 35px;
    width: 350px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    text-align: center;
}

.login-box h2 {
    margin-bottom: 20px;
}

.input-box {
    margin-bottom: 15px;
}

.input-box input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
}

.input-box input:focus {
    border-color: #667eea;
    box-shadow: 0 0 5px #667eea;
}

button {
    width: 100%;
    padding: 10px;
    background: #667eea;
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background: #5a67d8;
}

.msg {
    color: red;
    margin-bottom: 10px;
}

.footer-text {
    margin-top: 10px;
    font-size: 14px;
}
</style>

</head>

<body>

<div class="login-box">
    <h2>🏫 School Login</h2>

    <?php if($msg != "") { ?>
        <div class="msg"><?php echo $msg; ?></div>
    <?php } ?>

    <form method="POST">
    
          <div class="input-box">
        <input type="text" name="login_id" placeholder="Enter Username or Student ID" required>

        </div>
       
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button name="login">Login</button>
    </form>

    <div class="footer-text">
        <p>Admin adds students. No self-registration.</p>
    </div>
</div>

</body>
</html>