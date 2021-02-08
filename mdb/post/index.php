<?php
session_start();

if(!in_array("admin", $_SESSION['roles'])){
    header("Location:../login/");
}

if(!isset($_GET['pid'])){
    header("Location:../posts/");
}else{
    $_SESSION['postid'] = ($_GET['pid'])/85;
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
        <title>CAS</title>
        <!-- <link rel="icon" href="../../img/logo.png" type="image/png" /> -->
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <!-- navbar begin -->
               <?php require '../components/navbar.php'; ?>


<!-- nav bar end -->

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <!-- side nav begin -->
                                <?php include '../components/sidenav.php'?>

                <!-- side nav end -->
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4 mt-2">
                            <li class="breadcrumb-item active">Post Details</li>
                        </ol>
                        <div class="container">
                            <nav class="nav nav-pills nav-fill">
                                <a class="nav-item nav-link active" href="#" id="show-details">Details</a>
                                <a class="nav-item nav-link" href="#" id="show-comments">Comments</a>
                                <a class="nav-item nav-link" href="../../blog-details/?pid=<?php echo $_GET['pid']?>">View in blog</a>
                                
                            </nav>

                            <div class="jumbotron mt-1" >
                                <div id="details">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <nav class="nav nav-pills nav-fill">
                                <a class="nav-item edit" title="Edit" data-toggle="tooltip" href="../edit-post/?pid=<?php echo $_GET['pid']?>" id=""><i class="material-icons">&#xE254;</i></a>
                                <a href="#deleteModal" data-pid="<?php echo $_SESSION['postid']?>" id="delete-post-button" class="nav-item text-danger delete " title="Delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
                                
                            </nav>
                                    </div>
                                    <div class="card-body table-responsive-md">
                                        <table class="table">
  <thead>
    <tr>
      <th scope="col">Category</th>
      <th scope="col">Date Created</th>
      <th scope="col">Date Updated</th>
      <th scope="col">Views</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody id="details-tbody">
    
    
  </tbody>
</table>
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Title
                                    </div>
                                    <div class="card-body" id="title" >
                                           
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Keywords
                                    </div>
                                    <div class="card-body" id="keywords" >
                                           
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Main Image
                                    </div>
                                    <div class="card-body" id="main-image">
                                        
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Title Details
                                    </div>
                                    <div class="card-body" id="title-details">
                                        
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Images
                                    </div>
                                    <div class="card-body row" id="more-images">
                                        
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Description details
                                    </div>
                                    <div class="card-body" id="details-description">
                                        
                                            
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        Quotes
                                    </div>
                                    <div class="card-body" id="quotes">
                                        
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-header">
                                        More Description
                                    </div>
                                    <div class="card-body" id="more-description">
                                        
                                    </div>
                                </div>

                                <div class="card mb-2" >
                                    <div class="card-header">
                                        Author
                                    </div>
                                    <div class="card-body" id="author">
                                        
                                        
                                    </div>
                                </div>

                            </div>
                            <div id="comments" style="display:none" class="table-responsive-md">
                                <table class="table table-striped" id="comments-table">
                                    <thead class="thead-dark">
                                        <tr>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="comments-tbody">
                                        
                                    </tbody>
                                </table>
                            </div>
                            </div>

                        </div>
                       
                        
                    </div>
                </main>
                <!-- footer begin -->
        <?php require '../components/footer.php'; ?>

                <!-- footer end -->
            </div>
        </div>

<!-- success modal start -->
<!-- Modal HTML -->
<div id="successModal" class="modal fade">
	<div class="modal-dialog success-modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>				
				<h4 class="modal-title w-100">Success!</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center success-modal-text"></p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div> 
<!-- success modal end -->


<!-- Modal HTML -->
<div id="deleteModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="material-icons">&#xE5CD;</i>
				</div>						
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete this Post? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="delete-post-form">
				<button type="submit" class="btn btn-danger">Delete</button>
                </form>
			</div>
		</div>
	</div>
</div> 

<!-- confirm delete modal end -->





<!-- comment settings modal -->
<div class="modal fade bd-example-modal-xl" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ">
      
    <div class="modal-content p-2">
        <div class="modal-header">
      </div>

      <div class="modal-body" id="comment-settings-modal">
          
      </div>
      

    </div>
  </div>
</div>
<!-- comment settings modal end -->
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script> 
        <script src="../js/utilities.js"></script>
      <script src="../js/view-post.js"></script>
    </body>
</html>
