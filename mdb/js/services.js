class Services {
  static getServices(start, limit) {
    if (start <= 1) {
      $("#services-tbody").empty();
    }
    $.ajax({
      url: "../php/services.php",
      method: "post",
      dataType: "text",
      data: {
        key: "get_services",
        start: start,
        limit: limit,
      },
      success: function (response) {
        if (response != "no_more") {
          $("#services-tbody").append(response);
          start += limit;
          Services.getServices(start, limit);
        } else {
          $("#services-table").DataTable();
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

  static addService() {
    $("#add-service-form").submit(function (e) {
      e.preventDefault();

      let form_data = new FormData($("#add-service-form")[0]);
      form_data.append("key", "add_service");
      form_data.append("description", addDescription.getData());
console.log(form_data);

      $.ajax({
        url: "../php/services.php",
        method: "POST",
        dataType: "text",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          if (response == "service_added") {
            $(".success-modal-text").text("Service added successfully");
            $("#addModal").modal("hide");
            $(".add-service-error").hide();
            $("#add-service-form").trigger("reset");
            addDescription.setData("<p></p>");

            $("#successModal").modal("show");
            $("#services-tbody").html("<div></div>");

            Services.getServices(0, 10);
          } else if (response == "name_exist") {
            $(".add-service-error").text("Service name exist.");
            $(".add-service-error").css("display", "block");
          } else if (response == "failed") {
            $(".add-service-error").text("Error while adding service");
            $(".add-service-error").css("display", "block");
          } else {
            console.log(response);

            $(".add-service-error").text("Unknown Error.");
            $(".add-service-error").css("display", "block");
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

  static editService(serviceid) {
    Services.getDetails(serviceid);
    $(".edit-service-error").hide();

    $("#edit-service-form").submit(function (e) {
      e.preventDefault();

      let form_data = new FormData($("#edit-service-form")[0]);
      form_data.append("key", "edit_service");
      form_data.append("description", editDescription.getData());
      form_data.append("serviceid", serviceid);

      $.ajax({
        url: "../php/services.php",
        method: "POST",
        dataType: "text",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          if (response === "service_updated") {
            $(".success-modal-text").text("Service updated successfully.");
            $("#editModal").modal("hide");
            $("#successModal").modal("show");
            $("#services-tbody").html("<div></div>");
            editDescription.setData("<p></p>");
            $("#edit-service-form").trigger("reset");
            Services.getServices(0, 10);
          } else if (response === "name_exist") {
            $(".edit-service-error").text("Service Name exist.");
            $(".edit-service-error").show();
          } else if (response === "failed") {
            $(".edit-service-error").text("Error while updating service");
            $(".edit-service-error").show();
          } else {
            console.log(response);

            $(".edit-service-error").text("Unknown Error.");
            $(".edit-service-error").css("display", "block");
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

  static getDetails(serviceid) {
    $.ajax({
      type: "post",
      url: "../php/services.php",
      data: {
        key: "get_service_details",
        serviceid: serviceid,
      },
      dataType: "text",
      success: function (response) {
        if (Utils.isJSON(response)) {
          let details = JSON.parse(response);
          $("#edit-service-name").val(details.name);
          editDescription.setData(details.description);
          $("#current-service-image").attr(
            "src",
            "../../img/services/" + details.image
          );
          $("#edit-" + details.status).attr("checked", "checked");
        } else if (response == "not_found") {
          $("#addModal").modal("hide");
          alert(
            "No such service. It might have been deleted or something. Try refreshing the page."
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

  static deleteService(serviceid) {
    $("#delete-service-form").submit(function (e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "../php/services.php",
        data: {
          key: "delete_service",
          serviceid: serviceid,
        },
        dataType: "text",
        success: (response) => {
          $("#deleteModal").modal("hide");
          if (response == "service_deleted") {
            $(".success-modal-text").text("Service deleted successfully.");
            $("#successModal").modal("show");
            $("#row-" + serviceid).remove();
          } else if (response == "failed") {
            alert("Failed to delete service");
          } else {
            //   alert("Error while deleting service");
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
  Services.getServices(0, 10);
  Services.addService();
  Services.deleteService();
});