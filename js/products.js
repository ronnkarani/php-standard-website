class Products {
  static getProducts() {
    $.ajax({
      method: "post",
      url: "./php/products.php",
      data: {
        key: "get_products",
      },
      dataType: "text",
      success: function (response) {
          console.log(response);
          
        if (Utils.isJSON(response)) {
          let data = JSON.parse(response);
          $("#products-container").html(data.products);
          
        //   set background
        $(".set-bg").each(function () {
          var bg = $(this).data("setbg");
          $(this).css("background-image", "url(" + bg + ")");
        });

    //Products slider
    $(".ts-slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        dotsEach: 2,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            320: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            }
        }
    });
        } else if (response == "no_products") {
          $("#products-container").html(
            "<h2 class='text-white mb-2'>No products for now :(</h2>"
          );
        } else {
          console.log(response);
          alert("Error while fetching products.");
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
  Products.getProducts();
});
