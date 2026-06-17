<?php
session_start();
include("../config/connection.php");

/* CHECK LOGIN */

if(!isset($_SESSION['user'])){
    die("Name session not found");
}

/* SESSION NAME */

$user = $_SESSION['user'];

/* FETCH STUDENT */

$query = mysqli_query($conn,
"SELECT * FROM students WHERE name='$user'");

$student = mysqli_fetch_array($query);

if(!$student){
    die("Student not found");
}

/* STUDENT ID */

$student_id = $student['student_id'];

/* FETCH MARKS */

$result = mysqli_query($conn,
"SELECT * FROM marks WHERE student_id='$student_id'");

?>
</table>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Marks</title>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f7fc;
}

/* MAIN */

.main{
    padding:30px;
}

/* HEADER */

.header{
    background:white;
    padding:25px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.header h1{
    margin:0;
    color:#111827;
}

/* PROFILE */

.profile{
    background:#2563eb;
    color:white;
    padding:10px 20px;
    border-radius:10px;
}

/* SUMMARY */

.summary{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.summary-box{
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    color:white;
    padding:25px;
    border-radius:20px;
}

.summary-box h2{
    margin:0 0 10px;
}

.summary-box h1{
    margin:0;
    font-size:40px;
}

/* CARD */

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
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

/* RESULT COLORS */

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

/* RESPONSIVE */

@media(max-width:768px){

    .header{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }

    table{
        font-size:13px;
    }
}

</style>

</head>

<body>

<!-- HEADER FILE -->

<?php include("../Layout/header.php"); ?>

<div class="main">

    <!-- PAGE HEADER -->

    <div class="header">

        <h1>📊 My Marks</h1>

        <div class="profile">
            <?php echo $student['name']; ?>
        </div>

    </div>

    <!-- SUMMARY -->

    <div class="summary">

        <?php
        $marksData = mysqli_query($conn,
        "SELECT * FROM marks WHERE student_id='$student_id'");

         $total = 0;
            $count = 0;

    while($m = mysqli_fetch_array($marksData)){

        $total += $m['marks'];

        $count++;
    }

    $percentage = ($count > 0) ? $total / $count : 0;


        ?>

        <div class="summary-box">
            <h2>Total Subjects</h2>
            <h1><?php echo $count; ?></h1>
        </div>

        <div class="summary-box">
            <h2>Percentage</h2>
            <h1><?php echo round($percentage); ?>%</h1>
        </div>

    </div>

    <!-- MARKS TABLE -->

    <div class="card">

        <table>

            <tr>
                <th>Subject</th>
                <th>Marks</th>
                <th>Result</th>
            </tr>

            <?php

            mysqli_data_seek($result,0);

            while($row = mysqli_fetch_array($result)){ ?>

            <tr>

                <td><?php echo $row['subject']; ?></td>

                <td><?php echo $row['marks']; ?></td>

                <td>

                    <?php

                    if($row['marks'] >= 70){
                        echo "<span class='high'>Excellent</span>";
                    }
                    elseif($row['marks'] >= 40){
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

</div>

<?php include("../Layout/footer.php"); ?>
</body>
</html>