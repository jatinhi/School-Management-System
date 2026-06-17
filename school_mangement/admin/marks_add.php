<?php
session_start();
include("../config/connection.php");

/* CHECK ADMIN LOGIN */

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = "";

/* ADD MARKS */

if(isset($_POST['add_marks'])){

    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    mysqli_query($conn,"INSERT INTO marks(student_id,subject,marks)
    VALUES('$student_id','$subject','$marks')");

    $msg = "✅ Marks Added Successfully!";
}

/* FETCH STUDENTS */

$students = mysqli_query($conn,"SELECT * FROM students");

/* FETCH MARKS DATA */

$marksData = mysqli_query($conn,"
SELECT marks.*, students.name
FROM marks
INNER JOIN students
ON marks.student_id = students.student_id
ORDER BY marks.id DESC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Marks Management</title>

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

.page-header{
    background:white;
    padding:25px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.page-header h1{
    margin:0;
    color:#111827;
}

/* CARD */

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

/* MESSAGE */

.msg{
    background:#dcfce7;
    color:#166534;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    font-weight:bold;
}

/* FORM */

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

select,
input{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
    font-size:15px;
}

button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
}

button:hover{
    background:#1d4ed8;
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

    .page-header{
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

<!-- NAVBAR -->

<?php include("../Layout/navbar.php"); ?>

<div class="main">

    <!-- PAGE HEADER -->

    <div class="page-header">

        <h1>📊 Marks Management</h1>

    </div>

    <!-- ADD MARKS -->

    <div class="card">

        <h2>Add Student Marks</h2>

        <br>

        <?php if($msg != ""){ ?>

            <div class="msg">
                <?php echo $msg; ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="form-grid">

                <!-- STUDENT -->

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

                <!-- SUBJECT -->

                <div>

                    <label>Subject</label><br><br>

                    <select name="subject" required>

                        <option value="">Select Subject</option>

                        <option value="Gujarati">Gujarati</option>

                        <option value="English">English</option>

                        <option value="Hindi">Hindi</option>

                        <option value="Mathematics">Mathematics</option>

                        <option value="Science">Science</option>

                        <option value="Social Science">Social Science</option>

                        <option value="Computer">Computer</option>

                        <option value="Sanskrit">Sanskrit</option>

                    </select>

                </div>

                <!-- MARKS -->

                <div>

                    <label>Marks</label><br><br>

                    <input type="number"
                    name="marks"
                    placeholder="Enter Marks"
                    required>

                </div>

            </div>

            <br>

            <button type="submit" name="add_marks">

                ➕ Add Marks

            </button>

        </form>

    </div>

    <!-- MARKS TABLE -->

    <div class="card">

        <h2>Student Marks List</h2>

        <br>

        <table>

            <tr>
                <th>Student</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($marksData)){ ?>

            <tr>

                <td><?php echo $row['name']; ?></td>

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

</body>
</html>