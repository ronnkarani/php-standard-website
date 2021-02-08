<?php
session_start();
if(!isset($_SESSION['logged_in_username'])){
header("Location:../login/");
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
        <title> Bedubiz</title>
        <!-- <link rel="icon" href="../../img/logo.png" type="image/png" /> -->
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body >
  <input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['logged_in_userid'];?>"> 
    <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
<?php
if(in_array("admin", $_SESSION['roles'])){

?>
  <a class="navbar-brand" href="../">
<?php } else{?>
<a class="navbar-brand" href="../../">
<?php } ?>
    <i class="fa fa-home" style="color:white;font-size:25px"></i>
  </a>


  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbar-list-4">
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


<?php if(isset($_SESSION['profile_pic'])){ ?>

    <img src="../../img/profiles/<?php echo $_SESSION['profile_pic'];?>" width="50" height="50" class="rounded-circle" alt="avatar ">

<?php } else {?>
    <img src="../../img/profiles/user.jpg" width="50" height="50" class="rounded-circle">

<?php } ?>


          
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#"><?php echo $_SESSION['logged_in_username'];?></a>

            <?php
if(in_array("admin", $_SESSION['roles'])){

?>

          <a class="dropdown-item" href="../">Dashboard</a>
<?php } ?>
          <a class="dropdown-item" href="../logout/">Log Out</a>
        </div>
      </li>   
    </ul>
  </div>
</nav>
       
                <main>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4 mt-2">
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                        <div class="container">
                            <div class="jumbotron">
                                <div class="card mb-2">
                                    
                                    
                                    <div class="card-body row">
                                        <div class="col-md-6 card text center">
                                        <div class="card-header">
                                        Profile Picture
                                    </div>
                                    <div class="card-body">

                                            <img 
                                            <?php if(isset($_SESSION['profile_pic'])){ ?>

                                            src="../../img/profiles/<?php echo $_SESSION['profile_pic'];?>"
                                            <?php } else{?>
                                            src="../../img/profiles/user.jpg"
                                            <?php }?>
                                            
                                             alt="" class="img-fluid" style="border-radius:50%;max-height:200px;max-width:200px">


                                    </div>
                                    <div class="card-footer">
<?php if(isset($_SESSION['profile_pic'])){ ?>
<form id="remove-profile-pic">
<div class="remove-picture-error text-danger"></div>
                                        <button type="submit"  class="btn btn-danger">Remove Profile Picture</button>
                                        </form>
<?php } ?>
                                    </div>
                                        </div>
                                        <div class="col-md-6 card">
                                        <form id="profile-picture-form">
                                            <div class="card-header" >
                                            <?php if(isset($_SESSION['profile_pic'])){ 
                                                echo "New Profile Picture";
                                            }else{
                                                echo 'Add Profile Picture';
                                            }?>
                                            
                                            </div>
                                            <div class="card-body form-group">
                                            
                                            <input type="file" class="form-control-file" id="profile-pic" name="profile-pic" accept="image/*" required>
                                            </div>
                                            <div class="card-footer">
                                            <div class="picture-error text-danger"></div>
                                        <button type="submit" class="btn btn-primary">
                                        <?php if(isset($_SESSION['profile_pic'])){ 
                                                echo "Change Profile Picture";
                                            }else{
                                                echo 'Add Profile Picture';
                                            }?>
                                        </button>
                                        </form>
                                    </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>

                                <div class="card mb-2">
                                    <form action="" id="profile-details-form">
                                    <div class="card-header">
                                        Edit Profile
                                    </div>
                                    <div class="card-body">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" name="username" id="username" 
                                                pattern="[A-Za-z0-9]{8,20}"
                                                minlength="3"
                                                maxleghth="20"
                                                class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">First Name</label>
                                                <input type="firstname" name="firstname" id="firstname"
                                                pattern="[A-Za-z]{3,20}"
                                                minlength="3"
                                                maxleghth="20"
                                                 class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Last Name</label>
                                                <input type="lastname" name="lastname" id="lastname"
                                                pattern="[A-Za-z]{3,20}"
                                                minlength="3"
                                                maxleghth="20"
                                                 class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="website">Website</label>
                                                <input type="url" name="website" id="website"
                                                pattern="https?://.+\..+"
                                                 class="form-control">
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  http://www.example.com
</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile">Mobile</label>
                                                <input type="tel" name="mobile" id="mobile" class="form-control"
                                                 pattern="[0-9]{10,12}"
                                                >
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  254-700-000-000
</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="about">About</label>
                                                <textarea id="about" class="form-control" name="about" rows="1" maxlength="150"></textarea>
                                            </div>
                                            
                                        
                                    </div>
                                    <div class="card-footer">
                                    <div class="text-danger details-error"></div>
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                    </form>
                                </div>
                                <div class="card mb-2">
                                    <form action="" id="password-form">
                                    
                                    <div class="card-header">
                                        Change Password
                                    </div>
                                    <div class="card-body row">
                                        <div class="form-group col-md-4">
                                          <label for="old-password">Old Password</label>
                                          <input type="password" class="form-control" name="old-password" id="old-password" placeholder="old password">
                                        </div>
                                        <div class="form-group col-md-4">
                                          <label for="old-password">New Password</label>
                                          <input type="password" class="form-control" name="new-password" id="new-password" placeholder="new password">
                                        </div>
                                        <div class="form-group col-md-4">
                                          <label for="old-password">Confirm New Password</label>
                                          <input type="password" class="form-control" name="new-password-confirm" id="new-password-confirm" placeholder="confirm new password">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                    <div class="password-errors text-danger" style="display:none"></div>
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                    </form>
                                </div>
                                <div class="card">
                                <form id="social-links-form">
                                    <div class="card-header">
                                        Social Links
                                    </div>
                                    <div class="card-body row">
                                        <div class="form-group col-md-6">
                                                <label for="facebook"><i class="fab fa-facebook-square"></i></i></label>
                                                <input type="url" name="facebook" id="facebook"
                                                placeholder="facebook"
                                                pattern="https?://.+\..+"
                                                maxlength="100"
                                                class="form-control">
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  http://
</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="twitter"><i class="fab fa-twitter-square"></i></label>
                                                <input type="url" name="twitter" id="twitter"
                                                pattern="https?://.+\..+"
                                                maxlength="100"
                                                placeholder="twitter"
                                                class="form-control">
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  http://
</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="googleplus"><i class="fab fa-google-plus-square"></i></label>
                                                <input type="url" name="googleplus" id="googleplus"
                                                placeholder="google-plus"
                                                pattern="https?://.+\..+"
                                                maxlength="100"
                                                class="form-control">
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  http://
</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="instagram"><i class="fab fa-instagram"></i></label>
                                                <input type="url" name="instagram" id="instagram"
                                                pattern="https?://.+\..+"
                                                maxlength="100"
                                                placeholder="instagram"
                                                class="form-control">
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  http://
</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="youtube"><i class="fab fa-youtube"></i></label>
                                                <input type="url" name="youtube" id="youtube"
                                                pattern="https?://.+\..+"
                                                maxlength="100"
                                                placeholder="youtube"
                                                class="form-control">
                                                <small id="passwordHelpBlock" class="form-text text-muted">
  http://
</small>
                                            </div>

                                    </div>
                                    <div class="card-footer">
                                    <div class="social-error text-danger"></div>
                                        <button type="submit" class="btn btn-primary">Update Links</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                       
                        
                    </div>
                </main>
                <!-- footer begin -->
        <?php require '../components/footer.php'; ?>

              

        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="../js/utilities.js"></script>
        <script src="../js/user-profile.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        
    </body>
</html>
