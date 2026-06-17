<?php
session_start();
include("../config/connection.php");

/* CHECK ADMIN */

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

/* GET STUDENT ID */

$id = $_GET['id'];

/* FETCH STUDENT */

$studentQuery = mysqli_query($conn,
"SELECT * FROM students WHERE id='$id'");

$student = mysqli_fetch_assoc($studentQuery);

/* FETCH MARKS */

$marksQuery = mysqli_query($conn,
"SELECT * FROM marks
WHERE student_id='".$student['student_id']."'");

/* FETCH ATTENDANCE */

$attendanceQuery = mysqli_query($conn,
"SELECT * FROM attendance
WHERE student_id='".$student['student_id']."'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Details</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f4f7fc;
}

.main{
    padding:30px;
}

/* PROFILE */

.profile-card{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.profile-top{
    display:flex;
    align-items:center;
    gap:30px;
}

.profile-top img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #2563eb;
}

.profile-info h1{
    margin:0 0 15px;
}

.profile-info p{
    margin:8px 0;
    color:#555;
    font-size:16px;
}

/* CARD */

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#2563eb;
    color:white;
    padding:15px;
}

table td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #eee;
}

table tr:hover{
    background:#f9fafb;
}

/* STATUS */

.present{
    color:green;
    font-weight:bold;
}

.absent{
    color:red;
    font-weight:bold;
}

.high{
    color:green;
    font-weight:bold;
}

.medium{
    color:orange;
    font-weight:bold;
}

.low{
    color:red;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include("../Layout/navbar.php"); ?>

<div class="main">

    <!-- PROFILE -->

    <div class="profile-card">

        <div class="profile-top">

            <img src="<?php echo $student['photo']; ?>">

            <div class="profile-info">

                <h1><?php echo $student['name']; ?></h1>

                <p><b>Student ID:</b>
                <?php echo $student['student_id']; ?></p>

                <p><b>Class:</b>
                <?php echo $student['class']; ?></p>

                <p><b>Roll No:</b>
                <?php echo $student['roll_no']; ?></p>

                <p><b>Phone:</b>
                <?php echo $student['phone']; ?></p>

            </div>

        </div>

    </div>

    <!-- MARKS -->

    <div class="card">

        <h2>📊 Marks Details</h2>

        <br>

        <table>

            <tr>
                <th>Subject</th>
                <th>Marks</th>
                <th>Status</th>
            </tr>

            <?php while($m = mysqli_fetch_assoc($marksQuery)){ ?>

            <tr>

                <td><?php echo $m['subject']; ?></td>

                <td><?php echo $m['marks']; ?></td>

                <td>

                    <?php

                    if($m['marks'] >= 70){
                        echo "<span class='high'>Excellent</span>";
                    }
                    elseif($m['marks'] >= 40){
                        echo "<span class='medium'>Average</span>";
                    }
                    else{
                        echo "<span class='low'>Fail</span>";
                    }

                    ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

    <!-- ATTENDANCE -->

    <div class="card">

        <h2>📅 Attendance Details</h2>

        <br>

        <table>

            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php while($a = mysqli_fetch_assoc($attendanceQuery)){ ?>

            <tr>

                <td><?php echo $a['date']; ?></td>

                <td>

                    <?php

                    if($a['status'] == "Present"){
                        echo "<span class='present'>Present</span>";
                    }else{
                        echo "<span class='absent'>Absent</span>";
                    }

                    ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>