class UpdateProfile{
    getDetails(userid){
        $.ajax({
          url: "../php/user_profile.php",
          method: "POST",
          dataType: "text",
          data: {
            key: "get_details",
            userid: userid,
          },
          beforeSend: () => {
            
          },
          success: (response) => {
              let data = JSON.parse(response);
              $('#username').val( data.details.username);
              $("#firstname").val(data.details.firstname);
              $("#lastname").val(data.details.lastname);
              $("#website").val(data.details.website);
              $("#about").val(data.details.about);
              $("#mobile").val(data.details.mobile);
              $("#email").val(data.details.email);

              if(data.social != null){
                  $('#facebook').val(data.social.facebook);
                  $("#twitter").val(data.social.twitter);
                  $("#instagram").val(data.social.instagram);
                  $("#googleplus").val(data.social.googleplus);
                  $("#youtube").val(data.social.youtube);

              }

          },
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            if (XMLHttpRequest.readyState == 4) {
              // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            //   errors.innerHTML = "Error!";
            //   errors.style.display = "block";
            } else if (XMLHttpRequest.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
            //   errors.innerHTML = "Network Error!";
            //   errors.style.display = "block";
            alert("Network error!");
            } else {
              // something weird is happening
            //   errors.innerHTML = "Error!";
            //   errors.style.display = "block";
            alert("Unknown error");
            }
          },
        });
    }

    changePassword(userid){
        let oldPassword = document.getElementById("old-password");
        let newPassword = document.getElementById("new-password");
        let cnewPassword = document.getElementById("new-password-confirm");
        let passwordErrors = document.querySelector(".password-errors");
        oldPassword.value = "";
        newPassword.value = "";
        cnewPassword.value = "";
        $("#password-form").submit((e)=> { 
            e.preventDefault();
            
            if(!Utils.checkEmpty(oldPassword) && !Utils.checkEmpty(newPassword) && !Utils.checkEmpty(cnewPassword)){
                if(Utils.validatePassword(passwordErrors, newPassword.value.trim(),cnewPassword.value.trim())){
                    $.ajax({
                      url: "../php/user_profile.php",
                      method: "POST",
                      dataType: "text",
                      data: {
                        key: "change_password",
                        userid: userid,
                        oldPassword: oldPassword.value.trim(),
                        newPassword: newPassword.value.trim(),
                      },
                      beforeSend: () => {
                          passwordErrors.innerHTML = "<p class='text-success'>changing password</p>";
                          passwordErrors.style.display = "block";
                      },
                      success: (response) => {
                        if (response == "password_updated") {
                            passwordErrors.innerHTML =
                              "<p class='text-success'>Password updated</p>";
                              passwordErrors.style.display = "block";
                              oldPassword.value = '';
                              newPassword.value = '';
                              cnewPassword.value ='';
                        }else if (response == "wrong_password") {
                            passwordErrors.innerHTML = "Wrong old password!";
                            passwordErrors.style.display = "block";
                        } else if (response == "same") {
                            passwordErrors.innerHTML = "New password is equal to old password! Please enter new password";
                            passwordErrors.style.display = "block";
                        }
                        
                        else {
                            passwordErrors.innerHTML = "Unknown Error";
                            passwordErrors.style.display = "block";
                                console.log(response);
                              }
                      },
                      error: (XMLHttpRequest, textStatus, errorThrown) => {
                        if (XMLHttpRequest.readyState == 4) {
                          // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                          passwordErrors.innerHTML = "Error!";
                          passwordErrors.style.display = "block";
                        } else if (XMLHttpRequest.readyState == 0) {
                          // Network error (i.e. connection refused, access denied due to CORS, etc.)
                          passwordErrors.innerHTML = "Network Error!";
                          passwordErrors.style.display = "block";
                        } else {
                          // something weird is happening
                          passwordErrors.innerHTML = "Error!";
                          passwordErrors.style.display = "block";
                        }
                      },
                    });
                }
            }
        });
    }

    updateDetails(userid){
        $("#profile-details-form").submit(e=>{
            e.preventDefault();
            if(!Utils.jqCheckEmpty($("#username") )){
                if($("#username").val().trim().length >= 8 ){
                    $(".details-error").css("display","none");
                    $.ajax({
                      url: "../php/user_profile.php",
                      method: "POST",
                      dataType: "text",
                      data: {
                        key: "update_details",
                        userid: userid,
                        firstname: $("#firstname").val().trim(),
                        username: $("#username").val().trim(),
                        lastname: $("#lastname").val().trim(),
                        website: $("#website").val().trim(),
                        mobile: $("#mobile").val().trim(),
                        about: $("#about").val().trim(),
                      },
                      beforeSend: () => {
                        $(".details-error").html(
                          "<p class='text-success'>Updating profile</p>"
                        );
                        $(".details-error").css("display", "block");
                      },
                      success: (response) => {
                          if(response == 'details_updated'){
                              $(".details-error").html(
                                "<p class='text-success'>Profile updated</p>"
                              );
                              $(".details-error").css("display", "block");
                          } else if(response == 'username_exist'){
                              $(".details-error").text("Username exist!");
                              $(".details-error").css("display", "block");
                          }
                          else if(response == 'error'){

                              $(".details-error").text("Error while updating profile!");
                              $(".details-error").css("display", "block");
                          }
                          else{
                              $(".details-error").text(
                                "Error while updating profile!"
                              );
                              $(".details-error").css("display", "block");
                              console.log(response);
                              
                          }
                      },
                      error: (XMLHttpRequest, textStatus, errorThrown) => {
                        if (XMLHttpRequest.readyState == 4) {
                          // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                          console.log(XMLHttpRequest.statusText);
                          console.log(XMLHttpRequest.status);
                          
                          
                          $(".details-error").text("Error!");
                          $(".details-error").css("display", "block");
                        } else if (XMLHttpRequest.readyState == 0) {
                          // Network error (i.e. connection refused, access denied due to CORS, etc.)
                          $(".details-error").text("Network Error");
                          $(".details-error").css("display", "block");
                        } else {
                          // something weird is happening
                          $(".details-error").text("Error");
                          $(".details-error").css("display", "block");
                        }
                      },
                    });
                }
                else{
                    $(".details-error").text("username too short");
                    $(".details-error").css("display","block");
                }
            }
        });;
    }

    updateSocial(userid){
        $("#social-links-form").submit(e=>{
            e.preventDefault();
            $(".social-error").css("display", "none");
            $.ajax({
              url: "../php/user_profile.php",
              method: "POST",
              dataType: "text",
              data: {
                key: "update_social",
                userid: userid,
                facebook: $("#facebook").val().trim(),
                twitter: $("#twitter").val().trim(),
                youtube: $("#youtube").val().trim(),
                instagram: $("#instagram").val().trim(),
                googleplus: $("#googleplus").val().trim(),
              },
              beforeSend: () => {
                $(".social-error").html(
                  "<p class='text-success'>Updating social links</p>"
                );
                $(".social-error").css("display", "block");
              },
              success: (response) => {
                if (response == "social_updated") {
                  $(".social-error").html(
                    "<p class='text-success'>Social links updated</p>"
                  );
                  $(".social-error").css("display", "block");
                } else if (response == "error") {
                  $(".social-error").text("Error while updating social links!");
                  $(".social-error").css("display", "block");
                } else {
                  $(".social-error").text("Error while updating social links!");
                  $(".social-error").css("display", "block");
                  console.log(response);
                }
              },
              error: (XMLHttpRequest, textStatus, errorThrown) => {
                if (XMLHttpRequest.readyState == 4) {
                  // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                  $(".social-error").text("Error!");
                  $(".social-error").css("display", "block");
                } else if (XMLHttpRequest.readyState == 0) {
                  // Network error (i.e. connection refused, access denied due to CORS, etc.)
                  $(".social-error").text("Network Error");
                  $(".social-error").css("display", "block");
                } else {
                  // something weird is happening
                  $(".social-error").text("Error");
                  $(".social-error").css("display", "block");
                }
              },
            });
        });
    }

    updateProfilePicture(userid){
        $("#profile-picture-form").submit((e) => {
          e.preventDefault();
          let form_data = new FormData($("#profile-picture-form")[0]);
          form_data.append("userid", userid);
          $.ajax({
            url: "../php/user_profile.php",
            method: "POST",
            dataType: "text",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: () => {
              $(".picture-error").html(
                '<p class="text-primary">Uploading image</p>'
              );
                $(".picture-error").css("display", "block");
            },
            success: (response) => {
                if(response == "error"){
                  $(".picture-error").text("Error while uploading profile picture");
                  $(".picture-error").css("display", "block");
                }else{
                  location.reload();
                  
                }
                
            },
            error: (XMLHttpRequest, textStatus, errorThrown) => {
              console.log(XMLHttpRequest);
              
              if (XMLHttpRequest.readyState == 4) {
                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                console.log(XMLHttpRequest.statusText);
                
                $(".picture-error").text("Error!");
                $(".picture-error").css("display", "block");
              } else if (XMLHttpRequest.readyState == 0) {
                // Network error (i.e. connection refused, access denied due to CORS, etc.)
                $(".picture-error").text("Network Error");
                $(".picture-error").css("display", "block");
              } else {
                // something weird is happening
                $(".picture-error").text("Error");
                $(".picture-error").css("display", "block");
              }
            },
          });
        });
    }

    removeProfilePic(userid){
      $("#remove-profile-pic").submit((e)=>{
        e.preventDefault();
        $.ajax({
          url: "../php/user_profile.php",
          method: "POST",
          dataType: "text",
          data: {
            key: "remove_profile",
            userid: userid,
            
          },
          beforeSend: () => {
            $(".remove-picture-error").html(
              '<p class="text-primary">Removing profile Picture</p>'
            );
            $(".remove-picture-error").css("display", "block");
          },
          success: (response) => {
            if (response == "no_profile") {
              $(".remove-picture-error").text(
                "You have no profile picture"
              );
              $(".remove-picture-error").css("display", "block");
            }
            else if (response == "failed_delete") {
                   $(".remove-picture-error").text(
                     "Failed to delete profile picture due to an error!"
                   );
                   $(".remove-picture-error").css("display", "block");
                 } else if (response == "removed") {
                          location.reload();
                        }else{
                          $(".remove-picture-error").text(
                            "Unknown error!"
                          );
                          $(".remove-picture-error").css("display", "block");
                        }
          },
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            if (XMLHttpRequest.readyState == 4) {
              // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)

              $(".remove-picture-error").text("Error!");
              $(".remove-picture-error").css("display", "block");
            } else if (XMLHttpRequest.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
              $(".remove-picture-error").text("Network Error");
              $(".remove-picture-error").css("display", "block");
            } else {
              // something weird is happening
              $(".remove-picture-error").text("Error");
              $(".remove-picture-error").css("display", "block");
            }
          },
        });
      });
    }

}

window.addEventListener("DOMContentLoaded", () => {
  const updateProfile = new UpdateProfile();
  let userid = $("#userid").val();
  updateProfile.getDetails(userid);
  updateProfile.changePassword(userid);
  updateProfile.updateDetails(userid);
  updateProfile.updateSocial(userid);
  updateProfile.updateProfilePicture(userid);
  updateProfile.removeProfilePic(userid);


  
});