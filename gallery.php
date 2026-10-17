<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Premium Gallery</title>

<link rel="stylesheet" href="f1.css"/>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    color:white;
}

.section{
    padding:120px 8%;
}

.title{
    text-align:center;
    font-size:40px;
    margin-bottom:40px;
    font-weight:700;
}
.title span{
    color:#ffa500;
}

/* GALLERY */
.gallery{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap:25px;
}

.card{
    position:relative;
    border-radius:20px;
    overflow:hidden;
}

.card img{
    width:100%;
    height:300px;
    object-fit:cover;
    transition:0.5s;
}

.overlay{
    position:absolute;
    bottom:0;
    width:100%;
    padding:20px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    opacity:0;
    transition:0.4s;
}

.card:hover img{
    transform:scale(1.1);
}
.card:hover .overlay{
    opacity:1;
}

/* VIDEO SECTION */
.video-wrapper{
    overflow:hidden;
    padding:20px;
}

.video-title{
    text-align:center;
    font-size:40px;
    margin:60px 0 30px;
}
.video-title span{
    color:#ffa500;
}

.video-track{
    display:flex;
    gap:20px;
    width:max-content;
    animation: scroll 30s linear infinite;
}

@keyframes scroll{
    0%{ transform: translateX(0); }
    100%{ transform: translateX(-50%); }
}

.video-card{
    min-width:300px;
    height:350px;
    border-radius:15px;
    overflow:hidden;
    flex-shrink:0;
}

.video-card video{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* hover zoom */
.video-card:hover{
    transform:scale(1.08);
}

</style>
</head>

<body>

<!-- NAVBAR -->
<?php include 'navbar.php'; ?>

<!-- IMAGES -->
<section class="section">

<h1 class="title">Explore <span>Moments</span></h1>

<div class="gallery">

<div class="card"><img src="images/Manali12.jpg"><div class="overlay"><h3>Manali Hills</h3></div></div>
<div class="card"><img src="images/Delhi45.jpg"><div class="overlay"><h3>Delhi Heritage</h3></div></div>
<div class="card"><img src="images/Jodhpur2.jpg"><div class="overlay"><h3>Jodhpur Blue City</h3></div></div>
<div class="card"><img src="images/Ladak6.jpg"><div class="overlay"><h3>Leh Ladakh</h3></div></div>
<div class="card"><img src="images/Munnar3.jpg"><div class="overlay"><h3>Munnar Tea Gardens</h3></div></div>
<div class="card"><img src="images/Goa56.jpg"><div class="overlay"><h3>Goa Beaches</h3></div></div>
<div class="card"><img src="images/Meghalaya.jpg"><div class="overlay"><h3>Meghalaya Waterfalls</h3></div></div>
<div class="card"><img src="images/Kerala12.jpg"><div class="overlay"><h3>Kerala Backwaters</h3></div></div>

</div>

<!-- VIDEOS -->
<div class="video-wrapper">

<h1 class="video-title">Visual <span>Journeys</span></h1>

<div class="video-track">

<!-- ORIGINAL -->
<div class="video-card"><video src="video/goa1.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/manali2.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/jaipur3.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/swiggy4.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/singapur5.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/resort6.mp4" muted autoplay loop playsinline></video></div>

<!-- DUPLICATE (IMPORTANT FOR LOOP) -->
<div class="video-card"><video src="video/goa1.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/manali2.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/jaipur3.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/swiggy4.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/singapur5.mp4" muted autoplay loop playsinline></video></div>
<div class="video-card"><video src="video/resort6.mp4" muted autoplay loop playsinline></video></div>

</div>

</div>

</section>

</body>
</html>