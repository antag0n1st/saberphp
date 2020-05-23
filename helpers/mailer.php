<?php

/**
 * Mail wrapper 
 */
class Mailer {

    /**
     * Send email 
     * @param type $from
     * @param type $to
     * @param type $subject
     * @param string $message
     * @return boolean 
     */
    public static function send($from, $to, $subject, $message, $is_html = true, $reply_to = null) {

        $headers = "From: " . $from . "\r\n";
        if ($reply_to) {
            $headers .= "Reply-To: " . $reply_to . "\r\n";
        }

        $headers .= "Return-Path: <" . MAIL_BOUNCE . ">\r\n";
        $headers .= "X-Sender: " . MAIL_BOUNCE . "\r\n";
        $headers .= "X-PHP-Originating-Script: 0:main.inc\r\n";
        $headers .= "X-Mailer: PHP\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: " . ($is_html ? 'text/html' : 'text/plain' ) . " ; charset=UTF-8\r\n";
        if ($bcc) {
            $headers .= "Bcc: $bcc\r\n";
        }
        $message = $is_html ? "<html><head><title>" . $subject . "</title></head><body>" . $message . "</body></html>" : $message;

        if (mail($to, $subject, $message, $headers, '-f' . MAIL_BOUNCE)) {
            return true;
        } else {
            return false;
        }
    }

}

?>