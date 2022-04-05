<form method="post" id="delete">
    <p data-tr="Estas seguro de eliminar el vehículo con esta matrícula->">Estas seguro de eliminar el vehículo con esta matrícula-> <?php echo $prev['car_plate'] ?>?</p>
    <button name="delete" id="delete" onclick="return delete_car(<?php echo $_GET['id'] ?>)"><i class="fas fa-check-circle fa-3x"></i></button>
    <button onclick="return back_delete()" id="returned"><i class="fas fa-times-circle fa-3x"></i></button>
</form>
