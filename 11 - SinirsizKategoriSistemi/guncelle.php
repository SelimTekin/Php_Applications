<?php
require_once("../baglan.php");

function filtrele($deger){
    $bir   = trim($deger);
    $iki   = strip_tags($bir);
    $uc    = htmlspecialchars($iki);
    $sonuc = $uc;

    return $sonuc;
}

$gelenId = filtrele($_GET["id"]);

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
    
        function acilirMenuIcinMenuYaz($guncellenecekMenuId, $guncellenecekMenuUstId, $menuUstId=0, $boslukDegeri=0){
            global $db;
            
            $menuSorgusu = $db->prepare("SELECT * FROM menuler WHERE ustid = ?");
            $menuSorgusu->execute([$menuUstId]);
            $menuSorgusuSayisi = $menuSorgusu->rowCount();
            $menuSorgusuKayitlari = $menuSorgusu->fetchAll(PDO::FETCH_ASSOC);

            if($menuSorgusuSayisi>0){
                foreach($menuSorgusuKayitlari as $kayit){
                    $menuId = $kayit["id"];
                    $menuUstId = $kayit["ustid"];
                    $menuAdi = $kayit["menuadi"];

                    if($guncellenecekMenuId!=$menuId){
                        if($guncellenecekMenuUstId==$menuId){
                            echo "<option value='" . $menuId . "' selected='selected'>" . str_repeat("&nbsp;", $boslukDegeri) . $menuAdi . "</option>";
                        }
                        else{
                            echo "<option value='" . $menuId . "'>" . str_repeat("&nbsp;", $boslukDegeri) . $menuAdi . "</option>";
                        }

                        acilirMenuIcinMenuYaz($guncellenecekMenuId, $guncellenecekMenuUstId, $menuId, $boslukDegeri+5);
                    }
                    
                }
            }
        }

    $sorgu = $db->prepare("SELECT * FROM menuler WHERE id = ? LIMIT 1");
    $sorgu->execute([$gelenId]);
    $sorguSayisi = $sorgu->rowCount();
    $sorguKaydi = $sorgu->fetch(PDO::FETCH_ASSOC);

    print_r($sorguKaydi);
    ?>
    Menü Güncelleme Formu<br />
    <form action="guncellesonuc.php?id=<?php echo $sorguKaydi["id"]; ?>" method="post">
        Üst Menü : <select name="ustMenuSecimi">
            <option value="0" <?php if($sorguKaydi["ustid"] == 0){ ?>selected="selected"<?php } ?>>Ana Menü</option>
            <?php acilirMenuIcinMenuYaz($sorguKaydi["id"], $sorguKaydi["ustid"]); ?>
        <select><br />
        Menü Adı : <input type="text" name="menuAdi" value="<?php echo $sorguKaydi["menuadi"]; ?>"><br />
        <input type="submit" value="Menü Güncelle">
    </form><br /><br /><br />


    <?php
        $db = null;
    ?>

</body>
</html>