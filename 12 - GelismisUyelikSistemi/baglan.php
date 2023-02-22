<?php

    try{
        $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8", "root", "");
    }
    catch(PDOException $hata){
        echo "Bağlantı Hatası<br />" . $hata->getMessage();
        die();
    }

    function filtre($deger){
        $bir   = trim($deger);
        $iki   = strip_tags($bir);
        $uc    = htmlspecialchars($iki);
        $sonuc = $uc;

        return $sonuc;
    }

    $zamanDamgasi = time();

    if(isset($_SESSION["kullanici"])){
        $sorgu       = $db->prepare("SELECT * FROM uyeler WHERE kullaniciadi=?");
        $sorgu->execute([$_SESSION["kullanici"]]);
        $kayitSayisi = $sorgu->rowCount();
        $kayitlar    = $sorgu->fetch(PDO::FETCH_ASSOC);

        if($kayitSayisi>0){
            $uyeAdSoyad = $kayitlar["adisoyadi"];
        }
        else{
            $uyeAdSoyad = "";
        }
    }
?>