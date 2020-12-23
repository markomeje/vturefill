<?php

namespace VTURefill\Library;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    /**
     * Email method for sending emails
     */

	public static function mail($type, $email, $data = []) {
		$mail = new PHPMailer;
		try {
            $mail->isMail();
            $mail->SetFrom(EMAIL_FROM, EMAIL_FROM_NAME);
            $mail->AddReplyTo(EMAIL_REPLY_TO);
            $mail->isHTML(true);
            switch($type) {
                case (PASSWORD_RESET):
                    $mail->Body = self::passwordResetBody($email, $data);
                    $mail->Subject = PASSWORD_RESET_SUBJECT;
                    $mail->AddAddress($email);
                    break;
            }
            $mail->send();
        }catch(Exception $e) {
            $e->getMessage();
        }
        
	}

	private static function passwordResetBody($email, $data) {
        $body  = "";
        $body .= "Dear " . $email . ", Please Use The Following Token To Reset Your Password: ";
        $body .= " " . $data["reset_token"];
        $body .= " If you didn't Perform This Action With your email, Please contact the admin directly.";
        $body .= " Regards From HERIUM";
        return $body;
    }

}