<?php require_once("../baglan.php");

    function filtrele($deger){
        $bir   = trim($deger);
        $iki   = strip_tags($bir);
        $uc    = htmlspecialchars($iki);
        $sonuc = $uc;

        return $sonuc;
    }
    
    $gelenUstMenuSecimi = filtrele($_POST["ustMenuSecimi"]);
    $gelenMenuAdi       = filtrele($_POST["menuAdi"]);

    if((isset($gelenUstMenuSecimi)) and (isset($gelenMenuAdi))){
        $ekle = $db->prepare("INSERT INTO menuler (ustid, menuadi) VALUES (?, ?)");
        $ekle->execute([$gelenUstMenuSecimi, $gelenMenuAdi]);
        $ekleKontrolSayisi = $ekle->rowCount();

        if($ekleKontrolSayisi>0){
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
        echo "Anasayfaya Geri Dönmek İçin Lütfen Buraya <a href='index.php'>Tıklayınız</a><br />";
    }
    
    $db = null;
?>