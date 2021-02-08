<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // getting post
        if($_POST['key'] == "get_posts"){
            $start = $_POST['start'];
            $limit = $_POST['limit'];
            
            $sql = "SELECT posts.id,posts.title,posts.created_at, posts.status, users.firstname, users.lastname, categories.name, posts.created_at FROM ((posts INNER JOIN users ON users.id=posts.author) INNER JOIN categories ON categories.id=posts.category) limit $start,$limit";
            $posts = executer($sql);
            if(count($posts)>0){
                $response ='';
                foreach ($posts as $post) {
                    $postid = $post['id'];
                    // get image
                    $sql = "SELECT * FROM images WHERE postid = $postid AND `purpose` = 'postmain'";
                    $images = executer($sql);
                    $image = $images[0]['url'];

                    $title = $post['title'];
                    if(strlen($title)>60){
                        $title = substr($title, 0, 60);
                    }

                    // get author
                    $response .= '
                    <tr id="row-'.$postid.'">
                    <td><img src="../../img/posts/'.$image.'" class="avatar"></td>
                    <td>'.$title.'</td>
                    <td>'.$post['name'].'</td>
                    <td>'.$post['firstname'].' '.$post['lastname'].'</td>
                    <td>'.$post['created_at'].'</td>
                    <td>'.$post['status'].'</td>
                    <td class="text-center d-flex justify-content-between">
                        <a href="#setingsModal" class="settings" title="Settings" data-toggle="modal" 
                        onclick="Posts.setPost('.$postid.')"
                        data-target="#settingsModal"><i class="material-icons">&#xE8B8;</i></a>
                            <a href="../post/?pid='.($postid*85).'" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                            <a href="../edit-post/?pid='.($postid*85).'" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a href="#deleteModal" class="delete" 
                            onclick="Posts.deletePost('.$postid.')"
                            title="Delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
                    </td>

                    </tr>
                    ';
                }
                exit($response);
            }else{
                exit('no_more');
            }
        }elseif($_POST['key'] == "get_cats_quotes"){
            $sql = "SELECT * FROM categories";
            $categories = executer($sql);
            $cats= '<select id="category" class="form-control" name="category"><option value="">Select category--</option>';
            foreach ($categories as $category ) {
                $cats .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
            }
            $cats.='</select>';

            $sql = "SELECT * FROM quotes";
            $quotes = executer($sql);
            $quotesR= '<label class="my-1 mr-2" for="quote">Select from existing quotes</label><select id="quote" class="form-control" name="quote"><option value="">Select quote--</option>';
            foreach ($quotes as $quote ) {
                $quotesR .= '<option value="'.$quote['id'].'">'.$quote['author'].' - '.$quote['quote'].'</option>';
            }
            $quotesR.='</select>';

            $response = array('categories'=>$cats, 'quotes'=> $quotesR);
            exit(json_encode($response));

        }elseif($_POST['key'] == "add_post"){
            $title = $_POST['title'];
            $detailsTitle = $_POST['detailsTitle'];
            $keywords = $_POST['keywords'];
            $detailsDescription = $_POST['detailsDescription'];
            $detailsMoreDescription = $_POST['detailsMoreDescription'];
            $newQuote = $_POST['newQuote'];
            $quote = $_POST['quote'];
            $category = $_POST['category'];
            $newcategory = $_POST['new-category'];
            $detailsTitle = $_POST['detailsTitle'];
            $status = $_POST['status'];
            $author = $_POST['author'];
            // images
            $mainimage = $_FILES['main-image']['name'];
            $mainimagetmp = $_FILES['main-image']['tmp_name'];
            $image1 = $_FILES['image-1']['name'];
            $image1tmp = $_FILES['image-1']['tmp_name'];
            $image2 = $_FILES['image-2']['name'];
            $image2tmp = $_FILES['image-2']['tmp_name'];
            $image3 = $_FILES['image-3']['name'];
            $image3tmp = $_FILES['image-3']['tmp_name'];

            // get user posting this
            $userid = $_SESSION['logged_in_userid'];

            // determine category
            if($category == null && $newcategory != null){
                $sql = "INSERT INTO categories (`name`) VALUES ('$newcategory')";
                if(noResultQuery($sql) == 'done'){
                    $category = $connect->lastInsertId();
                }
            }

            $sql = "INSERT INTO posts (title, keywords, titledetails, `description`, moredescription, author, category, `status`,created_at) VALUES ('$title', '$keywords', '$detailsTitle', '$detailsDescription', '$detailsMoreDescription', '$userid', '$category', '$status',current_timestamp)";

            if(noResultQuery($sql) == 'done'){
                $postid = $connect->lastInsertId();

                if(!empty($quote) ){
                    $sql = "INSERT INTO postquotes (postid, quoteid) VALUES ($postid, $quote)";
                    noResultQuery($sql);
                }

                if(!empty($author) && !empty($newQuote)){
                    $sql = "INSERT INTO quotes (author, quote) VALUES ('$author', '$newQuote')";
                    if(noResultQuery($sql) == 'done'){
                        $quoteid = $connect->lastInsertId();
                        $sql = "INSERT INTO postquotes (postid, quoteid) VALUES ($postid, $quoteid)";
                    noResultQuery($sql);
                    }
                }

                // upload main image
                uploadImage($postid,$mainimage, $mainimagetmp, 'postmain');

                // Upload other images if not null
                if (!empty($image1)) {
                    uploadImage($postid,$image1, $image1tmp, 'postmore');
                }
                if (!empty($image2)) {
                    uploadImage($postid,$image2, $image2tmp, 'postmore');
                }
                if (!empty($image3)) {
                    uploadImage($postid,$image3, $image3tmp, 'postmore');
                }
                // header("Location:../post/?pid=".($postid*85));
                $response = array('result'=>'post_added', 'url'=>"../post/?pid=".($postid*85));
                exit(json_encode($response));
            }
            
        }elseif($_POST['key'] == "get_post_details"){
            $postid = $_POST['postid'];
            $sql = "SELECT * FROM posts WHERE id = $postid";
            $posts = executer($sql);
            $post = $posts[0];
            $status = $post['status'];
            // get categories
                $sql = "SELECT * FROM categories";
            $categories = executer($sql);
            $cats= '<label class="card-header">Category</label><div class="card-body"><select id="category" class="form-control" name="category"><option value="">Select category--</option>';
            foreach ($categories as $category ) {
                if($category['id'] == $post['category']){
                    $cats .= '<option value="'.$category['id'].'" selected>'.$category['name'].'</option>';
                }else{
                $cats .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                }
            }
            $cats.='</select></div>';
            $response = array('categories'=> $cats, 'status'=> $status);
            exit(json_encode($response));
        }elseif($_POST['key'] == "update_post"){
            $status = $_POST['status'];
            $category = $_POST['category'];
            $postid = $_POST['postid'];
            $sql = "UPDATE posts SET category = $category, `status`= '$status' WHERE id = $postid";
            if(noResultQuery($sql) == 'done'){
                exit('post_updated');
            }
        }
    } 
    catch (PDOException $e) {
    echo $e->getMessage();
    }
}

function uploadImage($postid, $image, $tmp, $purpose)
{
    global $connect;
    $test = explode(".", $image);
    $extension = end($test);
    $date   = date('l');
    $name = rand(100, 9990).''.$date.'.'.$extension;
    $location = '../../img/posts/'.$name;
    move_uploaded_file($tmp, $location);

    $sql = "INSERT INTO images (`url`,`postid`, `purpose`) VALUES('$name',$postid, '$purpose')";
    noResultQuery($sql);
}