class Services {
  static getServices() {
    $.ajax({
      method: "post",
      url: "../php/services.php",
      data: {
        key: "get_services",
      },
      dataType: "text",
      success: function (response) {
        // console.log(response);

        if (Utils.isJSON(response)) {
          let data = JSON.parse(response);
          $("#services-container").html(data.services);
        } else if (response == "no_services") {
          $("#services-container").html(
            "<h2 class='text-white mb-2'>No services for now :(</h2>"
          );
        } else {
          console.log(response);
          alert("Error while fetching service.");
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
  Services.getServices();
});
