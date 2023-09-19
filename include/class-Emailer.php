<?php
$ds = DIRECTORY_SEPARATOR;
include __DIR__ . $ds . '..' . $ds . 'lib' . $ds . 'PHPMailer' . $ds . 'class.phpmailer.php';
include __DIR__ . $ds . '..' . $ds . 'lib' . $ds . 'PHPMailer' . $ds . 'class.smtp.php';
class Emailer
{

    public function send_email($subject, $body, $to_address, $cc_address, $attachments)
    {
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); 

        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPDebug = false;
        $mail->SMTPAuth = true;
        $mail->Port =  587;//465;                    //SMTP port
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = "tls";
        $mail->Username = "websartechno@gmail.com";
        $mail->Password = "mqkpicufrpsuavlj"; //"abhijit_t";//
        if (is_array($to_address))
            $to_address = implode(",", $to_address);

        if (is_array($cc_address))
            $cc_address = implode(",", $cc_address);

        if (!empty($to_address))
            $mail->AddAddress($to_address);
        if (!empty($cc_address))
            $mail->AddCC($cc_address);
        $mail->From = 'websartechno@gmail.com';
        $mail->SetFrom("websartechno@gmail.com", "Matrimoni Site");
        $mail->addReplyTo("websartechno@gmail.com", "Matrimoni Site");
        //$mail->addAttachment('attachment.txt');

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);
        //$mail->MsgHTML($messageText);
        try {
            if ($mail->send()) {
                return 1;//'The email message was sent.';
            } else {
                return 0;//'Mailer Error: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo '<pre> '  ;
            print_r($e);
        }
    }
}
