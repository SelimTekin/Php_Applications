<?php
require_once("baglan.php"); // Birden fazla kez dosyayı yanlışlıkla dahil ederse hata veriyor.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anket Sayfası</title>
</head>
<body>
    <?php
    $anketSorgu = $db->prepare("SELECT * FROM anket LIMIT 1"); // Eğer birden fazla anket eklersek veritabanına bir tane gelsin diye LIMIT 1 yazdık
    $anketSorgu->execute();
    $kayitSayisi = $anketSorgu->rowCount();
    $kayit = $anketSorgu->fetch(PDO::FETCH_ASSOC);

    if($kayitSayisi>0){
    ?>
    <form action="oyver.php" method="post">
        <table width="300" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr height="30">
                <td colspan="2"><?= $kayit["soru"]; ?></td>
            </tr>
            <tr height="30">
                <td width="25"><input type="radio" name="cevap" value="1"></td>
                <td width="275"><?= $kayit["cevapbir"]; ?></td>
            </tr>
            <tr height="30">
                <td width="25"><input type="radio" name="cevap" value="2"></td>
                <td width="275"><?= $kayit["cevapiki"]; ?></td>
            </tr>
            <tr height="30">
                <td width="25"><input type="radio" name="cevap" value="3"></td>
                <td width="275"><?= $kayit["cevapuc"]; ?></td>
            </tr>
            <tr height="30">
                <td colspan="2"><input type="submit" value="Oyumu Gönder"></td>
            </tr>
            <tr height="30">
                <td colspan="2" align="right"><a href="sonuclar.php" style="color:blue; text-decoration:none;">Anket Sonuçlarını Göster</a></td>
            </tr>
        </table>
    </form>
    <?php
    } else{
    ?>
    Anket Bulunmuyor.
    <?php
    }
    ?>
</body>
</html>
<?php
$db = null;
?>