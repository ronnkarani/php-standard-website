class EditPost {
  static getPostDetails() {
    $.ajax({
      url: "../php/edit-post.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_post_details",
      },
      success: function (response) {
        if (Utils.isJSON(response)) {
          let data = JSON.parse(response);
          title.setData(data.title);
          $("#keywords").val(data.keywords);
          detailsTitle.setData(data.titledetails);
          $("#current-main-image").html(data.mainimage);
          $("#current-more-images").html(data.moreimages);
          detailsDescription.setData(data.descriptiondetails);
          $("#current-quotes").html(data.quotes);
          
          $("#quotes-cont").html(data.existingquotes);
          detailsMoreDescription.setData(data.moredescription);
          
          $("#status-" + data.status).attr("checked", "checked");
          $("#categories-cont").html(data.categories);
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

  static checkPostInputs() {
    if (
      title.getData().trim().length < 10 ||
      title.getData().trim().length > 200
    ) {
      $(".edit-post-error").text(
        "Title should be atleast 10 characters and max of 200 characters"
      );
      $(".edit-post-error").show();
      return false;
    }

    if (detailsTitle.getData().trim().length < 20) {
      $(".edit-post-error").text("Details title too short");
      $(".edit-post-error").show();
      return false;
    }

    if ($("#category").val() == null && $("#new-category").val().trim() == "") {
      $(".edit-post-error").text("Select or edit new category");
      $(".edit-post-error").show();
      return false;
    }

    $(".edit-post-error").hide();

    return true;
  }

  static updatePost() {
    $("#edit-post-form").submit((e) => {
      e.preventDefault(e);

      if (EditPost.checkPostInputs()) {
        let form_data = new FormData($("#edit-post-form")[0]);
        form_data.append("key", "update_post");
        form_data.append("keywords", $("#keywords").val());
        form_data.append("title", title.getData());
        form_data.append("detailsTitle", detailsTitle.getData());
        form_data.append("detailsDescription", detailsDescription.getData());
        form_data.append(
          "detailsMoreDescription",
          detailsMoreDescription.getData()
        );
        form_data.append("newQuote", newQuote.getData());

        $.ajax({
          url: "../php/edit-post.php",
          method: "POST",
          dataType: "text",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: () => {
              $(".edit-post-error").html(
                "<p class='text-primary'>Updating post...</p>"
              );
              $(".edit-post-error").show();
          },
          success: function (response) {
            if (Utils.isJSON(response)) {
              let data = JSON.parse(response);
              $(".edit-post-error").html(
                "<p class='text-success'>Post updated successfully</p>"
              );
              $(".edit-post-error").show();
              $(".success-modal-text").text("Post updated successfully");
              $("#successModal").modal("show");
              window.location.href = data.url;
            console.log(response);
            
            } else {
              console.log(response);
              $(".edit-post-error").text("Error while updating post");
              $(".edit-post-error").show();
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

  
}

window.addEventListener("DOMContentLoaded", () => {
  EditPost.getPostDetails();
  EditPost.updatePost();
});
