<?php
/**
 * Mail wrapper 
 */
class Mailer{
    /**
     * Send email 
     * @param type $from
     * @param type $to
     * @param type $subject
     * @param string $message
     * @return boolean 
     */
    public static function send($from,$to, $subject, $message) {

        $headers = "From: ".$from."\r\n";
        $headers .= "Reply-To: ".$from."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $message = "<html><head><title>".$subject."</title></head><body>".$message."</body></html>";
        
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }
}
?>