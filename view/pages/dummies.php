<?php
    if ($_GET["error"] == 1) {
        print_r("<script>toastr.error('No ha seleccionado ninguna opción')</script>");
    }
?>
<button id="all" data-tr="Todos" onclick="return select_all()"></button>
<form method="post" id="">
<button onclick="return back_dummies()"><i class="fas fa-share-square fa-3x"></i></button>
<p data-tr="Seleccione que marcas quiere para cargar dummies"></p>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/alfa_romeo_logo.jpg"/></br>
        <input type="checkbox" id="check" name="Alfa_Romeo"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/BMW-Logo.jpg"/></br>
        <input type="checkbox" id="check" name="BMW"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/ford_logo.jpg"/></br>
        <input type="checkbox" id="check" name="Ford"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/hyundai.jpg"/></br>
        <input type="checkbox" id="check" name="Hyundai"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/logo-seat-historia.jpg"/></br>
        <input type="checkbox" id="check" name="SEAT"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/Mercedes_Benz_Logo.jpg"/></br>
        <input type="checkbox" id="check" name="Mercedes"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/opel_logo.jpg"/></br>
        <input type="checkbox" id="check" name="Opel"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/Peugeot.jpg"/></br>
        <input type="checkbox" id="check" name="Peugeot"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/ferrari.jpg"/></br>
        <input type="checkbox" id="check" name="Ferrari"/>
    </div>
    <div id="select_dummie">
        <img id='logo_home' src="view/img/cars_logo/citroen.png"/></br>
        <input type="checkbox" id="check" name="Citroen"/>
    </div>
</br>    
</form>