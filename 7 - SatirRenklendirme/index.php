<?php
    try{
        $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8;", "root", "");
    }
    catch(PDOException $hata){
        echo $hata->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listelemelerde Satır Renklendirme</title>
</head>
<body>
    <table width="1000" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="30" bgcolor="#000000">
            <td align="left" style="color:white;">&nbsp;Ürün Adı</td>
            <td align="right" style="color:white;">Ürün Fiyatı&nbsp;</td>
        </tr>
        <?php
        $sorgu       = $db->prepare("SELECT * FROM urunler");
        $sorgu->execute();
        $kayitSayisi = $sorgu->rowCount();
        $kayitlar    = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        $birinciRenk = "#dfdfdf";
        $ikinciRenk = "#FFFFFF";
        $renkIcinSayi = 0;

        foreach($kayitlar as $kayit){

            if($renkIcinSayi%2){
                $arkaPlanRengi = $birinciRenk;
            }
            else{
                $arkaPlanRengi = $ikinciRenk;
            }
        ?>
        <tr height="30" bgcolor="<?php echo $arkaPlanRengi; ?>" onmouseover="this.bgColor='#c2cedb';" onmouseout="this.bgColor='<?php echo $arkaPlanRengi; ?>';" style="cursor:pointer;">
            <td align="left">&nbsp;<?php echo $kayit["urunadi"]; ?></td>
            <td align="right"><?php echo $kayit["urunfiyati"]; ?>&nbsp;</td>
        </tr>
        <?php 
            $renkIcinSayi++;
        } ?>
    </table>
</body>
</html>
<?php
$db = null;
?>