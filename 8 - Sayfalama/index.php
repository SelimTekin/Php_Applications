<?php
    try{
        $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8;", "root", "");
    }
    catch(PDOException $hata){
        echo $hata->getMessage();
        die();
    }

    if(isset($_REQUEST["sayfalama"])){
        $gelenSayfalama = $_REQUEST["sayfalama"];
    }
    else{
        $gelenSayfalama = 1;
    }

    $sayfalamaIcinSolVeSagButonSayisi   = 2; // 3. sayfadaysak yanlarında 1 2 ve 4 5 yazacak
    $sayfaBasinaGosterilecekKayitSayisi = 5;
    $toplamKayitSayisiSorgu             = $db->prepare("SELECT * FROM urunler");
    $toplamKayitSayisiSorgu->execute();
    $toplamKayitSayisi                  = $toplamKayitSayisiSorgu->rowCount();
    $sayfalamayaBaslanacakKayitSayisi   = ($gelenSayfalama*$sayfaBasinaGosterilecekKayitSayisi) - $sayfaBasinaGosterilecekKayitSayisi; // (1 * 5) - 5 -> yani Aşağıdaki sorguda LIMIT bu değişkenin değerinden başlayıp 5 tane kayıt getirecek
    $bulunanSayfaSayisi                 = ceil($toplamKayitSayisi / $sayfaBasinaGosterilecekKayitSayisi); // sonuç virgüllü çıkarsa yukarı yuvarlar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfalama</title>
    <style>
        .sayfalamaAlaniKapsayicisi{
            display: block;
            width: 100%;
            height: auto;
            margin: 0;
            padding: 10px 0 10px 0;
            border: 0;
            outline: 0;
            text-align: center;
            text-decoration: none;
        }
        .sayfalamaAlaniIciMetinAlaniKapsayicisi{
            display: block;
            width: 100%;
            height: auto;
            margin: 0;
            padding: 10px 0 10px 0;
            border: 0;
            outline: 0;
            text-align: center;
            text-decoration: none;
        }
        .sayfalamaAlaniIciNumaralandirmaAlaniKapsayicisi{
            display: block;
            width: 100%;
            height: auto;
            margin: 0;
            padding: 10px 0 10px 0;
            border: 0;
            outline: 0;
            text-align: center;
            text-decoration: none;
        }
        .pasif{
            display: inline-block;
            width: auto;
            height: 20px;
            margin: 0px 0.5px;
            padding: 0;
            padding: 5px 7.5px;
            background: #FFFFFF;
            border: none;
            border: 1px solid #DADADA;
            outline: none;
            color: #646464;
            font-size: 14px;
            font-style: normal;
            font-variant: normal;
            font-weight: normal;
            line-height: 20px;
            text-align: center;
            text-decoration: none;
        }
        .pasif a:link, a:visited, a:hover, a:active{
            text-decoration: none;
            color: #646464;
        }
        .aktif{
            display: inline-block;
            width: auto;
            height: 20px;
            margin: 0px 0.5px;
            padding: 0;
            padding: 5px 7.5px;
            background: #F6F6F6;
            border: none;
            border: 1px solid #DADADA;
            outline: none;
            color: #FF0000;
            font-size: 14px;
            font-style: normal;
            font-variant: normal;
            font-weight: bold;
            line-height: 20px;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
        <?php
            $sorgu = $db->prepare("SELECT * FROM urunler ORDER BY id LIMIT $sayfalamayaBaslanacakKayitSayisi, $sayfaBasinaGosterilecekKayitSayisi"); // LIMIT $sayfalamayaBaslanacakKayitSayisi, 5 -> $sayfalamayaBaslanacakKayitSayisi'ndan 5 tane kayıt getir
            $sorgu->execute();
            $kayitSayisi = $sorgu->rowCount();
            $kayitlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);

            foreach($kayitlar as $kayit){
                echo "<tr height='30'>";
                echo "<td width='25' align='left'>" . $kayit["id"] . "</td>";
                echo "<td width='375' align='left'>" . $kayit["urunadi"] . "</td>";
                echo "<td width='100' align='right'>" . $kayit["urunfiyati"] . " " . $kayit["parabirimi"] .  "</td>";
                echo "</tr>";
            }
        ?>
    </table>

    <div class="sayfalamaAlaniKapsayicisi">
        <div class="sayfalamaAlaniIciMetinAlaniKapsayicisi">
            Toplam <?php echo $bulunanSayfaSayisi; ?> sayfada, <?php echo $toplamKayitSayisi; ?> adet kayıt bulunmaktadır.
        </div>

        <div class="sayfalamaAlaniIciNumaralandirmaAlaniKapsayicisi">
            <?php
            
                if($gelenSayfalama>1){
                    echo "<span class='pasif'><a href='index.php?sayfalama=1'> << </a></span>";
                    $sayfalamaIcinSayfaDegeriniBirGeriAl = $gelenSayfalama - 1;
                    echo "<span class='pasif'><a href='index.php?sayfalama=" . $sayfalamaIcinSayfaDegeriniBirGeriAl . "'> < </a></span>";
                }

                for($sayfalamaIcinSayfaIndexDegeri=$gelenSayfalama - $sayfalamaIcinSolVeSagButonSayisi; $sayfalamaIcinSayfaIndexDegeri<=$gelenSayfalama + $sayfalamaIcinSolVeSagButonSayisi;
                $sayfalamaIcinSayfaIndexDegeri++){
                    if(($sayfalamaIcinSayfaIndexDegeri>0) and ($sayfalamaIcinSayfaIndexDegeri<=$bulunanSayfaSayisi)){
                        if($gelenSayfalama == $sayfalamaIcinSayfaIndexDegeri){
                            echo " <span class='aktif'>" . $sayfalamaIcinSayfaIndexDegeri . "</span>";
                        }
                        else{
                            echo " <span class='pasif'><a href='index.php?sayfalama=" . $sayfalamaIcinSayfaIndexDegeri . "'>" . $sayfalamaIcinSayfaIndexDegeri . "</a></span> ";
                        }

                    }
                }

                if($gelenSayfalama != $bulunanSayfaSayisi){
                    $sayfalamaIcinSayfaDegeriniBirIleriAl = $gelenSayfalama + 1;
                    echo "<span class='pasif'><a href='index.php?sayfalama=" . $sayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
                    echo "<span class='pasif'><a href='index.php?sayfalama=" . $bulunanSayfaSayisi . "'>>></a></span>";
                }

            ?>
        </div>
    </div>
</body>
</html>
<?php
$db = null;
?>