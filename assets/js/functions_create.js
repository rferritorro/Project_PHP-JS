function change_color() {
    var color = document.getElementById("color").value;
    document.getElementById("put_color").value=color;
}
function change_CV() {
    var cv = document.getElementById("CV").value;
    document.getElementById("put_CV").value=cv;
}
function change_km() {
    var km = document.getElementById("kilometres").value;
    document.getElementById("put_kilometres").value=km;
}
function change_price() {
    var price = document.getElementById("price").value;
    document.getElementById("put_price").value=price;
}

function change_car() {

    var brand = document.getElementById("brand").value;
    
        $.ajax({
            type: 'POST',
            url: 'cars/functions/function_ajax.php',
            data: {'brand':brand},
            dataType: 'json',
            success: function(answer) {
                $("#model").empty();
                for (var x in answer) {
                    $("#model").append("<option value="+answer[x]+">"+answer[x]+"</option>");
                }
            }
        })
    
}

function change_car_update(prueba) {
    console.log(prueba);
    var brand = document.getElementById("brand").value;
    
        $.ajax({
            type: 'POST',
            url: 'cars/functions/function_ajax.php',
            data: {'brand':brand,'type':0},
            dataType: 'json',
            success: function(answer) {
                $("#model").empty();
                for (var x in answer) {
                    $("#model").append("<option value="+answer[x]+">"+answer[x]+"</option>");
                }
            }
        })
    
}
function select_all() {
    
    Array.from($('input#check')).forEach(element => {
         element.checked =true;
 })
 }
 function close_error() {
     $("#error_marc").css({'display':'none'})
 }
 function charge_logs() {
    $.ajax({
        type: 'POST',
        url: 'cars/functions/function_ajax.php',
        data: {'type':'1'},
        dataType: 'json',
        success: function(answer) {
            $("#error_marc").css({'display':'block'});
            for (var x in answer) {
                $("#tabla_dinamica").append("<tr><td>"+answer[x][0]+"</td><td>"+answer[x][1]+"</td></tr>");
            }
        }
    })         
}
