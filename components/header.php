<!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>

        <nav class="canvas-menu mobile-menu">
            <ul>
                <!--<li><a href="../">Home</a></li>-->
                <li><a href="../about-us/">About Us</a></li>
                <li><a href="../services/">Services</a></li>
                <!--<li><a href="../#products">Products</a></li> -->
                <li><a href="../blog/">Blog</a></li>

<?php
if(!isset($_SESSION['logged_in_username'])){
?>
                
                <!--<li><a href="#">More</a> -->
                    <!--<ul class="dropdown">  -->
                        <li><a href="../mdb/login/">Login</a></li>
                        <li><a href="../mdb/register/">Sign Up</a></li>
                    <!--</ul> -->
                <!--</li>-->

<?php }?>

                <li><a href="../contact/">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <!--<a href="https://web.facebook.com"><i class="fa fa-facebook"></i></a>-->
            <a href="https://twitter.com/comradeswriter1"><i class="fa fa-twitter"></i></a>
            <!-- <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a> -->
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-3 row">
                    <div class="logo">
                        <a href="../">
                            <!--<i class="fa fa-home" style="color:white;font-size:25px"></i>-->
                            <img src="../img/logo.png" alt="logo">
                        </a>
                    </div>

<?php
if(isset($_SESSION['logged_in_username'])){
?>

<div class="dropdown" id="logged-user-dropdown">
  <a class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

<?php if(isset($_SESSION['profile_pic'])){ ?>

    <img src="../img/profiles/<?php echo $_SESSION['profile_pic'];?>" id="avatar" class="rounded-circle">

<?php } else {?>
    <img src="../img/profiles/user.jpg" id="avatar" class="rounded-circle">

<?php } ?>


</a>
  <div class="dropdown-menu" id="logged-user" aria-labelledby="dropdownMenu2">
    <a href="#" class="dropdown-item" ><?php echo $_SESSION['logged_in_username'];?></a>
    <?php
if(in_array("admin", $_SESSION['roles'])){
?>

    <a href="../mdb/" class="dropdown-item">Dashboard</a>

<?php }?>
    <a href="../mdb/user-profile/" class="dropdown-item" >User Profile</a>
    <a href="../mdb/logout/" class="dropdown-item">Logout</a>
  </div>
</div>

<?php
}
?>


                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <!-- <li class="home-link"><a href="../">Home</a></li> -->
                            <li class="about-link"><a href="../about-us/">About Us</a></li>
                            <li class="services-link"><a href="../services/">Services</a></li>
                            <!--<li><a href="../#products">Products</a></li> -->
                            <li class="blog-link"><a href="../blog/">Blog</a></li>
                            <?php
if(!isset($_SESSION['logged_in_username'])){
?>
                            <!--<li><a href="#">More</a> -->
                    <!--<ul class="dropdown"> -->
                        <li><a href="../mdb/login/">Login</a></li>
                        <li><a href="../mdb/register/">Sign Up</a></li>
                    <!--</ul> -->
                <!-- </li> -->
                <?php }?>
                             <li class="contact-link"><a href="../contact/">Contact</a></li> 
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-social">
                            <!--<a href="https://web.facebook.com"><i class="fa fa-facebook"></i></a>-->
                            <a href="https://twitter.com/comradeswriter1"><i class="fa fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->
