<?php
include("../baglan.php");
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCMB Döviz Kurları Bot Uygulaması</title>
</head>
<body>
    <?php
    
        $link = "https://www.tcmb.gov.tr/kurlar/today.xml";
        $icerik = simplexml_load_file($link); // xml'i işliyoruz

        // sleep(5); // Sayfa yenileme butonuna bastığımızda 5 saniye bekletip sayfayı yeniletiyoruz. Bunu yapmamızın nedeni çok sık sayfayı yenilersek merkez bankası sitesinde hata verecektir.
        $zamanDamgasi = time();

        $zamanSorgusu = $db->prepare("SELECT guncellenmezamani FROM dovizkurlari LIMIT 1");
        $zamanSorgusu->execute();
        $songuncellenmezamani    = $zamanSorgusu->fetch(PDO::FETCH_ASSOC);
        $sayi = $zamanSorgusu->rowCount();
        if($sayi<1){
            echo "$kod Güncelleme İşleminde Bir Hata Oluştu.";
            die();
        }

        $birGunKontrolu = $zamanDamgasi - $songuncellenmezamani["guncellenmezamani"];


        // Veritabanına döviz kodlarını kaydettik (Burayı bir daha açma, bir defaya mahsustu.)
        // for($i=0; $i<count($icerik->Currency)-1; $i++){
        //     $kod = $icerik->Currency[$i]["CurrencyCode"];
        //     $kayitSorgusu = $db->prepare("INSERT INTO dovizkurlari (kodu) values ('$kod')");
        //     $kayitSorgusu->execute();

        // }


        // Veritabanına döviz bilgilerini kaydettik(İlk başta 0 olarak kaydetmiştik o yüzden update ettik)((Burayı da bir daha açma, bir defaya mahsustu.))
        if($birGunKontrolu == 86400){
            for($i=0; $i<count($icerik->Currency)-1; $i++){
                $kod = $icerik->Currency[$i]["CurrencyCode"];
                $guncellemeSorgusu = $db->prepare("UPDATE dovizkurlari SET adi = ?, birim = ?, alis = ?, satis = ?, efektifalis = ?, efektifsatis = ?, guncellenmezamani = ? WHERE kodu = ?");
                $guncellemeSorgusu->execute([
                    $icerik->Currency[$i]->Isim,
                    $icerik->Currency[$i]->Unit,
                    $icerik->Currency[$i]->ForexBuying,
                    $icerik->Currency[$i]->ForexSelling,
                    $icerik->Currency[$i]->BanknoteBuying,
                    $icerik->Currency[$i]->BanknoteSelling,
                    $zamanDamgasi,
                    $kod
                ]);
                $guncllemeSayisi = $guncellemeSorgusu->rowCount();
                if($guncllemeSayisi<1){
                    echo "$kod Güncelleme İşleminde Bir Hata Oluştu.";
                    die();
                }

            }
        }

    ?>
        
    <table align="center" width="800" border="0" cellpadding="0" cellspacing="0">
        <tr height="30" bgcolor="#CCCCCC">
            <th align="left" width="250">Adı</th>
            <th align="left" width="250">Kısa Adı</th>
            <th align="left" width="100">Birim</th>
            <th align="left" width="100">Alış</th>
            <th align="left" width="100">Satış</th>
            <th align="left" width="125">Efektif Alış</th>
            <th align="left" width="125">Efektif Satış</th>
        </tr>
        <?php for($i=0; $i<count($icerik->Currency)-1; $i++){ ?>
        <tr height="30">
            <td align="left" widtd="250"><?php echo $icerik->Currency[$i]->Isim ; ?></td>
            <td align="left" widtd="250"><?php echo $icerik->Currency[$i]["CurrencyCode"] ; ?></td>
            <td align="left" widtd="100"><?php echo $icerik->Currency[$i]->Unit ; ?></td>
            <td align="left" widtd="100"><?php echo $icerik->Currency[$i]->ForexBuying ; ?></td>
            <td align="left" widtd="100"><?php echo $icerik->Currency[$i]->ForexSelling ; ?></td>
            <td align="left" widtd="125"><?php echo $icerik->Currency[$i]->BanknoteBuying ; ?></td>
            <td align="left" widtd="125"><?php echo $icerik->Currency[$i]->BanknoteSelling ; ?></td>
        </tr>
        <?php }?>
    </table>

    <?php    
        // echo "<pre>";
        // print_r($icerik);
        // echo "</pre>";
    ?>
</body>
</html>