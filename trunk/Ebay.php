<?php

class Ebay
{
    private $_client;
    private $_session;
    private $_transport;

    public function GetClientAlertsAuthToken()
    {
        $client = $this->_getClient();
        $client->call("GetClientAlertsAuthToken");

        if ($client->getResponseCode() == Ebay_Client::CALL_SUCCESS) {
            $response = $client->getResponseXml();
            return $response->ClientAlertsAuthToken;
        }

        return false;
    }

    public function GetEbayOfficialTime()
    {
        $client = $this->_getClient();
        $client->call("GeteBayOfficialTime");

        if ($client->getResponseCode() == Ebay_Client::CALL_SUCCESS) {
            $response = $client->getResponseXml();
            return $response->Timestamp;
        }

        return false;
    }

    public function setSession(Ebay_Session $session)
    {
        $this->_session = $session;
    }

    public function setTransport(Ebay_Transport_Interface $transport)
    {
        $this->_transport = $transport;
    }

    private function _getClient()
    {
        if ($this->_client == null) {
            $this->_client = new Ebay_Client($this->_session, $this->_transport);
        }

        return $this->_client;
    }
}