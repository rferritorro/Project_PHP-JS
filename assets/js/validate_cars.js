function validate_car() {
    var check=true;
    if (document.getElementById('car_plate').value.length > 0) {
        var reg = /^[a-zA-z0-9]*$/;
        if (!reg.test(document.getElementById('car_plate').value)) {
            toastr.error("La matrícula es incorrecto");
            check=false;
            return check;
        }
    } else {
        toastr.error("La matrícula esta vacía");
        check=false;
        return check;
    }
    if (document.getElementById('frame_number').value.length > 0 ) {
        var reg = /^[a-zA-z0-9]*$/;
        if (!reg.test(document.getElementById('frame_number').value)) {
            toastr.error("El número de bastidor es incorrecto");
            check=false;
            return check;            
        }
    } else {
        toastr.error("El número de bastidor esta vacío");
        check=false;
        return check;
    }
    document.getElementById('create').submit();
    document.getElementById('create').action="index.php?module=controller&option=create";
}
function validate_car_update($id) {
    var check=true;
    if (document.getElementById('car_plate').value.length > 0) {
        var reg = /^[a-zA-z0-9]*$/;
        if (!reg.test(document.getElementById('car_plate').value)) {
            toastr.error("La matrícula es incorrecto");
            check=false;
            return check;
        }
    } else {
        toastr.error("La matrícula esta vacía");
        check=false;
        return check;
    }
    if (document.getElementById('frame_number').value.length > 0 ) {
        var reg = /^[a-zA-z0-9]*$/;
        if (!reg.test(document.getElementById('frame_number').value)) {
            toastr.error("El número de bastidor es incorrecto");
            check=false;
            return check;            
        }
    } else {
        toastr.error("El número de bastidor esta vacío");
        check=false;
        return check;
    }
    document.getElementById('create').submit();
    document.getElementById('create').action="index.php?module=controller&option=update&id="+id;
}

function delete_car(id) {
    document.getElementById('delete').submit();
    document.getElementById('delete').action="index.php?module=controller&option=delete&id="+id;
}
function back_delete() {
    document.getElementById('delete').submit();
    document.getElementById('delete').action="index.php?module=controller&option=delete&id=-1";
}
function back_create() {
    document.getElementById('create').submit();
    document.getElementById('create').action="index.php?module=controller&option=create&back=1";
}
function back_dummies() {
   document.getElementById('form_home').submit();
   document.getElementById('form_home').action="index.php?module=controller&option=dummies";

}
function showModal(carTitle) {
    $("#detailsCars").show();
    $("#section_read").dialog({
        title: carTitle,
        width : 850,
        height: 500,
        resizable: "false",
        modal: "true",
        hide: "fold",
        show: "fold",     
    });
}

function showDummies() {
    

    $("#dummies").dialog({
        title: "Select dummies which you want to charge",
        width : 850,
        height: 500,
        resizable: "false",
        modal: "true",
        hide: "fold",
        show: "fold",
        buttons: {
            Create: function () {
                $('button#button_click_dummies').click();
            }
        },
    });
}
function loadContentModal() {
    $('button.read_modal').on("click", function() {
        var carId = this.getAttribute('id');

        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'cars/controller/controller.php/index.php?module=controller&option=read_modal&id=' + carId,
            
        }).done(function(Car) {
            $('<div></div>').attr('id', 'detailsCars', 'type', 'hidden').appendTo('#section_read');
            $('<div></div>').attr('id', 'table_cars').appendTo('#detailsCars');
            $('#table_cars').empty();
            $('<form></form>').attr('id', 'body_read').appendTo('#table_cars');
            $('#body_read').html(function() {
                var content = "";
                for (row in Car) {
                    content += '<br><span>' + row + ': <span id =' + row + '>' + Car[row] + '</span></span>';
                }// end_for
                //////
                return content;
                });
                
                showModal(carTitle = Car.brand_car + " " + Car.model_car, Car.id);
                
        })
    });
}
function loadDummiesModal() {
    $('i#button_dummies').on("click",function() {
       $.ajax({
           type: 'POST',
           data: { 'type':2},
           dataType: 'json',
            url:'cars/functions/function_ajax.php',
       }).done(function(brand) {
        $('<div></div>').attr('id', 'select_car', 'type', 'hidden').appendTo('#dummies');
        $('<div></div>').attr('id', 'all_cars').appendTo('#select_car');
        $('#all_cars').empty();
        $('<form></form>').attr('id', 'form_home').attr('method','post').appendTo('#all_cars');
        $('#form_home').html(function() {
            var content = "";
            for (row in brand) {
                content += '<div id="option_select"><img style="width:150px;height:150px" src="'+brand[row][1]+'"></br><input id="check" name="'+brand[row][0]+'" style="width:20px" type="checkbox"></div>';
            }
            content +='</br><button id="button_click_dummies" hidden onclick="return back_dummies()" style="z-index:103;color:black;position:absolute;top:0%;left:0%"><i class="fas fa-plus-square fa-2x"></i></button>';
            return content;
            });
            showDummies();
       })
    });
}

$(document).ready(function() {
    loadContentModal();
    loadDummiesModal();
   
});



