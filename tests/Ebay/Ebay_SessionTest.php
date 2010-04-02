<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../Ebay/Session.php';

/**
 * Test class for Ebay_Session.
 */
class Ebay_SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Ebay_Session
     */
    protected $_session;
    protected $_config;

    protected function setUp()
    {
        $this->_session = new Ebay_Session;

        $this->_config = array(
            'api' => array(
                'version' => 661
            ),
            'sandbox' => array(
                'dev-key' => '210dc166-01d7-4ab1-9f65-a1262283411b',
                'app-key' => 'RBS7b9bb0-0cfc-4dd5-a8ed-02c1c2c9e45',
                'cert-id' => 'fc9a6d13-c4a6-41b4-b269-4ad665375160',
                'token' => 'AgAAAA**AQAAAA**aAAAAA**y9isSw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoAJCEqAudj6x9nY+seQ**/0oBAA**AAMAAA**Qk2b4wo/Z1wjPzNNxXI44gTQ4CUspUTN2fRQQBZ/l2su/++UOJpANKCiIfhluEk/49E9kkXYUFv8qhtbu9KKMtzuD9Gdo1XdyClW9f6YpAFuVABDpSp7bLru+51azscqAXAHodnMalwoJYT2ndvDGk7akFPijd6a70ifKOH3hE+ieQdj67lP/qDCfu95/2xVcvajYMn9IPQnjBbjrkqsTNBqLgpInWArhsDXPYAZ19tnsuvCGALSgzpzdoflz002JClX2Rjd6buIDhlfos9ttU3xsiLzk79m6MpJWuVJO0aEgq/wIMt3Zkt0EDa8xnKHQAyEjp8qflg5kWZlioTTCptGiggKkBFaRx4EaPh8EEN0DfiHp4F0uZ1SNBcr7C79oUegtT069WOMif56tmWNQPvYxvVrLDtcEUhImWh55C4Rs0scT5OXeAzy1p8hVsTiql+cSfIkRsVxYl3s60yLfNjtpFfikAofwnVrop/EWPRtoa4G7AYBohH5l/KbV4lvw4X+xey5Ay5hfqZq9paMDuOBkG34CTr3YWYf5sLgoQ2NBEX9zpYERJsqQBM+qkENU6s2qUxjUo9R9HlbLfsSKO8MOtEz/FDUl2iv6sN6X7i72yDDrHWS2XGQZzhkBHuXohkzbABurCPbgRwzmRvjyd5hXotQtxMAgwy3yIMqpfJWzz+b5uGSlcyvKwqD40A71n8SqjfoymYgGXzWYquwDLHAMDYdrriPMwuIVif7T4b43wbj2H4lxCDOshk4C1Xi'
            ),
            'production' => array(
                'dev-key' => 'dummy-dev',
                'app-key' => 'dummy-app',
                'cert-id' => 'dummy-cert',
                'token' => 'dummy-token'
            )
        );
    }

    public function testInitializationOfSandboxWorks()
    {
        $this->_session->setConfig($this->_config);
        $this->_session->init();

        $this->assertEquals(661, $this->_session->getApiVersion());
        $this->assertEquals(true, $this->_session->getUseSandbox());

        $this->assertEquals('210dc166-01d7-4ab1-9f65-a1262283411b', $this->_session->getDevKey());
        $this->assertEquals('RBS7b9bb0-0cfc-4dd5-a8ed-02c1c2c9e45', $this->_session->getAppKey());
        $this->assertEquals('fc9a6d13-c4a6-41b4-b269-4ad665375160', $this->_session->getCertId());
    }

    public function testInitializationOfProductionWorks()
    {
        $this->_session->setConfig($this->_config);
        $this->_session->setUseSandbox(false);
        $this->_session->init();

        $this->assertEquals(661, $this->_session->getApiVersion());
        $this->assertEquals(false, $this->_session->getUseSandbox());
        
        $this->assertEquals('dummy-dev', $this->_session->getDevKey());
        $this->assertEquals('dummy-app', $this->_session->getAppKey());
        $this->assertEquals('dummy-cert', $this->_session->getCertId());
    }

    public function testApiModeChangeSwitchesSandbox()
    {
        $this->_session->setConfig($this->_config);
        $this->_session->init();

        $this->assertEquals(true, $this->_session->getUseSandbox());
        $this->assertEquals('210dc166-01d7-4ab1-9f65-a1262283411b', $this->_session->getDevKey());
        $this->assertEquals('RBS7b9bb0-0cfc-4dd5-a8ed-02c1c2c9e45', $this->_session->getAppKey());
        $this->assertEquals('fc9a6d13-c4a6-41b4-b269-4ad665375160', $this->_session->getCertId());
        
        $this->_session->setUseSandbox(false);
        $this->_session->init();

        $this->assertEquals(false, $this->_session->getUseSandbox());
        $this->assertEquals('dummy-dev', $this->_session->getDevKey());
        $this->assertEquals('dummy-app', $this->_session->getAppKey());
        $this->assertEquals('dummy-cert', $this->_session->getCertId());
    }
}