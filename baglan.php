<?php

    try{
        $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8", "root", "");
    }
    catch(PDOException $hata){
        echo "Bağlantı Hatası<br />" . $hata->getMessage();
        die();
    }

?>