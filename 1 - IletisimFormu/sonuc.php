<?php

header("Content-Type:text/html; charset=UTF-8"); // Türkçe karakter sorunu yaşamamak için Türkçe karakter setini ekledik

// Bunların hepsi https://github.com/PHPMailer/PHPMailer sayfasında var(biraz aşağılarda)
// PHPMailer sınıfımızı dahil ettik
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Frameworks/PHPMailer/src/Exception.php'; // PHPMailer sınıfını Frameworks klasörü içine koyduk
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';


// Zararlı koddan kaçınmak için bir fonksiyon yazıyoruz
function filtrele($deger){
    $islemBir = trim($deger);       // Baştaki ve sondaki boşlukları sildik
    $islemIki = strip_tags($islemBir); // HTML karakterlerini sildik
    $islemUc  = htmlspecialchars($islemIki, ENT_QUOTES); // tırnakları da dönüştürsün diye ENT_QUOTES yazdık
    $sonuc    = $islemUc;

    return $sonuc;
}

$gelenAdSoyad = filtrele($_POST["adSoyad"]);
$gelenTelefon = filtrele($_POST["telefon"]);
$gelenEmail   = filtrele($_POST["email"]);
$gelenKonu    = filtrele($_POST["konu"]);
$gelenMesaj   = filtrele($_POST["mesaj"]);

// mail sınıfı başlattık
$mail = new PHPMailer(true);

try {
    // Sunucu Ayarları
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;    // Olası bir işlemde çıktıları verir
    $mail->SMTPDebug = 2;                        // 2 dersek olası bir işlemde çıktıları verir( 0 dersek kapatır)
    $mail->isSMTP();                             // maili SMTP ile gönderir
    $mail->Host       = 'smtp.gmail.com';        // Kullanılan mail suncusunun adresi
    $mail->SMTPAuth   = true;                    // Enable SMTP authentication (SMTP enable ediliyor)
    $mail->CharSet    = 'UTF-8';                 // Giden mailin karakter seti Türkçe olacak
    $mail->Username   = 'root';                      //SMTP username(Hangi mail adresinden gideceği yazılıyor buraya)
    $mail->Password   = '';                      //SMTP password(mailin Şifresi)
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable implicit TLS encryption
    // $mail->Port       = 465;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption (maili göndermek için SMTP'nin tls'mi yoksa ssl yapısını mı kullandığımızı belirtiyoruz. Kendi sunucularımızda genelde tls üzerinden göndeririz. Ama burada SSL)
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`(ssl olursa 465)
    $mail->SMTPOptions = array(                                 // SMTP ayarlarını yapmazsak maili göndermez
        'ssl' => [                           // ssl yapısı
            'verify_peer' => false,          // ssl doğrulamasını kapattık (Bunları hosting ve sunucu firmaları bize belirtiyor)
            'verify_peer_name' => false,     // peer name'inin kapatılması gerekiyor
            // 'verify_depth' => 3,
            'allow_self_signed' => true,
            // 'peer_name' => 'smtp.example.com',
            // 'cafile' => '/etc/ssl/ca_cert.pem',
        ],
    );

    //Recipients
    $mail->setFrom('selim.tekin795734@gmail.com');             // Mail kimden gidecek(Gönderici adı)(Kendi sitemizden yine kendi sitemize mail gönderiyoruz yanıtı formdaki maile gönderiyoruz)
    $mail->addAddress('tekinselim.57.57@gmail.com', 'Selim'); //Add a recipient(Kime gidecek, Gönderdiğimiz kişinin adı)
    // $mail->addAddress('ellen@example.com');      //Name is optional // Başka bir kişiye daha gönderirsek bunu kullanırız.(İstenilen kadar çoğaltılabilir bu satır)
    $mail->addReplyTo($gelenEmail, $gelenAdSoyad);  // Yanıtla butonuna basıldığında hangi adrese gideceği(Yani formu gönderen kişi)
    // $mail->addCC('cc@example.com');              // Buna bilgi gönder
    // $mail->addBCC('bcc@example.com');            // Buna da gizli alanda gönder

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');           //Add attachments (Dosya felan göndereceksek bunları kullanıyoruz dosya yolunu belirterek)
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');      //Optional name

    //Content
    $mail->isHTML(true);                                                               //Set email format to HTML(Gönderim türü. HTML içerebilir deniyor burada)
    $mail->Subject = $gelenKonu;                                                  // Mailin konusu
    $mail->msgHTML($gelenMesaj);                                  // Bu şekilde HTML dokümanı da dahil edebiliriz. (Alttaki ikisini kullanmak yerine bunu kullandık. Aynı şey)
    // $mail->Body    = 'Mailin Gövdesi <b>in bold!</b>';                              // Mailin gövdesi yani içeriği 
    // $mail->AltBody = 'Mailin Gövdesi (HTML mail kabul etmeyen sunucular için )';    // Sunucu HTML metini okuyamıyorsa düz metin halinde burayı okuyor(Noramlde pek kullanılmaz. Çünkü tüm sunucular HTML mailleri kavbul ediyor)

    $mail->send();  // Mailin gönderilmesini sağlıyor
    echo 'Mail Gönderildi';
} catch (Exception $e) {
    echo "Mail Gönderim Hatası<br />Hata Açıklaması : {$mail->ErrorInfo}";
}

?>