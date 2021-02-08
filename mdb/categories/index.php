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
        <title> CAS</title>
        <!-- <link rel="icon" href="../../img/logo.png" type="image/png" /> -->
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
                        <ol class="breadcrumb mb-4 mt-4">
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
        <div class="jumbotron">
                <div class="row mb-1 bg-primary p-3">
                    <div class="col-sm-9">
                        <h4>Categories</h4>
                    </div>
                    <div class="col-sm-3">
                        <a href="#" class="btn btn-light" data-toggle="modal" id="showAddModalBtn" data-target="#addCategoryModal"><i class="fas fa-plus"></i> <span>Add New</span></a>
                        						
                    </div>
                </div>
                <div class="table-responsive-md">
                <table class="table table-striped table-hover" id="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categories-tbody">
                        
                    </tbody>
                </table>
                </div>
            
        </div>
                       
                        
                    </div>
                </main>
                <!-- footer begin -->
        <?php require '../components/footer.php'; ?>

                <!-- footer end -->
            </div>
        </div>





<!--Add category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body add-category-body">
                <form action="" id="add-category-form">
                <div class="form-group">
                    <input class="form-control form-control-sm" type="text" placeholder="category" id="add-category-name" pattern="[A-Za-z]{3,50}" required>
                </div>
            </div>
            <div class="modal-footer row">
                <div id="add-category-result" class="  col-sm-12"></div>
                <div class="d-flex justify-content-around col-sm-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add category modal end -->

<!-- category edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body add-user-body">
            <form action="" id="edit-category-form">
            <div class="form-group">
                    <input class="form-control form-control-sm" type="text" placeholder="category" id="edit-category-name" pattern="[A-Za-z]{3,50}"
                                                    required>
            </div>

            <div class="form-group">
                    <p id="edit-category-result"></p>
            </div>
        </div> 
        <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="hidden" id="categoryid" >
            <button type="submit" class="btn btn-primary" >Update</button>
            </form>

        </div>
    </div>
  </div>
</div>
<!-- category edit modal end -->

<!-- confirm delete modal start -->

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
				<p>Do you really want to delete this category? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="delete-category-form">
				<button type="submit" class="btn btn-danger">Delete</button>
                </form>
			</div>
		</div>
	</div>
</div> 

<!-- confirm delete modal end -->

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

        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="../js/categories.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        
    </body>
</html>
