<?php
    session_start();
    session_destroy();
    header("Location: ../index.php");// aqui redirigiremos a index
    die();
?>