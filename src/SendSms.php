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
 * $send_sms = new SendSms($app, $url, $user, $token, $pass, $operation, $phone, $message);
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
    protected $app;
    protected $phone;
    protected $message;
    protected $result;
    protected $result_message;
    protected $operation;

    public $auth_user;
    public $auth_pass;
    public $auth_token;
    public $service_url;

    /**
     * SMS kuldes
     *
     * SendSms constructor.
     * @param $app
     * @param $service_url
     * @param $auth_user
     * @param $sms_auth_token
     * @param $auth_pass
     * @param $operation
     * @param $phone
     * @param $message
     */
    public function __construct($app, $service_url, $auth_user, $sms_auth_token, $auth_pass, $operation, $phone, $message)
    {
        $this->app = $app;
        $this->service_url = $service_url;
        $this->auth_user = $auth_user;
        $this->auth_token = $sms_auth_token;
        $this->auth_pass = $auth_pass;
        $this->operation = $operation;
        $this->message = $message;

        if(is_array($phone)){
            $this->phone = implode(',', $phone);
        }else{
            $this->phone = $phone;
        }

        $params = [
            'app' => $this->app,        // app
            'u' => $this->auth_user,    // username
            'h' => $this->auth_token,   // webservices token, configured by user from Preferences menu
            'p' => $this->auth_pass,    // password, supplied for op=get_token
            'op' => $this->operation,   // operation or type of action
            'to' => $this->phone,       // destination numbers, @username or #groupcode, may use commas
            'msg' => $this->message,    // message (+ or %20 for spaces, urlencode for non ascii chars)
        ];

        $curl        = new Curl();
        try {
            $response = $curl
                ->setOption( CURLOPT_FOLLOWLOCATION, true )
                ->setOption( CURLOPT_SSL_VERIFYPEER, false )
                ->setGetParams(
                    $params
                )
                ->get( $this->service_url );

            $json = json_decode($response);

            if (isset($json->status)) $this->result_message = $json->status;
            if (isset($json->error)) $this->result = $json->error_string;

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