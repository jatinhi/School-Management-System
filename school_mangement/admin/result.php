<?php
session_start();
include("../config/connection.php");

/* CHECK ADMIN */

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = "";

/* ADD RESULT */

if(isset($_POST['add_result'])){

    $student_id = $_POST['student_id'];
    /* AUTO CALCULATE RESULT */

    $marksQuery = mysqli_query($conn,
    "SELECT SUM(marks) as total_marks,
    AVG(marks) as percentage
    FROM marks
    WHERE student_id='$student_id'");

    $marksData = mysqli_fetch_assoc($marksQuery);

    $total_marks = $marksData['total_marks'];

    $percentage = round($marksData['percentage'],2);

    /* GRADE SYSTEM */

    if($percentage >= 90){
        $grade = 'A+';
    }
    elseif($percentage >= 80){
        $grade = 'A';
    }
    elseif($percentage >= 70){
        $grade = 'B+';
    }
    elseif($percentage >= 60){
        $grade = 'B';
    }
    elseif($percentage >= 50){
        $grade = 'C';
    }
    else{
        $grade = 'D';
    }

    /* FINAL RESULT */

    if($percentage >= 40){
        $result = 'Pass';
    }
    else{
        $result = 'Fail';
    };

    /* CHECK EXISTING RESULT */

    $check = mysqli_query($conn,
    "SELECT * FROM results WHERE student_id='$student_id'");

    if(mysqli_num_rows($check) > 0){

        $msg = "❌ Result Already Added";

    }else{

        mysqli_query($conn,
        "INSERT INTO results(student_id,total_marks,percentage,grade,result)
        VALUES('$student_id','$total_marks','$percentage','$grade','$result')");

        $msg = "✅ Result Added Successfully";
    }
}

/* FETCH STUDENTS */

$students = mysqli_query($conn,
"SELECT * FROM students");

/* FETCH RESULTS */

$results = mysqli_query($conn,
"SELECT results.*, students.name
FROM results
INNER JOIN students
ON results.student_id = students.student_id
ORDER BY results.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Result Management</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f4f7fc;
}

.main{
    padding:30px;
}

.header{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

input,
select{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
}

button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

.msg{
    background:#dcfce7;
    color:#166534;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
}

.error{
    background:#fee2e2;
    color:#991b1b;
}

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

.pass{
    color:green;
    font-weight:bold;
}

.fail{
    color:red;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include("../Layout/navbar.php"); ?>

<div class="main">

    <div class="header">
        <h1>📊 Result Management</h1>
    </div>

    <div class="card">

        <h2>Add Student Result</h2>

        <br>

        <?php if($msg != ""){ ?>

            <div class="msg <?php if(strpos($msg,'❌') !== false){ echo 'error'; } ?>">
                <?php echo $msg; ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="form-grid">

                <div>
                    <label>Student</label><br><br>

                    <select name="student_id" required>

                        <option value="">Select Student</option>

                        <?php while($s = mysqli_fetch_assoc($students)){ ?>

                        <option value="<?php echo $s['student_id']; ?>">
                            <?php echo $s['name']; ?>
                        </option>

                        <?php } ?>

                    </select>
                </div>

                <div>
                    <label>Automatic Result System</label><br><br>

                    <input type="text"
                    value="Marks, Percentage, Grade and Result will be calculated automatically"
                    readonly>

            </div>

            <br>

            <button type="submit" name="add_result">
                ➕ Add Result
            </button>

        </form>

    </div>

    <div class="card">

        <h2>Student Results</h2>

        <br>

        <table>

            <tr>
                <th>Student</th>
                <th>Total Marks</th>
                <th>Percentage</th>
                <th>Grade</th>
                <th>Result</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($results)){ ?>

            <tr>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['total_marks']; ?></td>

                <td><?php echo $row['percentage']; ?>%</td>

                <td><?php echo $row['grade']; ?></td>

                <td>

                    <?php

                    if($row['result'] == 'Pass'){
                        echo "<span class='pass'>Pass</span>";
                    }else{
                        echo "<span class='fail'>Fail</span>";
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