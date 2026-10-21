<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delhi Package - BlueHorizon</title>
<link rel="stylesheet" href="f1.css"/>
<style>
    
:root{
    --primary:#7ac2e8;
    --accent:#ffa500;
    --gray:#f5f5f5;
}

body{
    margin:0;
    font-family:Poppins,sans-serif;
    background:var(--gray);
}

/* HEADER */
.header{
    position:fixed;
    top:0;
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 60px;
    background:rgba(0,0,0,0.7);
    backdrop-filter:blur(10px);
    z-index:1000;
}

.logo{
    color:var(--primary);
    font-size:22px;
    font-weight:bold;
}

.back-btn{
    color:var(--primary);
    text-decoration:none;
    font-weight:600;
}

.back-btn:hover{
    color:white;
}

/* HERO */
.hero{
    height:60vh;
    background:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),
               url('images/delhi.jpg') center/cover no-repeat;
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

/* GALLERY */
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

/* CARDS */
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

/* REVIEWS */
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

/* MAP */
.map{
    margin-top:25px;
    border-radius:12px;
    overflow:hidden;
}

/* PRICE BOX */
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

@media(max-width:768px){
    .grid{
        flex-direction:column;
    }
}
.back{
    display:inline-block;
    margin-bottom:20px;
    color: var(--primary);
    font-weight:600;
    text-decoration:none;
}

.back:hover{
    color:#000;
}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="hero">
    <h1>Delhi</h1>
    <p>📍 Delhi, India • ⭐ 4.6 (180 reviews)</p>
</section>

<div class="container">
	<a href="index.php#packages" class="back">← Back to Packages</a>

<div class="grid">

<!-- LEFT -->
<div class="left">

<div class="gallery">
    <img src="images/Delhi1.jpg">
    <img src="images/Delhi2.jpg">
    <img src="images/Delhi3.jpg">
</div>

<div class="card">
    <h2>Highlights</h2>
    <ul>
        <li>🏛 Red Fort Visit</li>
        <li>🌸 Garden of Five Senses</li>
        <li>🚗 Airport Pickup & Drop</li>
        <li>🍽 Complimentary Breakfast</li>
    </ul>
</div>

<div class="card">
    <h2>Day-wise Plan</h2>
    <p><b>Day 1:</b> Arrival & India Gate visit</p>
    <p><b>Day 2:</b> Red Fort & Chandni Chowk</p>
    <p><b>Day 3:</b> Lotus Temple & Akshardham</p>
    <p><b>Day 4:</b> Shopping & Departure</p>
</div>
<?php include 'itinerary_widget.php'; ?>
<div class="map">
<iframe
src="https://maps.google.com/maps?q=Delhi&t=&z=13&ie=UTF8&iwloc=&output=embed"
width="100%" height="300">
</iframe>
</div>

<div class="card">
    <h2>Reviews</h2>

    <div class="review-card">
        <img src="images/ph1.jpg">
        <div>
            <h4>Rohit Mehta</h4>
            <p>⭐⭐⭐⭐⭐ Wonderful historical trip.</p>
        </div>
    </div>

    <div class="review-card">
        <img src="images/ph2.jpg">
        <div>
            <h4>Ananya Singh</h4>
            <p>⭐⭐⭐⭐ Great experience and smooth stay.</p>
        </div>
    </div>

</div>

</div>

<!-- RIGHT -->
<div class="right">
    <div class="price-box">
        <h2>₹8,000</h2>
        <p style="
            text-decoration: line-through;
            color: gray;
        font-size: 20px;
        margin-top:5px;
">
₹10,000
</p>
       <a href="book.php?place=Delhi&price=8000"
   class="btn">
   Book Now
</a>
    </div>
</div>

</div>
</div>

</body>
</html>