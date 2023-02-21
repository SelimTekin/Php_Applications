<?php
session_start();

if(empty($_SESSION["siteDili"])){
    include("dilTR.php");
}
else{
    if($_SESSION["siteDili"] == "Turkish"){
        include("dilTR.php");
    }
    elseif($_SESSION["siteDili"] == "English"){
        include("dilEN.php");
    }
    elseif($_SESSION["siteDili"] == "French"){
        include("dilFR.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çoklu Dil Sistemi</title>
</head>
<body>
    <table width="1000" align="center" border="0">
        <tr>
            <td width="130"><?php echo ANASAYFA; ?></td>
            <td width="155"><?php echo HAKKİMİZDA; ?></td>
            <td width="130"><?php echo ILETISIM; ?></td>
            <td width="373"><?php echo URUNLER; ?></td>
            <td width="190"><a href="secim.php?dilSecimi=Turkish" style="color: #000000; text-decoration: none">TR</a> | 
            <a href="secim.php?dilSecimi=English" style="color: #000000; text-decoration: none">EN</a> | 
            <a href="secim.php?dilSecimi=French" style="color: #000000; text-decoration: none">FR</a></td>
        </tr>
    </table>
</body>
</html>