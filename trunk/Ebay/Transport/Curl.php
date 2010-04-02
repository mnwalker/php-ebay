<?PHP

include_once "Interface.php";

/**
 * Transport/Curl.php
 *
 * Send a request via Curl
 *
 * @package  Ebay
 * @author   Emran Hasan <phpfour@gmail.com>
 */
class Ebay_Transport_Curl implements Ebay_Transport_Interface
{
   /**
    * send a request
    *
    * @access   public
    * @param    string  uri to send data to
    * @param    string  body of the request
    * @param    array   headers for the request
    * @return   mixed   either
    */
    public function sendRequest($url, $headers, $body, $method = 'POST')
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->_createHeaders($headers));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        
        $result = curl_exec($curl);
        
        if ($result === false) {
            throw new Ebay_Exception(curl_error( $curl ));
        }
        
        return $result;
    }

   /**
    * Create the correct header syntax used by curl
    *
    * @param    array       headers as supplied 
    * @return   array       headers as needed by curl
    */
    private function _createHeaders( $headers )
    {
        $tmp = array();

        foreach ($headers as $key => $value) {
            array_push($tmp, "$key: $value");
        }

        return $tmp;
    }
}