$(document).ready(()=>{
    $("#show-details").click(()=>{
        if($("#details").css("display") == "block"){

            $("#details").hide();
        }
        else{
            $("#details").show();
        }
        $("#comments").hide();
      $("#show-comments").removeClass("active");
      $("#show-details").addClass("active");

    })

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
})

class Post {
  static getCatsQuotes() {
    $.ajax({
      url: "../php/posts.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_cats_quotes",
      },
      success: function (response) {
        if(Utils.isJSON(response)){

          let data = JSON.parse(response);
          $('.categories-cont').html(data.categories);
          $(".quotes-cont").html(data.quotes);
        }else{
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

  static addPost(){
    $("#add-post-form").submit(e=>{
      e.preventDefault(e);
      
      if (Post.checkPostInputs()) {
        let form_data = new FormData($("#add-post-form")[0]);
        form_data.append("key", "add_post");
        form_data.append("title", title.getData());
        form_data.append("keywords", $("#keywords").val());
        form_data.append("detailsTitle", detailsTitle.getData());
        form_data.append("detailsDescription", detailsDescription.getData());
        form_data.append(
          "detailsMoreDescription",
          detailsMoreDescription.getData()
        );
        form_data.append("newQuote", newQuote.getData());
        
        $.ajax({
          url: "../php/posts.php",
          method: "POST",
          dataType: "text",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: () => {
            $(".edit-post-error").html(
              "<p class='text-primary'>Adding post...</p>"
            );
            $(".edit-post-error").show();
          },
          success: function (response) {
            if (Utils.isJSON(response)) {
              let data = JSON.parse(response);
              $(".add-post-error").html(
                "<p class='text-success'>Post added successfully</p>"
              );
              $(".add-post-error").show();
              $(".success-modal-text").text("Post added successfully");
              $("#successModal").modal("show");
              window.location.href = data.url;
            } else {
              console.log(response);
              $(".add-post-error").text("Error while adding post");
              $(".add-post-error").show();
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
    });

  }

  static checkPostInputs(){
    if(title.getData().trim().length <10 || title.getData().trim().length >200){
      $(".add-post-error").text("Title should be atleast 10 characters and max of 200 characters");
      $(".add-post-error").show();
      return false;
    }

    if (
      detailsTitle.getData().trim().length < 20 
    ) {
      $(".add-post-error").text(
        "Details title too short"
      );
      $(".add-post-error").show();
      return false;
    }

    if ($("#category").val() == null && $("#new-category").val().trim() == "") {
      $(".add-post-error").text("Select or add new category");
      $(".add-post-error").show();
      return false;
    }

    
    $(".add-post-error").hide();

    return true;
  }


}

window.addEventListener("DOMContentLoaded", () => {
  Post.getCatsQuotes();
  Post.addPost();
});

