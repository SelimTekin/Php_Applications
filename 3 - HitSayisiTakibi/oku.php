<?php
require_once("baglan.php"); // require_once() -> daha önce dahil edildiyse hata verir. Bu işe yarıyor

$gelenId = $_GET["id"];

$hitGuncelle = $db->prepare("UPDATE makaleler SET gosterimsayisi=gosterimsayisi+1 WHERE id = ?");
$hitGuncelle->execute([$gelenId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table width="1000" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr height="30">
            <td align="left"><b>Görüntüleme ve Hit Uygulaması</b></td>
            <td align="right"><a href="index.php" style="text-decoration:none;color:black;">Anasayfa</a></td>
        </tr>
        <?php
            $sorgu       = $db->prepare("SELECT * FROM makaleler WHERE id = ?");
            $sorgu->execute([$gelenId]);
            $kayitSayisi = $sorgu->rowCount();
            $kayit    = $sorgu->fetch(PDO::FETCH_ASSOC); // Bir tane kayıt alacağımız için fetchAll değil de fetch kullandık

            if($kayitSayisi>0){
        ?>
        <tr height="30">
            <td colspan="2" align="left"><h3><?php echo $kayit["makalebasligi"]; ?></h3></td>
        </tr>
        <tr height="30">
            <td colspan="2" align="left"><?php echo $kayit["makaleicerigi"]; ?></td>
        </tr>
        <tr height="30">
            <td colspan="2" align="center">Bu makale <?php echo $kayit["gosterimsayisi"]; ?> defa görüntülendi.</td>
        </tr>
        <?php
            }
            else{
                header("Location:index.php"); // Kayıta erişilmezse header ile index sayfasına göndericez
            }
        ?>
    </table>
</body>
</html>
<?php
$db = null; // Veritabanı bağlantımızı kapattık
?>