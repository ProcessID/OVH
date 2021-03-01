<?php
    namespace processid\ovh;

    class SendRest {
        use \processid\traits\Hydrate;

        protected $applicationKey;
        protected $applicationSecret;
        protected $consumerKey;
        protected $endPoint;
        protected $api;
        protected $method;
        protected $url;
        protected $body;
        protected $result;

        function __construct($donnees) {
            $this->hydrate($donnees);
        }

        function applicationKey() { return $this->applicationKey; }
        function applicationSecret() { return $this->applicationSecret; }
        function consumerKey() { return $this->consumerKey; }
        function endPoint() { return $this->endPoint; }
        function api() { return $this->api; }
        function method() { return $this->method; }
        function url() { return $this->url; }
        function body() { return $this->body; }
        function result() { return $this->result; }

        function setApplicationKey($applicationKey) { $this->applicationKey = $applicationKey; }
        function setApplicationSecret($applicationSecret) { $this->applicationSecret = $applicationSecret; }
        function setConsumerKey($consumerKey) { $this->consumerKey = $consumerKey; }

        function setEndPoint($endPoint) {
            $url = '';

            switch ($endPoint) {
                case 'ovh-ca' : $url = 'https://ca.api.ovh.com'; break;
                case 'soyoustart-eu' : $url = 'https://eu.api.soyoustart.com'; break;
                case 'soyoustart-ca' : $url = 'https://ca.api.soyoustart.com'; break;
                case 'kimsufi-eu' : $url = 'https://eu.api.kimsufi.com'; break;
                case 'kimsufi-ca' : $url = 'https://https://ca.api.kimsufi.com'; break;
                case 'runabove-ca' : $url = 'https://api.runabove.com'; break;
                default : $url = 'https://eu.api.ovh.com'; break; // ovh-eu
            }

            $this->endPoint = $endPoint;
            $this->setUrl($url);

        }

        function setApi($api) { $this->api = $api; }
        function setMethod($method) { $this->method = $method; }
        function setUrl($url) { $this->url = $url; }
        function setBody($body) { $this->body = $body; }
        function setResult($result) { $this->result = $result; }

        function api_call() {
            $BodyJson = json_encode($this->body());
            $timestamp = time();
            $url = $this->url() . $this->api();

            $ToSign = $this->applicationSecret() . '+' . $this->consumerKey() . '+' . $this->method() . '+' . $url . '+' . $BodyJson . '+' . $timestamp;
            $Signature = '$1$' . (strtolower(str_replace(array("\r\n", "\n", "\r", " "), '', bin2hex(hash('sha1', $ToSign, true)))));
            $opts = array(
                'http'=>array(
                    'method'=>$this->method(),
                    'header'=>'Content-type: application/json'. "\r\n"
                    . 'X-Ovh-Application: ' . $this->applicationKey() . "\r\n"
                    . 'X-Ovh-Consumer: ' . $this->consumerKey() . "\r\n"
                    . 'X-Ovh-Signature: ' .$Signature . "\r\n"
                    . 'X-Ovh-Timestamp: ' .$timestamp . "\r\n",
                    'content'=>$BodyJson,
                )
            );

            $context = stream_context_create($opts);

            $result = file_get_contents($url,false,$context);

            if ($result == false) {
                trigger_error('Erreur lors de l\'appel a l\'API OVH classe : ' . __CLASS__,E_USER_NOTICE);
                return false;
            } else {
                $this->setResult($result);
            }
            return true;
        }

    }
?>