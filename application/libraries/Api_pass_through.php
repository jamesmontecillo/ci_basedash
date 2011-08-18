<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of apiPassThroughClass
 *
 * @author jmsmontecillo
 */

class Api_pass_through {

    var $command;
    //a preshared secret between remotelink, and the PI, to allow access
    var $hmacSecretKey = "594e4677334d4f2d35733a685f504231756f326c294a2c2536743d363c3e7c3e5a2f4e5873793d4a4d6679236e2a54663b797825326e3e6568256d4b70292b4f";
    var $hash;
    var $nonce; //a random byte String to skew the HMAC algoritm
    var $CI;

    /**
     *
     * @param type $command 
     */
    function Api_pass_through($command) {
        
        $this->CI =& get_instance();
        
        $this->command = $command['command'];
        $length = 5;
        $crypto_strong = false;
        $this->nonce = bin2hex(openssl_random_pseudo_bytes($length, $crypto_strong));

        $hmacSecretKey = "594e4677334d4f2d35733a685f504231756f326c294a2c2536743d363c3e7c3e5a2f4e5873793d4a4d6679236e2a54663b797825326e3e6568256d4b70292b4f";
        $secretBytes = $this->hex2bin($hmacSecretKey);

        $msg = $command . ":" . $this->nonce;
        $this->hash = hash_hmac('sha256', $msg, $secretBytes);
        
    }

    /**
     *
     * @param type $username
     * @param type $password
     * @return type 
     */
    function validateLogin($username, $password) {
        $requestBody = '&username=' . $username . '&password=' . $password . '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }

    /**
     *
     * @param type $email
     * @param type $callback
     * @return type 
     */
    function forgotPassword($email, $callback) {
        $requestBody = '&email_address=' . $email . '&callback=' . $callback . '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }

    /**
     *
     * @param type $new_password
     * @param type $apikey
     * @return type 
     */
    function forgotPasswordReset($new_password, $apikey) {
        $requestBody = '&token=' . $apikey . '&new_password=' . $new_password . '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }

    /**
     *
     * @param type $username
     * @param type $password
     * @param type $basecamp_apikey
     * @param type $basecamp_url
     * @return type 
     */
    function initializeSystem($username, $password, $basecamp_apikey, $basecamp_url) {
        $requestBody = '&username=' . $username . '&password=' . $password .
                '&basecamp_apikey=' . $basecamp_apikey . '&basecamp_url=' . $basecamp_url .
                '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }

    /**
     *
     * @param type $first_name
     * @param type $last_name
     * @param type $billing_address
     * @param type $billing_city
     * @param type $billing_state
     * @param type $billing_zip
     * @param type $billing_phone
     * @param type $billing_email
     * @param type $cc_number
     * @param type $cc_exp_month
     * @param type $cc_exp_year
     * @param type $username
     * @param type $password
     * @param type $promo_code
     * @return type 
     */
    function createAccount($first_name, $last_name, $billing_address, $billing_city, $billing_state, $billing_zip, $billing_phone, $billing_email, $cc_number, $cc_exp_month, $cc_exp_year, $username, $password, $promo_code) {
        $requestBody = '&first_name=' . $first_name .
                '&last_name=' . $last_name .
                '&billing_address=' . $billing_address .
                '&billing_city=' . $billing_city .
                '&billing_state=' . $billing_state .
                '&billing_zip=' . $billing_zip .
                '&billing_phone=' . $billing_phone .
                '&billing_email=' . $billing_email .
                '&cc_number=' . $cc_number .
                '&cc_exp_month=' . $cc_exp_month .
                '&cc_exp_year=' . $cc_exp_year .
                '&username=' . $username .
                '&password=' . $password .
                '&promo_code=' . $promo_code .
                '&n=' . $this->nonce .
                '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }

    /**
     *
     * @param type $username
     * @param type $password
     * @param type $basecamp_apikey
     * @param type $basecamp_url
     * @return type 
     */
    function tempRegistration($username, $password, $basecamp_apikey, $basecamp_url) {
        $requestBody = '&username=' . $username . '&password=' . $password .
                '&basecamp_apikey=' . $basecamp_apikey . '&basecamp_url=' . $basecamp_url .
                '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }

    /**
     *
     * @param type $username
     * @param type $password
     * @param type $logo
     * @return type 
     */
    function setLogo($username, $password, $logo) {
        $requestBody = '&username=' . $username . '&password=' . $password .
                '&logo=' . $logo . '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }
    
    /**
     *
     * @param type $username
     * @param type $password
     * @param type $pid
     * @param type $mid
     * @return type 
     */
    function getBcampMeta($username, $password, $pid, $mid) {
        $requestBody = '&username=' . $username . '&password=' . $password .
                '&pid=' . $pid . '&mid=' . $mid .
                '&n=' . $this->nonce . '&h=' . $this->hash;
        $response = $this->setRequest($requestBody);
        return $response;
    }
    
    /**
     *
     * @global type $basedash_config
     * @param type $requestBody
     * @return type 
     */
    function setRequest($requestBody) {
        $this->CI->config->load('basedash_settings');
        $this->CI->load->library('Rest',array( 'server' => $this->CI->config->item('apiengine')));  
        $response = $this->CI->rest->post($this->CI->config->item('apiengine').'/rlcore2/APIHandler?c=' . $this->command . $requestBody,'','application/xml');
        return $response;
    }

    /**
     *
     * @param type $h
     * @return type 
     */
    function hex2bin($h) {
        if (!is_string($h))
            return null;
        $r = '';
        for ($a = 0; $a < strlen($h); $a+=2) {
            $r.=chr(hexdec($h{$a} . $h{($a + 1)}));
        }
        return $r;
    }
}