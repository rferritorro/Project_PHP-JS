
  function validator_re(check) {
    var boolean = true;
    if (check[0].value) {
      var regex = /^[A-Za-z][A-Za-z0-9_]{2,20}$/;
      var result = new RegExp(regex);
      var result = regex.test(check[0].value);
  
      if (result == false ) {
        boolean = false;
        toastr.error("Username mustn't be contains less 20 caracters");
        return boolean;
      }
    } else {
        toastr.error("Username is required");
      boolean = false;
      return boolean;
    }
  
    if (check[1].value) {
  
      var regex = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
      var result = new RegExp(regex);
      var result = regex.test(check[1].value);
  
      if (result == false ) {
        boolean = false;
        toastr.error("Passoword must be contains at least one lowercase, uppercase and one digit with limit between 8 and 16 caracters");
        return boolean;
      }
    } else {
        toastr.error("Password is required");
      boolean = false;
      return boolean;
    }

    if (check[2].value) {
        if (check[2].value != check[1].value) {
            boolean = false;
            toastr.error("Confirm password and password aren't the same");
            return boolean;
        }
    } else {
        toastr.error("Confirm password is required");
        boolean = false;
        return boolean;
    }
    if (check[3].value) {
  
        var regex = /^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+.)+[A-Z]{2,4}$/i;
        var result = new RegExp(regex);
        var result = regex.test(check[3].value);
    
        if (result == false ) {
          boolean = false;
          toastr.error("Email ins't correct");
          return boolean;
        }
      } else {
        toastr.error("Email is required");
        boolean = false;
        return boolean;
      }
  
  
    return boolean;
  }
  function give_data_register() {
  
    $(document).on('click','#register_button',function () {
        
      var check = $('form#register').serializeArray();
      for ( i in check) {
          if (check[i].value == "") {
            $('input#'+check[i].name).css('background-color','black');
            
          } else {
            $('input#'+check[i].name).css('background-color','#363636');
          }
      }
      var data = $('form#register').serialize();
  
      $.when(validator_re(check))
      .then(element => {
        if (element == false) {
          console.log("Error");
        } else {
          ajaxPromise('login/controller/controller_login.php?option=register', 
          'POST', 'JSON',data)
          .then(function(check_user) {
            if (check_user == false) {
              toastr.error("Username or Email has already been registred");
            } else {
              localStorage.setItem('token',JSON.stringify(check_user));
              window.location.reload();
            };
          }).catch(function() {
            window.location.href = "index.php?exceptions=controller&option=503";        
          });
        }
      });
    });
  }
  $(document).ready(function () {
    give_data_register();
  });