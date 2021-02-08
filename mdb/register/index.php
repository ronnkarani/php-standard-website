<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CAS | Sign Up</title>
        <link rel="icon" href="../../img/logo.png" type="image/png" /> 
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
        <!-- navbar -->
        <?php include '../components/loginnavbar.php'?>
<!-- navbar -->
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Register</h3></div>
                                    <div class="card-body">
                                    <div class="form-error text-danger"></div>
                                        <form class="sign-up-form">
                                             <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Username</label>
                                                <input class="form-control py-4" id="username" type="text" 
                                                pattern="[A-Za-z0-9]{3,20}"
                                                minlength="3"
                                                maxleghth="20"
                                                placeholder="Enter Username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="email" type="email" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="password" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Confirm Password</label>
                                                <input class="form-control py-4" id="confirm-password" type="password" placeholder="Confirm password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary" >Register</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="../login/">Already have an account? Login!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <!-- footer begin -->
        <?php require '../components/footer.php'; ?>

                <!-- footer end -->
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        
        <script src="../js/signup.js"></script>
    </body>
</html>
