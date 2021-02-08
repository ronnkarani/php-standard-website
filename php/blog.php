<?php
session_start();
require '../mdb/php/db_connect.php';
require '../mdb/php/utils.php';

if (isset($_POST['key'])) {
    try {
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($_POST['key'] == "get_posts"){
            $category = $_POST['category'];
            $sql = "SELECT posts.id,posts.title,posts.titledetails,posts.created_at,posts.category, posts.author, images.url FROM posts INNER JOIN images ON images.postid=posts.id WHERE posts.status = 'published' AND images.purpose='postmain' ORDER BY created_at DESC";

            if(!empty($category)){
                $sql = "SELECT posts.id,posts.title,posts.titledetails,posts.created_at,posts.category, posts.author, images.url FROM posts INNER JOIN images ON images.postid=posts.id WHERE posts.status = 'published' AND images.purpose='postmain' AND posts.category =$category ORDER BY created_at DESC";
            }

            $posts = executer($sql);
            if(count($posts)>0){
                $response = '';
                foreach ($posts as $post ) {
                    // get total comments
                    $sql = "SELECT * FROM comments WHERE postid=".$post['id']."";
                    $comments = executer($sql);
                    $totalcomments = count($comments);
                    // get the role
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

                    $titledetails = $post['titledetails'];
                    if(strlen($titledetails)>200){
                        $titledetails = substr($titledetails, 0, 200);
                    }

                    $title = $post['title'];
                    if(strlen($title)>60){
                        $title = substr($title, 0, 60);
                    }

                    // prepare the response
                    $response .= '<div class="blog-item">
                        <div class="bi-pic">
                            <img src="../img/posts/'.$post['url'].'" alt="Post Image">
                        </div>
                        <div class="bi-text">
                            <h5><a href="../blog-details/?pid='.($post[id]*85).'">'.$title.'</a></h5>
                            <ul>
                                <li>by '.$author.'</li>
                                <li>'.$post['created_at'].'</li>
                                <li>'.$totalcomments.' Comment</li>
                            </ul>
                            <p>'.$titledetails.'</p>
                        </div>
                    </div>';

                }
                $res = array('posts'=>$response);
                exit(json_encode($res));
            }
            else{
                exit('no_posts');
            }
        }elseif($_POST['key'] == "get_categories"){
            $sql = "SELECT DISTINCT category, categories.name FROM posts INNER JOIN categories ON categories.id = posts.category WHERE posts.status = 'published'";
            $categories = executer($sql);
            if(count($categories)>0){
                $categoriesresult = '';
                $metaDescription = 'bedubiz: ';
                foreach ($categories as $category) {
                    $sql = "SELECT posts.category FROM posts WHERE posts.category= ".$category['category']."";
                    $posts = executer($sql);
                    $totalposts = count($posts);
                    $categoriesresult .= '<li><a onclick="Blog.getPosts('.$category['category'].')">'.$category['name'].'<span>'.$totalposts.'</span></a></li>'; 
                    $metaDescription .= $category['name'].', ';
                }
                $response = array('categories'=>$categoriesresult, 'metaDescription' => $metaDescription);
                exit(json_encode($response));
            }else{
                echo 'no_posts';
            }
        }

    } catch (PDOException $e) {
    echo $e->getMessage();
    }
}
        