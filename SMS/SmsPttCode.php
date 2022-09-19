<?php
/*
// Récupération du code PTT d'un SMS avec l'API d'OVH
// -------------------
// -- Instanciation --
// -------------------
$donnees = array();
$donnees['applicationKey'] = 'xxxxx';
$donnees['applicationSecret'] = 'xxxxx';
$donnees['consumerKey'] = 'xxxxx';
$donnees['endPoint'] = 'ovh-eu';
$donnees['serviceName'] = 'sms-xxxxxx-1';
$SmsRate = new SmsRate($donnees);

if ($SmsPttCode->pttCode(<code ptt>) {
echo $SmsPttCode->result();
} else {
echo ('Erreur lors de la récupération du code PTT');
}

// Pour générer sApplicationKey, sApplicationSecret et sConsumerKey, il faut se rendre sur https://eu.api.ovh.com/createToken/
// Il faut saisir NIC-Handle et mot de passe du compte OVH, le nom du script, sa description, une période de validité et les droits suivants:
// GET /sms/ptts

*/   
    namespace processid\ovh\SMS;

    use processid\ovh\SendRest;

    class SmsPttCode extends SendRest {

        protected $serviceName;

        function serviceName() { return $this->serviceName; }

        function setServiceName($serviceName) {
            $this->serviceName = $serviceName;
        }

        function pttCode($code) {
            $this->setMethod('GET');
            $this->setApi('/1.0/sms/ptts/'.$code);
            return $this->api_call();
        }

        function __construct($donnees) {
            parent::__construct($donnees);
        }
    }
?>
