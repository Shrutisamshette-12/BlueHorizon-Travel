<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Udaipur Package - BlueHorizon</title>

<link rel="stylesheet" href="f1.css"/>
<style>

/* ===== ROOT ===== */
:root {
    --primary: #7ac2e8;
    --accent: #ffa500;
    --gray: #f5f5f5;
}

body{
    margin:0;
    font-family:Poppins,sans-serif;
    background:var(--gray);
}

.back-btn{
    color:var(--primary);
    text-decoration:none;
    font-weight:600;
}

.back-btn:hover{
    color:white;
}

/* ===== HERO ===== */
.hero{
    height:60vh;
    background:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
               url('images/Udaipur.jpg') center/cover no-repeat;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:white;
    text-align:center;
    margin-top:0px;
}

.hero h1{
    font-size:50px;
    color:var(--primary);
}

/* ===== CONTAINER ===== */
.container{
    max-width:1200px;
    margin:auto;
    padding:30px;
}

.grid{
    display:flex;
    gap:25px;
    flex-wrap:wrap;
}

.left{flex:2;}
.right{flex:1;}

/* ===== GALLERY ===== */
.gallery{
    display:grid;
    grid-template-columns:2fr 1fr;
    grid-template-rows:200px 200px;
    gap:10px;
}

.gallery img:first-child{
    grid-row:span 2;
}

.gallery img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:10px;
    transition:0.3s;
}

.gallery img:hover{
    transform:scale(1.05);
    filter:brightness(0.85);
}

/* ===== CARDS ===== */
.card{
    background:white;
    padding:25px;
    border-radius:15px;
    margin-top:25px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    border-left:5px solid var(--primary);
}

.card h2{
    color:var(--primary);
}

.card ul{
    padding:0;
}

.card ul li{
    list-style:none;
    margin:10px 0;
    padding:10px;
    background:#f9f9f9;
    border-radius:8px;
}

/* ===== MAP ===== */
.map{
    margin-top:25px;
    border-radius:12px;
    overflow:hidden;
}

/* ===== REVIEWS ===== */
.review-card{
    display:flex;
    gap:15px;
    padding:15px;
    background:#f9f9f9;
    border-radius:10px;
    margin-top:15px;
}

.review-card img{
    width:55px;
    height:55px;
    border-radius:50%;
    object-fit:cover;
}

/* ===== PRICE BOX ===== */
.price-box{
    background:white;
    padding:25px;
    border-radius:15px;
    position:sticky;
    top:100px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.btn{
    display:block;
    margin-top:15px;
    padding:12px;
    background:linear-gradient(45deg,#ff8c00,#ffb347);
    color:white;
    border-radius:8px;
    text-decoration:none;
    text-align:center;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .grid{
        flex-direction:column;
    }
}

</style>
</head>

<body>
<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="hero">
    <h1>Udaipur</h1>
    <p>📍 Udaipur, India • ⭐ 4.7 (140 reviews)</p>
</section>

<div class="container">

<a href="index.php#packages" class="back-btn">← Back to Packages</a>

<div class="grid">

<!-- LEFT -->
<div class="left">

<!-- GALLERY -->
<div class="gallery">
    <img src="images/Udaipur1.jpg">
    <img src="images/Udaipur2.jpg">
    <img src="images/Udaipur3.jpg">
</div>

<!-- HIGHLIGHTS -->
<div class="card">
    <h2>Highlights</h2>
    <ul>
        <li>🏞 Lake Pichola Boat Ride</li>
        <li>🏰 City Palace Visit</li>
        <li>🌅 Sunset at Sajjangarh</li>
        <li>🚗 Pickup & Drop Included</li>
    </ul>
</div>

<!-- ITINERARY -->
<div class="card">
    <h2>Day-wise Plan</h2>
    <p><b>Day 1:</b> Arrival & Lake Visit</p>
    <p><b>Day 2:</b> City Palace & Local Tour</p>
    <p><b>Day 3:</b> Garden & Sunset Point</p>
    <p><b>Day 4:</b> Departure</p>
</div>

<!-- MAP -->
<?php include 'itinerary_widget.php'; ?>
<div class="map">
<iframe src="https://maps.google.com/maps?q=udaipur&t=&z=13&ie=UTF8&iwloc=&output=embed"
width="100%" height="300"></iframe>
</div>

<!-- REVIEWS -->
<div class="card">
    <h2>Reviews</h2>

    <div class="review-card">
        <img src="images/ph5.jpg">
        <div>
            <h4>Neha Kapoor</h4>
            <p>⭐⭐⭐⭐⭐ Beautiful lakes and peaceful city.</p>
        </div>
    </div>

    <div class="review-card">
        <img src="images/ph6.jpg">
        <div>
            <h4>Riya Mehta</h4>
            <p>⭐⭐⭐⭐ Royal experience!</p>
        </div>
    </div>

</div>

</div>

<!-- RIGHT -->
<div class="right">
    <div class="price-box">
        <h2>₹9,500</h2>
        <p style="
text-decoration: line-through;
color: gray;
font-size: 20px;
margin-top:5px;
">
₹12,000
</p>
        <a href="book.php?place=Udaipur&price=9500"
   class="btn">
   Book Now
</a>
    </div>
</div>

</div>
</div>

</body>
</html>