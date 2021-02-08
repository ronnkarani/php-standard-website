<?php
session_start();
require '../mdb/php/db_connect.php';
require '../mdb/php/utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $postid = $_SESSION['postid'];
        if($_POST['key'] == "get_post_details"){
            $sql = "SELECT posts.id,posts.title,posts.keywords,posts.titledetails,posts.description,posts.moredescription,posts.created_at,posts.author, users.firstname, users.lastname,users.about, posts.created_at, images.url  FROM ((posts INNER JOIN users ON users.id=posts.author) INNER JOIN images ON images.postid=posts.id) WHERE posts.id=$postid AND images.purpose='postmain'";
            $posts = executer($sql);
            if(count($posts)>0){
                $post = $posts[0];
                // get total comments
                    $sql = "SELECT * FROM comments WHERE postid=".$post['id']."";
                    $comments = executer($sql);
                    $totalcomments = count($comments);

                // get role of the person who posted this
                $sql = "SELECT * FROM roles WHERE userid =".$post['author']." ";
                    $roles = executer($sql);
                    $author = '';
                    foreach ($roles as $role) {
                        if($role['role']=='admin'){
                            $author = 'Admin';
                        }elseif ($role['role'] == 'Author') {
                            $author == 'author';
                        }elseif($role['role'] == 'user'){
                            $author = 'User';
                        }
                    }

                $keywords = $post['keywords'];
                $documentTitle = $post['title'];
                $blogherosection='<div class="blog-details-hero set-bg" data-setbg="../img/posts/'.$post['url'].'">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 p-0 m-auto">
                            <div class="bh-text">
                                <h3>'.$post['title'].'</h3>
                                <ul>
                                    <li>by '.$author.'</li>
                                    <li>'.$post['created_at'].'</li>
                                    <li>'.$totalcomments.' Comment</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </div>';
                $titledetails = $post['titledetails'];
                $detailsdescription = $post['description'];
                $moredescription = $post['moredescription'];

                // get more images author
                $sql = "SELECT * FROM images WHERE postid = $postid AND `purpose` = 'postmore'";
                $images = executer($sql);
                $moreimages='';
                foreach($images as $image){
                    $moreimages .= '<div class="blog-details-pic-item">
                                <img src="../img/posts/'.$image['url'].'" alt="">
                            </div>';
                }

                // get quotes
                $sql ="SELECT * FROM postquotes WHERE postid = $postid";
                $postquotes = executer($sql);
                $quotes='';
                foreach($postquotes as $postquote){
                    $quoteid=$postquote['quoteid'];
                    $sql ="SELECT * FROM quotes WHERE id = $quoteid";
                    $quoteresult = executer($sql);
                    $ourquote= $quoteresult[0];
                    $quotes .= '<div class="blog-details-quote">
                            <div class="quote-icon">
                                <img src="../img/posts/quote-left.png" alt="">
                            </div>
                            <h5>'.$ourquote['quote'].'</h5>
                            <span>'.$ourquote['author'].'</span>
                        </div>';
                }
                // get author details
                $sql = "SELECT * FROM socialnetwork WHERE userid =".$post['author']."";
                $socialnetworks = executer($sql);
                $socialnetwork = $socialnetworks[0];

                // get author image
                $sql = "SELECT `url` FROM images WHERE userid = ".$post['author']."";
                $images = executer($sql);
                $profile='user.jpg';
                if(count($images)>0){
                    $profile = $images[0]['url'];
                }

                // set author texts to display
                $blogauthor = '<div class="ba-pic">
                                <img src="../img/profiles/'.$profile.'" alt="">
                            </div>
                            <div class="ba-text"><h5>'.$post['firstname'].' '.$post['lastname'].'</h5>
                            <p>'.$post['about'].'</p>
                            <div class="bp-social">
                            ';
                            if(!empty($socialnetwork['facebook'])){
                                $blogauthor .= '<a href="'.$socialnetwork['facebook'].'"><i class="fa fa-facebook"></i></a>';
                            }
                            if(!empty($socialnetwork['twitter'])){
                                $blogauthor .= '<a href="'.$socialnetwork['twitter'].'"><i class="fa fa-twitter"></i></a>';
                            }
                            if(!empty($socialnetwork['googleplus'])){
                                $blogauthor .= '<a href="'.$socialnetwork['googleplus'].'"><i class="fa fa-google-plus"></i></a>';
                            }
                            if(!empty($socialnetwork['instagram'])){
                                $blogauthor .= '<a href="'.$socialnetwork['instagram'].'"><i class="fa fa-instagram"></i></a>';
                            }
                            if(!empty($socialnetwork['youtube'])){
                                $blogauthor .= '<a href="'.$socialnetwork['youtube'].'"><i class="fa fa-youtub-play"></i></a>';
                            }
                            $blogauthor .='</div>
                            </div>';
                
                //update the post views
                $sql = "UPDATE posts SET views = `views`+1 WHERE id = $postid";
                $result = noResultQuery($sql);

                $response = array(
                    'keywords' => $keywords,
                    'documentTitle' => $documentTitle,
                    'blogherosection'=> $blogherosection,
                    'titledetails' => $titledetails,
                    'detailsdescription' => $detailsdescription,
                    'moredescription' => $moredescription,
                    'moreimages' => $moreimages,
                    'quotes' => $quotes,
                    'author' => $blogauthor
                );
                exit(json_encode($response));
            }else{
                exit('not_exist');
            }
        }elseif($_POST['key'] == 'leave_comment'){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $website = $_POST['website'];
            $comment = $_POST['comment'];

            if(isset($_SESSION['logged_in_userid'])){
                $sql = "SELECT users.website, users.email, users.username FROM users WHERE id = ".$_SESSION['logged_in_userid']."";
                $users = executer($sql);
                $user = $users[0];
                $username = $user['username'];
                $email = $user['email'];
                $website = $user['website'];
            }

            $sql = "INSERT INTO comments (postid, username, email, website, ctext) VALUES ($postid, '$username', '$email', '$website', '$comment')";
            noResultQuery($sql);
            exit('comment_posted');
        }elseif($_POST['key'] == 'fetch_comments'){
            $sql = "SELECT * FROM comments WHERE postid = $postid AND `status` = 'visible' ORDER BY `date` DESC";
            $comments = executer($sql);
            $commentsR = '<h5 class="co-title">Comment</h5>';
            foreach ($comments as $comment) {
                $email=$comment['email'];
                $sql = "SELECT images.url FROM images INNER JOIN users ON images.userid = users.id WHERE users.email = '$email'";
                $images = executer($sql);
                $imagename = 'user.jpg';
                if(count($images)>0){
                    $imagename = $images[0]['url'];
                }
                $commentsR .= '<div class="co-item">
                                        <div class="co-pic">
                                            <img src="../img/profiles/'.$imagename.'" alt="">
                                            <h5>'.$comment['username'].'</h5>
                                        </div>
                                        <div class="co-text">
                                            <p>'.$comment['ctext'].'</p>
                                        </div>
                                    </div>';
            }

            $response = array('comments'=> $commentsR);
            exit(json_encode($response));
        }
    }
    catch (PDOException $e) {
    echo $e->getMessage();
    }
}