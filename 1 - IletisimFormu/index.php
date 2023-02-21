<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Formu</title>

    <style>
        .inputAlani{
            width: 100%;
            height: 15px;
            margin: 0;
            padding: 5px 10px 5px 10px;
        }
        .textAreaAlani{
            width: 100%;
            height: 50px;
            margin: 0;
            padding: 5px 10px 5px 10px;
        }
        .gonderButonu{
            height: 30px;
            margin: 0;
            padding: 5px 50px 5px 50px;
            border: 1px solid #00FF00;
            background: #009900;
            color:#FFFFFF;
        }
        .gonderButonu:hover{
            border: 1px solid #000000;
            background: #00FF00;
            color:#000000;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="sonuc.php" method="post">
        <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="150" height="30">Adınız Soyadınız</td>
                <td width="20" height="30">:</td>
                <td width="330" height="30"><input type="text" class="inputAlani" name="adSoyad"></td>
            </tr>
            <tr>
                <td width="150" height="30">Telefon Numaranız</td>
                <td width="20" height="30">:</td>
                <td width="330" height="30"><input type="text" class="inputAlani" name="telefon"></td>
            </tr>
            <tr>
                <td width="150" height="30">E-mail Adresiniz</td>
                <td width="20" height="30">:</td>
                <td width="330" height="30"><input type="email" class="inputAlani" name="email"></td>
            </tr>
            <tr>
                <td width="150" height="30">Konu</td>
                <td width="20" height="30">:</td>
                <td width="330" height="30"><input type="text" class="inputAlani" name="konu"></td>
            </tr>
            <tr>
                <td width="150" height="30" valign="top">Mesaj</td>
                <td width="20" height="30" valign="top">:</td>
                <td width="330" height="30"><input type="text" class="textAreaAlani" name="mesaj"></td>
            </tr>
            <tr>
                <td width="150" height="30">&nbsp;</td>
                <td width="20" height="30">&nbsp;</td>
                <td width="330" height="30" align="right"><input type="submit" class="gonderButonu" value="Gönder"></td>
            </tr>
        </table>
    </form>
</body>
</html>