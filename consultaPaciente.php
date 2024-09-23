<?php 
session_start();
require_once "include/sidebar/sidebar.php";
?>

<div class="content-container">
    <?php
    include 'module/consulta_pacientes/view/Tbl_Paciente.php';
    ?>
</div>