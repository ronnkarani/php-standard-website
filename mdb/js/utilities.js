class Utils {
  // validURL returns true if the passed url parameter is valid
  static validURL(myURL) {
    var pattern = new RegExp(
      "^(https?:\\/\\/)?" + // protocol
      "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|" + // domain name
      "((\\d{1,3}\\.){3}\\d{1,3}))" + // ip (v4) address
      "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + //port
      "(\\?[;&amp;a-z\\d%_.~+=-]*)?" + // query string
        "(\\#[-a-z\\d_]*)?$",
      "i"
    );
    return pattern.test(myURL);
  }

  static checkEmpty(caller) {
    if (caller.value.trim() == "") {
      caller.style = "border:1px solid red";
      return true;
    } else {
      caller.style = "border:none";
      return false;
    }
  }

  static jqCheckEmpty(caller) {
      
    if (caller.val().trim() == "") {
      caller.css( "border", "1px solid red");
      return true;
    } else {
      caller.css("border", "none");
      return false;
    }
  }

  static validateEmail(email) {
    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  static validatePassword(errors, password, confirmPassword) {
    if (password.length >= 8) {
      errors.style.display = "none";
      let upperCases = 0;
      let numbers = 0;
      for (let i = 0; i < password.length; i++) {
        if (password.charAt(i).toUpperCase() === password.charAt(i)) {
          upperCases += 1;
        }
        if (typeof (password.charAt(i) == "number")) {
          numbers += 1;
        }
      }
      if (upperCases >= 1 && numbers >= 1) {
        errors.style.display = "none";
        if (password == confirmPassword) {
          errors.style.display = "none";
          return true;
        } else {
          errors.innerHTML = "passwords does not match";
          errors.style.display = "block";
          return false;
        }
      } else {
        errors.innerHTML =
          "Password should have atleast 1 number and 1 capital letter";
        errors.style.display = "block";
        return false;
      }
    } else {
      errors.innerHTML = "Password too short";
      errors.style.display = "block";
      return false;
    }
  }

  static isJSON(str){
    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }
    return true;
  }
}