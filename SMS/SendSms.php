<?php
/*
   // Envoi d'un SMS avec l'API d'OVH
   // -------------------
   // -- Instanciation --
   // -------------------
   $donnees = array();
   $donnees['applicationKey'] = 'xxxxx';
   $donnees['applicationSecret'] = 'xxxxx';
   $donnees['consumerKey'] = 'xxxxx';
   $donnees['endPoint'] = 'ovh-eu';
   $donnees['serviceName'] = 'sms-xxxxxx-1';
   $sendSMS = new SendSms($donnees);
   
   $Sms_jobs = array();
   $Sms_jobs['charset'] = "UTF-8";
   $Sms_jobs['coding'] = "7bit"; // 7bit (default) | 8bit
   $Sms_jobs['class'] = "phoneDisplay"; // phoneDisplay (default) | flash | sim | toolkit
   $Sms_jobs['sender'] = "xxxxx";
   $Sms_jobs['receivers'] = array();
   $Sms_jobs['receivers'][] = "+33xxxxxxxxx";
   $Sms_jobs['message'] = "Test SMS OVH";
   $Sms_jobs['priority'] = "high";
   $Sms_jobs['senderForResponse'] = False;
   $Sms_jobs['noStopClause'] = True;
   if ($sendSMS->send($Sms_jobs)) {
      echo $sendSMS->result();
   } else {
      echo ('Erreur lors de l\'envoi du SMS');
   }
   
   // Pour générer sApplicationKey, sApplicationSecret et sConsumerKey, il faut se rendre sur https://eu.api.ovh.com/createToken/
   // Il faut saisir NIC-Handle et mot de passe du compte OVH, le nom du script, sa description, une période de validité et les droits suivants:
   // GET /sms/
   // GET /sms/* /jobs/
   // POST /sms/* /jobs/
   // Caractères autorisés : https://en.wikipedia.org/wiki/GSM_03.38
   
*/   
   namespace ProcessID\OVH\SMS;
   
   use ProcessID\OVH\SendRest;
   
   class SendSms extends SendRest {
      
      protected $serviceName;
      
      function serviceName() { return $this->serviceName; }
      
      function setServiceName($serviceName) {
         $this->serviceName = $serviceName;
      }
      
      function send($param) {
         $this->setBody($param);
         $this->setMethod('POST');
         return $this->api_call();
      }
      
      function __construct($donnees) {
         parent::__construct($donnees);
         $this->setApi("/1.0/sms/" . $this->serviceName() . "/jobs");
      }
   }
?>
