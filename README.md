Yii Web Programming Framework
=============================


INSTALLATION
------------

For send email you need to install package 

    composer require phpmailer/phpmailer

generate app key from the gmail and add that key in your PHPMailerComponent file 

First_Yii_Project\demos\blog\protected\components\PHPMailerComponent.php
    in this file you have to add following details 
    $mail->Username = 'Your_Email'; // Replace with your SMTP username
    $mail->Password = '#####'; // Replace with your SMTP password


