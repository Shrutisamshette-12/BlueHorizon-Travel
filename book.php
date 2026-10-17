<?php
session_start();
include("db.php");
include("packages.php");

// GET values from package page
$place = $_GET['place'] ?? '';
// Price comes from packages.php (server side), NOT from the URL
$price = get_price($place) ?? 0;

// Check login
if(!isset($_SESSION['user'])){
    header("Location: login.php?place=" . urlencode($place) . "&price=" . urlencode($price));
    exit();
}

$error = "";
$success = false;

if(isset($_POST['book'])) {

    $username = $_SESSION['user'];

    $mobile = $_POST['mobile'];

    $age = $_POST['age'];

    $traveller_names = $_POST['traveller_name'] ?? [];

    $traveller_ages = $_POST['traveller_age'] ?? [];

    $place = $_POST['place'];

    $people = $_POST['people'];

    $date = $_POST['date'];

    // Never trust the price sent by the browser: look it up on the server
    $price = get_price($place);

    if($price === null){
        die("Invalid package selected.");
    }

    $people = max(1, (int)$people);

    $total = $price * $people;

    // Insert booking

    $stmt = $conn->prepare(
        "INSERT INTO bookings 
        (username, place, guests, date) 
        VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssis",
        $username,
        $place,
        $people,
        $date
    );

    if($stmt->execute()){

        // SAVE DATA FOR RECEIPT

        $_SESSION['last_booking'] = [

            "username" => $username,

            "mobile" => $mobile,

            "age" => $age,

            "traveller_names" => $traveller_names,

            "traveller_ages" => $traveller_ages,

            "place" => $place,

            "people" => $people,

            "date" => $date,

            "price" => $price,

            "total" => $total
        ];

        $success = true;

    } else {

        $error = "❌ Booking failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Book Your Adventure</title>

<link rel="stylesheet" href="f1.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Roboto', sans-serif;
}

body{
    min-height:100vh;
    background:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')
    no-repeat center center/cover;
    background-size:cover;
    padding-bottom:40px;
}

/* CENTER */

.form-center{
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding-top:10px;
    padding-bottom:40px;
}

/* CONTAINER */

.container{
    width:420px;
    background:rgba(255,255,255,0.22);
    backdrop-filter:blur(14px);
    padding:28px;
    border-radius:22px;
    text-align:center;
    box-shadow:0 10px 35px rgba(0,0,0,0.35);
    border:1px solid rgba(255,255,255,0.2);
}

/* TITLE */

h2{
    margin-bottom:20px;
    font-size:28px;
    color:#ff5722;
}

/* INPUT GROUP */

.input-group{
    margin-bottom:15px;
    text-align:left;
}

.input-group label{
    display:block;
    margin-bottom:6px;
    font-size:15px;
    font-weight:600;
    color:#222;
}

/* INPUT */

.input-group input{
    width:100%;
    padding:11px 14px;
    border-radius:10px;
    border:1px solid #ddd;
    outline:none;
    font-size:15px;
    transition:0.3s;
}

.input-group input:focus{
    border-color:#ff5722;
    box-shadow:0 0 8px rgba(255,87,34,0.3);
}

/* DESTINATION */

.destination{
    background:white;
    padding:12px;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    color:#333;
}

/* BUTTON */

button{
    width:100%;
    padding:13px;
    border:none;
    border-radius:12px;
    background:linear-gradient(90deg,#ff5722,#ff9800);
    color:white;
    font-size:17px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(255,87,34,0.35);
}

/* NOTE */

.note{
    margin-top:15px;
    color:#222;
    font-size:14px;
}

/* POPUP */

.popup{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.65);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:1000;
}

/* SUCCESS POPUP */

.popup-content{
    background:white;
    padding:28px;
    border-radius:18px;
    width:340px;
    text-align:center;
    animation:popupAnim 0.4s ease;
}

/* PAYMENT BOX */

.payment-box{
    background:white;
    width:380px;
    padding:28px;
    border-radius:22px;
    text-align:center;
    animation:popupAnim 0.4s ease;
    box-shadow:0 15px 40px rgba(0,0,0,0.35);
}

.payment-box h2{
    color:#ff5722;
    margin-bottom:8px;
    font-size:28px;
}

.pay-subtitle{
    color:#666;
    margin-bottom:20px;
    font-size:14px;
}

/* METHODS */

.payment-methods{
    display:flex;
    gap:10px;
    margin-bottom:22px;
}

.method{
    flex:1;
    padding:10px;
    border:2px solid #eee;
    border-radius:14px;
    cursor:pointer;
    transition:0.3s;
    background:#fafafa;
}

.method img{
    width:36px;
    height:36px;
    object-fit:contain;
}

.method span{
    display:block;
    margin-top:6px;
    font-size:13px;
    font-weight:600;
}

.method:hover{
    transform:translateY(-3px);
}

.method.active{
    border-color:#ff5722;
    background:#fff4ef;
}

/* QR */

.scanner-box{
    position:relative;
    width:200px;
    height:200px;
    margin:0 auto;
    overflow:hidden;
    border-radius:18px;
    border:4px solid #f2f2f2;
}

.qr-image{
    width:100%;
    height:100%;
}

/* SCAN LINE */

.scanner-line{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:4px;
    background:#00ff66;
    animation:scan 2s linear infinite;
    box-shadow:0 0 15px #00ff66;
}

@keyframes scan{
    0%{top:0;}
    100%{top:100%;}
}

.scan-text{
    margin-top:12px;
    color:#444;
    font-size:13px;
}

/* AMOUNT */

.amount-box{
    margin-top:16px;
    font-size:20px;
    color:#ff5722;
    font-weight:bold;
}

/* PAYMENT INPUT */

.pay-input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    margin-top:16px;
    font-size:15px;
}

/* PAYMENT BUTTON */

.pay-btn{
    margin-top:16px;
}

/* CANCEL BUTTON */

.cancel-btn{
    margin-top:10px;
    background:#e0e0e0;
    color:#333;
}

/* ANIMATION */

@keyframes popupAnim{
    from{
        transform:scale(0.7);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

/* MOBILE */

@media(max-width:500px){

    .container,
    .payment-box{
        width:92%;
    }

    h2{
        font-size:24px;
    }

    .payment-methods{
        flex-direction:column;
    }
}

</style>
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="form-center">

<div class="container">

<h2>🌴 Book Your Adventure</h2>

<?php
if($error != ""){
    echo "<p style='color:red; margin-bottom:15px;'>$error</p>";
}
?>

<form method="POST">

    <!-- HIDDEN -->

    <input type="hidden" name="place" value="<?php echo $place; ?>">
    <input type="hidden" name="price" value="<?php echo $price; ?>">

    <!-- USERNAME -->

    <div class="input-group">

        <label>👤 Username</label>

        <input type="text"
               value="<?php echo $_SESSION['user']; ?>"
               readonly>

    </div>

    <!-- MOBILE -->

    <div class="input-group">

        <label>📱 Mobile Number</label>

        <input type="tel"
               name="mobile"
               placeholder="Enter mobile number"
               pattern="[0-9]{10}"
               required>

    </div>

    <!-- AGE -->

    <div class="input-group">

        <label>🎂 Age</label>

        <input type="number"
               name="age"
               min="1"
               max="100"
               placeholder="Enter your age"
               required>

    </div>

    <!-- DESTINATION -->

    <div class="input-group">

        <label>📍 Destination</label>

        <div class="destination">
            <?php echo ucfirst($place); ?>
        </div>

    </div>

    <!-- TOTAL PRICE -->

    <div class="input-group">

        <label>💰 Total Package Price</label>

        <div class="destination"
             style="
             font-size:20px;
             color:#ff5722;
             font-weight:bold;">

            ₹<span id="totalPrice">
                <?php echo $price; ?>
            </span>

        </div>

        <small style="color:#444;">
            ₹<?php echo $price; ?> Per Person
        </small>

    </div>

    <!-- GUESTS -->

    <div class="input-group">

        <label>👥 Number Of Guests</label>

        <input type="number"
               name="people"
               id="people"
               min="1"
               value="1"
               oninput="updatePrice(); generateTravellers();"
               required>

    </div>

    <!-- EXTRA TRAVELLERS -->

    <div id="travellerDetails"></div>

    <!-- DATE -->

    <div class="input-group">

        <label>📅 Select Date</label>

        <input type="date"
               name="date"
               id="date"
               min="<?php echo date('Y-m-d'); ?>"
               required>

    </div>

    <!-- PAYMENT BUTTON -->

    <button type="button"
            onclick="validateForm()">

        Proceed To Payment 💳

    </button>

    <!-- REAL SUBMIT -->

    <button type="submit"
            name="book"
            id="realSubmit"
            style="display:none;">

    </button>

</form>

<p class="note">
Get Ready For An Unforgettable Journey 🌍
</p>

</div>
</div>

<!-- PAYMENT POPUP -->

<div class="popup" id="paymentPopup" style="display:none;">

    <div class="payment-box">

        <h2>Secure Payment</h2>

        <p class="pay-subtitle">
            Choose your preferred payment method
        </p>

        <div class="payment-methods">

            <div class="method active" onclick="selectMethod(this)">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968279.png">
                <span>Google Pay</span>
            </div>

            <div class="method" onclick="selectMethod(this)">
                <img src="https://cdn-icons-png.flaticon.com/512/825/825454.png">
                <span>PhonePe</span>
            </div>

            <div class="method" onclick="selectMethod(this)">
                <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png">
                <span>Paytm</span>
            </div>

        </div>

        <!-- QR -->

        <div class="scanner-box">

            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=TravelBookingPayment"
                 class="qr-image">

            <div class="scanner-line"></div>

        </div>

        <p class="scan-text">
            Scan QR using any UPI app
        </p>

        <!-- TOTAL -->

        <div class="amount-box">
            Total Amount:
            <b id="popupTotal"></b>
        </div>

        <!-- UPI -->

        <input type="text"
               placeholder="Enter UPI ID"
               class="pay-input"
               id="upiInput">

        <!-- BUTTON -->

        <button class="pay-btn"
                onclick="makePayment()">
            Pay Securely 
        </button>

        <button class="cancel-btn"
                onclick="closePayment()">
            Cancel
        </button>

    </div>

</div>

<!-- SUCCESS POPUP -->

<?php if($success): ?>

<div class="popup">

    <div class="popup-content">

        <h2> Booking Confirmed!</h2>

        <p style="margin-top:10px;">

            Your trip to

            <b><?php echo ucfirst($place); ?></b>

            is booked successfully.

        </p>

        <p style="margin-top:10px;">

            Total Paid:

            <b>
                ₹<?php echo $total; ?>
            </b>

        </p>

        <a href="receipt.php">

            <button style="margin-top:15px;">
                Download Receipt 🧾
            </button>

        </a>

    </div>

</div>

<?php endif; ?>

<script>

// VALIDATE FORM

function validateForm(){

    let people =
        document.getElementById("people").value;

    let date =
        document.getElementById("date").value;

    if(people == "" || people < 1){

        alert("Please enter valid number of guests!");
        return;
    }

    if(date == ""){

        alert("Please select travel date!");
        return;
    }

    openPayment();
}


// UPDATE PRICE

function updatePrice(){

    let people =
        document.getElementById("people").value;

    let price =
        <?php echo $price; ?>;

    let total =
        people * price;

    document.getElementById("totalPrice")
        .innerHTML = total;
}


// GENERATE EXTRA TRAVELLERS

// GENERATE EXTRA TRAVELLERS

function generateTravellers(){

    let people =
        parseInt(document.getElementById("people").value);

    let travellerBox =
        document.getElementById("travellerDetails");

    travellerBox.innerHTML = "";

    // START FROM TRAVELLER 2
    // MAIN USER ALREADY EXISTS

    for(let i = 2; i <= people; i++){

        travellerBox.innerHTML += `

        <div style="
            display:flex;
            gap:10px;
            margin-bottom:15px;
        ">

            <!-- NAME -->

            <div class="input-group"
                 style="flex:2; margin-bottom:0;">

                <label>
                     Traveller ${i} Name
                </label>

                <input type="text"
                       name="traveller_name[]"
                       placeholder="Traveller ${i} Name"
                       required>

            </div>

            <!-- AGE -->

            <div class="input-group"
                 style="flex:1; margin-bottom:0;">

                <label>
                     Age
                </label>

                <input type="number"
                       name="traveller_age[]"
                       min="1"
                       max="100"
                       placeholder="Age"
                       required>

            </div>

        </div>

        `;
    }
}
// OPEN PAYMENT

function openPayment(){

    let people =
        document.getElementById("people").value;

    let price =
        <?php echo $price; ?>;

    let total =
        people * price;

    document.getElementById("popupTotal")
        .innerHTML = "₹" + total;

    document.getElementById("paymentPopup")
        .style.display = "flex";
}


// CLOSE PAYMENT

function closePayment(){

    document.getElementById("paymentPopup")
        .style.display = "none";
}


// SELECT PAYMENT METHOD

function selectMethod(element){

    let methods =
        document.querySelectorAll(".method");

    methods.forEach(method => {

        method.classList.remove("active");

    });

    element.classList.add("active");
}


// MAKE PAYMENT

function makePayment(){

    let upi =
        document.getElementById("upiInput").value;

    if(upi.trim() == ""){

        alert("Please enter UPI ID!");
        return;
    }

    if(!upi.includes("@")){

        alert("Invalid UPI ID!");
        return;
    }

    alert("✅ Payment Successful!");

    document.getElementById("realSubmit")
        .click();
}


// PAGE LOAD

window.onload = function(){

    updatePrice();

    generateTravellers();
};

</script>

</body>
</html>