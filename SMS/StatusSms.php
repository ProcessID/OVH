<?php
/*
   // Récupération du statut d'un SMS avec l'API d'OVH
   // -------------------
   // -- Instanciation --
   // -------------------
   $donnees = array();
   $donnees['applicationKey'] = 'xxxxx';
   $donnees['applicationSecret'] = 'xxxxx';
   $donnees['consumerKey'] = 'xxxxx';
   $donnees['endPoint'] = 'ovh-eu';
   $donnees['serviceName'] = 'sms-xxxxxx-1';
   $statusSMS = new StatusSms($donnees);
   
   $result = $statusSMS->status(<broker_id>);
   
   // Pour générer sApplicationKey, sApplicationSecret et sConsumerKey, il faut se rendre sur https://eu.api.ovh.com/createToken/
   // Il faut saisir NIC-Handle et mot de passe du compte OVH, le nom du script, sa description, une période de validité et les droits suivants:
   // GET /sms/
   // GET /sms/*
   // POST /sms/*
   // Caractères autorisés : https://en.wikipedia.org/wiki/GSM_03.38
   
*/   
   namespace processid\ovh\SMS;
   
   use processid\ovh\SendRest;
   
   class StatusSms extends SendRest {
      
      protected $serviceName;
      
      function serviceName() { return $this->serviceName; }
      
      function setServiceName($serviceName) {
         $this->serviceName = $serviceName;
      }
      
      function status($id) {
         $this->setBody($param);
         $this->setMethod('GET');
         $this->setApi($this->api().$id);
         $result = $this->api_call();
         if ($result) {
             return $this->result();
         } else {
             return false;
         }
      }
      
      function __construct($donnees) {
         parent::__construct($donnees);
         $this->setApi("/1.0/sms/" . $this->serviceName() . "/outgoing/");
      }
   }
?>
