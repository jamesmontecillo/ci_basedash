<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basedash_data {

    var $params = array();
    var $params_get = array();
    var $milestone_timestamp;
    var $ident;
    var $CI;

    function Basedash_data($params) {
        $this->ident = $params['ident'];
        $this->CI = & get_instance();

        $params_get = array('ident' => $this->ident);
        $this->CI->load->library('Response_get', $params_get);
        $this->CI->load->library('Settings_projects', $params_get);
    }

    function getAccountSummary() {
        return $this->CI->response_get->getAccountResponse();
    }

    var $project_summary = Array();
    var $project_array = Array();
    var $project_data = Array();

    function setProjectSummary() {
        $project_array = $this->CI->response_get->getProjectResponse();

        $i = 0;
        $data = $project_array['data'];
        foreach ($data as $project_data) {

            $this->project_summary['data'][$i]['id'] = $project_data['project_id'];

            $project_name = trim($project_data['project_title']);
            $project_title = $project_name;
            if (strlen($project_name) > 18) {
                $value = strlen($project_name) - 18;
                $project_title = substr($project_name, 0, -$value);
                $project_title = $project_title . "...";
            }

            $this->project_summary['data'][$i]['title'] = $project_title;

            $updated_time = new DateTime($project_data['project_last_changed_on']);
            $last_update = $this->convert_to_gmt($updated_time, $project_data['project_last_changed_on'], true);
            $this->project_summary['data'][$i]['last_update'] = $last_update;

            $todo_list = $this->CI->response_get->getToDoListsResponse($project_data['project_id']);

            $todo_total_done = 0;
            $todo_total_undone = 0;
            $x = 1;
            $y = 0;
            $z = 0;
            
            $j = 0 ;
            if (!empty($todo_list)) {
                foreach ($todo_list as $todo_list_data) {

                    $todo_total_done += $todo_list_data["completed_count"];
                    $todo_total_undone += $todo_list_data["uncompleted_count"];
                    
                    $todo_item = $this->CI->response_get->getToDoItemsResponse($todo_list_data["id"]);
                    
                    if (!empty($todo_item)) {
                        foreach ($todo_item as $todo_item_data) {
                            //Make the Widget default to Green status
                            $item_over_due = 259200;

                            $todo_item_due = strlen(trim($todo_item_data['item_due']));
                            if ($todo_item_due != 0) {
                                if ($todo_item_data['item_completed'] == "false") {
                                    $item_due_time = new DateTime($todo_item_data['item_due'], new DateTimeZone('America/Chicago'));
                                    $item_due_time = date_format($item_due_time, 'Y-m-d');
                                    $item_due = strtotime($item_due_time);

                                    $item_current_time = strtotime(date("Y-m-d"));

                                    $item_over_due = $item_due - $item_current_time;
                                }
                            }
                            
                            if ($item_over_due >= 259200) {
                                $x = 1;
                            } 
                            if (($item_over_due < 259200) && ($item_over_due > 0)) {
                                $y = 1;
                            } 
                            if ($item_over_due < 0) {
                                $z = 1;
                            }

                        }
                    }
                }
            }

            if ($x == 1) {
                $this->project_summary['data'][$i]['color'] = 'green';
            }
            if ($y == 1) {
                $this->project_summary['data'][$i]['color'] = 'yellow';
            }
            if ($z == 1) {
                $this->project_summary['data'][$i]['color'] = 'red';
            }

            $todo_total_item = $todo_total_done + $todo_total_undone;
            $this->project_summary['data'][$i]['total_done'] = $todo_total_done;
            $this->project_summary['data'][$i]['total_undone'] = $todo_total_undone;
            $this->project_summary['data'][$i]['total_items'] = $todo_total_item;

            if ($todo_total_item == 0) {
                $todo_total_item = 1;
            }
            $this->project_summary['data'][$i]['progress'] = round(($todo_total_done / $todo_total_item) * 100);

            $category_id = $this->CI->response_get->getCategoryReponse($project_data['project_id']);
            $message_result = $this->CI->response_get->getMessageReponse($project_data['project_id'], $category_id);
            $status = "No Status Update.";
            if ($message_result != null) {
                $status = $message_result[0];
            }
            $this->project_summary['data'][$i]['status'] = $status;

            $milestone_array = $this->CI->response_get->getMilestoneReponse($project_data['project_id']);
            $j = 0;
            if (!is_null($milestone_array)) {
                foreach ($milestone_array['data'] as $milestone_data) {
                    if (!is_null($milestone_array['data'][$j]['milestone_completed'])) {
                        $milestone_completed = $milestone_data['milestone_completed'];
                        $milestone_deadline = $milestone_data['milestone_deadline'];
                        break;
                    }
                }
            }
            $this->project_summary['data'][$i]['milestonecolor'] = "white";
            $milestone_due = 0;
            $miles_data = $this->getMilestoneColor($milestone_completed, $milestone_deadline);

            $this->project_summary['data'][$i]['milestonecolor'] = $miles_data['color'];
            $this->project_summary['data'][$i]['milestonedue'] = round($miles_data['due']);

            if ($miles_data['color'] == 'red') {
                if (preg_match("/\bCustomer: \b/i", $milestone_array['data'][0]['milestone_title'])) {
                    $this->project_summary['data'][$i]['color'] = "orange";
                }
            }

            $this->project_summary['data'][$i]['milestonetitle'] = $milestone_array['data'][0]['milestone_title'];

            if (empty($milestone_array)) {
                $this->project_summary['data'][$i]['milestonecolor'] = "white";
                $this->project_summary['data'][$i]['milestonedue'] = 0;
            }

            $project_conf = $this->CI->settings_projects->getProjectConfig($project_data['project_id']);
            $this->project_summary['data'][$i]['enabled'] = $project_conf['enabled'];
            $this->project_summary['data'][$i]['order'] = $project_conf['order'];
            $i++;
        }
        $this->project_summary['projects'] = $i;
    }

    function getMilestoneColor($milestone_completed, $milestone_deadline) {
        if ($milestone_completed == 'false') {
            if (!empty($milestone_deadline)) {
                $milestone_due_date = date_format($milestone_deadline, 'Y-m-d');
                $milestone_due_date = strtotime($milestone_due_date);

                $milestone_current_time = strtotime(date("Y-m-d"));

                //Not completed not over due
                if ($milestone_due_date >= $milestone_current_time) {
                    $milestone_due = $milestone_due_date - $milestone_current_time;
                    $milestone['color'] = "white";
                }
                //Not completed and over due
                else if ($milestone_due_date < $milestone_current_time) {
                    $milestone_due = $milestone_current_time - $milestone_due_date;
                    $milestone['color'] = "red";
                }
                $milestone['due'] = $milestone_due / 86400;
            }
        }
        if ((isset($milestone)) && (!empty($milestone))) {
            return $milestone;
        }
    }

    function setProjectMileStoneSummary($project_id) {
        $project_array = $this->CI->response_get->getProjectResponse();

        $data = $project_array['data'];
        foreach ($data as $project_data) {
            if ($project_id == $project_data['project_id']) {
                $this->project_milestone_summary['project_name'] = $project_data['project_title'];
                break;
            }
        }

        $this->project_milestone_summary['project_id'] = $project_id;

        $milestone_array = $this->CI->response_get->getMilestoneReponse($project_id);
        $todo_list = $this->CI->response_get->getToDoListsResponse($project_id);

        $j = 0;
        if (!empty($milestone_array)) {
            foreach ($milestone_array['data'] as $milestone_data) {
                $milestone_total_done = 0;
                $milestone_total_undone = 0;
                if (!empty($milestone_data['milestone_id'])) {

                    foreach ($todo_list as $todo_list_data) {
                        if ($todo_list_data['milestone_id'] == $milestone_data['milestone_id']) {
                            $milestone_total_done += $todo_list_data['completed_count'];
                            $milestone_total_undone += $todo_list_data['uncompleted_count'];
                        }
                    }

                    $total_milestone = $milestone_total_done + $milestone_total_undone;

                    $milestone_completed = $milestone_data['milestone_completed'];

                    if ($total_milestone == 0) {
                        $milestone_progress = "N/A";
                        $bg_color = "green";
                        $milestone_status = "No to do items.";
                        if ($milestone_completed == "true") {
                            $milestone_progress = "N/A";
                            $bg_color = "blue";
                            $milestone_status = "Complete";
                        }
                    } else {

                        $milestone_progress = round(($milestone_total_done / $total_milestone) * 100);

                        $milestone_deadline = $milestone_data['milestone_deadline'];
                        $miles_data = $this->getMilestoneColor($milestone_completed, $milestone_deadline);
                        if ($miles_data['color'] == "red") {
                            if ($milestone_data['milestone_responsible'] == "Customer") {
                                $bg_color = "orange";
                                $milestone_status = "Blocking";
                            } else if ($milestone_progress == 100) {
                                $bg_color = "red";
                                $milestone_status = "Todos Completed";
                            } else if ($milestone_progress < 100) {
                                $bg_color = "red";
                                $milestone_status = "Blocking";
                            }
                        } else if (($milestone_completed == "true") && (($milestone_progress == 100))) {
                            $bg_color = "blue";
                            $milestone_status = "Complete";
                        } else if ($milestone_progress == 100) {
                            $bg_color = "red";
                            $milestone_status = "Todos Completed";
                        } else if (($milestone_progress < 100) && ($milestone_completed == "true")) {
                            $bg_color = "red";
                            $milestone_status = "Blocking";
                        } else if ($milestone_progress < 100) {
                            $bg_color = "green";
                            $milestone_status = "On-time";
                        }
                    }

                    if (is_numeric($milestone_progress)) {
                        $milestone_progress = $milestone_progress . "%";
                    }
                    
                    $milestone_due_date = $milestone_data['milestone_deadline'];
                    if ($milestone_completed == "true") {
                        $milestone_due_date = $milestone_data['milestone_completed_on'];
                    }
                    $response = $this->getMileStoneOrder($milestone_data['milestone_deadline']);
                    
                    $this->project_milestone_summary['milestone'][$j]['milestone_id'] = $milestone_data['milestone_id'];

                    $this->project_milestone_summary['milestone'][$j]['milestone_title'] = $milestone_data['milestone_title'];

                    $this->project_milestone_summary['milestone'][$j]['milestone_responsible'] = $milestone_data['milestone_responsible'];

                    $this->project_milestone_summary['milestone'][$j]['total_completed'] = $milestone_total_done;

                    $this->project_milestone_summary['milestone'][$j]['total_uncompleted'] = $milestone_total_undone;

                    $this->project_milestone_summary['milestone'][$j]['progress'] = $milestone_progress;

                    $this->project_milestone_summary['milestone'][$j]['milestone_color'] = $bg_color;

                    $this->project_milestone_summary['milestone'][$j]['status'] = $milestone_status;

                    $this->project_milestone_summary['milestone'][$j]['milestone_deadline'] = date_format($milestone_data['milestone_deadline'], 'M j, Y');
                    
                    $this->project_milestone_summary['milestone'][$j]['milestone_due_date'] = date_format($milestone_due_date, 'M j, Y');

                    $this->project_milestone_summary['milestone'][$j]['milestone_order'] = $response['order'];

                    $j++;
                }
            }
        }
    }

    function getMileStoneOrder($milestone_deadline){
        $milestone_due_date = date_format($milestone_deadline, 'Y-m-d');
        $milestone_due_date = strtotime($milestone_due_date);
        $result['order'] = $milestone_due_date;
        if ((isset($result)) && (!empty($result))) {
            return $result;
        }
    }
    
    function getMileStoneDueDate($username, $password, $milestone ) {      
        $this->CI->load->library('Api_access');
        $j  = 0;
        foreach ($milestone['milestone'] as $milestone_data){
            $response = $this->CI->api_access->ApiGetMileStone($username, $password, $milestone['project_id'], $milestone_data['milestone_id']);
            $result = $this->getResponseArray($response);
            
            $milestone_deadline = new DateTime($milestone_data['milestone_deadline'], new DateTimeZone('America/Chicago'));
            $milestone_deadline = date_format($milestone_deadline, 'Y-m-d');
            
            $completed_date = new DateTime($milestone_data['milestone_due_date'], new DateTimeZone('America/Chicago'));
            $completed_date = date_format($completed_date, 'Y-m-d');
            if (empty($result['slip'])){
                $result['slip'] = 0;
            }
            if ($result['slip'] != 0) {
                $finishdate = trim($result['finishdate']);
                if (($finishdate != "NONE") && (!empty($finishdate))) {
                    $completed_date = $finishdate;
                }
            }
            
            $milestone_deadline = strtotime($milestone_deadline);
            $completed_date = strtotime($completed_date);
            
            if ($completed_date >= $milestone_deadline ){
                $this->milestone_timestamp = $this->milestone_timestamp + ($completed_date - $milestone_deadline);
                $due_date = $this->milestone_timestamp + $milestone_deadline;
            }else{
                $due_date = $this->milestone_timestamp + $completed_date;
            }
            
//            echo $this->milestone_timestamp . "-";
            
            $due_date = date('Y-m-d', $due_date);
            $milestone_due_date = new DateTime($due_date, new DateTimeZone('America/Chicago'));

            
            $this->project_milestone_summary['milestone'][$j]['milestone_id'] = $milestone_data['milestone_id'];

            $this->project_milestone_summary['milestone'][$j]['milestone_title'] = $milestone_data['milestone_title'];

            $this->project_milestone_summary['milestone'][$j]['milestone_responsible'] = $milestone_data['milestone_responsible'];

            $this->project_milestone_summary['milestone'][$j]['total_completed'] = $milestone_data['total_completed'];

            $this->project_milestone_summary['milestone'][$j]['total_uncompleted'] = $milestone_data['total_uncompleted'];

            $this->project_milestone_summary['milestone'][$j]['progress'] = $milestone_data['progress'];

            $this->project_milestone_summary['milestone'][$j]['milestone_color'] = $milestone_data['milestone_color'];

            $this->project_milestone_summary['milestone'][$j]['status'] = $milestone_data['status'];

            $this->project_milestone_summary['milestone'][$j]['milestone_deadline'] = $milestone_data['milestone_deadline'];

            $this->project_milestone_summary['milestone'][$j]['milestone_due_date'] = date_format($milestone_due_date, 'M j, Y');

            $this->project_milestone_summary['milestone'][$j]['milestone_order'] = $milestone_data['milestone_order'];
            
//            $this->project_milestone_summary['milestone'][$j]['milestone_slip_result'] = $result;

            $j++;
        }
    }
    
    function getProjectSummary() {
        $this->project_summary['data'] = $this->array_sort($this->project_summary['data'], 'order', SORT_ASC);;
        return $this->project_summary;
    }

    function getProjectMileStoneSummary() {
        $this->project_milestone_summary['milestone'] = $this->array_sort($this->project_milestone_summary['milestone'], 'milestone_order', SORT_ASC);
        return $this->project_milestone_summary;
    }

    function convert_to_gmt($updated_time, $time_to_update, $datum) {
        $sign = "-"; // Whichever direction from GMT to your timezone. + or -
        $h = "4"; // offset for time (hours)
        $dst = false; // true - use dst ; false - don't
        if ($dst == true) {
            $daylight_saving = date('I');
            if ($daylight_saving) {
                if ($sign == "-") {
                    $h = $h - 1;
                } else {
                    $h = $h + 1;
                }
            }
        }
        $hm = $h * 60;
        $ms = $hm * 60;
        if ($sign == "-") {
            $timestamp = strtotime($time_to_update) - ($ms);
        } else {
            $timestamp = strtotime($time_to_update) + ($ms);
        }

        if ($datum == true) {
            return gmdate('M jS h:i A', $timestamp) . " (EDT)";
        } else {
            return date_format($updated_time, 'M jS h:i A');
        }
    }

    /**
     *
     * @param type $response
     * @return type 
     * 
     */
    function getResponseArray($response) {
        $this->CI->load->library('Simple_xml');
        $xmlData = $this->CI->simple_xml->xml_parse($response);

        $response_data = array();

        if (!empty($xmlData['Reply'])) {
            $response_data['reply'] = $xmlData['Reply'];
        }else{
            $response_data['reply'] = "Failed";
        }
        if (!empty($xmlData['Status'])) {
            $response_data['status'] = $xmlData['Status'];
        }
        if (($response_data['reply'] == "OK") && ($response_data['status'] != "Logo set")) {
            if (is_array($response_data['status'])) {
                foreach ($response_data['status'] as $xmlvalue) {
                    $response_data['finishdate'] = $xmlData['Status']['finishdate'];
                    $response_data['slip'] = $xmlData['Status']['slip'];
                }
            }
            $response_data['qt'] = $xmlData['QT'];
        }
        return $response_data;
    }

    function array_sort($array, $on, $order=SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
}

?>
