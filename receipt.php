<?php
session_start();
include("db.php");
include("packages.php");

// CHECK LOGIN

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// GET LATEST BOOKING

$username = $_SESSION['user'];

$stmt = $conn->prepare(
    "SELECT * FROM bookings 
     WHERE username=? 
     ORDER BY id DESC 
     LIMIT 1"
);

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){

    echo "No booking found!";
    exit();
}

$data = $result->fetch_assoc();

// PRICE

$place = $data['place'];

$price_per_person =
    get_price($place) ?? 0;

$total =
    $price_per_person * $data['guests'];

// BOOKING ID

$booking_id =
    "BH" . rand(10000,99999);

// DESTINATION IMAGES

$banner =
"https://images.unsplash.com/photo-1507525428034-b723cf961d3e";

if($place == "Goa"){

    $banner =
    "https://images.unsplash.com/photo-1519046904884-53103b34b206";
}

elseif($place == "Kashmir"){

    $banner =
    "https://images.unsplash.com/photo-1598091383021-15ddea10925d";
}

elseif($place == "Agra"){

    $banner =
    "https://images.unsplash.com/photo-1564507592333-c60657eea523";
}

elseif($place == "Jaipur"){

    $banner =
    "https://images.unsplash.com/photo-1477587458883-47145ed94245";
}

elseif($place == "Delhi"){

    $banner =
    "https://images.unsplash.com/photo-1587474260584-136574528ed5";
}

elseif($place == "Udaipur"){

    $banner =
    "https://images.unsplash.com/photo-1599661046289-e31897846e41";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Premium Receipt</title>

<link rel="stylesheet" href="f1.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

/* BODY */

body{
    font-family: Arial;
    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
    no-repeat center center/cover;

    min-height:100vh;

    justify-content:center;
    align-items:center;

    padding-top:90px;
}

/* CENTER */

.form-center{
    width:100%;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* RECEIPT CARD */

.receipt{

    width:430px;

    background:rgba(255,255,255,0.16);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:28px;

    overflow:hidden;

    box-shadow:0 15px 40px rgba(0,0,0,0.35);

    animation:fadeIn 0.5s ease;
}

/* BANNER */

.banner{

    position:relative;

    height:220px;
}

.banner img{

    width:100%;
    height:100%;
    object-fit:cover;
}

/* OVERLAY */

.overlay{

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:100%;

    background:
    linear-gradient(
    to top,
    rgba(0,0,0,0.8),
    transparent);
}

/* TITLE */

.ticket-title{

    position:absolute;

    bottom:20px;
    left:20px;

    color:white;
}

.ticket-title h2{

    font-size:30px;
}

.ticket-title p{

    font-size:14px;

    opacity:0.9;
}

/* PAID BADGE */

.paid{

    position:absolute;

    top:18px;
    right:18px;

    background:#00c853;

    color:white;

    padding:8px 16px;

    border-radius:50px;

    font-size:13px;

    font-weight:bold;

    box-shadow:0 0 15px rgba(0,200,83,0.6);
}

/* CONTENT */

.content{

    padding:25px;

    color:white;
}

/* ROW */

.row{

    display:flex;

    justify-content:space-between;

    margin-bottom:16px;

    font-size:16px;
}

/* LABEL */

.label{

    opacity:0.85;
}

/* VALUE */

.value{

    font-weight:600;
}

/* DIVIDER */

.divider{

    border-top:2px dashed rgba(255,255,255,0.3);

    margin:20px 0;
}

/* TOTAL */

.total-box{

    display:flex;

    justify-content:space-between;

    align-items:center;
}

.total-box h1{

    font-size:34px;

    color:#ffd166;
}

/* QR */

.qr-box{

    margin-top:25px;

    text-align:center;
}

.qr-box img{

    width:120px;

    background:white;

    padding:10px;

    border-radius:16px;
}

.booking-id{

    margin-top:10px;

    font-size:15px;

    letter-spacing:1px;
}

/* BUTTON */

.btn{

    margin-top:25px;

    width:100%;

    padding:14px;

    border:none;

    border-radius:14px;

    background:
    linear-gradient(
    90deg,
    #ff512f,
    #f09819);

    color:white;

    font-size:17px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    transform:translateY(-2px);

    box-shadow:0 10px 20px rgba(255,81,47,0.4);
}

/* ANIMATION */

@keyframes fadeIn{

    from{

        transform:translateY(20px);

        opacity:0;
    }

    to{

        transform:translateY(0);

        opacity:1;
    }
}

/* MOBILE */

@media(max-width:500px){

    .receipt{

        width:100%;
    }

    .ticket-title h2{

        font-size:24px;
    }

    .total-box h1{

        font-size:26px;
    }
}
@media print {

    nav,
    .navbar,
    header{
        display:none !important;
    }

    body{
        background:white !important;
    }

    .receipt{
        box-shadow:none !important;
        border:none !important;
        width:100%;
    }

    .btn{
        display:none;
    }
}
@media print {

    body{
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;

        background:
        linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
        url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
        no-repeat center center/cover !important;
    }

    .receipt{
        background:rgba(255,255,255,0.16) !important;
        backdrop-filter:blur(18px);
    }
}
@media print {

    /* HIDE NAVBAR + BUTTON */

    nav,
    .navbar,
    header,
    .btn{
        display:none !important;
    }

    /* BODY */

    body{

        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;

        background:white !important;

        display:block !important;
    }

    /* CENTER */

    .form-center{

        display:flex !important;
        justify-content:center !important;
        align-items:center !important;

        padding:0 !important;
        margin:0 !important;
    }

    /* RECEIPT */

    .receipt{

        width:420px !important;

        background:white !important;

        color:black !important;

        box-shadow:none !important;

        border:2px solid #ddd !important;
    }

    /* CONTENT */

    .content{

        color:black !important;
    }

    .label,
    .value,
    .total-box,
    .booking-id{

        color:black !important;
    }

    /* REMOVE GLASS EFFECT */

    .receipt,
    .content{

        backdrop-filter:none !important;
    }

    /* IMAGE */

    .banner img{

        display:block !important;
    }
}

</style>
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="form-center">

<div class="receipt">

    <!-- BANNER -->

    <div class="banner">

        <img src="<?php echo $banner; ?>">

        <div class="overlay"></div>

        <!-- PAID -->

        <div class="paid">

            PAID

        </div>

        <!-- TITLE -->

        <div class="ticket-title">

            <h2>✈️ Blue Horizon</h2>

            <p>Premium Travel Receipt</p>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="content">

        <div class="row">

            <span class="label">
                👤 Passenger
            </span>

            <span class="value">
                <?php echo $data['username']; ?>
            </span>

        </div>

        <div class="row">

            <span class="label">
                📍 Destination
            </span>

            <span class="value">
                <?php echo $data['place']; ?>
            </span>

        </div>

        <div class="row">

            <span class="label">
                👥 Guests
            </span>

            <span class="value">
                <?php echo $data['guests']; ?>
            </span>

        </div>

        <div class="row">

            <span class="label">
                📅 Travel Date
            </span>

            <span class="value">
                <?php echo $data['date']; ?>
            </span>

        </div>

        <div class="row">

            <span class="label">
                💰 Price / Person
            </span>

            <span class="value">
                ₹<?php echo $price_per_person; ?>
            </span>

        </div>

        <div class="divider"></div>

        <!-- TOTAL -->

        <div class="total-box">

            <div>

                <p>Total Paid</p>

                <h1>
                    ₹<?php echo $total; ?>
                </h1>

            </div>

            <div style="font-size:42px;">

                🌍

            </div>

        </div>

        <!-- QR -->

        <div class="qr-box">

            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $booking_id; ?>">

            <div class="booking-id">

                Booking ID :
                <b><?php echo $booking_id; ?></b>

            </div>

        </div>

        <!-- BUTTON -->

        <button class="btn"
                onclick="window.print()">

            Download Receipt 🧾

        </button>

    </div>

</div>

</div>

</body>
</html>