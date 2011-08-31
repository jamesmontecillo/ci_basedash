<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of basedash_model
 *
 * @author jmsmontecillo
 */
class basedash_model extends CI_Model {

    function user_exist($ident) {
        $filename = "xml/users_account/" . $ident;
        if (is_dir($filename)) {
            return true;
        }
    }

    function get_basedash_data($ident) {
        $params = array('ident' => $ident);
        $this->load->library('Basedash_data', $params);
        $this->basedash_data->setProjectSummary();
        $response = $this->basedash_data->getProjectSummary();
        return $response;
    }

    function project_order() {
        $params = array('ident' => $this->input->post('ident'));
        $this->load->library('Settings_projects', $params);

        $array = $this->input->post('id', TRUE);
        $project_order = 1;
        foreach ($array as $project_id) {
            $this->settings_projects->setProjectOrder($project_id, $project_order);
            $project_order++;
        }
//        return $array;
    }

    function project_status() {
        $params = array('ident' => $this->input->post('ident'));
        $this->load->library('Settings_projects', $params);
        $this->settings_projects->setProjectEnabled($this->input->post('project_id'), $this->input->post('status'));
//        return $array;
    }

    function get_project_dashlet($ident) {
        $params = array('ident' => $ident);
        $this->load->library('Settings_dashlets', $params);
        return $this->settings_dashlets->getDashlet();
    }

    function project_dashlet() {
        $params = array('ident' => $this->input->get('ident'));
        $this->load->library('Settings_dashlets', $params);
        return $this->settings_dashlets->updateDashlet($this->input->get('project_dashlet'));
    }

    function project_milestone($ident, $username, $password, $pid) {
        $params = array('ident' => $ident);
        $this->load->library('Basedash_data', $params);
        $this->basedash_data->setProjectMileStoneSummary($pid);
        $milestone = $this->basedash_data->getProjectMileStoneSummary();
        $this->basedash_data->getMileStoneDueDate($username, $password, $milestone);
        $response = $this->basedash_data->getProjectMileStoneSummary();
        return $response;
    }
}

?>
