<?php
    try{
        $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8", "root", "");
    }
    catch(PDOException $hata){
        echo "Bağlantı Hatası<br />" . $hata->getMessage();
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner</title>
</head>
<body>
    <?php
        $reklamSorgusu = $db->prepare("SELECT * FROM bannerlar ORDER BY gosterimsayisi ASC LIMIT 1");
        $reklamSorgusu->execute();
        $reklamKaydi = $reklamSorgusu->fetch(PDO::FETCH_ASSOC);
    ?>

    <table width="1000" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="150">
            <td align="center"><img src="bannerlar/<?php echo $reklamKaydi["bannerdosyasi"] ?>" alt="banner" border="0"></td>
        </tr>
    </table>
</body>
</html>
<?php
    $reklamGuncelle = $db->prepare("UPDATE bannerlar SET gosterimsayisi=gosterimsayisi+1 WHERE id = ? LIMIT 1");
    $reklamGuncelle->execute([$reklamKaydi["id"]]);

    $db = null;
?>