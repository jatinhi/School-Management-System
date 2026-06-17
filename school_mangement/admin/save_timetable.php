<?php
include("../config/connection.php");


$class_name  = $_POST['class_name'];
$day_name    = $_POST['day_name'];
$period_time = $_POST['period_time'];
$subject     = $_POST['subject_name'];

$sql = "INSERT INTO student_timetable
(class_name,day_name,period_time,subject_name)
VALUES
('$class_name','$day_name','$period_time','$subject')";

if(mysqli_query($conn,$sql)){
    echo "<script>
            alert('Timetable Added Successfully');
            window.location='../user/view_timetable.php';
          </script>";
}
else{
    echo "Error";
}

?>