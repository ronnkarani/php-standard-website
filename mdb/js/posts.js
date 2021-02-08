class Posts {
  
  static getPosts(start, limit) {
    if (start <= 1) {
      $("#posts-tbody").html('');
    }
    $.ajax({
      url: "../php/posts.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_posts",
        start: start,
        limit: limit,
      },
      success: function (response) {

        if (response != "no_more") {
          $("#posts-tbody").append(response);
          start += limit;
          Posts.getPosts(start, limit);
        } else {
          $("#posts-table").DataTable();
        }
      },
      error: (XMLHttpRequest, textStatus, errorThrown) => {
        console.log(textStatus);

        if (XMLHttpRequest.readyState == 4) {
          // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
        } else if (XMLHttpRequest.readyState == 0) {
          // Network error (i.e. connection refused, access denied due to CORS, etc.)
          alert("Network Error!");
        } else {
          // something weird is happening
        }
      },
    });
  }

  static deletePost(postid) {
    $("#delete-post-form").submit(function (e) {
      
      e.preventDefault();
      $.ajax({
        method:"post",
        url: "../php/deletepost.php",
        data: {
          key: "delete_post",
          postid: postid,
        },
        dataType: "text",
        success: function (response) {
          if (response == "post_deleted") {
            $("#deleteModal").modal("hide");
            $(".success-modal-text").text("Post deleted successfully");
            $("#successModal").modal("show");
            $("#posts-tbody").html("");
            Posts.getPosts(0, 10);
          } else {
            alert("Error while deleting post");
            console.log(response);
          }
        },
        error: (XMLHttpRequest, textStatus, errorThrown) => {
          console.log(textStatus);

          if (XMLHttpRequest.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
          } else if (XMLHttpRequest.readyState == 0) {
            // Network error (i.e. connection refused, access denied due to CORS, etc.)
            alert("Network Error!");
          } else {
            // something weird is happening
          }
        },
      });
    });
  }

  static setPost(postid){
    $(".set-post-error").hide();
    $.ajax({
      type: "post",
      url: "../php/posts.php",
      data: {
        key: "get_post_details",
        postid: postid,
      },
      dataType: "text",
      success: function (response) {
        if (Utils.isJSON(response)) {
          let data = JSON.parse(response);
          $("#post-"+ data.status).attr('checked', 'checked');
          $("#post-category").html(data.categories);
          Posts.updatePost(postid);
        } else {
          alert("Error while getting post details!");
          console.log(response);
        }
      },
      error: (XMLHttpRequest, textStatus, errorThrown) => {
        console.log(textStatus);

        if (XMLHttpRequest.readyState == 4) {
          // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
        } else if (XMLHttpRequest.readyState == 0) {
          // Network error (i.e. connection refused, access denied due to CORS, etc.)
          alert("Network Error!");
        } else {
          // something weird is happening
        }
      },
    });
  }

  static updatePost(postid){
    $("#set-post-form").submit(function (e) {
      e.preventDefault();
      let form_data = new FormData($("#set-post-form")[0]);
      form_data.append("key", "update_post");
      form_data.append("postid",postid );
      
      $.ajax({
        type: "post",
        url: "../php/posts.php",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: () => {
          $(".set-post-error").html(
            '<p class="text-primary">Updating post...</p>'
          );
          $(".set-post-error").show();
        },
        success: function (response) {
          if(response == 'post_updated'){
            $("#settingsModal").modal('hide');
            $(".success-modal-text").text("Post updated successfully");
            $("#successModal").modal("show");
            $("#posts-tbody").html("");
            Posts.getPosts(0, 10);
          }
          else{
            $(".set-post-error").html(
              "<p class='text-danger'>Error updating post!</p>"
            );
            $(".set-post-error").show();
            console.log(response);
            
          }
        },
        error: (XMLHttpRequest, textStatus, errorThrown) => {
          console.log(textStatus);

          if (XMLHttpRequest.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
          } else if (XMLHttpRequest.readyState == 0) {
            // Network error (i.e. connection refused, access denied due to CORS, etc.)
            alert("Network Error!");
          } else {
            // something weird is happening
          }
        },
      });
    });
  }
}

window.addEventListener("DOMContentLoaded", () => {
  Posts.getPosts(0, 10);
//   Posts.addPost();
//   Posts.deletePost();
});