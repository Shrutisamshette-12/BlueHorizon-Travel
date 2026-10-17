<?php
session_start();
include("db.php");

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Delete user
if (isset($_GET['delete_user'])) {
    $userId = intval($_GET['delete_user']);
    $conn->query("DELETE FROM users WHERE id = $userId");
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch data
$totalUsers = $conn->query("SELECT * FROM users")->num_rows;
$totalBookings = $conn->query("SELECT * FROM bookings")->num_rows;

$usersResult = $conn->query("SELECT * FROM users");
$bookingsResult = $conn->query("SELECT * FROM bookings ORDER BY date DESC");
$summaryResult = $conn->query("SELECT place, COUNT(*) AS total FROM bookings GROUP BY place");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f4f7fb;
    margin-top:70px;
    overflow-x:hidden;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    height:100%;
    background:linear-gradient(180deg,#1e1e2f,#2c2c54);
    color:#fff;
    padding:20px;
    position:fixed;
    top:70px;
    left:0;
}

.sidebar h2{
    text-align:center;
    margin-bottom:30px;
    color:#ffa500;
}

.sidebar a{
    display:block;
    padding:12px;
    margin:8px 0;
    color:#ddd;
    border-radius:8px;
    transition:0.3s;
    text-decoration:none;
}

.sidebar a:hover{
    background:#ffa500;
    color:#fff;
    padding-left:18px;
}

/* MAIN */
.main{
    margin-left:250px;
    padding:20px;
    width:calc(100% - 250px);
}

/* CARDS */
.cards{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.card{
    flex:1;
    min-width:200px;
    padding:20px;
    background:#fff;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    font-size:18px;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

th{
    background:#ffa500;
    color:#fff;
    text-align:left;
    padding:12px 15px;
    font-size:16px;
}

td{
    text-align:left;
    padding:12px 15px;
    border-bottom:1px solid #eee;
    font-size:15px;
}

tr:hover{
    background:#f9f9f9;
}

/* STATUS COLORS */
.status-on{
    color: orange;
    font-weight: bold;
}

.status-done{
    color: green;
    font-weight: bold;
}

.status-today{
    color: blue;
    font-weight: bold;
}

/* DELETE */
.delete{
    color:red;
    font-weight:bold;
}

.delete:hover{
    color:darkred;
}

h1{margin-bottom:20px;}
h2{margin-top:30px;}

</style>
</head>

<body>

<!-- NAVBAR -->
<?php include 'navbar.php'; ?>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="#">Dashboard</a>
    <a href="#users">Users</a>
    <a href="#bookings">Bookings</a>
    <a href="admin_login.php?logout=1">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <h1>Welcome Admin: <?php echo $_SESSION['admin']; ?> 👋</h1>

    <!-- CARDS -->
    <div class="cards">
        <div class="card">👤 Total Users <br><strong><?php echo $totalUsers; ?></strong></div>
        <div class="card">📦 Total Bookings <br><strong><?php echo $totalBookings; ?></strong></div>
    </div>

    <!-- SUMMARY -->
    <h2>📊 Bookings Summary</h2>
    <table>
        <tr><th>Place</th><th>Total Bookings</th></tr>
        <?php while($row = $summaryResult->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['place']; ?></td>
            <td><?php echo $row['total']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- USERS -->
    <h2 id="users">👥 Users</h2>
    <table>
        <tr><th>ID</th><th>Username</th><th>Email</th><th>Action</th></tr>
        <?php while($row = $usersResult->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a class="delete" href="admin_dashboard.php?delete_user=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- BOOKINGS -->
    <h2 id="bookings">📦 Bookings</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Place</th>
            <th>Date</th>
            <th>Status</th> <!-- 🔥 NEW -->
        </tr>

        <?php 
        $currentDate = date("Y-m-d");

        while($row = $bookingsResult->fetch_assoc()): 

            $bookingDate = date("Y-m-d", strtotime($row['date']));

            if($bookingDate == $currentDate){
                $status = "Today";
                $class = "status-today";
            }
            elseif($bookingDate < $currentDate){
                $status = "Completed";
                $class = "status-done";
            }
            else{
                $status = "On Trip";
                $class = "status-on";
            }
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['place']; ?></td>
            <td><?php echo $row['date']; ?></td>

            <td class="<?php echo $class; ?>">
                <?php echo $status; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

</body>
</html>