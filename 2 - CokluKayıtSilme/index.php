<?php
require_once("baglan.php"); // veritabanına bağlandık
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Sayfası</title>
</head>
<body>
    <form action="sonuc.php" method="post">
        <table width="500" align="center" border="0" cellpadding="0" cellspacing="0">
            <?php
            $sorgu = $db->prepare("SELECT * FROM members");
            $sorgu->execute();

            $kayitSayisi = $sorgu->rowCount();
            $kayitlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);

            foreach($kayitlar as $kayit){
            ?>
                <tr>
                    <td width="25" height="30" align="left" ><input type="checkbox" name="secim[]" value="<?php echo $kayit['id']; ?>"></td>
                    <td height="30" align="left"><?php echo $kayit['first_name'] . " " . $kayit['last_name']; ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td height="50" colspan="2" align="left"> <input type="submit" value="Seçili Olanları Sil"></td>
            </tr>
        </table>
    </form>
</body>
</html>