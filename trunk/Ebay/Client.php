<?php

class Ebay_Client
{
    const CALL_SUCCESS = 'Success';
    const CALL_FAILURE = 'Failure';
    
    private $_session;
    private $_transport;
    private $_headers;
    private $_body;

    private $_responseBody;
    private $_responseCode;
    private $_responseXml;

    public function __construct(Ebay_Session $session, Ebay_Transport_Interface $transport)
    {
        $this->_session = $session;
        $this->_transport = $transport;
    }

    public function call($method, $params = array())
    {
        $this->_prepareHeaders($method);
        $this->_prepareBody($method, $params);
        $this->_makeRequest();
        $this->_pareseResponse();
    }

    private function _prepareHeaders($method)
    {
        $this->_setHeader('X-EBAY-API-DEV-NAME', $this->_session->getDevKey());
        $this->_setHeader('X-EBAY-API-APP-NAME', $this->_session->getAppKey());
        $this->_setHeader('X-EBAY-API-CERT-NAME', $this->_session->getCertId());

        $this->_setHeader('X-EBAY-API-CALL-NAME', $method);
        $this->_setHeader('X-EBAY-API-SITEID', $this->_session->getSiteId());
        $this->_setHeader('X-EBAY-API-COMPATIBILITY-LEVEL', $this->_session->getApiVersion());
    }

    private function _prepareBody($method, $params = array())
    {
        $requestType = $method . 'Request';

        $this->_body  = '<?xml version="1.0" encoding="utf-8"?>';
        $this->_body .= '<' . $requestType . ' xmlns="urn:ebay:apis:eBLBaseComponents">';
        $this->_body .= '<RequesterCredentials>';
        $this->_body .= '<eBayAuthToken>' . $this->_session->getToken() . '</eBayAuthToken>';
        $this->_body .= '</RequesterCredentials>';
        $this->_body .= '</' . $requestType . '>';
    }

    private function _makeRequest()
    {
        $this->_responseBody = $this->_transport->sendRequest($this->_session->getEndPoint(), $this->_headers, $this->_body);
    }

    private function _pareseResponse()
    {
        $this->_responseXml = simplexml_load_string($this->_responseBody);
        $this->_responseCode = (string) $this->_responseXml->Ack;
    }

    private function _setHeader($key, $value)
    {
        $this->_headers[$key] = $value;
    }

    public function getResponseCode()
    {
        return $this->_responseCode;
    }

    public function getResponseBody()
    {
        return $this->_responseBody;
    }

    public function getResponseXml()
    {
        return $this->_responseXml;
    }

}