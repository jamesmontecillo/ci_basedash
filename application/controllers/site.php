<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author jmsmontecillo
 */
class Site extends CI_Controller {

    function index() {
        $this->is_logged_in();
        $user_data = $this->_get_session_data();
//        print_r($user_data);
        $this->load->model('basedash/basedash_model');


        $data['project_enabled'] = 'true';
        $data['user_data'] = $user_data;

        $view = $this->input->get('view');
        $status = 'false';
        if (empty($view)) {
            $view = 'all';
        }
        if ($view == 'disabled') {
            $status = 'true';
            $data['project_enabled'] = 'false';
        }
        $data['project_status'] = $status;
        $data['project_view'] = $view;


        if ($this->basedash_model->user_exist($user_data['ident'])) {
            $data['dashlet'] = $this->basedash_model->get_project_dashlet($user_data['ident']);
            $data['main_content'] = 'basedash/index';
            $basedash_data = $this->basedash_model->get_basedash_data($user_data['ident']);
            $data['basedash_projects'] = $basedash_data['projects'];
            $data['basedash_data'] = $basedash_data['data'];
        } else {
            $data['dashlet'] = "1380";
            $data['main_content'] = 'basedash/update';
            $data['return_view'] = 'all';
        }

        $this->load->view('include/template', $data);
    }

    function change_project_order() {
        if (IS_AJAX) {
            $this->load->model('basedash/basedash_model');
            $this->basedash_model->project_order();
        }
    }

    function change_project_status() {
        if (IS_AJAX) {
            $this->load->model('basedash/basedash_model');
            $this->basedash_model->project_status();
        }
    }

    function change_project_dashlet() {
        if (IS_AJAX) {
            $this->load->model('basedash/basedash_model');
            $this->basedash_model->project_dashlet();
        }
    }

    function update() {
        $this->is_logged_in();
        $user_data = $this->_get_session_data();
        $data['main_content'] = 'basedash/update';
        $data['user_data'] = $user_data;

        $return_view = $this->input->get('return_view');
        if (empty($return_view)) {
            $return_view = 'all';
        }
        $data['return_view'] = $return_view;

        $this->load->model('basedash/basedash_model');
        $data['dashlet'] = $this->basedash_model->get_project_dashlet($user_data['ident']);

        $this->load->view('include/template', $data);
    }

    function milestone() {
        $this->is_logged_in();
        $user_data = $this->_get_session_data();
        $this->load->model('basedash/basedash_model');

        $view = $this->input->get('return_view');
        if (empty($view)) {
            $view = 'all';
        }
        $data['project_view'] = $view;

        if ($this->basedash_model->user_exist($user_data['ident'])) {
            $data['dashlet'] = $this->basedash_model->get_project_dashlet($user_data['ident']);
            $data['main_content'] = 'basedash/index';
            $basedash_data = $this->basedash_model->get_basedash_data($user_data['ident']);
            $data['basedash_projects'] = $basedash_data['projects'];
            $data['basedash_data'] = $basedash_data['data'];

            $pid = $this->input->get('pid');
            $milestone_data = $this->basedash_model->project_milestone($user_data['ident'], $user_data['username'], $user_data['password'], $pid);
            $data['project_name'] = $milestone_data['project_name'];
            $data['project_id'] = $milestone_data['project_id'];
            if (!empty($milestone_data['milestone'])) {
                $data['project_milestone_order'] = $milestone_data['milestone'];
            }
//            $data['project_milestone_order'] = $milestone_data_order;
        }

        $data['main_content'] = 'basedash/milestone';
        $data['user_data'] = $user_data;

        $return_view = $this->input->get('return_view');
        if (empty($return_view)) {
            $return_view = 'all';
        }
        $data['return_view'] = $return_view;

        $this->load->view('include/template', $data);
    }

    function generate_xml_data() {
        if (IS_AJAX) {
            $this->load->model('basedash/generate_model');
            $this->generate_model->generate();
        }
    }

    function is_logged_in() {
        $is_logged_in = $this->session->userdata('is_logged_in');

        if (!isset($is_logged_in) || $is_logged_in != true) {
            $this->session->set_userdata(array('login_error' => 'Session expired! Please Login again.'));
            redirect('');
        }
    }

    function _get_session_data() {
        $session_data['username'] = $this->session->userdata('username');
        $session_data['password'] = $this->session->userdata('password');
        $session_data['ident'] = $this->session->userdata('ident');
        $session_data['basecamp_url'] = $this->session->userdata('basecamp_url');
        $session_data['apikey'] = $this->session->userdata('apikey');
        $session_data['logo'] = $this->session->userdata('logo');
        $session_data['account'] = $this->session->userdata('account');
        $daysleft = $this->session->userdata('daysleft');
        if ($session_data['account'] == 'T') {
            $day = 'day';
            if ($daysleft > 1) {
                $day .= 's';
            } else if ($daysleft < 0) {
                redirect('');
//                header('Location: index.php?module=Accounts&action=registered_billing');
            }
            $session_data['daysleft'] = "<blink> Trial Account - " . $daysleft . " $day remaining</blink>";
        }

        $session_data['qt'] = $this->session->userdata('qt');
        return $session_data;
    }

    function user_account() {
        $this->is_logged_in();
        $user_data = $this->_get_session_data();
        $data['main_content'] = 'basedash/user_account';
        $data['user_data'] = $user_data;
        $data['account_error'] = $this->session->userdata('account_error');
        $this->load->view('include/template', $data);
    }

    function update_user_account() {
        $this->load->library('form_validation');
        //field name, error message, validation rules

        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|min_length[6]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('basecampUrl', 'Basecamp Url', 'trim|required|callback_check_input|prep_url');
        $this->form_validation->set_rules('apikey', 'Api Key', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->user_account();
        } else {
            $this->load->model('users/user_model');
            $result = $this->user_model->update_account();
            if ($result) {
                $this->session->set_userdata(array('account_error' => 'Update Successful.'));
                redirect('site/user_account');
            } else {
                $this->session->set_userdata(array('account_error' => 'Update Failed.'));
                redirect('site/user_account');
            }
        }
    }
    
    function user_billing() {
        $this->is_logged_in();
        $user_data = $this->_get_session_data();
        $data['main_content'] = 'basedash/user_billing';
        $data['user_data'] = $user_data;
        $data['account_error'] = $this->session->userdata('account_error');
        $this->load->view('include/template', $data);
    }
    
}

?>
