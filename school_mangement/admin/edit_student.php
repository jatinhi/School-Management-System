<?php
session_start();
include("../config/connection.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

/* GET ID */

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM students WHERE id='$id'");

$row = mysqli_fetch_assoc($query);

/* UPDATE */

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $class = $_POST['class'];
    $roll_no = $_POST['roll_no'];
    $phone = $_POST['phone'];

    mysqli_query($conn,"
    UPDATE students SET
    name='$name',
    student_id='$student_id',
    class='$class',
    roll_no='$roll_no',
    phone='$phone'
    WHERE id='$id'
    ");

    header("Location: student.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>

<style>

body{
    background:#f4f7fc;
    font-family:Arial;
}

.form-box{
    width:500px;
    background:white;
    padding:30px;
    margin:40px auto;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:20px;
    border:1px solid #ccc;
    border-radius:10px;
}

button{
    width:100%;
    padding:12px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Edit Student</h2>

<form method="POST">

<input type="text"
name="name"
value="<?php echo $row['name']; ?>"
required>

<input type="text"
name="student_id"
value="<?php echo $row['student_id']; ?>"
required>

<input type="text"
name="class"
value="<?php echo $row['class']; ?>"
required>

<input type="text"
name="roll_no"
value="<?php echo $row['roll_no']; ?>"
required>

<input type="text"
name="phone"
value="<?php echo $row['phone']; ?>"
required>

<button name="update">
Update Student
</button>

</form>

</div>

</body>
</html>