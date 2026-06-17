<?php
session_start();
include("../config/connection.php");

/* CHECK USER */

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
    header("Location: ../login.php");
    exit();
}

/* GET SESSION NAME */

$name = $_SESSION['user'];

/* FETCH STUDENT */

$studentQuery = mysqli_query($conn,
"SELECT * FROM students WHERE name='$name'");

$student = mysqli_fetch_assoc($studentQuery);

/* CHECK STUDENT */

if(!$student){
    die("Student Record Not Found");
}

$student_id = $student['student_id'];

/* FETCH RESULT */

$resultQuery = mysqli_query($conn,
"SELECT * FROM results WHERE student_id='$student_id'");

$resultData = mysqli_fetch_assoc($resultQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Result</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f7fc;
}

.main{
    padding:30px;
}

.card{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    max-width:700px;
    margin:auto;
}

.card h1{
    text-align:center;
    margin-bottom:30px;
}

.result-box{
    background:#f9fafb;
    padding:20px;
    border-radius:15px;
    margin-bottom:15px;
}

.result-box h3{
    margin-bottom:10px;
    color:#2563eb;
}

.result-box p{
    font-size:20px;
}

.pass{
    color:green;
    font-weight:bold;
}

.fail{
    color:red;
    font-weight:bold;
}

.no-result{
    text-align:center;
    color:red;
    font-size:20px;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include("../Layout/header.php"); ?>

<div class="main">

    <div class="card">

        <h1>📊 My Result</h1>

        <?php if($resultData){ ?>

        <div class="result-box">

            <h3>Student Name</h3>

            <p>
                <?php echo $student['name']; ?>
            </p>

        </div>

        <div class="result-box">

            <h3>Total Marks</h3>

            <p>
                <?php echo $resultData['total_marks']; ?>
            </p>

        </div>

        <div class="result-box">

            <h3>Percentage</h3>

            <p>
                <?php echo $resultData['percentage']; ?>%
            </p>

        </div>

        <div class="result-box">

            <h3>Grade</h3>

            <p>
                <?php echo $resultData['grade']; ?>
            </p>

        </div>

        <div class="result-box">

            <h3>Final Result</h3>

            <p>

            <?php

            if($resultData['result'] == "Pass"){

                echo "<span class='pass'>Pass</span>";

            }else{

                echo "<span class='fail'>Fail</span>";

            }

            ?>

            </p>

        </div>

        <?php } else { ?>

            <div class="no-result">

                ❌ Result Not Available Yet

            </div>

        <?php } ?>

    </div>

</div>

<?php include("../Layout/footer.php"); ?>

</body>
</html>