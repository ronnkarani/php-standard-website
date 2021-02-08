<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="comradesacademicsolutions website">
    <meta name="robots" content="index, follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="canonical" href="https://www.comradesacademicsolutions.com/">
    <meta property="og:site_name" content="Bedubiz">
    <meta property="og:type" content="article">
    <meta property="og:title" content="Writing, Writers, Academic, Essays">
    <meta property="og:description" content="Writing, Writers, Academic, Essays">
    <meta property="og:url" content="https://www.comradesacademicsolutions.com/">
    <meta property="article:published_time" content="2021-1-09T13:34:47Z">
    <meta property="article:modified_time" content="2021-01-09T05:44:45Z">
    <meta name="keywords" content="Bedubiz, blog, website, updates">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@comradeswriter1">
    <meta property="twitter:domain" content="www.comradesacademicsolutions.com">
    <meta property="twitter:title" content="Writing, Writers, Academic, Essays">
    <meta property="twitter:description" content="Writing, Writers, Academic, Essays">
    <meta property="twitter:creator" content="@comradeswriter1">

    <meta name="google-site-verification" content="zT1Yz-O0wG2D63GbhJ1Nieup9mO8EPhxYQUQQtNN1ew" />

    <title>CAS | Contact Us</title>

    <link rel="icon" href="./../img/logo.png" type="image/png" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="../css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
</head>

<body>
    <!-- header begin -->
    <?php include '../components/header.php'?>

    <!-- header end -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" id="hero-section" data-setbg="../img/gallery-2.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Contact Us</h2>
                        <div class="bt-option">
                            <a href="./index.php">Home</a>
                            <span>Contact us</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title contact-title">
                        <span>Contact Us</span>
                        <h2>GET IN TOUCH</h2>
                    </div>
                    <div class="contact-widget">
                        <!--<div class="cw-text">
                            <i class="fa fa-map-marker"></i>
                            <p>Comrade Academic Solutions<br /> 2919-60200 <br> Meru</p>
                        </div> -->
                        <div class="cw-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li>+254716077601</li>

                            </ul>
                        </div>
                        <div class="cw-text email">
                            <i class="fa fa-envelope"></i>
                            <p>comradeswriter@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="leave-comment">
                        <form action="#" id="contact-form">
                            <?php if(!isset($_SESSION['logged_in_userid'])){
                
            ?>
                                        <input type="text" placeholder="Username" name="username" required 
                                                minlength="3"
                                                maxleghth="20">

                                        <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{1,}$" name="email" required type="email" placeholder="Email" >

                                        <input type="url" pattern="https?://.+\..+" placeholder="Website" name="website">
<?php }?>
<input type="text" placeholder="Subject" name="subject" required 
                                                minlength="3"
                                                maxleghth="20">
                            <textarea required placeholder="Message" name="message"></textarea>
                            <input type="file" name="file">
                            <button type="submit">Send Message</button>
                            <div class="text-success contact-result"></div>
                        </form>
                    </div>
                </div>
            </div>
            <!--  <div class="map">
               <iframe src="https://maps.google.com/maps?q=meru%20diary&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    height="550" style="border:0;" allowfullscreen=""></iframe> 
            </div> -->
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Comrade Academic Solutions<br /> 2919-60200 <br> Meru</p>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="gt-text">
                        <a href="tel:+254716077601">
                            <i class="fa fa-mobile"></i>
                            <p>+254716077601</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <a href="mailto:comradeswriter@gmail.com"><i class="fa fa-envelope"></i>
                            <p>comradeswriter@gmail.com</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Footer Section Begin -->
        <?php require '../components/footer.php'; ?>

    <!-- Footer Section End -->

    <!-- Js Plugins -->
        <script src="../js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/masonry.pkgd.min.js"></script>
    <script src="../js/jquery.barfiller.js"></script>
    <script src="../js/jquery.slicknav.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>  
    <script src="../js/contact.js"></script>    

    <script>
        $(document).ready(()=> {
            $(".contact-link").addClass("active");
        });
    </script>


</body>

</html>
