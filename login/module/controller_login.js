
function panel_user() {
  $(document).on('click','#logger',function () {

    $('div#panel_register').attr('hidden',false);
    $('div.layer_user').attr('hidden',false);

  });
  $(document).on('click','#logger_out',function () {
    localStorage.removeItem('token');
    ajaxPromise('login/controller/controller_login.php?option=logout', 
    'POST', 'TEXT')
    .then(function(data) {
      if (data == "Out") {
        toastr.info("User just finished session,wait a few seconds..");
        setTimeout(window.location.reload(),5000);
      }
  
    }).catch(function() {
      window.location.href = "index.php?exceptions=controller&option=503";
  
    });
  });

  $(document).on('click','#user_login_close',function () {

    $('div#panel_register').attr('hidden',true);
    $('div.layer_user').attr('hidden',true);

  });

}
function validator_log(check) {
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

  return boolean;
}
function give_data_login() {

  $(document).on('click','#login_button',function () {
  
    var check = $('form#login').serializeArray();
    for ( i in check) {
      if (check[i].value == "") {
        $('input#'+check[i].name).css('background-color','black');
        
      } else {
        $('input#'+check[i].name).css('background-color','#363636');
      }
  }
    var data = $('form#login').serialize();

    $.when(validator_log(check))
    .then(element => {
      if (element == false) {
        console.log("Error");
      } else {
        ajaxPromise('login/controller/controller_login.php?option=login', 
        'POST', 'JSON',data)
        .then(function(data) {
          if (data == 0) {
            toastr.error("Username doesn't exist");
          } else if ( data == 1) {
            toastr.error("Password isn't correct");
          } else {
            localStorage.setItem('token',JSON.stringify(data));
          toastr.info("User has logged");
          setTimeout(window.location.reload(),5000);
          }
         console.log(data);
        }).catch(function() {
          window.location.href = "index.php?exceptions=controller&option=503";
      
        });
      }
    });
  });
}
$(document).ready(function () {
   panel_user();
   give_data_login();
});