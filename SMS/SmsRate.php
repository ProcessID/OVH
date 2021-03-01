<?php
/*
// Récupération du prix d'envoi d'un SMS avec l'API d'OVH
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

if ($SmsRate->rate($billingCountry,$country)) {
echo $SmsRate->result();
} else {
echo ('Erreur lors de la récupération du prix d\'envoi d\'un SMS');
}

// $billingCountry est le pays de facturation
// $country est le pays vers lequel le SMS doit être envoyé
// Ces 2 valeurs doivent être au format ISO 2 caractères

// Pour générer sApplicationKey, sApplicationSecret et sConsumerKey, il faut se rendre sur https://eu.api.ovh.com/createToken/
// Il faut saisir NIC-Handle et mot de passe du compte OVH, le nom du script, sa description, une période de validité et les droits suivants:
// GET /sms/rates/destinations

*/   
    namespace processid\ovh\SMS;

    use processid\ovh\SendRest;

    class SmsRate extends SendRest {

        protected $serviceName;

        function serviceName() { return $this->serviceName; }

        function setServiceName($serviceName) {
            $this->serviceName = $serviceName;
        }

        function rate($billingCountry,$country) {
            $this->setMethod('GET');
            $this->setApi('/1.0/sms/rates/destinations?billingCountry='.strtolower($billingCountry).'&country='.strtolower($country));
            return $this->api_call();
        }

        function __construct($donnees) {
            parent::__construct($donnees);
        }
    }
?>
