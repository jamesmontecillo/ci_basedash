<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    var $result;

    function validate() {
        $this->load->library('Api_access');
        $response = $this->api_access->ApiValidateLogin(
                $this->input->post('username'), $this->input->post('password')
        );

        $response = $this->get_ArrayResponse($response);
        $this->result = $response;

        if ($response['reply'] == "OK") {
            return true;
        }
    }

    function forgot_password() {
        $this->load->library('Api_access');
        $response = $this->api_access->ApiForgotPassword(
                $this->input->post('email')
        );

        $response = $this->get_ArrayResponse($response);
        $this->result = $response;

        if ($response['reply'] == "OK") {
            return true;
        }
    }

    function forgot_password_reset() {
        $password = $this->input->post('password');
        $apikey = $this->input->post('apikey');
        $to_email = $this->input->post('username');

        $this->load->library('Api_access');
        $response = $this->api_access->ApiForgotPasswordReset($password, $apikey);

        $response = $this->get_ArrayResponse($response);
        $this->result = $response;

        if ($response['reply'] == "OK") {
            $this->load->library('email');
            $this->email->from('support@basedash.com', 'Basedash');
            $this->email->to($to_email);

            $this->email->subject('Basedash Reset Password');
            $this->email->message(
                    "Forgot Password\n\n" .
                    "Requested for password reset:\n\n" .
                    "Use the following credentials to login in to your account:\n" .
                    "Username: $to_email\n" .
                    "Password: $password\n\n" .
                    "Site Url: " . base_url() . " \n"
            );

            if ($this->email->send()) {
                return true;
            }
            echo $this->email->print_debugger();
        }
    }

    function create_account() {
        $this->load->library('Api_access');
        $response =
                $this->api_access->ApiTempCreateAccount(
                $this->input->post('username'), $this->input->post('password'), $this->input->post('apikey'), $this->input->post('basecampUrl')
        );

        $response = $this->get_ArrayResponse($response);
        $this->result = $response;

        if ($response['reply'] == "OK") {
            $this->CreateDirectory("xml/users_account/" . $response['ident']);
            $this->CreateDirectory("xml/users_account/" . $response['ident'] . "/settings/");

            $this->load->library('Api_access');
            $set_logo =
                    $this->api_access->ApiSetLogo(
                    $this->input->post('username'), $this->input->post('password'), $response['ident'], $this->input->post('logo')
            );
            $set_logo_result = $this->get_ArrayResponse($set_logo);
//            $this->result = $set_logo_result;
            if ($set_logo_result['reply'] == "OK") {
                return true;
            }
        }
    }

    function update_account() {
        $this->load->library('Api_access');
        $set_logo =
                $this->api_access->ApiSetLogo(
                $this->input->post('username'), $this->input->post('password'), $this->input->post('ident'), $this->input->post('logo')
        );
        $this->result = $set_logo;
        $set_logo_result = $this->get_ArrayResponse($set_logo);
        if ($set_logo_result['reply'] == "OK") {
            return true;
        }
    }

    var $dir;

    function CreateDirectory($dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
            return true;
        }
        return false;
    }

    function get_result() {
        return $this->result;
    }

    function get_ArrayResponse($response) {
        $this->load->library('Simple_xml');
        $xmlData = $this->simple_xml->xml_parse($response);

        $response_data = array();

        if (!empty($xmlData['Reply'])) {
            $response_data['reply'] = $xmlData['Reply'];
        }
        if (!empty($xmlData['Status'])) {
            $response_data['status'] = $xmlData['Status'];
        }
        if (($response_data['reply'] == "OK") && ($response_data['status'] != "Logo set")) {
            if (is_array($response_data['status'])) {
                foreach ($response_data['status'] as $xmlvalue) {
                    $response_data['url'] = $xmlData['Status']['url'];
                    $response_data['apikey'] = $xmlData['Status']['apikey'];
                    $response_data['ident'] = $xmlData['Status']['ident'];
                    if (!empty($xmlData['Status']['logo'])) {
                        $response_data['logo'] = $xmlData['Status']['logo'];
                    }
                    if (!empty($xmlData['Status']['account'])) {
                        $response_data['account'] = $xmlData['Status']['account'];
                        if ($response_data['account'] == 'T') {
                            $response_data['daysleft'] = $xmlData['Status']['daysleft'];
                        }
                    }
                }
            }
            $response_data['qt'] = $xmlData['QT'];
        }

        return $response_data;
    }

}