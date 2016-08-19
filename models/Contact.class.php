<?php

    class Contact extends basesql {

        protected $email;
        protected $subject;
        protected $message;


        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = htmlspecialchars($email);
        }

        public function getSubject(){
            return $this->subject;
        }

        public function setSubject($subject){
            $this->subject = htmlspecialchars($subject);
        }

        public function getMessage(){
            return $this->message;
        }

        public function setMessage($message){
            $this->message = htmlspecialchars($message);
        }

        protected $columns = [
        ];

        public function sendEmail() {
            try {
                require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
            } catch(Execption $e) {
                die("Unable to load phpmailer : ".$e->getMessage());
            }
            $mail = new PHPMailer();

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'testmail3adw@gmail.com';                 // SMTP username
            $mail->Password = 'test3ADW';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom($this->email, $this->email);
            $mail->addAddress("lambot.rom@gmail.com");     // Add a recipient
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $this->subject;

                $mail->Body    = $this->message;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                //$mail->send();
                if(!$mail->send()) {
                    echo "<span class='info'> Message could not be sent. </span>";
                    echo "<span class='info'> Mailer Error: " . $mail->ErrorInfo ."</span>";
                    return FALSE;
                } else {
                    return TRUE;
                }

        }


        public function getForm(){

        $form = [
          "title" => "Nouveau ticket",
          "buttonTxt" => "Nous contacter",
          "options" => ["method" => "POST", "action" => WEBROOT . "contact/sendMail"],
          "struct" => [
            "Sujet"=>[ "type"=>"text", "class"=>"form-control", "required"=>1,"placeholder"=>"Sujet", "msgerror"=>"subject"],
            "Email"=>["type"=>"email","class"=>"form-control", "required"=>1,"placeholder"=>"Email",  "msgerror"=>"email"],
            "message"=>[ "type"=>"textarea", "class"=>"form-control ", "required"=>1,"placeholder"=>"Message",  "msgerror"=>"message"],
            "form-type" => ["type" => "hidden", "value" => "subscription", "placeholder" => "", "required" => 0, "msgerror" => "hidden input", "class" => ""
            ]
          ]
        ];

        return $form;
      }

    }

?>
