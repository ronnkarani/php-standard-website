class Users {
    static getUsers(start, limit){
        $.ajax({
          url: "../php/users.php",
          method: "post",
          dataType: "text",
          data: {
            key: "get_users",
            start: start,
            limit: limit,
          },
          success: function (response) {
              
            if (response != "no_more") {
              $("#users-tbody").append(response);
              start += limit;
              Users.getUsers(start, limit);
            } else {
              $("#users-table").DataTable();
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

    static addUser(){
        $("#add-user-form").submit(function (e) {
          e.preventDefault();
        
        let admin = $("#admin").prop("checked") == true ? 1 : 0;
        $.ajax({
          url: "../php/users.php",
          method: "post",
          dataType: "text",
          data: {
            key: "add_user",
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            email: $("#email").val(),
            username: $("#username").val(),
            admin: admin,
          },
          success: function (response) {
            if (response == "exist") {
              $(".add-user-error").text("Email or username exist");
              $(".add-user-error").css("display", "block");
            } else if (response == "user_added") {

                $(".success-modal-text").text("User added successfully");
              $("#addUserModal").modal('hide');
              $("#successModal").modal("show");
              $("#users-tbody").empty(); 
              $("#add-user-form").trigger("reset");
              Users.getUsers(0,10);
            } else {
              console.log(response);

              $(".add-user-error").text("Error while creating user");
              $(".add-user-error").css("display", "block");
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

    static deleteUser(userid){
      $("#delete-user-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          url: "../php/users.php",
          data: {
            key: "delete_user",
            userid: userid,
          },
          dataType: "text",
          success: (response) => {
            $("#deleteModal").modal("hide");
            if(response == 'user_deleted'){
              $(".success-modal-text").text('User deleted successfully.');
              $("#successModal").modal("show");
              $('#row-'+userid).remove();
            }else if(response == 'failed'){
              alert('Failed to delete user')
            }
            else if(response == 'on_session'){
              alert('Error! You cannot delete your own account!');
            }
            else{
              alert('Error while deleting user');
              console.log('response');
              
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

    static updateUser(userid){
      console.log(userid);

      document.getElementById("edit-user-form").reset();
      $.ajax({
          type: "post",
          url: "../php/users.php",
          data: {
            key: "get_user_details",
            userid: userid,
          },
          dataType: "text",
          success: (response) => {
              response = JSON.parse(response);
              $("#show-username").text(response.username);
              $("#show-email").text(response.email);
              $("#show-firstname").text(response.firstname);
              $("#show-lastname").text(response.lastname);
              $("#show-about").text(response.about);
              $("#show-website").text(response.website);
              $("#show-mobile").text(response.mobile);
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
      
      if (
        $("#roles-" + userid)
          .text()
          .toLowerCase()
          .indexOf('admin') > -1
      ) {
        $("#update-admin").attr("checked", "checked");
      }else{
        $("#update-admin").removeAttr("checked");

      }

      if (
        $("#status-" + userid)
          .text()
          .toLowerCase()
          .indexOf("active") > -1
      ) {
        $("#update-activate").attr("checked", "checked");
        $("#update-suspend").removeAttr("checked");
      }else{
        $("#update-suspend").attr("checked", "checked");
        $("#update-activate").removeAttr("checked");
      }
      
      $('#userid').val(userid);

      
    }

    static updateUserSubmit(){
      $("#edit-user-form").submit(function (e) {
        e.preventDefault();
        let userid = $("#userid").val();
        let admin = $("#update-admin").prop("checked") == true ? 1 : 0;
        let status = $('input[name="status"]:checked').val();

        $.ajax({
          type: "post",
          url: "../php/users.php",
          data: {
            key: "update_user",
            admin: admin,
            status: status,
            userid: userid,
          },
          dataType: "text",
          success: function (response) {
            $("#settingsModal").modal("hide");
            document.getElementById("edit-user-form").reset();
            if (response == "failed") {
              alert("Failed to update user");
              return;
            } else if (response == "on_session") {
                     alert("Error! You cannot edit your own account!");
                     return;
                   }else {
                     try {
                       $(".success-modal-text").text(
                         "User updated successfully."
                       );
                       $("#successModal").modal("show");
                       let roles = JSON.parse(response);
                       $("#roles-" + userid).text(roles);
                       $("#status-" + userid).text(status);
                       return;
                     } catch (error) {
                       
                       alert("Error while updating user");
                       console.log(response);
                       return;
                     }
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
  Users.getUsers(0,10);
  Users.addUser();
  Users.updateUserSubmit();
  $("#users-tbody").click(function (e) {
    e.preventDefault();
    if ($(e.target.parentElement).hasClass("settings")) {

      Users.updateUser(e.target.parentElement.dataset.userid);
    }
  });
  $("#settingsModal").on("hide.bs.modal", function () {
    console.log('hiding');
    
    document.getElementById("edit-user-form").reset();
  });
});
