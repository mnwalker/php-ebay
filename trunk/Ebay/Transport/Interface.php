<?php

interface Ebay_Transport_Interface
{
    public function sendRequest($url, $headers, $body, $method = 'POST');
}