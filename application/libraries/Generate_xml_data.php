<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generate_xml_data {

    var $ident;
    var $apikey;
    var $basecampUrl;
    var $project_array;
    var $project_data;
    var $to_do_list_id;
    var $todo_id;
    var $category_array;
    var $category_data;
    var $CI;

    function Generate_xml_data($params) {
        $this->ident = $params['ident'];
        $this->basecampUrl = $params['basecampUrl'];
        $this->apikey = $params['apikey'];
        $this->CI = & get_instance();

        $params_set = array(
            'ident' => $this->ident,
            'apikey' => $this->apikey,
            'basecampUrl' => $this->basecampUrl
        );
        $this->CI->load->library('Response_set', $params_set);

        $params_get = array('ident' => $this->ident);
        $this->CI->load->library('Response_get', $params_get);
    }

    function setGenerateXmlFiles() {
        $this->CI->response_set->setEverything();
        $this->CI->response_set->setAccountResponse();
        $this->CI->response_set->setProjectResponse();

        $project_array = $this->CI->response_get->getProjectResponse();
        foreach ($project_array['data'] as $project_data) {
            $this->CI->response_set->setToDoListsResponse($project_data['project_id']);

            $to_do_list = $this->CI->response_get->getToDoListsResponse($project_data['project_id']);
            foreach ($to_do_list as $todo_list_data) {
                $this->CI->response_set->setToDoItemsResponse($todo_list_data["id"]);
            }

            $this->CI->response_set->createCategoryPost($project_data['project_id']);
            $this->CI->response_set->setCategoryReponse($project_data['project_id']);
            $category_id = $this->CI->response_get->getCategoryReponse($project_data['project_id']);
            $this->CI->response_set->setMessageReponse($project_data['project_id'], $category_id);

            $this->CI->response_set->setMilestoneReponse($project_data['project_id']);
            $this->CI->response_set->setMilestoneReponseNew($project_data['project_id']);
        }
        return true;
    }

}