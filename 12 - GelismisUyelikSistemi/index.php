<?php
session_start();
ob_start(); // Çıktı tablolaması
require_once("baglan.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelişmiş Üyelik Sistemi</title>
</head>
<body>
    <table width="1000" height="600" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="5" height="100" bgcolor="#CCCCCC">ÜST ALAN (HEADER ALANI) (LOGO - BANNER - MENULER Vs.)</td>
        </tr>
        <tr>
            <td colspan="5" height="20">&nbsp;</td>
        </tr>
        <tr>
            <td width="250" valign="top" height="400" bgcolor="#CCCCCC"><a href="index.php" style="text-decoration: none; color: black;">Ana Sayfa</a></td>
            <td width="10" height="400">&nbsp;</td>
            <td width="480" height="400" bgcolor="#CCCCCC">İÇERİK ALANI (MAIN ALANI)</td>
            <td width="10" height="400">&nbsp;</td>
            <td width="250" height="400" valign="top">

            <?php if(isset($_SESSION["kullanici"])){ ?>
                <table width="300" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3" height="30" bgcolor="#990000" style="color:#FFFFFF;">&nbsp;Üyelik Alanı</td>
                    </tr>
                    <tr>
                        <td height="30" align="left">Merhaba <?php echo $uyeAdSoyad; ?></td>
                    </tr>
                    <tr>
                        <td height="30" align="right"><a href="cikis.php" style="text-decoration: none; color: red;">Çıkış Yap</a></td>   
                    </tr>
                </table>
            <?php }else{ ?>
                <form action="uyegiris.php" method="post">
                    <table width="300" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="3" height="30" bgcolor="#990000" style="color:#FFFFFF;">&nbsp;Üyelik Alanı</td>
                        </tr>
                        <tr>
                            <td height="30" width="100">&nbsp;Kullanıcı Adı</td>
                            <td height="30" width="10">:</td>
                            <td height="30" width="190"><input type="text" name="kullaniciadi" style="width:97%;"></td>
                        </tr>
                        <tr>
                            <td height="30" width="100">&nbsp;Şifre</td>
                            <td height="30" width="10">:</td>
                            <td height="30" width="190"><input type="password" name="sifre" style="width:97%;"></td>
                        </tr>
                        <tr>
                            <td height="30" width="100">&nbsp;</td>
                            <td height="30" width="10">&nbsp;</td>
                            <td height="30" width="190" align="right"><input type="submit" value="Giriş Yap"></td>
                        </tr>
                        <tr>
                            <td colspan="3" height="30" align="right"><a href="uyeol.php" style="text-decoration: none; color: red;">Yeni Üye Ol</a></td>
                        </tr>
                    </table>
                </form>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" height="20">&nbsp;</td>
        </tr>
        <tr>
        <td colspan="5" width="100" bgcolor="#CCCCCC">ALT ALAN (FOOTER ALANI) (LOGO - BANNER - MENULER Vs.)</td>
        </tr>
    </table>
</body>
</html>
<?php $db = null; ?>