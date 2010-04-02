<?php

require_once 'Ebay.php';
require_once 'Ebay/Client.php';
require_once 'Ebay/Session.php';
require_once 'Ebay/Exception.php';
require_once 'Ebay/Transport/Curl.php';

$session = new Ebay_Session('config.ini');
$session->setSiteId(0);
$session->init();

$transport = new Ebay_Transport_Curl();

$ebay = new Ebay();
$ebay->setSession($session);
$ebay->setTransport($transport);

echo "<h2>Client Alerts Auth Token</h2>";
echo "<p>" . $ebay->GetClientAlertsAuthToken() . "</p>";