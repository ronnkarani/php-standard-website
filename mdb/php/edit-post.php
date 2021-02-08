<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    $postid = $_SESSION['postid'];
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($_POST['key'] == "get_post_details"){
            
            $sql = "SELECT posts.id,posts.title,posts.keywords,posts.titledetails,posts.description,posts.moredescription,posts.created_at,posts.updated_at, posts.status, users.firstname, users.lastname,users.about, posts.category, posts.created_at FROM (posts INNER JOIN users ON users.id=posts.author) WHERE posts.id=$postid";
            $posts = executer($sql);
            if(count($posts)>0){
                $post = $posts[0];
                $status = $post['status'];
                $title = $post['title'];
                $keywords = $post['keywords'];
                $titledetails = $post['titledetails'];
                $description = $post['description'];
                $moredescription = $post['moredescription'];
                $author = '<p class="card-text">'.$post['firstname'].' '.$post['lastname'].'</p><p class="card-text">'.$post['about'].'</p>';

                // get categories
                $sql = "SELECT * FROM categories";
            $categories = executer($sql);
            $cats= '<select id="category" class="form-control" name="category"><option value="">Select category--</option>';
            foreach ($categories as $category ) {
                if($category['id'] == $post['category']){
                    $cats .= '<option value="'.$category['id'].'" selected>'.$category['name'].'</option>';
                break;
                }
                $cats .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
            }
            $cats.='</select>';
                    
                    // get image
                    $sql = "SELECT * FROM images WHERE postid = $postid AND `purpose` = 'postmain'";
                    $images = executer($sql);
                    $image = $images[0]['url'];
                    $mainimage = '<img class="img-fluid" src="../../img/posts/'.$image.'" alt="">';

                    // get more images author
                    $sql = "SELECT * FROM images WHERE postid = $postid AND `purpose` = 'postmore'";
                    $images = executer($sql);
                    $moreimages='';
                    foreach($images as $image){
                        $moreimages .= '<div class="form-check col-md-4 mb-2">
                                <input class="form-check-input" type="checkbox" value="'.$image['url'].'" id="more-image-'.$image['id'].'" name="current-more-image[]">
                                <label class="form-check-label" for="defaultCheck1">
                                    <img src="../../img/posts/'.$image['url'].'" alt="" class="w-100 h-80">
                                </label>
                            </div>';
                    }
                    
                    // get quotes
                    $sql ="SELECT * FROM postquotes WHERE postid = $postid";
                    $postquotes = executer($sql);
                    $quotescurrent='';
                    foreach($postquotes as $postquote){
                        $quoteid=$postquote['quoteid'];
                        $sql ="SELECT * FROM quotes WHERE id = $quoteid";
                        $quoteresult = executer($sql);
                        $ourquote= $quoteresult[0];
                        $quotescurrent .= '<div class="form-check">
                                <input class="form-check-input" type="checkbox" value="'.$ourquote['id'].'" id="quote-'.$ourquote['id'].'" name="current-quotes[]">
                                <label class="form-check-label" for="qiote-'.$quoteid['id'].'"><span class="font-weight-bold">'.$ourquote['author'].'</span> - '.$ourquote['quote'].'
                                </label>
                            </div>';
                    }

                    // get existing quotes
                    $sql = "SELECT * FROM quotes";
                    $quotes = executer($sql);
                    $quotesR= '<label class="my-1 mr-2" for="quote">Select from existing quotes</label><select id="quote" class="form-control" name="quote"><option value="">Select quote--</option>';
                    foreach ($quotes as $quote ) {
                        $quotesR .= '<option value="'.$quote['id'].'">'.$quote['author'].' - '.$quote['quote'].'</option>';
                    }
                    $quotesR.='</select>';


                    $response = array(
                        'title' => $title,
                        'keywords' => $keywords,
                        'titledetails' => $titledetails,
                        'descriptiondetails' => $description,
                        'mainimage'=> $mainimage,
                        'quotes'=> $quotescurrent,
                        'moredescription'=>$moredescription,
                        'moreimages'=>$moreimages,
                        'author'=> $author,
                        'detailstbody'=>$detailstbody,
                        'existingquotes'=>$quotesR,
                        'status'=> $status,
                        'categories'=>$cats
                    );


                exit(json_encode($response));
            }else{
                exit('not_exist');
            }
        }elseif($_POST['key'] == 'update_post'){
            $title = $_POST['title'];
            $keywords = $_POST['keywords'];
            $detailsTitle = $_POST['detailsTitle'];
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

            // get existing images checked to be deleted
            $currmoreimages = $_POST['current-more-image'];

            // get existing quotes to be deleted
            $currquotes = $_POST['current-quotes'];

            // determine category
            if($newcategory != null){
                $sql = "INSERT INTO categories (`name`) VALUES ('$newcategory')";
                if(noResultQuery($sql) == 'done'){
                    $category = $connect->lastInsertId();
                }
            }

            // perform an update 
            $sql = "UPDATE posts SET title='$title', keywords='$keywords', titledetails = '$detailsTitle', `description`= '$detailsDescription', moredescription = '$detailsMoreDescription', category = '$category', `status`='$status', updated_at = current_timestamp WHERE id = $postid";
            if(noResultQuery($sql)=='done'){
                if(!empty($quote) ){
                    $sql = "INSERT INTO postquotes (postid, quoteid) VALUES ($postid, $quote)";
                    noResultQuery($sql);
                }
            }

            if(!empty($author) && !empty($newQuote)){
                    $sql = "INSERT INTO quotes (author, quote) VALUES ('$author', '$newQuote')";
                    if(noResultQuery($sql) == 'done'){
                        $quoteid = $connect->lastInsertId();
                        $sql = "INSERT INTO postquotes (postid, quoteid) VALUES ($postid, $quoteid)";
                    noResultQuery($sql);
                    }
            }

            // change main image if not empty
            if (!empty($mainimage)) {
                $sql = "UPDATE images SET purpose = 'postmore' WHERE postid= $postid AND purpose = 'postmain'";
                if(noResultQuery($sql) == 'done'){
                    uploadImage($postid,$mainimage, $mainimagetmp, 'postmain');
                }
            }
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

            if(!empty($currmoreimages)){
                foreach ($currmoreimages as $cimage) {
                    $sql = "DELETE FROM images WHERE `url` = '$cimage' AND postid = $postid";
                    noResultQuery($sql);
                    unlink('../../img/posts/'.$cimage);

                }
            }

            if(!empty($currquotes)){
                foreach ($currquotes as $cquote) {
                    $sql = "DELETE FROM postquotes WHERE quoteid= $cquote AND postid=$postid";
                    noResultQuery($sql);
                }
            }

            $response = array('result'=>'post_updated', 'url'=>"../post/?pid=".($postid*85));
            exit(json_encode($response));

        }
    } catch (PDOException $e) {
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