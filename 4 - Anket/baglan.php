<?php

    try{
        $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8", "root", "");
    }catch(PDOException $hata){
        echo "Bağlantı Hatası<br />" . $hata->getMessage();
        die();
    }

    function filtrele($deger){
        $bir   = trim($deger);
        $iki   = strip_tags($bir);
        $uc    = htmlspecialchars($iki, ENT_QUOTES); // Tırnak işareti varsa temizledik
        $sonuc = $uc;

        return $sonuc;
    }
?>