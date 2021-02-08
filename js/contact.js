window.addEventListener("DOMContentLoaded", () => {
  $("#contact-form").submit(function (e) {
    e.preventDefault();
    let form_data = new FormData($("#contact-form")[0]);
    $.ajax({
      url: "../php/contact.php",
      method: "post",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: () => {
            $(".contact-result").html('<span class="text-primary">Sending message...</p>');
      },
      success: function (response) {
        if (response == "message_sent") {
          $(".contact-result").html(
            '<span class="text-success">Message sent.</p>'
          );
          $(".contact-form").trigger("reset");
        } else {
          $(".contact-result").html('<span class="text-danger">Error! Message not sent.</p>');
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
});