<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

/* NAVBAR */

.navbar{
    width:100%;
    background:#111827;
    padding:15px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

/* LOGO */

.logo{
    color:white;
    font-size:26px;
    font-weight:bold;
}

/* MENU */

.nav-links{
    display:flex;
    gap:15px;
}

.nav-links a{
    color:#d1d5db;
    text-decoration:none;
    padding:10px 18px;
    border-radius:10px;
    transition:0.3s;
    display:flex;
    align-items:center;
    gap:8px;
    font-size:15px;
}

.nav-links a:hover{
    background:#2563eb;
    color:white;
}

/* MOBILE BUTTON */

.menu-btn{
    display:none;
    background:none;
    border:none;
    color:white;
    font-size:22px;
    cursor:pointer;
}

/* MOBILE */

@media(max-width:768px){

    .navbar{
        padding:15px 20px;
    }

    .menu-btn{
        display:block;
    }

    .nav-links{
        position:absolute;
        top:70px;
        left:0;
        width:100%;
        background:#111827;
        flex-direction:column;
        display:none;
        padding:20px;
    }

    .nav-links.active{
        display:flex;
    }

    .nav-links a{
        width:100%;
    }
}

</style>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        🎓 Admin Panel
    </div>

    <button class="menu-btn" onclick="toggleMenu()">
        <i class="fa fa-bars"></i>
    </button>

    <div class="nav-links" id="navLinks">

        <a href="dashboard.php">
            <i class="fa fa-home"></i>
            Dashboard
        </a>

        <a href="student.php">
            <i class="fa fa-users"></i>
            Students
        </a>
        <a href="marks_add.php">
        <i class="fa fa-chart-column"></i>
             Marks
        </a>
        <a href="../admin/attendance.php">
            <i class="fa-solid fa-calendar-check"></i>
                Attendance
        </a>

        <a href="../admin/result.php">
    <i class="fa-solid fa-square-poll-vertical"></i>
    Result
</a>

        <a href="logout.php">
            <i class="fa fa-sign-out-alt"></i>
            Logout
        </a>

    </div>

</div>

<script>

function toggleMenu(){
    document.getElementById("navLinks").classList.toggle("active");
}

</script>