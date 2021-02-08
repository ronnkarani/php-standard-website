class BlogDetails {
  static getPostDetails() {
    $.ajax({
      url: "../php/blog-details.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_post_details",
      },
      success: function (response) {
        if (Utils.isJSON(response)) {
          let data = JSON.parse(response);
          $("#blog-hero-section").html(data.blogherosection);
          $("#details-title").html(data.titledetails);
          $("#blog-more-images").html(data.moreimages);
          $("#details-description").html(data.detailsdescription);
          $("#blog-quotes").html(data.quotes);
          $("#more-description").html(data.moredescription);
          $("#blog-author").html(data.author);

          //set meta tags and title
          document.querySelector('meta[name="description"]').setAttribute("content", data.titledetails.replace(/<p>|<\/p>/g, ''));
          document.querySelector('meta[name="keywords"]').setAttribute("content", data.keywords.replace(/<p>|<\/p>/g, ''));
          let documentTitle = data.documentTitle;
          documentTitle = data.documentTitle.replace(/<(.*?)>/g, '');
          document.title = documentTitle;


        //   set background image
        $(".set-bg").each(function () {
          var bg = $(this).data("setbg");
          $(this).css("background-image", "url(" + bg + ")");
        });
          
        } else if (response == "not_exist") {
          window.location.href = "../blog/";
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
          window.location.href = "../blog/";
        } else {
          // something weird is happening
        }
      },
    });
  }

  static leaveComment(){
      $('#comment-form').submit(function (e) { 
          e.preventDefault();
          let form_data = new FormData($("#comment-form")[0]);
          form_data.append('key', 'leave_comment');
          $.ajax({
            url: "../php/blog-details.php",
            method: "post",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
              if (response == "comment_posted") {
                $("#comment-result").html(
                  '<span class="text-success">Comment posted</p>'
                );
                BlogDetails.fetchComments();
                $("#comment-form").trigger('reset');
              } else {
                $("#comment-result").html(
                  '<span class="text-danger">Error!</p>'
                );
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
  static fetchComments(){
      $.ajax({
        url: "../php/blog-details.php",
        method: "post",
        dataType: "text",
        data: {
          key: "fetch_comments",
        },
        success: function (response) {
            if(Utils.isJSON(response)){
                let data = JSON.parse(response);
                $("#comments-cont").html(data.comments);
            }else{
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
  BlogDetails.getPostDetails();
  BlogDetails.leaveComment();
  BlogDetails.fetchComments();
});
