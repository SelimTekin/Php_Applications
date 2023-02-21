<?php

header("Content-Type: text/xmlns");

try{
    $db = new PDO("mysql:host=localhost;dbname=phpegitim;charset=UTF8;", "root", "");
}
catch(PDOException $hata){
    echo $hata->getMessage();
}

echo "
<?xml version:='1.0' encoding='UTF-8'?>
<rss xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' version='2.0'>
    <channel>
        <title>PHP Eğitimi</title>
        <description>İleri Seviye PHP Eğitimi</description>
        <link>http://www.selimtekin.com</link>
        <language>tr</language>";

$sorgu = $db->prepare("SELECT * FROM urunler");
$sorgu->execute();
$sorguSayisi = $sorgu->rowCount();
$sorguKayitlari = $sorgu->fetchAll(PDO::FETCH_ASSOC);

if($sorguSayisi>0){
    foreach($sorguKayitlari as $kayitlar){
        $urunAdi = $kayitlar["urunadi"];
        $urunFiyati = $kayitlar["urunfiyati"];

        echo "
        <item>
        <title>$urunAdi</title>
        <title>$urunFiyati</title>
        </item>";
    }
}

echo "
    </channel>
</rss>";

$db = null;
?>