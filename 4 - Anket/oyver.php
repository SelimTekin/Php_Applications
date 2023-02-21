<?php
    require_once("baglan.php");

    $IPAdresi         = $_SERVER["REMOTE_ADDR"]; // localhostta ::1 bir şeklinde gözükür fakat gerçek ortamda gerçek ip gözükür
    $zamanDamgasi     = time();
    $oyKullanmaSiniri = 86400;                             // Saniye cinsinden (Bir güne tekabül ediyor)
    $zamaniGeriAl     = $zamanDamgasi - $oyKullanmaSiniri; // Zamanı bir gün geri aldık


    $gelenCevap = filtrele($_POST["cevap"]);

    $kontrolSorgusu = $db->prepare("SELECT * FROM oykullananlar WHERE ipadresi = ? AND tarih >= ?"); // Eğer oy kullandığı tarih bizim belirlediğimiz zamandan büyükse oy kullanmış demektir.
    $kontrolSorgusu->execute([$IPAdresi, $zamaniGeriAl]);
    $kontrolSayisi  = $kontrolSorgusu->rowCount();

    if($kontrolSayisi>0){
        echo "HATA<br />";
        echo "Daha Önce oy kullanmışsınız. Lütfen 24 saat sonra tekrar deneyiniz.<br />";
        echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız</a>.<br />";
    }
    else{

        if($gelenCevap==1){
            $guncelle = $db->prepare("UPDATE anket SET oysayisibir=oysayisibir+1, toplamoysayisi=toplamoysayisi+1");
            $guncelle->execute();
        }
        elseif($gelenCevap==2){
            $guncelle = $db->prepare("UPDATE anket SET oysayisiiki=oysayisiiki+1, toplamoysayisi=toplamoysayisi+1");
            $guncelle->execute();
        }
        elseif($gelenCevap==3){
            $guncelle = $db->prepare("UPDATE anket SET oysayisiuc=oysayisiuc+1, toplamoysayisi=toplamoysayisi+1");
            $guncelle->execute();
        }
        else{
            echo "HATA<br />";
            echo "Cevap Kaydı Bulunamıyor.<br />";
            echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız</a>.<br />";
        }

        $ekle = $db->prepare("INSERT INTO oykullananlar (ipadresi, tarih) VALUES (?, ?)");
        $ekle->execute([$IPAdresi, $zamanDamgasi]);
        $ekleKontrol = $ekle->rowCount();

        if($ekleKontrol>0){ // Ekleme yapılmış mı onu kontrol ediyoruz
            echo "TEŞEKKÜRLER<br />";
            echo "Vermiş Olduğunuz Oy Sisteme Kaydedildi.<br />";
            echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız</a>.<br />";
        }
        else{
            echo "HATA<br />";
            echo "İşlem Sırasında Beklenmeyen Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz.<br />";
            echo "Anasayfaya dönmek için <a href='index.php'>tıklayınız</a>.<br />";
        }

    }

    $db = null;
?>