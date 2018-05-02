<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->SMTPAuth = false;
$mail->From = 'info@zdravstvenanegaeliksir.rs';
$mail->FromName = 'info';
$mail->addAddress('zdravstvenanega@eliksir.co.rs', 'Zdravstvena Nega Eliksir'); //---------!!! ovde upises adresu primaoca..mozes prvo svoju kako bi testirao, pa posle njihovu 
$mail->addReplyTo('info@zdravstvenanegaeliksir.rs', 'Info Eliksir');
$mail->WordWrap = 50;
$mail->isHTML(true);

if (isset($_POST['first_name'])) {
    // ok
    if (filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING) &&
        filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING) &&
        filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) &&
        filter_input(INPUT_POST, 'body_text', FILTER_SANITIZE_STRING)
    ) {

        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_INT);
        $body_text = filter_input(INPUT_POST, 'body_text', FILTER_SANITIZE_STRING);

        $body_content = '<div style="display: block">Ime: ' . $first_name . '</div>';
        $body_content .= '<div style="display: block">Prezime: ' . $last_name . '</div>';
        $body_content .= '<div style="display: block">Email: ' . $email . '</div>';
        $body_content .= '<div style="display: block">Telefon: ' . $phone . '</div>';
        $body_content .= '<div style="display: block">Poruka: ' . $body_text . '</div>';

        $mail->Subject = 'Kontakt sa vebsajta - Eliksir';
        $mail->Body = $body_content;
        $mail->AltBody = 'Alt msg';

        if (!$mail->send()) {
            echo 'Greška, server.Poruka nije poslata.';
            exit;
        } else {
            header('Location: /thankyou.html');
            exit;
        }
    }

} else {
    header('Location: /contact.html');
}
?>