<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                            <a class="nav-link" href="../">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link" href="../user-profile/">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                User Profile
                            </a>
                            
                            <a class="nav-link" href="../users/">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Users
                            </a>
                            <a class="nav-link" href="../posts/">
                                <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                                Posts
                            </a>
                            <a class="nav-link" href="../categories/">
                                <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                                Categories
                            </a>
                            <!--<a class="nav-link" href="../products/">
                                <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                                Products
                            </a> -->
                            <a class="nav-link" href="../services/">
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
                                    <a class="nav-link" href="../../">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Home
                            </a>
                                    <a class="nav-link" href="../../blog">
                                <div class="sb-nav-link-icon"><i class="fab fa-blogger-b"></i></div>
                                Blog
                            </a>
                             <a class="nav-link" href="../../services">
                                <div class="sb-nav-link-icon"><i class="fab fa-servicestack"></i></div>
                                Services
                            </a>
                            <!--<a class="nav-link" href="../../#products">
                                <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                                Products
                            </a> -->
                            <a class="nav-link" href="../../about-us">
                                <div class="sb-nav-link-icon"><i class="fas fa-people-carry"></i></div>
                                About Us
                            </a>
                            <a class="nav-link" href="../../contact">
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
