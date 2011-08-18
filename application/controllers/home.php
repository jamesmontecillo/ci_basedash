<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function index() {
        $data['main_content'] = 'Home/index';
        $data['login_error'] = $this->session->userdata('login_error');
        $data['err_forgotpass'] = $this->session->userdata('err_forgotpass');
        $this->load->view('include/template', $data);
        $this->session->sess_destroy();
    }

    function test() {
//        echo "Hello ".$value;
//        $params = array('value' => $value);
//        $this->load->library('Foo', $params);       
//        $this->config->load('basedash_settings');
//        echo $this->config->item('apiengine');
//        
////        $this->load->model('users/user_model');
////        $q = $this->user_model->test();
////        $result = $this->user_model->get_result();
////        print_r($result);

        $data['main_content'] = 'Generate/index';
        $data['ident'] = '1';
        $data['basecampUrl'] = 'https://remotelink1.basecamphq.com';
        $data['apikey'] = '012e7050924af105e9c55c9d6c71ecffaf2e2a9c';
        $data['from'] = 'reg';
        $this->load->view('include/template', $data);

//        $this->load->library('Rest');  
//        $this->rest->initialize(
//            array(  
//                'server' => 'https://remotelink1.basecamphq.com',
//                'http_user' => '012e7050924af105e9c55c9d6c71ecffaf2e2a9c',  
//                'http_pass' => 'X',  
//                'http_auth' => 'basic' // or 'digest'  
//            ));
//        $this->rest->get('account.xml','xml');
//        echo $this->rest->debug();
    }

    function authenticate() {
        $this->load->model('users/user_model');
        $q = $this->user_model->validate();
        $result = $this->user_model->get_result();
        if ($q) {
            $data = array(
                'basecamp_url' => $result['url'],
                'apikey' => $result['apikey'],
                'ident' => $result['ident'],
                'logo' => $result['logo'],
                'account' => $result['account'],
                'qt' => $result['qt'],
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'is_logged_in' => true,
            );
            if ($result['account'] == 'T') {
                $data['daysleft'] = $result['daysleft'];
            }

            $this->session->set_userdata($data);
            redirect('site');
        } else {
            $this->session->set_userdata(array('login_error' => 'Login Failed Status: ' . $result['reply']));
            redirect('');
        }
//        print_r($result);
    }

    function forgot_password() {
        $this->load->model('users/user_model');
        $q = $this->user_model->forgot_password();

        $result = $this->user_model->get_result();
        if ($q) {
            $this->session->set_userdata(array('err_forgotpass' => 'Check your email for verification.'));
            redirect('');
        } else {
            $this->session->set_userdata(array('err_forgotpass' => 'Request Failed. Status: ' . $result['reply']));
            redirect('');
        }
//        print_r($result);
    }

    function reset_password() {
        $data['main_content'] = 'Home/ForgotPasswordReset';
        $email = $this->input->get('e');
        $apikey = $this->input->get('token');
        if (empty($email)) {
            $email = $this->session->userdata('email');
            $apikey = $this->session->userdata('apikey');
        }
        if (empty($email)) {
            $data['main_content'] = 'Home/index';
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('apikey');
        } else {
            $this->session->set_userdata(array('email' => $email, 'apikey' => $apikey));
            $data['email'] = $email;
            $data['apikey'] = $apikey;
        }
        $this->load->view('include/template', $data);
    }

    function reset_forgotten_password() {
        $this->load->library('form_validation');
        $this->load->model('users/user_model');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|min_length[6]|callback_check_input');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_input');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]|callback_check_input');

        if ($this->form_validation->run() == FALSE) {
            $this->reset_password();
        } else {
            $reset = $this->user_model->forgot_password_reset();
            print_r($this->user_model->get_result());
            if ($reset) {
                $this->session->set_userdata(array('err_forgotpass' => "Password Reset Successfully!"));
                redirect('');
            } else {
                $this->reset_password();
            }
        }
    }

    function registration() {
        $data['main_content'] = 'registration/registration';
        $this->load->view('include/template', $data);
    }

    function register() {
        $this->load->library('form_validation');
        //field name, error message, validation rules

        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|min_length[6]|callback_check_input');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_input');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]|callback_check_input');
        $this->form_validation->set_rules('basecampUrl', 'Basecamp Url', 'trim|required|callback_check_input|prep_url');
        $this->form_validation->set_rules('apikey', 'Api Key', 'trim|required|callback_check_input');

        if ($this->form_validation->run() == FALSE) {
            $this->registration();
        } else {
            $this->load->model('users/user_model');
            $q = $this->user_model->create_account();

            $result = $this->user_model->get_result(); // the info came from the validate
//            print_r($q);
            if ($q) {
                $data['main_content'] = 'Generate/index';
                $data['ident'] = $result['ident'];
                $data['basecampUrl'] = $result['url'];
                $data['apikey'] = $result['apikey'];
                $data['from'] = 'reg';
                $this->load->view('include/template', $data);
            } else {
                $this->registration();
            }
        }
    }

    function check_input($str) {
        switch ($str) {
            case "Password": $this->form_validation->set_message('check_input', 'The %s field can not be the word "Password"');
                return FALSE;
                break;
            case "Basecamp Url": $this->form_validation->set_message('check_input', 'The %s field can not be the word "Basecamp Url"');
                return FALSE;
                break;
            case "Api Key": $this->form_validation->set_message('check_input', 'The %s field can not be the word "Api key"');
                return FALSE;
                break;
            default: return TRUE;
                break;
        }
    }

    function generate_xml_data() {
        if (IS_AJAX) {
            $this->load->model('basedash/generate_model');
            $this->generate_model->generate();
        } else {
            
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('');
    }

}
