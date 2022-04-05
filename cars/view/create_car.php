
<form id="create" method="post">
    <p data-tr="¿Tipo de vehículo?">¿Tipo de vehículo?</p>
    <select id="brand"  name="brand" onclick="return change_car()">
            <?php
                $car = new Cars();
                $ocurrs = $car->select_brand();
                foreach ($ocurrs as $row) {
                    echo "<option value=".$row['id'].">".$row['brand']."</option>";
                }
            ?>
    </select>
    <?php
    ?>
    <select id="model" name="model">
       
    </select>
    </br>
    <p data-tr="Matrícula/Número de bastidor" >Matrícula/Número de bastidor</p>
    <input type="text" name="car_plate" id="car_plate"></input>
    <input type="text" name="frame_number" id="frame_number"></input></br>
    <p data-tr="CV/Km/Precio">CV/Km/Precio</p>
    <input type="range" name="CV" min="60" max="300" value="60" id="CV" onchange="return change_CV()"></input>
    <input type="text" id="put_CV" name="CV" value="60" readonly/>
    <input type="range" name="kilometres" min="0" max="300000" value="0" id="kilometres" onchange="return change_km()"></input>
    <input type="text" id="put_kilometres" name="kilometres" value="0" readonly/>
    <input type="range"  name="price" id="price" min="300" max="10000" value="300" onchange="return change_price()"></input>
    <input type="text" id="put_price" name="price" value="0" readonly/></br>
    <p data-tr="Fecha" >Fecha</p>
    <input type="text" id="fecha" name="fecha"/></br>
    <p data-tr="Color" >Color</p>
    <input type="color" id="color" onchange="return change_color()"/>
    <input type="text" id="put_color" name="color" value="#000000" readonly/></br>
    <p data-tr="Categoria" >Categoria</p>
    <select id="category" name="categorie">
        <option value="0">KM 0</option>
        <option value="1" selected>Nuevo</option>
    </select>
    <p data-tr="Descripción" >Descripción</p>
    <textarea placeholder="Description..." name="description" id="description" cols="65" rows="5"></textarea></br>
    
    <div id="buttons">
        <button onclick="return back_create()" ><i class="fas fa-arrow-alt-circle-left fa-3x"></i></button>
        <button name="Submit" id="button_submit" onclick="return validate_car()"><i class="fas fa-upload fa-3x"></i></button>
    </div>
    <!-- <i class='fas fa-plus-circle'></i> -->
</form>