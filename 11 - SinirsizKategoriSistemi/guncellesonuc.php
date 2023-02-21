<?php require_once("../baglan.php");

    function filtrele($deger){
        $bir   = trim($deger);
        $iki   = strip_tags($bir);
        $uc    = htmlspecialchars($iki);
        $sonuc = $uc;

        return $sonuc;
    }
    
    $gelenId            = filtrele($_GET["id"]);
    $gelenUstMenuSecimi = filtrele($_POST["ustMenuSecimi"]);
    $gelenMenuAdi       = filtrele($_POST["menuAdi"]);

    if(($gelenId!="") and ($gelenUstMenuSecimi!="") and ($gelenMenuAdi!="")){
        $guncelle = $db->prepare("UPDATE menuler SET ustid = ?, menuadi = ? WHERE id = ? LIMIT 1");
        $guncelle->execute([$gelenUstMenuSecimi, $gelenMenuAdi, $gelenId]);
        $guncelleKontrolSayisi = $guncelle->rowCount();

        if($guncelleKontrolSayisi>0){
            header("Location: index.php");
            exit();
        }
        else{
            echo "HATA<br />";
            echo "İşlem Sırasında Beklenmhyen Bir Sorun Oluştu. Daha Sonra Tekrar Deneyiniz.<br />";
            echo "Anasayfaya Geri Dönmek İçin Lütfen Buraya <a href='index.php'>Tıklayınız</a><br />";
        }
    }
    else{
        echo "HATA<br />";
        echo "Lütfen Boş Alan Bırakmayınız<br />";
        echo "Güncelleme Sayfasına Geri Dönmek İçin Lütfen Buraya <a href='guncelle.php?id=" . $gelenId . "'>Tıklayınız</a><br />";
    }
    
    $db = null;
?>