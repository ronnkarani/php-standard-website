const email = document.querySelector("#email");
const password = document.querySelector("#password");
const errors = document.querySelector(".form-error");

class Login {
  checkEmpty(caller) {
    if (caller.value.trim() == "") {
      caller.style = "border:1px solid red";
      return true;
    } else {
      caller.style = "border:none";
      return false;
    }
  }

  validateEmail(email) {
    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  submitForm() {
    if (!this.checkEmpty(email) && !this.checkEmpty(password)) {
      if (this.validateEmail(email.value.trim())) {
        errors.style.display = "none";
        $.ajax({
          url: "../php/sign_in_up.php",
          method: "POST",
          dataType: "text",
          data: {
            key: "signin",
            email: email.value.trim(),
            password: password.value.trim(),
          },
          beforeSend: () => {
            errors.innerHTML = '<p style="color:green">Signing in...</p>';
          },
          success: (data) => {
            if (data == "no_such_user") {
              errors.innerHTML = "wrong email or password";
              errors.style.display = "block";
            } else if (data == "signed_in") {
              window.location.href = "../../";
            } else if (data == "suspended") {
              errors.innerHTML =
                "Your account has been suspended! To activate your account, please <a href='../../contact/'>contact us</a> with a request to activate your account.";
              errors.style.display = "block";
            } else {
              errors.innerHTML = 'Error while trying to login';
              errors.style.display = "block";
              console.log(data);
            }
          },
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            if (XMLHttpRequest.readyState == 4) {
              // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
              errors.innerHTML = "Error!";
              errors.style.display = "block";

            } else if (XMLHttpRequest.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
              errors.innerHTML = "Network Error!";
              errors.style.display = "block";
            } else {
              // something weird is happening
              errors.innerHTML = "Error!";
              errors.style.display = "block";
            }
          },
        });
      } else {
        errors.innerHTML = "Invalid Email address";
        errors.style.display = "block";
      }
    }
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const login = new Login();
  $("#sign-in-form").submit((e) => {
    e.preventDefault();

    login.submitForm();
  });
});
