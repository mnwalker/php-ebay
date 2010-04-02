<?php

class Ebay_Session
{
    const API_ENDPOINT = 'https://api.ebay.com/ws/api.dll';
    const API_ENDPOINT_SANDBOX = 'https://api.sandbox.ebay.com/ws/api.dll';

    private $config;
    
    private $devKey;
    private $appKey;
    private $certId;
    private $token;

    private $apiVersion;
    private $endPoint;
    private $siteId;
    private $useSandbox = true;

    public function  __construct($configFile = null)
    {
        if ($configFile && file_exists($configFile)) {
            $this->config = parse_ini_file($configFile, true);
        }
    }

    public function init()
    {
        $this->setApiVersion($this->config['api']['version']);
        
        if ($this->getUseSandbox()) {

            $this->setKeys($this->config['sandbox']);
            $this->setToken($this->config['sandbox']['token']);
            $this->setEndPoint(Ebay_Session::API_ENDPOINT_SANDBOX);

        } else {

            $this->setKeys($this->config['production']);
            $this->setToken($this->config['production']['token']);
            $this->setEndPoint(Ebay_Session::API_ENDPOINT);

        }
    }

    public function setKeys(array $keys)
    {
        if (!array_key_exists('dev-key', $keys) || !array_key_exists('app-key', $keys) || !array_key_exists('cert-id', $keys)) {
            throw new Ebay_Exception("All three keys must be provided to create a successful session.");
        }

        $this->devKey = $keys['dev-key'];
        $this->appKey = $keys['app-key'];
        $this->certId = $keys['cert-id'];
    }

    public function setToken($token)
    {
        if (empty($token)) {
            throw new Ebay_Exception("Token must be provided to create a successful session.");
        }

        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getDevKey() {
        return $this->devKey;
    }

    public function setDevKey($devKey) {
        $this->devKey = $devKey;
    }

    public function getAppKey() {
        return $this->appKey;
    }

    public function setAppKey($appKey) {
        $this->appKey = $appKey;
    }

    public function getCertId() {
        return $this->certId;
    }

    public function setCertId($certId) {
        $this->certId = $certId;
    }

    public function getApiVersion() {
        return $this->apiVersion;
    }

    public function setApiVersion($apiVersion) {
        $this->apiVersion = $apiVersion;
    }

    public function getEndPoint() {
        return $this->endPoint;
    }

    public function setEndPoint($endPoint) {
        $this->endPoint = $endPoint;
    }

    public function getSiteId() {
        return $this->siteId;
    }

    public function setSiteId($siteId) {
        $this->siteId = $siteId;
    }

    public function getConfig() {
        return $this->config;
    }

    public function setConfig($config) {
        $this->config = $config;
    }
    
    public function getUseSandbox() {
        return $this->useSandbox;
    }

    public function setUseSandbox($useSandbox) {
        $this->useSandbox = $useSandbox;
    }
}