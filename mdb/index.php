<?php
session_start();

if(!in_array("admin", $_SESSION['roles'])){
    header("Location:./login/");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title> Comrades Academic Solutions</title>
         <link rel="icon" href="../img/logo.png" type="image/png" /> 
        <link href="./css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <!-- navbar begin -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="./"><i class="fa fa-home" style="color:white;font-size:25px"></i></a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">

<?php if(isset($_SESSION['profile_pic'])){ ?>

    <img src="../img/profiles/<?php echo $_SESSION['profile_pic'];?>" class="avatar" alt="avatar ">

<?php } else {?>
    <img src="../img/profiles/user.jpg" class="avatar" alt="avatar ">

<?php } ?>
                
                
                </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="./user-profile/">User Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="./logout/">Logout</a>
            </div>
        </li>
    </ul>
</nav>

<!-- nav bar end -->

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">


                <!-- side nav begin -->
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                            <a class="nav-link" href="./">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link" href="./user-profile">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                User Profile
                            </a>
                            
                            <a class="nav-link" href="./users">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Users
                            </a>
                            <a class="nav-link" href="./posts">
                                <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                                Posts
                            </a>
                            <a class="nav-link" href="./categories/">
                                <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                                Categories
                            </a>
                            <!--<a class="nav-link" href="./products">
                                <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                                Products
                            </a>-->
                            <a class="nav-link" href="./services">
                                <div class="sb-nav-link-icon"><i class="fab fa-servicestack"></i></div>
                                Services
                            </a>
                           
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Website Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="../">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Home
                            </a>
                                    <a class="nav-link" href="../blog/">
                                <div class="sb-nav-link-icon"><i class="fab fa-blogger-b"></i></div>
                                Blog
                            </a>
                             <a class="nav-link" href="../services/">
                                <div class="sb-nav-link-icon"><i class="fab fa-servicestack"></i></div>
                                Services
                            </a>
                            <!--<a class="nav-link" href="../#products">
                                <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                                Products
                            </a>-->
                            <a class="nav-link" href="../about-us/">
                                <div class="sb-nav-link-icon"><i class="fas fa-people-carry"></i></div>
                                About Us
                            </a>
                            <a class="nav-link" href="../contact/">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                                Contact Us
                            </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['logged_in_username'];?>
                    </div>
                </nav>

                <!-- side nav end -->


            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row jumbotron ">
                            <div class="card bg-dark text-white p-5 m-4">
                                <p><i class="fas fa-users"></i>  Users</p>
                                <span class="badge badge-light users-value"></span>
                            </div>
                            <div class="card bg-dark text-white p-5 m-4">
                                <p><i class="fas fa-blog"></i>  Posts </p>
                                <span class="badge badge-light posts-value"></span>
                            </div>
                            <div class="card bg-dark text-white p-5 m-4">
                                <p><i class="fas fa-comments"></i>  Comments </p>
                                <span class="badge badge-light comments-value"></span>
                            </div>
                            <!--<div class="card bg-dark text-white p-5 m-4">
                                <p><i class="fab fa-product-hunt"></i>  Products </p>
                                <span class="badge badge-light products-value"></span>
                            </div>-->
                            <div class="card bg-dark text-white p-5 m-4">
                                <p><i class="fab fa-servicestack"></i>  Services </p>
                                <span class="badge badge-light services-value"></span>
                            </div>
                            
                        </div>
                       
                        
                    </div>
                </main>
                <!-- footer begin -->
        <?php require './components/footer.php'; ?>

                <!-- footer end -->
            </div>
        </div>

        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./js/scripts.js"></script>
        <script src="./js/dashboard.js"></script>
        <!-- <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script> -->
        
    </body>
</html>
