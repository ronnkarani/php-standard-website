class Dashboard{
    getDetails(){
        $.ajax({
            url: "./php/dashboard.php",
            method: "post",
            dataType: "text",
            data: {
                key: "get_details",                
            },
            success: function (response) {
              // console.log(response);
              
                let data = JSON.parse(response);
                $('.users-value').text(data.users);
                $(".posts-value").text(data.posts);
                $(".comments-value").text(data.comments);
                $(".products-value").text(data.products);
                $(".services-value").text(data.services);
                
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
    const dashboard = new Dashboard();
    dashboard.getDetails()
});