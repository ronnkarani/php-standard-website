<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="../"><i class="fa fa-home" style="color:white;font-size:25px"></i></a>
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

    <img src="../../img/profiles/<?php echo $_SESSION['profile_pic'];?>" class="avatar" alt="avatar ">

<?php } else {?>
    <img src="../../img/profiles/user.jpg" class="avatar" alt="avatar ">

<?php } ?>
</a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../user-profile/">User Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../login/">Logout</a>
            </div>
        </li>
    </ul>
</nav>