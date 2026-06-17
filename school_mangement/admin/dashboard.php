<?php
session_start();
include("../config/connection.php");

/* CHECK ADMIN LOGIN */

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}

/* TOTAL STUDENTS */

$total_students = mysqli_num_rows(
mysqli_query($conn, "SELECT * FROM students"));

/* TOTAL SUBJECTS */

$total_subjects = mysqli_num_rows(
mysqli_query($conn, "SELECT DISTINCT subject FROM marks"));

/* TOTAL CLASSES */

$total_classes = mysqli_num_rows(
mysqli_query($conn, "SELECT DISTINCT class FROM students"));

/* TOTAL MARKS RECORD */

$total_marks = mysqli_num_rows(
mysqli_query($conn, "SELECT * FROM marks"));

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
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
    color:#111827;
}

.admin-box{
    background:#2563eb;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
}

/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
    gap:20px;
}

/* CARD */

.card{
    padding:30px;
    border-radius:20px;
    color:white;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    position:relative;
    overflow:hidden;
}

.card i{
    font-size:45px;
    opacity:0.2;
    position:absolute;
    right:20px;
    bottom:20px;
}

.card h3{
    margin-bottom:15px;
    font-size:20px;
}

.card h1{
    font-size:42px;
}

/* CARD COLORS */

.card1{
    background:linear-gradient(135deg,#4f46e5,#7c3aed);
}

.card2{
    background:linear-gradient(135deg,#06b6d4,#2563eb);
}

.card3{
    background:linear-gradient(135deg,#16a34a,#22c55e);
}

.card4{
    background:linear-gradient(135deg,#dc2626,#ef4444);
}

/* INFO SECTION */

.info-section{
    margin-top:30px;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.info-section h2{
    margin-bottom:20px;
    color:#111827;
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.info-box{
    background:#f9fafb;
    padding:20px;
    border-radius:15px;
    border-left:5px solid #2563eb;
}

.info-box h3{
    margin-bottom:10px;
    color:#111827;
}

.info-box p{
    color:#6b7280;
    line-height:1.6;
}

/* RESPONSIVE */

@media(max-width:768px){

    .header{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }

    .cards{
        grid-template-columns:1fr;
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

        <h1>🏫 School Admin Dashboard</h1>

        <div class="admin-box">
            Welcome Admin
        </div>

    </div>

    <!-- DASHBOARD CARDS -->

    <div class="cards">

        <!-- STUDENTS -->

        <div class="card card1">

            <h3>Total Students</h3>

            <h1><?php echo $total_students; ?></h1>

            <i class="fa-solid fa-user-graduate"></i>

        </div>

        <!-- SUBJECTS -->

        <div class="card card2">

            <h3>Total Subjects</h3>

            <h1><?php echo $total_subjects; ?></h1>

            <i class="fa-solid fa-book"></i>

        </div>

        <!-- CLASSES -->

        <div class="card card3">

            <h3>Total Classes</h3>

            <h1><?php echo $total_classes; ?></h1>

            <i class="fa-solid fa-school"></i>

        </div>

        <!-- MARKS -->

        <div class="card card4">

            <h3>Total Marks Records</h3>

            <h1><?php echo $total_marks; ?></h1>

            <i class="fa-solid fa-chart-column"></i>

        </div>

    </div>

    <!-- SCHOOL DETAILS -->

    <div class="info-section">

        <h2>📚 School Information</h2>

        <div class="info-grid">

            <div class="info-box">

                <h3>Student Management</h3>

                <p>
                    Manage all student records including
                    admission, class details, phone number,
                    and profile photos.
                </p>

            </div>

            <div class="info-box">

                <h3>Marks Management</h3>

                <p>
                    Add subject-wise marks for students
                    and monitor academic performance easily.
                </p>

            </div>

            <div class="info-box">

                <h3>Class Management</h3>

                <p>
                    Organize students according to their
                    classes and maintain academic structure.
                </p>

            </div>

            <div class="info-box">

                <h3>Performance Tracking</h3>

                <p>
                    Track student performance and results
                    using marks and percentage analysis.
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>