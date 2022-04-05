<form method="post" id="create">
<p data-tr="¿Tipo de vehículo?"></p>
    <select id="brand" name="brand" onclick="return change_car()">
    <option value="<?php
    $car = new Cars();
    $ocurrs = $car->search_id($ocurr['brand_car']);
    $ocurrs=get_object_vars($ocurrs);
    echo $ocurrs['id'];
    ?>"
    ><?php echo $ocurr['brand_car'] ?></option>
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
    <option value="<?php echo $ocurr['model_car'] ?>"><?php echo $ocurr['model_car'] ?></option>

       <!-- Aqui se pintan los modelos de los coches -->
    </select>

    <p data-tr="Matrícula/Número de bastidor"></p>
    <input type="text" name="car_plate" id="car_plate" value="<?php echo $ocurr['car_plate']; ?>" readonly></input>
    <input type="text" name="frame_number" id="frame_number" value="<?php echo $ocurr['frame_number']; ?>" readonly></input>

    <p data-tr="CV/Km/Precio"></p>
    <input type="range" name="CV" min="60" max="300" value="<?php echo $ocurr['CV']; ?>" id="CV" onchange="return change_CV()"></input>
    <input type="text" id="put_CV" name="CV" value="<?php echo $ocurr['CV']; ?>" readonly/>
    <input type="range" name="kilometres" min="0" max="300000" value="<?php echo $ocurr['kilometres']; ?>" id="kilometres" onchange="return change_km()"></input>
    <input type="text" id="put_kilometres" name="kilometres" value="<?php echo $ocurr['kilometres']; ?>" readonly/>
    <input type="range"  name="price" id="price" min="300" max="10000" value="<?php echo $ocurr['price']; ?>" onchange="return change_price()"></input>
    <input type="text" id="put_price" name="price" value="<?php echo $ocurr['price']; ?>" readonly/>
    <p data-tr="Fecha"></p>
    <input type="text" id="fecha" name="fecha" value="<?php echo $ocurr['date']; ?>"/></br>
    <p data-tr="Color"></p>
    <input type="color" id="color" onchange="return change_color()" value="<?php echo $ocurr['color']; ?>"/>
    <input type="text" id="put_color" name="color" value="<?php echo $ocurr['color']; ?>" readonly/>
   
    <p data-tr="Descripción"></p>
    <textarea name="description" id="description" cols="65" rows="5"><?php echo $ocurr['description']; ?></textarea>           
    <div id="buttons">
        <button onclick="return back_create()"><i class="fas fa-arrow-alt-circle-left fa-3x"></i></button>
        <button name="Submit" id="button_submit" onclick="return validate_car_update(<?php echo $_GET['id'] ?>)"><i class="fas fa-upload fa-3x"></i></button>
    </div>
</form>