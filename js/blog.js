class Blog{
    static getPosts(category){
        $.ajax({
          method: "post",
          url: "../php/blog.php",
          data: {
            key: "get_posts",
            category: category,
          },
          dataType: "text",
          success: function (response) {
              if(Utils.isJSON(response)){
                  let data = JSON.parse(response);
                  $("#posts-container").html(data.posts);
              }else if(response == 'no_posts'){
                  $("#posts-container").html("<h2 class='text-white mb-2'>No posts have been published for now :(</h2>");
              }
              else{
                  console.log(response);
                  alert("Error while fetching posts.");
                  
              }
              
          },
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            console.log(textStatus);

            if (XMLHttpRequest.readyState == 4) {
              // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
              console.log(XMLHttpRequest.status);
              console.log(XMLHttpRequest.statusText);
              
            } else if (XMLHttpRequest.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
              alert("Network Error!");
            } else {
              // something weird is happening
            }
          },
        });
    }

    static getCategories(){
      $.ajax({
        method: "post",
        url: "../php/blog.php",
        data: {
          key: "get_categories",
        },
        dataType: "text",
        success: function (response) {
          if (Utils.isJSON(response)) {
            let data = JSON.parse(response);
            $("#categories-list").html(data.categories);
            document.querySelector('meta[name="description"]').setAttribute("content", data.metaDescription);
            document.querySelector('meta[name="keywords"]').setAttribute("content", data.metaDescription);
          } else if (response == "no_posts") {
            $("#categories-list").html(
              "<h2 class='text-white mb-2'>No posts have been published for now :(</h2>"
            );
          } else {
            console.log(response);
            alert("Error while fetching posts.");
          }
        },
        error: (XMLHttpRequest, textStatus, errorThrown) => {
          console.log(textStatus);

          if (XMLHttpRequest.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.statusText);
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
  Blog.getPosts('');
  Blog.getCategories();

});