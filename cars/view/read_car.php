<div id="read_car">
<table id="table_data">
    <tr>
        <td><p data-tr="Marca"></p></td>
        <td><p><?php echo $ocurr['brand_car']?></p></td>
    </tr>
    <tr>
        <td><p data-tr="Modelo"></p></td>
        <td><p><?php echo $ocurr['model_car']?></p></td>

    </tr>
        <td><p data-tr="Matrícula"></p></td>
        <td><p><?php echo $ocurr['car_plate']?></p></td>

    </tr>
    <tr>
        <td><p data-tr="Numero de Bastidor"></p></td>
        <td><p><?php echo $ocurr['frame_number']?></p></td>

    </tr>
    <tr>
        <td><p data-tr="CV"></p></td>
        <td><p><?php echo $ocurr['CV']?> CV</p></td>

    </tr>
    <tr>
        <td><p data-tr="Precio"></p></td>
        <td><p><?php echo $ocurr['price']?> €</p></td>

    </tr>
    <tr>
        <td><p data-tr="KM"></p></td>
        <td><p><?php echo $ocurr['kilometres']?> km</p></td>

    </tr>
    <tr>
        <td><p data-tr="Fecha"></p></td>
        <td><p><?php echo $ocurr['date']?></p></td>

    </tr>
    <tr>
        <td><p data-tr="Color"></p></td>
        <td><input type="color" value="<?php echo $ocurr['color']?>" disabled></input></td>

    </tr>
    <tr>
        <td><p data-tr="Descripción"></p></td>
        <td><textarea readonly cols="20" rows="5"><?php echo $ocurr['description']?></textarea></td>

    </tr>
    </table>
<button><a href="index.php?module=controller&option=list"><i class="fas fa-arrow-alt-circle-left fa-3x"></i></a></button>
</div>