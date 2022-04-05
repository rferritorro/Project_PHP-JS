
function charge_items_type() {
    ajaxPromise("search/controller/controller_search.php?option=type",'POST', 'JSON')
    .then(function(data) {
        for (row in data) {
            $('<option></option>').attr({'id':'id'+data[row].id,'class':'select_type_header','value':data[row].id}).html(data[row].nom).appendTo('#select_type_header');
        }    
    }
    ).catch(function() {
        window.location.href = "index.php?exceptions=controller&option=503";
    
    });
}
function charge_items_brand(data=undefined) {
    if (data) {
        $('<option></option>').attr({'id':'id','class':'select_brand_header','value':0}).html("--").appendTo('#select_brand_header');
        }
    ajaxPromise("search/controller/controller_search.php?option=brand",'POST', 'JSON',data)
    .then(function(data) {
        for (row in data) {
            $('<option></option>').attr({'id':'id','class':'select_brand_header','value':data[row].brand}).html(data[row].brand).appendTo('#select_brand_header');
        }   
    }
    ).catch(function() {
        window.location.href = "index.php?exceptions=controller&option=503";
        
    });
}

$(document).on("change","#select_type_header",function() {
    $('#select_brand_header').empty();
    $('#autocom').val('');
    var data = {value:this.value};
    charge_items_brand(data);
});
$(document).on("change","#select_brand_header",function() {
   
    $('#autocom').val('');
 
});
function increment_keyup_input() {
    $("#autocom").on("keyup", function () {
        var data_type = $('select#select_type_header').val();
        var data_brand = $('select#select_brand_header').val();
        var data_city = $('input#autocom').val();
        $('div#search_auto').css('display','block');
        var data;
        if (data_type == 0 && data_brand == 0) {
           data ={city:$('input#autocom').val()} ;
        } 
        else if (data_type && data_brand) {
            data = {type:data_type,brand:data_brand,city:data_city};
        } 
        else if ( data_type == 0 && data_brand) {

            data = {brand:data_brand,city:data_city};
        } 
        else {

            data = {type:data_type,city:data_city};
        }
      
        ajaxPromise("search/controller/controller_search.php?option=autocomplete",'POST', 'JSON',data)
        .then(function(data) {
            $('div#search_auto').empty();
            for (row in data) {
                $('<div></div>').appendTo('#search_auto').html(data[row].ciudad).attr({'class': 'searchElement', 'id': data[row].id,'data-id':data[row].ciudad});
            }
            $(document).on('click', '.searchElement', function() {
                $('#autocom').val(this.getAttribute('data-id'));
                $('#search_auto').fadeOut(1000);
            });
            $(document).on('click scroll', function(event) {
                if (event.target.id !== 'autocom') {
                    $('#search_auto').fadeOut(1000);
                    }
                })
        }).catch(function() {
            window.location.href = "index.php?exceptions=controller&option=503";
            
        });
    });
}    
function send_information() {
    $(document).on("click",".send_information_header",function() {
        var data_type = $('select#select_type_header').val();
        var data_brand = $('select#select_brand_header').val();
        var data_city = $('input#autocom').val();
        var filtro = {};
        //checkeo de que las partes del objeto se cumplen
        if (data_type != 0 ) {
            type = {tipo: data_type};
            filtro = Object.assign(filtro,type)
        }
        if (data_brand != 0 ) {
            brand = {marca: data_brand};
            filtro = Object.assign(filtro,brand)
        }
        if (data_city != '' ) {
            city = {ciudad: data_city};
            filtro = Object.assign(filtro,city)
        }
        localStorage.setItem('filtro_research',JSON.stringify(filtro));
        
        window.location.href= "index.php?module=shop&option=list";

    });
}
$(document).ready(function() {
    charge_items_type();
    charge_items_brand();
    increment_keyup_input();
    send_information();    
});