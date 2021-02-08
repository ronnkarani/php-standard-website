$(document).ready(() => {
  $("#show-details").click(() => {
    if ($("#details").css("display") == "block") {
      $("#details").hide();
    } else {
      $("#details").show();
    }
    $("#comments").hide();
    $("#show-comments").removeClass("active");
    $("#show-details").addClass("active");
  });

  $("#show-comments").click(() => {
    if ($("#comments").css("display") == "block") {
      $("#comments").hide();
    } else {
      $("#comments").show();
    }
    $("#details").hide();
    $("#show-details").removeClass("active");
    $("#show-comments").addClass("active");
  });
});


class ViewPost {
  static getPostDetails() {
    $.ajax({
      url: "../php/viewpost.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_post_details",
      },
      success: function (response) {
        if (Utils.isJSON(response)) {
          let data = JSON.parse(response);
          $("#title").html(data.title);
          $("#keywords").html(data.keywords);
          $("#title-details").html(data.titledetails);
          $("#main-image").html(data.mainimage);
          $("#more-images").html(data.moreimages);
          $("#details-description").html(data.descriptiondetails);
          $("#quotes").html(data.quotes);
          $("#more-description").html(data.moredescription);
          $("#author").html(data.author);
          $("#details-tbody").html(data.detailstbody);
        } else if (response == "not_exist") {
          window.location.href = "../posts/";
        } else {
          console.log(response);
          alert("Error");
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

  static getPostComments(start, limit) {
    $.ajax({
      url: "../php/viewpost.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_post_comments",
        start: start,
        limit: limit,
      },
      success: function (response) {
        if (response != "no_more") {
          $("#comments-tbody").append(response);
          start += limit;
          ViewPost.getPostComments(start, limit);
        } else {
          $("#comments-table").DataTable();
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
        method: "post",
        url: "../php/deletepost.php",
        data: {
          key: "delete_post",
          postid: postid,
        },
        dataType: "text",
        success: function (response) {
          if (response == "post_deleted") {
            window.location.href = "../posts/";
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

  static setComment(commentid, status){
    $.ajax({
      method: "post",
      url: "../php/viewpost.php",
      data: {
        key: "set_comment",
        commentid: commentid,
        status: status,
      },
      dataType: "text",
      success: function (response) {
        if (response == "comment_updated") {
          ViewPost.getCommentsDetails(commentid);
          $("#comments-tbody").html('');
          ViewPost.getPostComments(0, 10);
          alert('Comment Updated.');
        } else {
          alert("Error while setting comment");
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

  static getCommentsDetails(commentid){
$.ajax({
  method: "post",
  url: "../php/viewpost.php",
  data: {
    key: "get_comment_details",
    commentid: commentid,
  },
  dataType: "text",
  success: function (response) {
    if (Utils.isJSON(response)) {
      let data = JSON.parse(response);
      $("#comment-settings-modal").html(data.commentdetails);
    } else {
      alert("Error while getting comment details");
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
}

window.addEventListener("DOMContentLoaded", () => {
  ViewPost.getPostDetails();
  ViewPost.getPostComments(0, 10);
  $("#delete-post-button").click((e)=>{
      ViewPost.deletePost(e.target.parentElement.dataset.pid);
      
  });
  $("#comments-tbody").click((e)=>{

    if(e.target.parentElement.classList.contains('delete-comment-button')){
    let commentid = e.target.parentElement.dataset.commentid;
    if(confirm("Do you really want to delete this comment. This process cannot be undone")){
      $.ajax({
        method: "post",
        url: "../php/viewpost.php",
        data: {
          key: "delete_comment",
          commentid: commentid,
        },
        dataType: "text",
        success: function (response) {
          if (response == "comment_deleted") {
            $("#comments-tbody").html('');
            ViewPost.getPostComments(0, 10);
            alert("Comment deleted successfully");
          } else {
            alert("Error while deleting comment");
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
    }else if(e.target.parentElement.classList.contains('set-comment')){
      let commentid = e.target.parentElement.dataset.commentid;
        ViewPost.getCommentsDetails(commentid);
      
      }
  })
  });
    

