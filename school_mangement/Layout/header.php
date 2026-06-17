<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

.navbar{
    background:#111827;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    color:white;
    font-size:24px;
    font-weight:bold;
}

.menu{
    display:flex;
    gap:15px;
}

.menu a{
    color:#d1d5db;
    text-decoration:none;
    padding:10px 15px;
    border-radius:8px;
    transition:0.3s;
}

.menu a:hover{
    background:#2563eb;
    color:white;
}

</style>

<div class="navbar">

    <div class="logo">
        🎓 Student Panel
    </div>

    <div class="menu">
<div class="menu">

    <a href="dashboard.php">
        <i class="fa fa-home"></i>
        Dashboard
    </a>

    <a href="marks.php">
        <i class="fa fa-chart-column"></i>
        My Marks
    </a>

    <a href="result.php">
        <i class="fa-solid fa-chart-line"></i>
        My Result
    </a>

    <a href="view_timetable.php">
        <i class="fa-solid fa-calendar-days"></i>
        Timetable
    </a>

    <a href="logout.php">
        <i class="fa fa-sign-out-alt"></i>
        Logout
    </a>

</div>
    </div>

</div>