<?php
session_start();
include("../config/connection.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$username = $_SESSION['user'];

$result = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f4f7fb;
}
.container {
    padding: 20px;
}
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
    gap: 20px;
}
.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    text-align: center;
}
.table-card {
    margin-top: 20px;
    background: white;
    padding: 20px;
    border-radius: 12px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
</style>

</head>

<body>

<?php include("../Layout/header.php"); ?>

<div class="container">

<h2>Welcome, <?php echo $username; ?> 👋</h2>

<div class="cards">
    <div class="card">
        <h3><?php echo $data['class'] ?? '-'; ?></h3>
        <p>Class</p>
    </div>

    <div class="card">
        <h3><?php echo $data['roll_no'] ?? '-'; ?></h3>
        <p>Roll No</p>
    </div>

    <div class="card">
        <h3><?php echo $data['phone'] ?? '-'; ?></h3>
        <p>Phone</p>
    </div>
</div>

<div class="table-card">
<h3>Your Details</h3>

<?php if($data){ ?>
<table>
<tr><th>ID</th><td><?php echo $data['student_id']; ?></td></tr>
<tr><th>Name</th><td><?php echo $data['name']; ?></td></tr>
<tr><th>Class</th><td><?php echo $data['class']; ?></td></tr>
<tr><th>Roll</th><td><?php echo $data['roll_no']; ?></td></tr>
<tr><th>Phone</th><td><?php echo $data['phone']; ?></td></tr>
</table>
<?php } else { ?>
<p style="color:red;">⚠️ No data found!</p>
<?php } ?>

</div>

</div>

<?php include("../Layout/footer.php"); ?>

</body>
</html>