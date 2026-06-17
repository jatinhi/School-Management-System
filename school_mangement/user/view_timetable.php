<?php
session_start();
include("../config/connection.php");

if(!isset($_SESSION['student_id']))
{
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* Fetch Student Details */
$studentQuery = mysqli_query(
    $conn,
    "SELECT * FROM students WHERE student_id='$student_id'"
);

if(mysqli_num_rows($studentQuery) == 0)
{
    die("Student record not found!");
}

$student = mysqli_fetch_assoc($studentQuery);

$student_name = $student['name'];
$class_name   = $student['class'];

/* Fetch Timetable According To Student Class */
$timetableQuery = mysqli_query(
    $conn,
    "SELECT * FROM student_timetable
     WHERE class_name='$class_name'
     ORDER BY FIELD(day_name,
     'Monday',
     'Tuesday',
     'Wednesday',
     'Thursday',
     'Friday',
     'Saturday')"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Timetable</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fc;
}

.card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.card-header{
    background:linear-gradient(135deg,#2563eb,#4f46e5);
    color:white;
}

.table th{
    background:#2563eb;
    color:white;
}

</style>

</head>

<body>

<?php include("../Layout/header.php"); ?>

<div class="container mt-4">

<div class="card">

<div class="card-header p-4">

<h3>
<i class="fa-solid fa-calendar-days"></i>
 My Class Timetable
</h3>

<p class="mb-1">
<b>Student:</b> <?php echo $student_name; ?>
</p>

<p class="mb-0">
<b>Class:</b> <?php echo $class_name; ?>
</p>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>
<tr>
<th>Day</th>
<th>Time</th>
<th>Subject</th>
</tr>
</thead>

<tbody>

<?php

if(mysqli_num_rows($timetableQuery) > 0)
{
    while($row = mysqli_fetch_assoc($timetableQuery))
    {
?>

<tr>
<td><?php echo $row['day_name']; ?></td>
<td><?php echo $row['period_time']; ?></td>
<td><?php echo $row['subject_name']; ?></td>
</tr>

<?php
    }
}
else
{
?>

<tr>
<td colspan="3" class="text-center text-danger">
No Timetable Available For Your Class
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>