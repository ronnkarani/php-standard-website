class Products {
  static getProducts(start, limit) {
    if(start <= 1){
      $("#products-tbody").empty();
    }
    $.ajax({
      url: "../php/products.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_products",
        start: start,
        limit: limit,
      },
      success: function (response) {
        if (response != "no_more") {
          $("#products-tbody").append(response);
          start += limit;
          Products.getProducts(start, limit);
        } else {
          $("#products-table").DataTable();
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

  static addProduct() {
    
    $("#add-product-form").submit(function (e) {
      e.preventDefault();

      let form_data = new FormData($("#add-product-form")[0]);
      form_data.append("key", "add_product");
      form_data.append("description", addDescription.getData());

      $.ajax({
        url: "../php/products.php",
        method: "POST",
        dataType: "text",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          if (response == "product_added") {
            $(".success-modal-text").text("Product added successfully");
            $("#addModal").modal("hide");
            $(".add-product-error").hide();
            $("#add-product-form").trigger("reset");
    addDescription.setData("<p></p>");

            $("#successModal").modal("show");
            $("#products-tbody").html("<div></div>");
            
            Products.getProducts(0, 10);
          } else if (response == "name_exist") {
            $(".add-product-error").text("Product Name exist.");
            $(".add-product-error").css("display", "block");
          } else if (response == "failed") {
            $(".add-product-error").text("Error while adding product");
            $(".add-product-error").css("display", "block");
          } else {
            console.log(response);
            
            $(".add-product-error").text("Unknown Error.");
            $(".add-product-error").css("display", "block");
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

  static editProduct(productid) {
    
    Products.getDetails(productid);
    $(".edit-product-error").hide();

    $("#edit-product-form").submit(function (e) {
      e.preventDefault();

      let form_data = new FormData($("#edit-product-form")[0]);
      form_data.append("key", "edit_product");
      form_data.append("description", editDescription.getData());
      form_data.append("productid", productid);

      $.ajax({
        url: "../php/products.php",
        method: "POST",
        dataType: "text",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          if (response === "product_updated") {
            $(".success-modal-text").text("Product updated successfully");
            $("#editModal").modal("hide");
            $("#successModal").modal("show");
            $("#products-tbody").html("<div></div>");
            editDescription.setData("<p></p>");
            $("#edit-product-form").trigger("reset");
            Products.getProducts(0, 10);
          } else if (response === "name_exist") {
            $(".edit-product-error").text("Product Name exist.");
            $(".edit-product-error").show();
          } else if (response === "failed") {
            $(".edit-product-error").text("Error while updating product");
            $(".edit-product-error").show();
          } else {
            console.log(response);
            
            $(".edit-product-error").text("Unknown Error.");
            $(".edit-product-error").css("display", "block");
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

  static getDetails(productid) {
    $.ajax({
      type: "post",
      url: "../php/products.php",
      data: {
        key: "get_product_details",
        productid: productid,
      },
      dataType: "text",
      success: function (response) {
        if (Utils.isJSON(response)) {
          let details = JSON.parse(response);
          $("#edit-product-name").val(details.name);
          editDescription.setData(details.description);
          $("#current-product-image").attr("src", "../../img/products/" + details.image);
          $("#edit-" + details.status).attr("checked", "checked");
        } else if (response == "not_found") {
          $("#addModal").modal("hide");
          alert(
            "No such product. It might have been deleted or something. Try refreshing the page."
          );
        } else {
          $("#addModal").modal("hide");
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

  static deleteProduct(productid) {
    $("#delete-pruduct-form").submit(function (e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "../php/products.php",
        data: {
          key: "delete_product",
          productid: productid,
        },
        dataType: "text",
        success: (response) => {
          $("#deleteModal").modal("hide");
          if (response == "product_deleted") {
            $(".success-modal-text").text("Product deleted successfully.");
            $("#successModal").modal("show");
            $("#row-" + productid).remove();
          } else if (response == "failed") {
            alert("Failed to delete product");
          } else {
            //   alert("Error while deleting product");
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
  Products.getProducts(0, 10);
  Products.addProduct();
  Products.deleteProduct();
});