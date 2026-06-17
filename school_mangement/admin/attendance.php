<?php
session_start();
include("../config/connection.php");

/* CHECK ADMIN */

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$msg = "";

/* ADD ATTENDANCE */

if(isset($_POST['save_attendance'])){

    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    /* CHECK DUPLICATE ATTENDANCE */

    $check = mysqli_query($conn,"
    SELECT * FROM attendance
    WHERE student_id='$student_id'
    AND date='$date'
    ");

    if(mysqli_num_rows($check) > 0){

        $msg = "❌ Attendance Already Added For This Student Today!";

    }
    else{

        mysqli_query($conn,"
        INSERT INTO attendance(student_id,date,status)
        VALUES('$student_id','$date','$status')
        ");

        $msg = "✅ Attendance Added Successfully!";
    }
}

/* FETCH STUDENTS */

$students = mysqli_query($conn,
"SELECT * FROM students");

/* FETCH ATTENDANCE */

$attendance = mysqli_query($conn,"
SELECT attendance.*, students.name
FROM attendance
INNER JOIN students
ON attendance.student_id = students.student_id
ORDER BY attendance.id DESC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Attendance Management</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
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
}

/* CARD */

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* FORM */

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
    font-size:15px;
}

button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    font-size:15px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#1d4ed8;
}

/* MESSAGE */

.msg-success{
    background:#dcfce7;
    color:#166534;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    font-weight:bold;
}

.msg-error{
    background:#fee2e2;
    color:#991b1b;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    font-weight:bold;
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

<!-- NAVBAR -->

<?php include("../Layout/navbar.php"); ?>

<div class="main">

    <!-- HEADER -->

    <div class="header">

        <h1>📅 Attendance Management</h1>

    </div>

    <!-- ADD ATTENDANCE -->

    <div class="card">

        <h2>Add Attendance</h2>

        <br>

        <!-- MESSAGE -->

        <?php if($msg != ""){ ?>

            <?php if(strpos($msg,"❌") !== false){ ?>

                <div class="msg-error">
                    <?php echo $msg; ?>
                </div>

            <?php } else { ?>

                <div class="msg-success">
                    <?php echo $msg; ?>
                </div>

            <?php } ?>

        <?php } ?>

        <!-- FORM -->

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

                <!-- DATE -->

                <div>

                    <label>Date</label><br><br>

                    <input type="date"
                    name="date"
                    required>

                </div>

                <!-- STATUS -->

                <div>

                    <label>Status</label><br><br>

                    <select name="status" required>

                        <option value="">Select Status</option>

                        <option value="Present">Present</option>

                        <option value="Absent">Absent</option>

                    </select>

                </div>

            </div>

            <br>

            <button type="submit" name="save_attendance">

                ✅ Save Attendance

            </button>

        </form>

    </div>

    <!-- ATTENDANCE LIST -->

    <div class="card">

        <h2>Attendance Records</h2>

        <br>

        <table>

            <tr>
                <th>Student</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($attendance)){ ?>

            <tr>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['date']; ?></td>

                <td>

                    <?php

                    if($row['status'] == "Present"){

                        echo "<span class='present'>Present</span>";

                    }
                    else{

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