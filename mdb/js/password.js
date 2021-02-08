function sendMail(){

    $.ajax({
      url: "../php/password.php",
      dataType: "text",
      method: "POST",
      data: {
        email: $("#email").val(),
        key: "recover_password",
      },
      beforeSend: () => {
        $(".password-error").html(
          '<p class="text-primary">Sending email...</p>'
        );
      },
      success: (response) => {
        if (response == "sent") {
          $(".password-error").html(
            '<p class="text-success">We have sent you instructions to recover your password to your email.</p>'
          );
        } else if (response == "failed") {
          $(".password-error").html(
            '<p class="text-danger">Failed to send email</p>'
          );
        } else if (response == "not_found") {
          $(".password-error").html(
            '<p class="text-danger">Email not registered</p>'
          );
        } else {
          $(".password-error").html(
            '<p class="text-danger">Failed to send email</p>'
          );
          console.log(response);
        }
      },
      error: (XMLHttpRequest, textStatus, errorThrown) => {
        console.log(textStatus);

        if (XMLHttpRequest.readyState == 4) {
          // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
          $(".password-error").html(
            '<p class="text-danger">'+XMLHttpRequest.statusText+'</p>'
          );
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

$("#password-form").submit((e) => {
  e.preventDefault();
  sendMail();
});
