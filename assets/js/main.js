function load_user(token) {
    ajaxPromise('login/controller/controller_login.php?option=data_user', 
    'POST', 'JSON',{'token': token})
    .then(function(info_user) {
        $('<div></div>').attr('id','panel_log').appendTo('div#space_logger');
        $('<img></img>').attr({'id':'img_perfil','src': info_user["avatar"]}).appendTo('div#panel_log');
        $('<h4></h4>').attr({'id':'username_perfil'}).html(info_user["username"]).appendTo('div#panel_log');
    }).catch(function() {
      window.location.href = "index.php?exceptions=controller&option=503";
    });
}
function load_menu() {
    var user = JSON.parse(localStorage.getItem('token'));
    if (user) {
        load_user(user);
        $('<span></span>').attr('id','logger_out').html("<i class='fas fa-lock-open'></i> Login Out").appendTo('div#space_logger');
    } else {
        $('<span></span>').attr('id','logger').html("<i class='fas fa-lock'></i> Login In").appendTo('div#space_logger');
    }

}
$(document).ready(function () {
    load_menu();
});