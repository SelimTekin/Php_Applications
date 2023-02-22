<?php

    require_once("baglan.php");
    session_start();

    unset($_SESSION["kullanici"]);
    session_destroy(); // unset ile yok edemezse session_destroy ile hepsini yok etmesini sağladık
    header("Location: index.php");
    exit();

?>