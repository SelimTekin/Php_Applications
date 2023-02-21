<?php
require_once("baglan.php"); // Birden fazla kez dosyayı yanlışlıkla dahil ederse hata veriyor.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sonuçlar Sayfası</title>
</head>
<body>
    <?php
    $anketSorgu = $db->prepare("SELECT * FROM anket LIMIT 1"); // Eğer birden fazla anket eklersek veritabanına bir tane gelsin diye LIMIT 1 yazdık
    $anketSorgu->execute();
    $kayitSayisi = $anketSorgu->rowCount();
    $kayit = $anketSorgu->fetch(PDO::FETCH_ASSOC);

    $birinciSeceneginOySayisi = $kayit["oysayisibir"];
    $ikinciSeceneginOySayisi  = $kayit["oysayisiiki"];
    $ucuncuSeceneginOySayisi  = $kayit["oysayisiuc"];
    $toplamOySayisi           = $kayit["toplamoysayisi"];

    if($kayitSayisi>0){

        // Zero Division hatası almamak için buraya koyduk
        $birinciSeceneginYuzdesiniHesapla = ($birinciSeceneginOySayisi / $toplamOySayisi) * 100; // yüzdelik değeri bulduk
        $birinciSecenekIcinYuzde          = number_format($birinciSeceneginYuzdesiniHesapla, 2, ",", ""); // virgülden sonra 2 basamak olsun ve ondalık hane virgül ile ayrılsın. Ayrıca binlik hanesi boş kalsın

        $ikinciSeceneginYuzdesiniHesapla = ($ikinciSeceneginOySayisi / $toplamOySayisi) * 100;
        $ikinciSecenekIcinYuzde          = number_format($ikinciSeceneginYuzdesiniHesapla, 2, ",", "");

        $ucuncuSeceneginYuzdesiniHesapla = ($ucuncuSeceneginOySayisi / $toplamOySayisi) * 100;
        $ucuncuSecenekIcinYuzde          = number_format($ucuncuSeceneginYuzdesiniHesapla, 2, ",", "");
    ?>
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr height="30">
                <td colspan="2"><?= $kayit["soru"]; ?></td>
            </tr>
            <tr height="30">
                <td width="75">%<?= $birinciSecenekIcinYuzde; ?></td>
                <td width="225"><?= $kayit["cevapbir"]; ?></td>
            </tr>
            <tr height="30">
                <td width="75">%<?= $ikinciSecenekIcinYuzde; ?></td>
                <td width="225"><?= $kayit["cevapiki"]; ?></td>
            </tr>
            <tr height="30">
                <td width="75">%<?= $ucuncuSecenekIcinYuzde; ?></td>
                <td width="225"><?= $kayit["cevapuc"]; ?></td>
            </tr>
            <tr height="30">
                <td colspan="2" align="right"><a href="index.php" style="color:blue; text-decoration:none;">Anasayfaya Dön</a></td>
            </tr>
        </table>
    <?php
    } else{
        header("Location: index.php"); // Kayıt bulamazsa anasayfaya geri göndersin
    }
    ?>
</body>
</html>
<?php
$db = null;
?>