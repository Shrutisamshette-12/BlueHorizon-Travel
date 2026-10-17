<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Travel</title>
<!-- swiper js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<!-- CSS file link -->
<link rel="stylesheet" href="f1.css"/>
<!-- font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
</head>
<body>
<header class="header">
    <a href="#" class="logo">
        <img src="images/Blue.png"
     alt="BlueHorizon Logo"
     class="logo-img">
   <span class="blue">Blue</span><span class="horizon">Horizon</span>
</a>

    <nav class="navbar">
        <div class="nav-links">
            <a href="#home">HOME</a>
            <a href="#packages">PACKAGES</a>
            <a href="#services">SERVICES</a>
            <a href="#gallery">GALLERY</a>
            <a href="#review">REVIEW</a>
            <a href="contact.php">CONTACT</a>
            <a href="login.php" class="login-link">LOGIN</a>
            <a href="registration_form.php" class="btn-register">REGISTER</a>
            <a href="admin_login.php" class="admin-link">ADMIN</a>
        </div>
    </nav>
</header>

<!-- Section top slideshow -->
<div class="section_top" id="home">
    <div class="slideshow">
        <div class="slide" style="background-image: url('images/img1.jpg');"></div>
        <div class="slide" style="background-image: url('images/img3.jpg');"></div>
        <div class="slide" style="background-image: url('images/img2.jpg');"></div>
        <div class="slide" style="background-image: url('images/img4.jpg');"></div>
        <div class="slide" style="background-image: url('images/img5.jpg');"></div>
        <div class="slide" style="background-image: url('images/img6.jpg');"></div>

    </div>
    <div class="hero">
       
    </div>
</div>
<!-- ===== Packages Section ===== -->
<section class="packages" id="packages">
    <h1 class="heading">
        <span>P</span><span>A</span><span>C</span><span>K</span>
        <span>A</span><span>G</span><span>E</span><span>S</span>
    </h1>

    <div class="box-container">
        <!-- Box 1 -->
        <div class="box">
            <img src="images/p1.jpg" alt="Delhi">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Delhi</h3>
                <p>Delhi is the soul of India. Every monument has a tale to tell.</p>
                <div class="starts">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <div class="price">Rs.8000 <span>Rs.10,000</span></div>
                <a href="delhi.php" class="btn">book now</a>
            </div>
        </div>

        <!-- Box 2 -->
        <div class="box">
            <img src="images/p2.jpg" alt="Agra">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Agra</h3>
                <p>The Taj Mahal in Agra is a symbol of eternal love.</p>
                <div class="starts">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <div class="price">Rs.8500 <span>Rs.10,500</span></div>
                <a href="agra.php" class="btn">book now</a>
            </div>
        </div>

        <!-- Box 3 -->
        <div class="box">
            <img src="images/p3.jpg" alt="Udaipur">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Udaipur</h3>
                <p>Udaipur, where the heart finds its home and the soul finds peace.</p>
                <div class="starts">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="price">Rs.9,500<span>Rs.12000</span></div>
                <a href="udaipur.php" class="btn">book now</a>
            </div>
        </div>

        <!-- Box 4 -->
        <div class="box">
            <img src="images/p4.jpg" alt="Jaipur">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Jaipur</h3>
                <p>Life in Jaipur is a tapestry of tradition, culture, and modernity.</p>
                <div class="starts">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="price">Rs.9000 <span>Rs.11,000</span></div>
                <a href="jaipur.php" class="btn">book now</a>
            </div>
        </div>

        <!-- Box 5 -->
        <div class="box">
            <img src="images/p5.jpg" alt="Goa">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Goa</h3>
                <p>Watching sunrise on a Goa beach will make you realize what you’ve missed.</p>
                <div class="starts">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <div class="price">Rs.10,000 <span>Rs.12,000</span></div>
                <a href="goa.php" class="btn">book now</a>
            </div>
        </div>

        <!-- Box 6 -->
        <div class="box">
            <img src="images/p6.jpg" alt="Kashmir">
            <div class="content">
                <h3><i class="fas fa-map-marker-alt"></i> Kashmir</h3>
                <p>The beauty of Kashmir is unmatched anywhere in the world.</p>
                <div class="starts">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <div class="price">Rs.12,000 <span>Rs.15,000</span></div>
                <a href="kashmir.php" class="btn">book now</a>
            </div>
        </div>
    </div>
</section>

<!-- services section starts -->
<section class="services" id="services">

<h1 class="heading">
<span>S</span>
<span>E</span>
<span>R</span>
<span>V</span>
<span>I</span>
<span>C</span>
<span>E</span>
<span>S</span>
</h1>

<br><br>

<div class="box-container">

    <div class="box">
        <i class="fas fa-hotel"></i>
        <h3>Affordable Hotels</h3>
    </div>

    <div class="box">
        <i class="fas fa-utensils"></i>
        <h3>Food and Drinks</h3>
    </div>

    <div class="box">
        <i class="fas fa-bullhorn"></i>
        <h3>Safety Guide</h3>
    </div>

    <div class="box">
        <i class="fas fa-globe-asia"></i>
        <h3>Around the World</h3>
    </div>

    <div class="box">
        <i class="fas fa-plane"></i>
        <h3>Fastest Travel</h3>
    </div>

    <div class="box">
        <i class="fas fa-hiking"></i>
        <h3>Adventure</h3>
    </div>

</div>

</section>
<!-- services section ends -->
<!-- Gallery section -->
<section class="gallery" id="gallery">
    <h1 class="heading">
        <span>G</span><span>A</span><span>L</span><span>L</span><span>E</span><span>R</span><span>Y</span>
    </h1>
    
    <div class="box-container">
        <div class="box"><img src="images/n1.jpg" alt="not"><div class="content"><h3>Amazing Places</h3><p>Explore the world</p><a href="gallery.php" class="btn">See More</a></div></div>
        <div class="box"><img src="images/m1.jpg" alt="not"><div class="content"><h3>Amazing Places</h3><p>Explore the world</p><a href="gallery.php" class="btn">See More</a></div></div>
        <div class="box"><img src="images/m3.jpg" alt="not"><div class="content"><h3>Amazing Places</h3><p>Explore the world</p><a href="gallery.php" class="btn">See More</a></div></div>
    </div>
</section>

<section class="review" id="review">
    <h1 class="heading">
        <span>R</span><span>E</span><span>V</span><span>I</span><span>E</span><span>W</span>
    </h1>

    <div class="swiper review-slider">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="box">
                    <img src="images/r1.jpg" alt="Penelope Cruz">
                    <h3>Penelope Cruz</h3>
                    <p>It was really a wonderful experience, everyone enjoyed a lot, food and hotel's given by you was the best. Thanks to Roving travel Agency for giving us amazing experience.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="box">
                    <img src="images/r2.jpg" alt="Robert Downey">
                    <h3>Robert Downey</h3>
                    <p>Thank you for all you did to make the trip wonderful. Our vacation was a huge success. It's been a pleasure working with you.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide">
                <div class="box">
                    <img src="images/r3.jpg" alt="Emma Watson">
                    <h3>Emma Watson</h3>
                    <p>I was delighted with the service you provided. This is the second time I have used your services, and both times were faultless.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="swiper-slide">
                <div class="box">
                    <img src="images/r4.jpg" alt="Vin Diesel">
                    <h3>Vin Diesel</h3>
                    <p>We just wanted to thank you again for all your help in making our trip so enjoyable and relaxing.</p>
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                </div>
            </div>

            <!-- Slide 5 -->
            <div class="swiper-slide">
                <div class="box">
                    <img src="images/r5.jpg" alt="Diane Kruger">
                    <h3>Diane Kruger</h3>
                    <p>You know, I have planned many trips before, but you are truly one of the best agencies I have interacted with. Thank you very much!</p>
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="footer">
    <div class="footer-container">

        <!-- About Us -->
        <div class="footer-box">
            <h3>About BlueHorizon</h3>
            <p>
                Since 2023, <strong>BlueHorizon</strong> has been crafting unforgettable travel experiences. 
                We help you explore the world with comfort, safety, and joy — making every journey truly special ✈️
            </p>
        </div>

        <!-- Branch Locations -->
        <div class="footer-box">
            <h3>Top Destinations</h3>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i> Delhi</li>
                <li><i class="fas fa-map-marker-alt"></i> Agra</li>
                <li><i class="fas fa-map-marker-alt"></i> Udaipur</li>
                <li><i class="fas fa-map-marker-alt"></i> Jaipur</li>
                <li><i class="fas fa-map-marker-alt"></i> Goa</li>
                <li><i class="fas fa-map-marker-alt"></i> Kashmir</li>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="footer-box">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#packages">Packages</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#review">Reviews</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="registration_form.php">Register</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="footer-box">
            <h3>Contact & Follow Us</h3>
            <ul>
                <li><i class="fas fa-phone"></i> +91 12345 67890</li>
                <li><i class="fas fa-envelope"></i> support@BlueHorizon.com</li>
                <li><i class="fas fa-globe"></i> www.BlueHorizon.com</li>
            </ul>

            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

    </div>

    <!-- NEW PROFESSIONAL ENDING -->
    <div class="footer-credit">
        <p>
            Explore. Dream. Discover. ✈️ <br>
            <span>BlueHorizon</span> — Your Travel Partner <br><br>
            © 2026 BlueHorizont. All Rights Reserved.
        </p>
    </div>
</section>

<!-- REMOVE THIS (not professional) -->
<!-- <h1 class="th"><span>T</span>hanks for visiting <br>our website.</h1> -->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="script1.js"></script>
</body>
</html>