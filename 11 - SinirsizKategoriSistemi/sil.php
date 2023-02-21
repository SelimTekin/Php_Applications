<?php require_once("../baglan.php");

    function filtrele($deger){
        $bir   = trim($deger);
        $iki   = strip_tags($bir);
        $uc    = htmlspecialchars($iki);
        $sonuc = $uc;

        return $sonuc;
    }
    
    $gelenId = filtrele($_GET["id"]);

    $menuHiyerarsisiniBulDizisi = array($gelenId); // gelen menünün id'sini de ekledik ilk başta.(seçtiğimizde gelmiyor)

    function menuHiyerarsisiniBul($menuIdDegeri=0){
        global $db;
        global $menuHiyerarsisiniBulDizisi;

        $menuSorgusu = $db->prepare("SELECT * FROM menuler WHERE ustid = ?");
        $menuSorgusu->execute([$menuIdDegeri]);
        $menuSorgusuSayisi = $menuSorgusu->rowCount();
        $menuSorgusuKayitlari = $menuSorgusu->fetchAll(PDO::FETCH_ASSOC);

        if($menuSorgusuSayisi>0){
            foreach($menuSorgusuKayitlari as $kayit){
                $menuId = $kayit["id"];
                $menuUstId = $kayit["ustid"];
                $menuAdi = $kayit["menuadi"];

                $menuHiyerarsisiniBulDizisi[] = $menuId;

                menuHiyerarsisiniBul($menuId);
            }
        }

        return $menuHiyerarsisiniBulDizisi;
    }

    if(isset($gelenId)){

        $silinecekMenuler = menuHiyerarsisiniBul($gelenId);

        foreach($silinecekMenuler as $silinecekId){
            $sil = $db->prepare("DELETE FROM menuler WHERE id = ? LIMIT 1");
            $sil->execute([$gelenId]);
            $silKontrolSayisi = $sil->rowCount();

            if($silKontrolSayisi<1){
                echo "HATA<br />";
                echo "İşlem Sırasında Beklenmhyen Bir Sorun Oluştu. Daha Sonra Tekrar Deneyiniz.<br />";
                echo "Anasayfaya Geri Dönmek İçin Lütfen Buraya <a href='index.php'>Tıklayınız</a><br />";
            }
        }
        
        header("Location: index.php");
        exit();

    }
    else{
        echo "HATA<br />";
        echo "Anasayfaya Geri Dönmek İçin Lütfen Buraya <a href='index.php'>Tıklayınız</a><br />";
    }
    
    $db = null;
?>