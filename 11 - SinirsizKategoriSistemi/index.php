<?php
require_once("../baglan.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınırsız Kategori Sistemi</title>
</head>
<body>
    <?php

        function menuYaz($menuUstId=0, $boslukDegeri=0){
            global $db; // veritabanı bağlantısı fonksiyon dışında olduğu için fonksiyon içinde kullanabilmek için global ifadesini kullandık

            $menuSorgusu = $db->prepare("SELECT * FROM menuler WHERE ustid = ?");
            $menuSorgusu->execute([$menuUstId]);
            $menuSorgusuSayisi = $menuSorgusu->rowCount();
            $menuSorgusuKayitlari = $menuSorgusu->fetchAll(PDO::FETCH_ASSOC);

            if($menuSorgusuSayisi>0){
                foreach($menuSorgusuKayitlari as $kayit){
                    $menuId = $kayit["id"];
                    $menuUstId = $kayit["ustid"];
                    $menuAdi = $kayit["menuadi"];

                    echo str_repeat("&nbsp;", $boslukDegeri) . $menuAdi . "<a href='guncelle.php?id=" . $menuId . "'>[Güncelle]</a> <a href='sil.php?id=" . $menuId . "'>[Sil]</a><br />"; // str_repeat -> 2. parametre kadar 1. parametreyi tekrarlar

                    menuYaz($menuId, $boslukDegeri+10);
                }
            }
        }
    
        function acilirMenuIcinMenuYaz($menuUstId=0, $boslukDegeri=0){
            global $db; // veritabanı bağlantısı fonksiyon dışında olduğu için fonksiyon içinde kullanabilmek için global ifadesini kullandık

            $menuSorgusu = $db->prepare("SELECT * FROM menuler WHERE ustid = ?");
            $menuSorgusu->execute([$menuUstId]);
            $menuSorgusuSayisi = $menuSorgusu->rowCount();
            $menuSorgusuKayitlari = $menuSorgusu->fetchAll(PDO::FETCH_ASSOC);

            if($menuSorgusuSayisi>0){
                foreach($menuSorgusuKayitlari as $kayit){
                    $menuId = $kayit["id"];
                    $menuUstId = $kayit["ustid"];
                    $menuAdi = $kayit["menuadi"];

                    echo "<option value='" . $menuId . "'>" . str_repeat("&nbsp;", $boslukDegeri) . $menuAdi . "</option>"; // str_repeat -> 2. parametre kadar 1. parametreyi tekrarlar

                    acilirMenuIcinMenuYaz($menuId, $boslukDegeri+5);
                }
            }
        }

    // Yeni Menü Ekleme
    ?>
    Menü Ekleme Formu<br />
    <form action="ekle.php" method="post">
        Üst Menü : <select name="ustMenuSecimi">
            <option value="0">Ana Menü Yap</option>
            <?php acilirMenuIcinMenuYaz(); ?>
        <select><br />
        Menü Adı : <input type="text" name="menuAdi"><br />
        <input type="submit" value="Menü Ekle">
    </form><br /><br /><br />


    <?php
        // Menüleri Listeleme
        menuYaz();


        // echo "4 numaralı ID'ye (Bilgisayar) ait alt menüler";
        // menuYaz(4); // 0 olursa hepsini gösterir
        
        $db = null;
    ?>

</body>
</html>