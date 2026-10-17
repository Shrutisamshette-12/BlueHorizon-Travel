<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Goa Package - BlueHorizon</title>

<link rel="stylesheet" href="f1.css"/>
<style>

/* ===== ROOT ===== */
:root {
    --primary: #7ac2e8;
    --dark: #111;
    --light: #fff;
    --gray: #f5f5f5;
    --accent: #ffa500;
}

/* ===== GLOBAL ===== */
body{
    margin:0;
    font-family: "Poppins", sans-serif;
    background: var(--gray);
}


/* ===== NAV ACTIONS ===== */
.nav-actions{
    display:flex;
    align-items:center;
}

.back-btn{
    color: var(--primary);
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition:0.3s;
}

.back-btn:hover{
    color:white;
}

/* ===== HERO ===== */
.hero{
    height:60vh;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                url('images/goa.jpg') center/cover no-repeat;
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
    color: var(--primary);
}

.hero p{
    font-size:18px;
}

/* ===== CONTAINER ===== */
.container{
    max-width:1200px;
    margin:auto;
    padding:30px;
}

/* ===== GRID ===== */
.grid{
    display:flex;
    gap:25px;
    flex-wrap:wrap;
}

.left{ flex:2; }
.right{ flex:1; }

/* ===== GALLERY ===== */
.gallery{
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-template-rows: 200px 200px;
    gap: 10px;
}

.gallery img:first-child{
    grid-row: span 2;
}

.gallery img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:10px;
    transition: transform 0.3s ease, filter 0.3s ease;
}

.gallery img:hover {
    transform: scale(1.05);
    filter: brightness(0.8);
}

/* ===== CARDS ===== */
.details, .itinerary, .reviews{
    background:white;
    padding:25px;
    border-radius:15px;
    margin-top:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.3s;
    border-left:5px solid var(--primary);
}

.details:hover, .itinerary:hover, .reviews:hover{
    transform: translateY(-5px);
}

/* ===== HEADINGS ===== */
.details h2, .itinerary h2, .reviews h2{
    color: var(--primary);
    margin-bottom:15px;
}

/* ===== LIST ===== */
.details ul{
    padding:0;
}

.details ul li{
    list-style:none;
    margin:10px 0;
    padding:10px;
    background:#f9f9f9;
    border-radius:8px;
}

/* ===== ITINERARY ===== */
.itinerary p{
    background:#f9f9f9;
    padding:10px;
    border-radius:8px;
    margin:10px 0;
}

/* ===== REVIEWS ===== */
.review-card{
    display:flex;
    gap:15px;
    background:#f9f9f9;
    padding:15px;
    border-radius:12px;
    margin-top:15px;
}

.review-card img{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}

/* ===== BUTTON ===== */
.btn{
    display:block;
    margin-top:15px;
    padding:12px;
    background: linear-gradient(45deg,#ff8c00,#ffb347);
    color:white;
    border-radius:8px;
    text-decoration:none;
    text-align:center;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.05);
    box-shadow:0 5px 15px rgba(255,140,0,0.5);
}

/* ===== PRICE BOX ===== */
.price-box{
    background:white;
    padding:25px;
    border-radius:12px;
    position:sticky;
    top:100px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* ===== MAP ===== */
.map{
    margin-top:20px;
    border-radius:10px;
    overflow:hidden;
}

/* ===== BACK BUTTON (below hero) ===== */
.back{
    display:inline-block;
    margin-bottom:15px;
    color: var(--primary);
    font-weight:bold;
}

/* ===== MOBILE ===== */
.mobile-book{
    display:none;
}

@media(max-width:768px){
    .grid{
        flex-direction:column;
    }

    .mobile-book{
        display:block;
        position:fixed;
        bottom:0;
        width:100%;
        background:white;
        padding:10px;
    }
}

</style>
</head>

<body>
<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="hero">
    <h1>Goa</h1>
    <p>📍 Goa, India • ⭐ 4.5 (120 reviews)</p>
</section>

<div class="container">

<a href="index.php#packages" class="back">← Back to Packages</a>

<div class="grid">

<!-- LEFT -->
<div class="left">

<div class="gallery">
    <img src="images/goa1.jpg">
    <img src="images/goa2.jpg">
    <img src="images/goa3.jpg">
</div>

<div class="details">
    <h2>Highlights</h2>
    <ul>
        <li>🏖 Beachside Resort</li>
        <li>🍽 Free Breakfast</li>
        <li>🚗 Pickup & Drop</li>
        <li>🎉 Nightlife Experience</li>
    </ul>
</div>

<div class="itinerary">
    <h2>Day-wise Plan</h2>
    <p><b>Day 1:</b> Arrival</p>
    <p><b>Day 2:</b> Activities</p>
    <p><b>Day 3:</b> Sightseeing</p>
    <p><b>Day 4:</b> Checkout</p>
</div>

<div class="map">
<iframe src="https://maps.google.com/maps?q=goa&t=&z=13&ie=UTF8&iwloc=&output=embed"
width="100%" height="300"></iframe>
</div>

<div class="reviews">
    <h2>Reviews</h2>

    <div class="review-card">
        <img src="images/ph5.jpg">
        <div>
            <h4>Seema Patil</h4>
            <p>⭐⭐⭐⭐⭐ Amazing experience!</p>
        </div>
    </div>
    <div class="review-card">
        <img src="images/ph6.jpg">
        <div>
            <h4>Priya Kulkarni</h4>
            <p>⭐⭐⭐⭐⭐ The place is very beautiful!</p>
        </div>
    </div>

</div>

</div>

<!-- RIGHT -->
<div class="right">
<div class="price-box">

    <h2>₹10,000</h2>

    <p style="
    text-decoration: line-through;
    color: gray;
    font-size: 20px;
    margin-top:5px;
    ">
    ₹12,000
    </p>

    <a href="book.php?place=Goa&price=10000"
       class="btn">
       Book Now
    </a>

</div>
</div>

</div>
</div>

</body>
</html>