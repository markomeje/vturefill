<?php

namespace Application\Library;
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
                case (PATIENT_REGISTRATION):
                    $mail->Body = self::patientRegistrationBody($email, $data);
                    $mail->Subject = PATIENT_REGISTRATION_SUBJECT;
                    $mail->AddAddress($email);
                    break;
                case (EMAIL_VERIFICATION):
                    $mail->Body = self::emailVerifyBody($email, $data);
                    $mail->Subject = EMAIL_VERIFICATION_SUBJECT;
                    $mail->AddAddress($email);
                    break;
                case (PASSWORD_RESET):
                    $mail->Body = self::passwordResetBody($email, $data);
                    $mail->Subject = PASSWORD_RESET_SUBJECT;
                    $mail->AddAddress($email);
                    break;
                case (REPORT_BUG):
                    $mail->Body = self::reportBugBody($email, $data);
                    $mail->Subject = "";
                    $mail->AddAddress($email);
                    break;
                case (DOCTOR_REGISTRATION):
                    $mail->Body = self::doctorRegistrationBody($email, $data);
                    $mail->Subject = DOCTOR_REGISTRATION_SUBJECT;
                    $mail->AddAddress($email);
                    break;
            }
            $mail->send();
        }catch(Exception $e) {
            $e->getMessage();
        }
        
	}

	private static function emailVerifyBody($email, $data) {
        $body  = "";
        $body .= "Dear " . $email . ", Please Verify Your Email With The Following Link: ";
        $body .= EMAIL_VERIFICATION_URL . "/" . urlencode($data["verify_token"]) . "/" . urlencode($data["id"]);
        $body .= " If you didn't Perform This Action With your email, Please contact the admin directly.";
        $body .= " Regards From HERIUM";
        return $body;
	}

	private static function passwordResetBody($email, $data) {
        $body  = "";
        $body .= "Dear " . $email . ", Please Use The Following Token To Reset Your Password: ";
        $body .= " " . $data["reset_token"];
        $body .= " If you didn't Perform This Action With your email, Please contact the admin directly.";
        $body .= " Regards From HERIUM";
        return $body;
    }

	private static function reportBugBody() {}

    private static function doctorRegistrationBody($email, $data) {
        $body  = "";
        $body .= "Dear " . $email . ", your partial registration with " . ucwords($data["hospital_name"]) . " was successfull: ";
        $body .= "Below is your Login password'<br>'";
        $body .= "Password : " . $data["password"];
        $body .= "If click here to login to your account and complete the registration process.";
        $body .= "Please, if you did not perform this action with your email, contact the admin directly.";
        $body .= "Regards from " . ucwords($data["hospital_name"]);
        return $body;
    }

    private static function patientRegistrationBody($email, $data) {
        $body = "";
        $body .= '<h3>'. strtoupper($data["hospital_name"]) .'</h3>';
        $body .= '<p>Dear ' . $email . ', your account registration was successfull</p>';
        $body .= '<div>Your Patient Number is ' . $data['patient_number'] . '</div>';
        $body .= '<h4>Login details below. Use the details to login to your acount</h4>';
        $body .= '<p>Login email ' . $email . ' which is the email you registered with</p>';
        $body .= '<p>Login password ' . $data['random_password'] . '</p><br><br>';
        $body .= '<a href="'.$data["login_url"].'>Please click here to login to your account</a>';
        $body .= '<h5>Regard from '. strtoupper($data["hospital_name"]) .'</h5>';
        return $body;
    }


}