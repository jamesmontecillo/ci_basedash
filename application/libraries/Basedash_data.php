<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Basedash_data {

    var $params = array();
    var $params_get = array();
    var $milestone_timestamp = 0;
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

            if (!empty($todo_list)) {
                foreach ($todo_list as $todo_list_data) {

                    $todo_total_done += $todo_list_data["completed_count"];
                    $todo_total_undone += $todo_list_data["uncompleted_count"];

                    $todo_item = $this->CI->response_get->getToDoItemsResponse($todo_list_data["id"]);

                    if (!empty($todo_item)) {
                        foreach ($todo_item as $todo_item_data) {
                            //Make the Widget to go default in Green status
                            $item_over_due = 259200;

                            if (($todo_item_data['item_completed'] == "false") && (!empty($todo_item_data['item_due']))) {

                                $item_due_time = new DateTime($todo_item_data['item_due'], new DateTimeZone('America/Chicago'));
                                $item_due_time = date_format($item_due_time, 'Y-m-d');
                                $item_due = strtotime($item_due_time);

                                $item_current_time = strtotime(date("Y-m-d"));

                                $item_over_due = $item_due - $item_current_time;
                            }

                            if ($item_over_due >= 259200) {
                                $x = 1;
                            } else if (($item_over_due < 259200) && ($item_over_due > 0)) {
                                $y = 1;
                            } else if ($item_over_due < 0) {
                                $z = 1;
                                break;
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
//        return $milestone;
    }

    function getMileStoneStatus($username, $password, $pid, $mid, $milestone_deadline) {
        $this->CI->load->library('Api_access');
        $response = $this->CI->api_access->ApiGetMileStone($username, $password, $pid, $mid);
        $response = $this->getResponseArray($response);

//        $response = $new_api->getBcampMeta($username, $password, "7710061", "23476462");
//        $this->milestone_timestamp = 86400;

        if ((isset($response['slip'])) && ($response['slip'])) {
            if (($response['finishdate'] != "NONE") && (!empty($result['finishdate']))) {
                $finish_date = date_format($finish_date, 'Y-m-d');
                $finish_date = strtotime($finish_date);

                $deadline_date = date_format($milestone_deadline, 'Y-m-d');
                $deadline_date = strtotime($deadline_date);

                $mlstn_due_date = (($finish_date - $deadline_date) + $deadline_date);
                $mlstn_order = $deadline_date;
                $this->milestone_timestamp += $finish_date - $deadline_date;
                $response['mlstn_due_date'] = new DateTime($mlstn_due_date, new DateTimeZone('America/Chicago'));
                //date('Y-m-d', $mlstn_due_date);
            }
        } else {
            $milestone_due_date = date_format($milestone_deadline, 'Y-m-d');
            $milestone_due_date = strtotime($milestone_due_date);
            $mlstn_due_date = $milestone_due_date + $this->milestone_timestamp;
            $mlstn_order = $milestone_due_date;
            $mlstn_due_date = date('Y-m-d', $mlstn_due_date);
            $response['mlstn_due_date'] = new DateTime($mlstn_due_date, new DateTimeZone('America/Chicago'));
        }
        $response['order'] = $mlstn_order;
        if ((isset($response)) && (!empty($response))) {
            return $response;
        }
//        return $response;
    }

    function setProjectMileStoneSummary($username, $password, $project_id) {
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
                    $response = $this->getMileStoneStatus($username, $password, $project_id, $milestone_data['milestone_id'], $milestone_data['milestone_deadline']);

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
                            $response['mlstn_due_date'] = $milestone_data['milestone_completed_on'];
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

                    $this->project_milestone_summary['milestone'][$j]['milestone_id'] = $milestone_data['milestone_id'];

                    $this->project_milestone_summary['milestone'][$j]['milestone_title'] = $milestone_data['milestone_title'];

                    $this->project_milestone_summary['milestone'][$j]['milestone_responsible'] = $milestone_data['milestone_responsible'];

                    $this->project_milestone_summary['milestone'][$j]['total_completed'] = $milestone_total_done;

                    $this->project_milestone_summary['milestone'][$j]['total_uncompleted'] = $milestone_total_undone;

                    $this->project_milestone_summary['milestone'][$j]['progress'] = $milestone_progress;

                    $this->project_milestone_summary['milestone'][$j]['milestone_color'] = $bg_color;

                    $this->project_milestone_summary['milestone'][$j]['status'] = $milestone_status;

                    $this->project_milestone_summary['milestone'][$j]['milestone_deadline'] = date_format($milestone_data['milestone_deadline'], 'M j, Y');

                    $this->project_milestone_summary['milestone'][$j]['milestone_due_date'] = date_format($response['mlstn_due_date'], 'M j, Y');

                    $this->project_milestone_summary['milestone'][$j]['milestone_order'] = $response['order'];
                    $this->project_milestone_summary['milestone'][$j]['milestone_response'] = $response;

                    $j++;
                }
            }
        }
    }

    function getProjectSummary() {
        return $this->project_summary;
    }

    function getProjectMileStoneSummary() {
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

}

?>
