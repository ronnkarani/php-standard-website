<?php
session_start();
require './db_connect.php';
require './utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $postid = $_SESSION['postid'];
        if($_POST['key'] == "get_post_details"){
            $sql = "SELECT posts.id,posts.title,posts.keywords,posts.titledetails,posts.description,posts.views,posts.moredescription,posts.created_at,posts.updated_at, posts.status, users.firstname, users.lastname,users.about, categories.name, posts.created_at FROM ((posts INNER JOIN users ON users.id=posts.author) INNER JOIN categories ON categories.id=posts.category) WHERE posts.id=$postid";
            $posts = executer($sql);
            if(count($posts)>0){
                $post = $posts[0];
                $detailstbody = '<tr>
                                <td>'.$post['name'].'</td>
                                <td>'.$post['created_at'].'</td>
                                <td>'.$post['updated_at'].'</td>
                                <td>'.$post['views'].'</td>
                                <td>'.$post['status'].'</td>
                                </tr>';
                $title = $post['title'];
                $keywords = $post['keywords'];
                $titledetails = $post['titledetails'];
                $description = $post['description'];
                $moredescription = $post['moredescription'];
                $author = '<p class="card-text">'.$post['firstname'].' '.$post['lastname'].'</p><p class="card-text">'.$post['about'].'</p>';
                    
                    // get image
                    $sql = "SELECT * FROM images WHERE postid = $postid AND `purpose` = 'postmain'";
                    $images = executer($sql);
                    $image = $images[0]['url'];
                    $mainimage = '<img class="img-fluid" src="../../img/posts/'.$image.'" alt="">';

                    // get more images
                    $sql = "SELECT * FROM images WHERE postid = $postid AND `purpose` = 'postmore'";
                    $images = executer($sql);
                    $moreimages='';
                    foreach($images as $image){
                        $moreimages .= '<div class="col-md-4">
                                            <img class="img-fluid" src="../../img/posts/'.$image['url'].'" alt="">
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
                        $quotes .= '<p class="card-text"><span class="text-bold">'.$ourquote['author'].' - </span>'.$ourquote['quote'].'</p>';
                    }


                    $response = array(
                        'title' => $title,
                        'keywords' => $keywords,
                        'titledetails' => $titledetails,
                        'descriptiondetails' => $description,
                        'mainimage'=> $mainimage,
                        'quotes'=> $quotes,
                        'moredescription'=>$moredescription,
                        'moreimages'=>$moreimages,
                        'author'=> $author,
                        'detailstbody'=>$detailstbody
                    );


                exit(json_encode($response));
            }else{
                exit('not_exist');
            }
        }elseif ($_POST['key'] == "get_post_comments") {
            $start = $_POST['start'];
            $limit = $_POST['limit'];
            $sql = "SELECT * FROM comments WHERE postid = $postid LIMIT $start, $limit";
            $commentsarray = executer($sql);
            if(count($commentsarray)>0){
                $comments = '';
                foreach ($commentsarray as $comment) {
                    $comments .= '<tr id="row-'.$comment['id'].'">
                    <td>'.$comment['ctext'].'</td>
                    <td>'.$comment['status'].'</td>
                    <td>'.$comment['date'].'</td>
                    <td>
                                            <a href="#setingsModal"
                                            data-commentid="'.$comment['id'].'"
                                            class="settings set-comment" title="more details and settings" data-toggle="modal" data-target="#settingsModal"><i class="material-icons">&#xE8B8;</i></a>
                                            <a href="#" data-commentid="'.$comment['id'].'" class="delete delete-comment-button" title="Delete" data-toggle="modal"><i class="material-icons">&#xE872;</i></a>
                                        </td>
                    </tr>';
                }
                exit($comments);
            }
            else{
                exit('no_more');
            }
        }elseif($_POST['key'] == "delete_comment"){
            $commentid= $_POST['commentid'];
            $sql = "DELETE FROM comments WHERE id=$commentid AND postid= $postid";
            if(noResultQuery($sql) == 'done'){
                exit('comment_deleted');
            }else{
                exit('failed');
            }
        }elseif($_POST['key'] == "get_comment_details"){
            $commentid= $_POST['commentid'];
            $sql = "SELECT * FROM comments WHERE id = $commentid AND postid = $postid";
            $commentsarray = executer($sql);
            $comment = $commentsarray[0];
            $commentdetails = '<div class="card">
              <div class="card-header">
                Comment Settings
              </div><div class="card-body">
              <p>Username : '.$comment['username'].'</p>
              <p>email: '.$comment['email'].'</p>
              <p>website: '.$comment['website'].'</p>
              <p>status: '.$comment['status'].'</p>
              <p>Date: '.$comment['date'].'</p>
              <h5>Comment</h5>
              <p class="card-text">'.$comment['ctext'].'</p>
              </div>
              <div class="card-footer d-flex justify-content-around">
                  <button type="button" class="btn btn-success" title="set visible to users" onclick="ViewPost.setComment('.$comment['id'].',`visible`)">Set visible</button>
                                            <button type="button" class="btn btn-warning" title="hide from users" onclick="ViewPost.setComment('.$comment['id'].',`hidden`)">Hide</button>
                                           
              </div>
              </div>
              ';
              $response = array('commentdetails' => $commentdetails);
              exit(json_encode($response));
        }elseif($_POST['key'] == "set_comment"){
            $commentid= $_POST['commentid'];
            $status= $_POST['status'];
            $sql = "UPDATE comments SET `status`= '$status' WHERE id=$commentid AND postid= $postid";
            if(noResultQuery($sql) == 'done'){
                exit('comment_updated');
            }else{
                exit('failed');
            }
        }
    } catch (PDOException $e) {
    echo $e->getMessage();
    }
}