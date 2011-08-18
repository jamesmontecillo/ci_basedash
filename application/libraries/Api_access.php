<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of APIAccessClass
 *
 * @author jmsmontecillo
 */

class Api_access {

    var $username;
    var $password;
    var $CI;
    
    function Api_access() {
        $this->CI =& get_instance();
//        $this->username = $username;
//        $this->password = $password;
    }

    function ApiValidateLogin($username, $password) {
        $params = array('command' => 'validate_login');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->validateLogin($username, $password);
        return $result;
    }

    function ApiForgotPassword($email) {
        $this->CI->config->load('basedash_settings');
        $params = array('command' => 'forgot_password');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->forgotPassword($email, $this->CI->config->item('callback'));
        return $result;
    }

    function ApiForgotPasswordReset($new_password, $apikey) {
        $params = array('command' => 'forgot_password_reset');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->forgotPasswordReset($new_password, $apikey);
        return $result;
    }

    function ApiInitializeSystem($username, $password, $basecamp_apikey, $basecamp_url) {
        $params = array('command' => 'initialize_system');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->initializeSystem($username, $password, $basecamp_apikey, $basecamp_url);
        return $result;
    }

    function ApiCreateAccount($first_name, $last_name, $billing_address,
            $billing_city, $billing_state, $billing_zip, $billing_phone,
            $billing_email, $cc_number, $cc_exp_month, $cc_exp_year,
            $username = '', $password = '', $promo_code = ''
            ) {
        $params = array('command' => 'createAccount');
        $this->CI->load->library('Api_pass_through', $params);
        $result =  $this->CI->api_pass_through->createAccount($first_name, $last_name, $billing_address,
                $billing_city, $billing_state, $billing_zip, $billing_phone,
                $billing_email, $cc_number, $cc_exp_month, $cc_exp_year,
                $username, $password, $promo_code
                );
        return $result;
    }

    function ApiTempCreateAccount($username, $password, $basecamp_apikey, $basecamp_url) {
        $params = array('command' => 'tempRegistration');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->tempRegistration($username, $password, $basecamp_apikey, $basecamp_url);
        return $result;
    }
    
    function ApiSetLogo($username, $password, $ident, $logo) {
        $logo_loc = $this->uploadLogo($ident, $logo);
        $params = array('command' => 'set_logo');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->setLogo($username, $password, $logo_loc);
        $result['logo'] = $logo_loc;
        return $result;
    }
    
    function ApiGetMileStone($username, $password, $pid, $mid) {
        $params = array('command' => 'get_bcamp_meta');
        $this->CI->load->library('Api_pass_through', $params);
        $result = $this->CI->api_pass_through->getBcampMeta($username, $password, $pid, $mid);
        return $result;
    }
    
    /**     
     * @param type $UID
     * @param type $logo
     * @return string 
     */
    function uploadLogo($ident, $logo) {
        $config['upload_path'] = "xml/users_account/$ident/settings/";
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = 'logo';
        $config['max_size'] = '250';
        $config['max_width'] = '0';
        $config['max_height'] = '70';
        
        $this->CI->load->library('Upload', $config);
        $upload = $this->CI->upload->do_upload($logo);  
        $data = $this->CI->upload->data();
        if($upload === FALSE)
        {
            $data['full_path'] = "images/dashboard/default.png";
        }  
        return $data['full_path'];
    }
    
/**
 * 
 *      This function reads the extension of the file.
 *      It is used to determine if the file is an image by checking the extension.
 *
 * @param type $str
 * @return type 
 * 
 */
    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }
}
?>