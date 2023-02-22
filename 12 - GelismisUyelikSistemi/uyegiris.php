<?php

    require_once("baglan.php");

    session_start();

    if(isset($_POST["kullaniciadi"])){
        $gelenKullaniciAdi = filtre($_POST["kullaniciadi"]);
    }
    else{
        $gelenKullaniciAdi = "";

    }

    if(isset($_POST["sifre"])){
        $gelenSifre = filtre($_POST["sifre"]);
    }
    else{
        $gelenSifre = "";

    }

    $sorgu         = $db->prepare("SELECT * FROM uyeler WHERE kullaniciadi=? AND sifre=?");
    $sorgu->execute([$gelenKullaniciAdi, $gelenSifre]);
    $kontrolSayisi = $sorgu->rowCount();

    if($kontrolSayisi>0){
        $_SESSION["kullanici"] = $gelenKullaniciAdi;
        header("Location: index.php");
        exit();
    }
    else{
        echo "HATA<br />";
        echo "Girilen Bilgiler ile Eşleşen Kullanıcı Bulunamadı.<br />";
        echo "Anasayfaya Dönmek İçin Lüften Buraya <a href='index.php'>Tıklayınız</a>.";
    }

?>