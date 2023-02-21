<?php
    require_once("baglan.php"); // veritabanına bağlandık

    // Herhangi bir sql injectiondan korunmak için bu fonksiyonu yazıyoruz
    function filtrele($deger){ 
        $bir = trim($deger);                       // baştaki ve sondaki boşlukları sildik
        $iki = strip_tags($bir);                   // HTMl taglarını temizledik
        $uc  = htmlspecialchars($iki, ENT_QUOTES); // trınakları sildik
        $sonuc = $uc;

        return $sonuc;

    }

    $gelenSecimler   = $_POST["secim"];
    $idleriBirlestir = implode(", ", $gelenSecimler); // implode dizi elemanlarını birleştirir.(arasında virgül koyduk)
    $idler           = filtrele($idleriBirlestir);

    $sil = $db->prepare("DELETE FROM members WHERE id IN ($idler)");
    $sil->execute();

    // döngüyle de olur
    // foreach($gelenSecimler as $silinecekDeger){
    //     $silinecekId = filtrele($silinecekDeger);

    //     $sil = $db->prepare("DELETE FROM members WHERE id = ? LIMIT 1");
    //     $sil->execute([$silinecekId]);
    // }

    header("Location:index.php");
    exit();  // Her zaman header'ın altında exit veya die kullan yoksa bazı sunucularda çalışma engellenebiliyor.
?>