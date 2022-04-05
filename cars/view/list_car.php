
<?php
if ($_GET['create'] == 1) {
    print_r("<script>toastr.success('Se ha añadido un nuevo vehículo')</script>");
} else if ($_GET['create'] == 2) {
    print_r("<script>toastr.success('Se ha actualizado el vehículo')</script>");
} else if ($_GET['create'] == 3) {
    print_r("<script>toastr.success('Se han creado los dummies')</script>");

}
?>
<div id="error_marc">
    <div id="button_area">
        <button id="close_error" onclick="return close_error()"><i class="fas fa-window-close fa-2x"></i></button>
    </div>
    <div id="scroll_table">
    <table id="tabla_dinamica">
        <tr>
            <th>Hora</th>
            <th>Error</th>
        </tr>

    </table>
</div>
</div>
<div id="list">
    <div id="move_text">
        <button id="create_car"><a href="index.php?module=controller&option=create"><i class="far fa-plus-square fa-3x"></i></a></button>
        <button hidden id="error_logs" onclick="return charge_logs()"><i class="fas fa-exclamation-triangle fa-3x"></i></button>
    </div>
<div id="container">
<table id="table_data">
    <thead>
            <tr>
                <th data-tr="Marca">></th>
                <th data-tr="Modelo"></th>
                <th data-tr="Matrícula">></th>
                <th data-tr="Numero de Bastidor"></th>
                <th data-tr="CV"></th>
                <th data-tr="Precio"></th>
                <th data-tr="KM"></th>
                <th data-tr="Fecha"></th>
                <th data-tr="Color"></th>
                <th data-tr="Descripción">></th>
            </tr>
    </thead>
    <tbody>
    <?php
        foreach ($GLOBALS["ocurrs"] as $row) {
                echo " 
                <tr><td>".$row['brand_car']."</td>
                <td>".$row['model_car']."</td>
                <td>".$row['car_plate']."</td>
                <td>".$row['frame_number']."</td>
                <td>".$row['CV']."</td>
                <td>".$row['price']."</td>
                <td>".$row['kilometres']."</td>
                <td>".$row['date']."</td>
                <td><input type='color' value='".$row['color']."' disabled></td>
                <td>".$row['description']."</td>
                <td><button class='read_modal' id=".$row['id']."><i class='fas fa-eye fa-3x'></button></td>
                <td><button id='edit_button'><a href='index.php?module=controller&option=update&id=".$row['id']."'><i class='fas fa-edit fa-3x'></i></a></button></td>
                <td><button id='delete_button'><a href='index.php?module=controller&option=delete&id=".$row['id']."'><i class='fas fa-trash-alt fa-3x'></i></a></button></td>
                
            ";
            echo "</tr>";
        }
    ?>
    </tbody>
    </table>
</div>
<div id="section_read"></div>
</div>