<?php
session_start();
include("../config/connection.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Students</title>

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

.add-btn{
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
}

/* TABLE CARD */

.table-card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* SEARCH */

.search-box{
    margin-bottom:20px;
}

.search-box input{
    width:300px;
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    outline:none;
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
    font-size:15px;
}

table td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #eee;
}

table tr:hover{
    background:#f9fafb;
}

/* IMAGE */

.student-img{
    width:60px;
    height:60px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #2563eb;
}

/* BUTTONS */

.btn{
    padding:8px 15px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-size:14px;
    font-weight:bold;
}

.edit-btn{
    background:#16a34a;
}

.delete-btn{
    background:#dc2626;
}

/* RESPONSIVE */

@media(max-width:768px){

    .page-header{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }

    .search-box input{
        width:100%;
    }

    table{
        font-size:13px;
    }

    table th,
    table td{
        padding:10px;
    }
}

</style>

</head>

<body>

<!-- NAVBAR -->
<?php include("../Layout/navbar.php"); ?>

<div class="main">

    <!-- HEADER -->

    <div class="page-header">

        <h1>📚 Student Management</h1>

        <a href="add_student.php" class="add-btn">
            ➕ Add Student
        </a>

    </div>

    <!-- TABLE -->

    <div class="table-card">

        <div class="search-box">
            <input type="text" id="searchInput"
            placeholder="Search student..."
            onkeyup="searchStudent()">
        </div>

        <table id="studentTable">

            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Class</th>
                <th>Roll No</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td>
                    <a href="student_detail.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo $row['photo']; ?>" class="student-img">
                    </a>
                </td>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['student_id']; ?></td>

                <td><?php echo $row['class']; ?></td>

                <td><?php echo $row['roll_no']; ?></td>

                <td><?php echo $row['phone']; ?></td>

                <td>

                    <a href="edit_student.php?id=<?php echo $row['id']; ?>"
                    class="btn edit-btn">
                        Edit
                    </a>

                    <a href="delete_student.php?id=<?php echo $row['id']; ?>"
                    class="btn delete-btn"
                    onclick="return confirm('Delete this student?')">
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

<script>

function searchStudent(){

    let input = document.getElementById("searchInput").value.toLowerCase();

    let table = document.getElementById("studentTable");

    let tr = table.getElementsByTagName("tr");

    for(let i=1; i<tr.length; i++){

        let td = tr[i].getElementsByTagName("td")[1];

        if(td){

            let text = td.textContent || td.innerText;

            if(text.toLowerCase().indexOf(input) > -1){
                tr[i].style.display = "";
            }else{
                tr[i].style.display = "none";
            }
        }
    }
}

</script>

</body>
</html>