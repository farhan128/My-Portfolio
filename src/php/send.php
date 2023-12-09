<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('phpmailer/Exception.php');
include('phpmailer/PHPMailer.php');
include('phpmailer/SMTP.php');

$email_pengirim = $_POST['email'];
$nama_pengirim = $_POST['name'];
$email_penerima = 'timdeveloper12@gmail.com';
$subjek = $_POST['subject'];
$pesan = $_POST['mail'];
$attachment = $_FILES['attachment']['name'];


$mail = new PHPMailer;
$mail->isSMTP();

$mail->Host = 'smtp.gmail.com';
$mail->Username = $email_penerima; 
$mail->Password = 'odle jnuo mvkd lkmd';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
// $mail->SMTPDebug = 2;

$mail->setFrom($email_pengirim, $nama_pengirim);
$mail->addAddress($email_penerima, '');
$mail->isHTML(true);

ob_start();
include "content.php";

$content = ob_get_contents();
ob_end_clean();

$mail->Subject = $subjek;
$mail->Body = $content;
$mail->AddEmbeddedImage('/src/images/icon.png', 'icon_portfolio', 'icon.png');

if(empty($attachment)){
    $send = $mail->send();

    if($send){ 
        // echo "<script>document.querySelector('.info').style.display = 'inline';</script>";
        echo "<h1>Email dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
    }else{ 
        echo "<h1>Email gagal dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
        // echo "<script>document.querySelector('.info').style.display = 'inline';</script>";
        // echo '<h1>ERROR<br /><small>Error while sending email: '.$mail->getError().'</small></h1>';
    }
} else { 
    $tmp = $_FILES['attachment']['tmp_name'];
    $size = $_FILES['attachment']['size'];

    if($size <= 25000000){
        $mail->addAttachment($tmp, $attachment);

        $send = $mail->send();

        if($send){
            echo "<h1>Email berhasil dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
        }else{
            echo "<h1>Email gagal dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
        }
    }else{
        echo "<h1>Ukuran file attachment maksimal 25 MB</h1><br /><a href='index.php'>Kembali ke Form</a>";
    }
}
?>