<?php
session_start();
include("../config/connection.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$msg = "";

if(isset($_POST['add'])){
    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $roll = $_POST['roll_no'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    $folder = "../uploads/";
    if(!is_dir($folder)){
        mkdir($folder);
    }

    $path = $folder . time() . "_" . $photo;

    if(move_uploaded_file($tmp, $path)){

        $hash = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "INSERT INTO users(student_id, username, password, role)
        VALUES('$id','$name','$hash','user')");

        mysqli_query($conn, "INSERT INTO students(student_id, name, class, roll_no, phone, photo)
        VALUES('$id','$name','$class','$roll','$phone','$path')");

        $msg = "✅ Student Added Successfully!";
    } else {
        $msg = "❌ Image Upload Failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f4f6f9;
}

/* CONTAINER */
.container {
    padding: 20px;
}

/* FORM CARD */
.form-card {
    max-width: 500px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.form-card h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* INPUT */
input {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

input:focus {
    border-color: #667eea;
}

/* BUTTON */
button {
    width: 100%;
    padding: 10px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
}

/* IMAGE */
.preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: block;
    margin: 10px auto;
    border: 2px solid #667eea;
    object-fit: cover;
}

/* MESSAGE */
.msg {
    text-align: center;
    margin-bottom: 10px;
    color: green;
}
</style>

<script>
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</head>

<body>

<!-- SAME NAVBAR -->
<?php include("../Layout/navbar.php"); ?>

<div class="container">

<div class="form-card">

<h2>➕ Add Student</h2>

<?php if($msg != "") { ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

<input name="student_id" placeholder="Student ID" required>
<input name="name" placeholder="Name" required>
<input name="class" placeholder="Class" required>
<input name="roll_no" placeholder="Roll No" required>
<input name="phone" placeholder="Phone" required>
<input type="password" name="password" placeholder="Password" required>

<img id="preview" src="https://via.placeholder.com/80" class="preview">

<input type="file" name="photo" accept="image/*" onchange="previewImage(event)" required>

<button name="add">Add Student</button>

</form>

</div>

</div>

</body>
</html>