function protectuser() {
    var token = JSON.parse(localStorage.getItem('token'));
    if (token) {
      var data = {"token":token};
      ajaxPromise('login/controller/controller_login.php?option=controluser', 
      'POST', 'TEXT',data)
      .then(function(awnser) {
          if(awnser=="error"){
              setTimeout(console.log("Usuario no reconocido"),1000);
            
            }else if (awnser=="need_log"){
              setTimeout(console.log("Usuario correcto"),1000);
            }
      }).catch(function() {
        window.location.href = "index.php?exceptions=controller&option=503";
      });
    }
}
function check_user() {
    setInterval(function() {
      ajaxPromise('login/controller/controller_login.php?option=activity', 
      'POST', 'TEXT')
      .then(function(awnser) {
        console.log(awnser);
        if(awnser=="inactivo"){
                toastr.info("Se ha cerrado la cuenta por inactividad");
                $('span#logger_out').trigger('click');
            }
        }).catch(function() {
          window.location.href = "index.php?exceptions=controller&option=503";
        });
    },120000);
  }
  function refresh_session_php() {
    var token = JSON.parse(localStorage.getItem('token'));
    if (token) {
      var data = {"token":token};
      setInterval(function(){
        ajaxPromise('login/controller/controller_login.php?option=refresh_cookie', 
        'POST', 'TEXT',data)
        .then(function(awnser) {
          console.log(awnser);
          }).catch(function() {
            window.location.href = "index.php?exceptions=controller&option=503";
          });
      },120000)
    }
  }
  function refresh_session_token() {
    var token = JSON.parse(localStorage.getItem('token'));
    if (token) {
    var data = {"token":token};
    setInterval(function(){
      ajaxPromise('login/controller/controller_login.php?option=refresh_token', 
      'POST', 'TEXT',data)
      .then(function(token) {
        if (token == 'logout') {
          toastr.info("Se ha cerrado la cuenta por datos corrputos");
          $('span#logger_out').trigger('click');
        } else {
          localStorage.setItem('token',JSON.stringify(token));        
        }
        }).catch(function() {
          window.location.href = "index.php?exceptions=controller&option=503";
        });
    },120000)
    }
  }
  $(document).ready(function(){
    protectuser();
    check_user();
    refresh_session_php();
    refresh_session_token();
});