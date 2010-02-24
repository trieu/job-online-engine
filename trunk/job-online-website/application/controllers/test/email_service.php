<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 * @property CI_Email $email
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class email_service extends Controller {
    public function __construct() {
        parent::Controller();
    }

    /**
     * @Decorated
     */
    public function index() {
        $this->load->library('email');

        $this->email->clear();
        $this->email->set_newline("\r\n");

        //$this->email->from('tantrieuf31.database@gmail.com', 'Trieu');
        $this->email->from('tantrieuf31@gmail.com', 'tantrieuf31');
        $this->email->to('tantrieuf31.database@gmail.com');


        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->attach("assets/images/ajax-loader.gif");

        if ( ! $this->email->send()) {
            echo "send Fail!";
            echo $this->email->print_debugger();
            return;
        }
        echo $this->email->print_debugger();
        echo "send OK!";
    }

    public function get_mails() {
        /* connect to gmail */
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'tantrieuf31.database@gmail.com';
        $password = 'Mycatisfat@31';

        /* try to connect */
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

        /* grab emails */
        $emails = imap_search($inbox,'ALL');

        /* if emails are returned, cycle through each... */
        if($emails) {

            /* begin output var */
            $output = '';

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach($emails as $email_number) {

                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox,$email_number,0);
                $message = imap_fetchbody($inbox,$email_number,2);
                $mail_header = imap_headerinfo($inbox, $email_number);
                //   print_r($mail_header);

                /* output the email header information */
                $output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
                $output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
                $output.= '<span class="from">'.$overview[0]->from.'</span>';
                $output.= '<span class="date">on '.$overview[0]->date.'</span>';
                $output.= '</div>';

                /* output the email body */
                $output.= '<div class="body">'.'</div>';

                $attachments  = $this->extract_attachments($inbox, $email_number);
                //   echo "<br>";echo "<br>";
                //print_r($attachments);
                foreach ($attachments as $id => $attachment) {
                    //$this->downloadFile(".gif", $attachment['filename'], $attachment['attachment']);

                    if($attachment["is_attachment"]) {
                        //echo  "<h1>".$attachment["name"]."</h1>";
                        //$this->downloadFile($attachment['name'], $attachment['attachment']);
                        $this->writeFile($attachment['name'], $attachment['attachment']);
                        break;
                    }
                    //  print_r($attachment);
                    // echo "<br>";

                    // break;
                }


                // echo "<br>";


            }

            // echo $output;
        }

        /* close the connection */
        imap_close($inbox);
    }

    protected function extract_attachments($connection, $message_number) {

        $attachments = array();
        $structure = imap_fetchstructure($connection, $message_number);

        if(isset($structure->parts) && count($structure->parts)) {

            for($i = 0; $i < count($structure->parts); $i++) {

                $attachments[$i] = array(
                        'is_attachment' => false,
                        'filename' => '',
                        'name' => '',
                        'attachment' => ''
                );

                if($structure->parts[$i]->ifdparameters) {
                    foreach($structure->parts[$i]->dparameters as $object) {
                        if(strtolower($object->attribute) == 'filename') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if($structure->parts[$i]->ifparameters) {
                    foreach($structure->parts[$i]->parameters as $object) {
                        if(strtolower($object->attribute) == 'name') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if($attachments[$i]['is_attachment']) {
                    $attachments[$i]['attachment'] = imap_fetchbody($connection, $message_number, $i+1);
                    if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }
        return $attachments;
    }


    function downloadFile($strFileName,$fileContent) {
        $strFileType = substr($strFileName, strrpos($strFileName, '.') + 1);
        $ContentType = "application/octet-stream";

        if ($strFileType == ".asf")
            $ContentType = "video/x-ms-asf";
        if ($strFileType == ".avi")
            $ContentType = "video/avi";
        if ($strFileType == ".doc")
            $ContentType = "application/msword";
        if ($strFileType == ".zip")
            $ContentType = "application/zip";
        if ($strFileType == ".xls")
            $ContentType = "application/vnd.ms-excel";
        if ($strFileType == ".gif")
            $ContentType = "image/gif";
        if ($strFileType == ".jpg" || $strFileType == "jpeg")
            $ContentType = "image/jpeg";
        if ($strFileType == ".wav")
            $ContentType = "audio/wav";
        if ($strFileType == ".mp3")
            $ContentType = "audio/mpeg3";
        if ($strFileType == ".mpg" || $strFileType == "mpeg")
            $ContentType = "video/mpeg";
        if ($strFileType == ".rtf")
            $ContentType = "application/rtf";
        if ($strFileType == ".htm" || $strFileType == "html")
            $ContentType = "text/html";
        if ($strFileType == ".xml")
            $ContentType = "text/xml";
        if ($strFileType == ".xsl")
            $ContentType = "text/xsl";
        if ($strFileType == ".css")
            $ContentType = "text/css";
        if ($strFileType == ".php")
            $ContentType = "text/php";
        if ($strFileType == ".asp")
            $ContentType = "text/asp";
        if ($strFileType == ".pdf")
            $ContentType = "application/pdf";

        header ("Content-Type: $ContentType");
        header ("Content-Disposition: attachment; filename=$strFileName; ");

        // Updated oktober 29. 2005
        if (substr($ContentType,0,4) == "text") {
            echo ($fileContent);
        } else {
            echo ($fileContent);
        }
    }

    function writeFile($fileName, $data) {
        $Handle = fopen($fileName, 'w');
        fwrite($Handle, $data);
        fclose($Handle);
    }

}
?>
