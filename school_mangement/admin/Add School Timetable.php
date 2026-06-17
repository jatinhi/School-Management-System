<?php include("../config/connection.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Timetable</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    min-height:100vh;
    background:linear-gradient(135deg,#4f46e5,#7c3aed,#9333ea);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.card-box{
    width:100%;
    max-width:700px;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0px 15px 40px rgba(0,0,0,.2);
}

.header{
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    color:white;
    text-align:center;
    padding:25px;
}

.btn-save{
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    border:none;
}

</style>
</head>
<body>

<div class="card card-box">

    <div class="header">
        <h2><i class="bi bi-calendar-week"></i> Student Timetable</h2>
        <p>Add Daily Timetable</p>
    </div>

    <div class="card-body p-4">

        <form action="save_timetable.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Class</label>

                <select name="class_name" class="form-select" required>

                    <option value="">Select Class</option>

                    <option>Class 1</option>
                    <option>Class 2</option>
                    <option>Class 3</option>
                    <option>Class 4</option>
                    <option>Class 5</option>
                    <option>Class 6</option>
                    <option>Class 7</option>
                    <option>Class 8</option>
                    <option>Class 9</option>
                    <option>Class 10</option>
                    <option>Class 11 Science</option>
                    <option>Class 11 Commerce</option>
                    <option>Class 12 Science</option>
                    <option>Class 12 Commerce</option>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Day</label>

                <select name="day_name" class="form-select" required>

                    <option value="">Select Day</option>

                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                    <option>Saturday</option>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Period Time</label>

                <select name="period_time" class="form-select" required>

                    <option value="">Select Time</option>

                    <option>08:00 AM - 09:00 AM</option>
                    <option>09:00 AM - 10:00 AM</option>
                    <option>10:00 AM - 11:00 AM</option>
                    <option>11:00 AM - 12:00 PM</option>
                    <option>12:00 PM - 01:00 PM</option>

                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Subject</label>

                <select name="subject_name" class="form-select" required>

                    <option value="">Select Subject</option>

                    <option>English</option>
                    <option>Gujarati</option>
                    <option>Hindi</option>
                    <option>Mathematics</option>
                    <option>Science</option>
                    <option>Social Science</option>
                    <option>Computer</option>
                    <option>Physics</option>
                    <option>Chemistry</option>
                    <option>Biology</option>
                    <option>Economics</option>
                    <option>Accountancy</option>
                    <option>Statistics</option>

                </select>
            </div>

            <button class="btn btn-primary btn-save w-100">
                <i class="bi bi-plus-circle"></i>
                Add Timetable
            </button>

        </form>

    </div>

</div>

</body>
</html>