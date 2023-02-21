<?php
require_once("baglan.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site içi Arama</title>
</head>
<body>
    <br /><br /><br /><br /><br />
    <form action="index.php" method="post">
        <table width="500" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td><input type="text" name="aranan" style="width: 100%; height: 30px; margin-bottom:20px; padding: 0 20px;"></td>
            </tr>
            <tr>
                <td align="center"><input type="submit" value="Arama Yap" style="padding: 0 100px; height: 30px;"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left">
                <?php
                if(isset($_POST["aranan"])){
                    $gelenArama = filtrele($_POST["aranan"]);
                }
                else{
                    $gelenArama = ""; // Boş gelirse veritabanından bütün veriler çekilir. Çünkü LIKE'ın içi boş kalır.
                }

                if($gelenArama!=""){
                    $kosul      = "%" . $gelenArama . "%";

                    $sorgu       = $db->prepare("SELECT * FROM esyalar WHERE adi LIKE ?");
                    $sorgu->execute([$kosul]);
                    $kayitSayisi = $sorgu->rowCount();
                    $kayitlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    
                    echo "Bulunan Kayıtlar<br />";
                    foreach($kayitlar as $kayit){
                        echo $kayit["adi"] . "<br />";
                    }
                }
                else{

                }
                

                ?>
                </td>
            </tr>
        </table>
    </form>

    
</body>
</html>
<?php
$db = null;
?>