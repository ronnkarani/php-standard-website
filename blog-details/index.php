<?php
session_start();

if(!isset($_GET['pid'])){
    header("Location:../blog/");
}else{
    $_SESSION['postid'] = ($_GET['pid'])/85; 
}

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
    
    <title>CAS | Blog-Post</title>

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

    <!-- Blog Details Hero Section Begin -->
    <section id="blog-hero-section">
    
    </section>
    <!-- Blog Details Hero Section End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 p-0 m-auto">
                    <div class="blog-details-text">
                        <div class="blog-details-title" id="details-title">
                            
                        </div>
                        <div class="blog-details-pic" id="blog-more-images">
                            

                        </div>
                        <div class="blog-details-desc" id="details-description">
                            
                        </div>
                        <div id="blog-quotes">
                            
                        </div>
                        

                        <div class="blog-details-more-desc" id="more-description">
                            
                        </div>
                        <div class="blog-details-author" id="blog-author">
                            
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="comment-option" id="comments-cont">
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="leave-comment">
                                    <h5>Leave a comment</h5>
                                    <p id="comment-result"></p>
                                    <form action="#" id="comment-form">
<?php if(!isset($_SESSION['logged_in_userid'])){
                
            ?>
                                        <input type="text" placeholder="Username" name="username" required pattern="[A-Za-z0-9]{3,20}"
                                                minlength="3"
                                                maxleghth="20">

                                        <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{1,}$" name="email" required type="email" placeholder="Email" >

                                        <input type="url" pattern="https?://.+\..+" placeholder="Website" name="website">
<?php }?>
                                        <textarea name="comment" placeholder="Comment" required></textarea>
                                        <button type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <!--<div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Mount Kenya Diary<br /> 2919-60200 <br> Meru</p>
                    </div>
                </div>-->
                <div class="col-md-6">
                    <div class="gt-text">
                        <a href="tel:+254716077601">
                            <i class="fa fa-mobile"></i>
                            <p>+254716077601</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
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
    <?php include '../components/footer.php'?>
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
    <script src="../mdb/js/utilities.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/blog-details.js"></script>


    <script>
        $(document).ready(()=> {
            $(".blog-link").addClass("active");
        });
    </script>


</body>

</html>
