<?php




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailerComponent extends CApplicationComponent
{
    public function sendEmail($to, $subject, $message)
    {
        // print_r($message);die();
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'zeeshanirfan913@gmail.com'; // Replace with your SMTP username
        $mail->Password = 'cgshpkxtjhilrald'; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;


        $mail->setFrom('zeeshanirfan913@gmail.com', 'VerifyEmail');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body    = $message;


        if (!$mail->send()) {
            Yii::log('Mailer Error: ' . $mail->ErrorInfo, CLogger::LEVEL_ERROR);
            return false;
        }


        return true;
    }
}
