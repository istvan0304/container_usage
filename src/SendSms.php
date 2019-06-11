<?php

namespace attek\usage;

use Exception;
use linslin\yii2\curl\Curl;
use Yii;

/**
 * For Sms REST API
 * @author PEAXAAP.PTE
 * 
 * Example
 * $send_sms = new SendSms($phone, $message, 0);
 *
* if ($send_sms->getResult()) {
 *
* //do somehting stuff....
 *
* } else {
 *
* echo $send_sms->getResultMessage();
 *
* }
 *
 */
class SendSms
{
    
    protected $phone;
    protected $message;
    protected $result;
    protected $result_message;
    protected $processed;
    
    public $auth_user;
    public $auth_pass;
    public $service_url;

    /**
     * SMS kuldes, $processed alapesetben 1-es, igy kikkuldes nincs csak adatbazisba rogzites
     *
     * @param string $service_url
     * @param string $auth_user
     * @param string $auth_pass
     * @param string $phone
     * @param string $message
     * @param int|number $processed
     */
    public function __construct($service_url, $auth_user, $auth_pass, $phone, $message, $processed = 1)
    {
        
        $this->service_url = $service_url;
        $this->auth_user = $auth_user;
        $this->auth_pass = $auth_pass;
        $this->phone = $phone;
        $this->message = $message;
        $this->processed = $processed;
        
        $params = [
            'phone' => $this->phone,
            'message' => $this->message,
            'processed' => $this->processed,
        ];

        $curl        = new Curl();
        try {
            $response = $curl
                ->setOption( CURLOPT_FOLLOWLOCATION, true )
                ->setOption( CURLOPT_SSL_VERIFYPEER, false )
                ->setHeaders( [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode( $this->auth_user . ':' . $this->auth_pass )
                ] )
                ->setGetParams(
                    $params
                )
                ->get( $this->service_url );
            $json = json_decode($response);


            if (isset($json->message)) $this->result_message = $json->message;
            if (isset($json->success)) $this->result = $json->success;

        } catch ( Exception $e ) {
            Yii::error('SMS send error: ' . $e->getMessage());
        }
    }

    public function getPhone()
    {
        return $this->phone;
    }
    
    public function setPhone($phone)
    {
        return $this->phone = $phone;
    }
    
    public function getMessage()
    {
        return $this->message; 
    }
    
    public function setMessage($message)
    {
        return $this->message = $message;
    }
    
    /**
     * Get return from sms API
     * @return boolean
     */
    public function getResult()
    {
        return $this->result;
    }
    
    public function setResult($result)
    {
        return $this->result = $result;
    }
    
    /**
     * Get return message from sms API
     * @return string 
     */
    public function getResultMessage()
    {
        return $this->result_message;
    }
    
    public function setResultMessage($result_message)
    {
        return $this->result_message = $result_message;
    }
}