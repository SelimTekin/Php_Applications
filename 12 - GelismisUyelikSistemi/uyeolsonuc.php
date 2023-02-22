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

    if(isset($_POST["adsoyad"])){
        $gelenAdSoyad = filtre($_POST["adsoyad"]);
    }
    else{
        $gelenAdSoyad = "";

    }

    if(isset($_POST["emailadresi"])){
        $gelenEmailAdresi = filtre($_POST["emailadresi"]);
    }
    else{
        $gelenEmailAdresi = "";

    }

    $sorgu         = $db->prepare("SELECT * FROM uyeler WHERE kullaniciadi=? OR emailadresi=?");
    $sorgu->execute([$gelenKullaniciAdi, $gelenEmailAdresi]);
    $kontrolSayisi = $sorgu->rowCount();

    if($kontrolSayisi>0){
        echo "HATA<br />";
        echo "Kullanıcı Adı veya E-Mail Adresi BAşka Bir Kullanıcı Tarafından Kullanılmaktadır.<br />";
        echo "Anasayfaya Dönmek İçin Lüften Buraya <a href='index.php'>Tıklayınız</a>.";
    }
    else{
        $kayitEkle         = $db->prepare("INSERT INTO uyeler (kullaniciadi, sifre, adisoyadi, emailadresi, kayittarihi) VALUES (?, ?, ?, ?, ?)");
        $kayitEkle->execute([$gelenKullaniciAdi, $gelenSifre, $gelenEmailAdresi, $gelenAdSoyad, $zamanDamgasi]);
        $kayitKontrol      = $kayitEkle->rowCount();

        if($kayitKontrol>0){
            echo "TEBRİKLER<br />";
            echo "Kullanıcı Kaydı Başarıyla Tamamlandı.<br />";
            echo "Anasayfaya Dönmek İçin Lüften Buraya <a href='index.php'>Tıklayınız</a>.<br />";
        }
        else{
            echo "HATA<br />";
            echo "Kullanıcı Kaydı İşlemi Sırasında Beklenmeyen Bir Hata Oluştu.<br />";
            echo "Lütfen Daha Sonra Tekrar Deneyiniz.<br />";
            echo "Anasayfaya Dönmek İçin Lüften Buraya <a href='index.php'>Tıklayınız</a>.";
        }

    }

?>