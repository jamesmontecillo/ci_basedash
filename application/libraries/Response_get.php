<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Description of GetResponseClass
 *
 * @author jmsmontecillo
 */

class Response_get {

    var $ident;
    var $account_elements;
    var $account_created_at;
    var $account_id;
    var $account_updated_at;
    var $account_name;
    var $account_account_holder_id;
    var $account_ssl_enabled;
    var $account_time_tracking_enabled;
    var $account_email_notification_enabled;
    var $account_storage;
    var $account_primary_company_id;
    var $account_subscription;
    var $account_sub_projects;
    var $account_sub_writeboards;
    var $account_sub_storage;
    var $account_sub_time_tracking;
    var $account_sub_name;
    var $account_sub_ssl;
    var $objDOM;
    var $a;
    var $i;
    var $k;
    var $x;
    var $y;
    var $z;
    var $projects;
    var $project;
    var $project_elements;
    var $project_data;
    var $project_title;
    var $project_id;
    var $project_last_changed_on;
    var $project_name;
    var $project_value;
    var $project_array = array();
    var $to_do_lists;
    var $to_do_list;
    var $to_do_list_elements;
    var $to_do_list_data;
    var $to_do_list_id;
    var $to_do_list_array = array();
    var $to_do_items;
    var $to_do_item;
    var $to_do_item_elements;
    var $to_do_item_data;
    var $to_do_item_id;
    var $to_do_item_array = array();
    var $item_due_at;
    var $item_completed;
    var $item_over_due;
    var $item_due_time;
    var $item_due;
    var $item_current_time;
    var $categories;
    var $category;
    var $category_elements;
    var $category_data;
    var $category_value;
    var $category_id;
    var $category_name;
    var $category_array = array();
    var $messages;
    var $message;
    var $message_elements;
    var $message_data;
    var $message_value;
    var $message_body;
    var $message_array = array();
    var $milestones;
    var $milestone;
    var $milestone_elements;
    var $milestone_data;
    var $milestone_value;
    var $milestone_completed;
    var $milestone_deadline;
    var $milestone_due;
    var $milestone_due_date;
    var $milestone_array = array();
    var $milestone_current_time;
    var $string;
    var $body;
    var $value;
    var $title;
    var $CI;

    function Response_get($param) {
        $this->ident = $param['ident'];
        $this->CI = & get_instance();
    }

    function getAccountResponse() {
        $file = "xml/users_account/" . $this->ident . "/project/account.xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $account = $objDOM->getElementsByTagName("account");
            foreach ($account as $account_elements) {
                $account_created_at = $account_elements->getElementsByTagName("created-at")->item(0)->nodeValue;
                $account_id = $account_elements->getElementsByTagName("id")->item(0)->nodeValue;
                $account_updated_at = $account_elements->getElementsByTagName("updated-at")->item(0)->nodeValue;
                $account_name = $account_elements->getElementsByTagName("name")->item(0)->nodeValue;
                $account_account_holder_id = $account_elements->getElementsByTagName("account-holder-id")->item(0)->nodeValue;
                $account_ssl_enabled = $account_elements->getElementsByTagName("ssl-enabled")->item(0)->nodeValue;
                $account_time_tracking_enabled = $account_elements->getElementsByTagName("time-tracking-enabled")->item(0)->nodeValue;
                $account_email_notification_enabled = $account_elements->getElementsByTagName("email-notification-enabled")->item(0)->nodeValue;
                $account_storage = $account_elements->getElementsByTagName("storage")->item(0)->nodeValue;
                $account_primary_company_id = $account_elements->getElementsByTagName("primary-company-id")->item(0)->nodeValue;
                $account_subscription = $objDOM->getElementsByTagName("subscription");
                foreach ($account_subscription as $subscription_data) {
                    $account_sub_projects = $subscription_data->getElementsByTagName("projects")->item(0)->nodeValue;
                    $account_sub_writeboards = $subscription_data->getElementsByTagName("writeboards")->item(0)->nodeValue;
                    $account_sub_storage = $subscription_data->getElementsByTagName("storage")->item(0)->nodeValue;
                    $account_sub_time_tracking = $subscription_data->getElementsByTagName("time-tracking")->item(0)->nodeValue;
                    $account_sub_name = $subscription_data->getElementsByTagName("name")->item(0)->nodeValue;
                    $account_sub_ssl = $subscription_data->getElementsByTagName("ssl")->item(0)->nodeValue;
                }
            }
            return $account_id;
        }
    }

    function getProjectResponse() {
        $file = "xml/users_account/" . $this->ident . "/project/projects.xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $projects = $objDOM->getElementsByTagName("projects");
            foreach ($projects as $project_elements) {
                $a = 0;
                $project = $objDOM->getElementsByTagName("project");
                foreach ($project as $project_data) {
                    //                var $announcement = $project_data->getElementsByTagName("announcement")->item(0)->nodeValue;
                    //                var $created_on = $project_data->getElementsByTagName("created-on")->item(0)->nodeValue;
                    $project_id = $project_data->getElementsByTagName("id")->item(0)->nodeValue;
                    $project_last_changed_on = $project_data->getElementsByTagName("last-changed-on")->item(0)->nodeValue;
                    $project_name = $project_data->getElementsByTagName("name")->item(0)->nodeValue;
                    //                var $show_announcement = $project_data->getElementsByTagName("show-announcement")->item(0)->nodeValue;
                    //                var $show_writeboard = $project_data->getElementsByTagName("show-writeboards")->item(0)->nodeValue;
                    //                var $start_page = $project_data->getElementsByTagName("start-page")->item(0)->nodeValue;
                    $project_status = $project_data->getElementsByTagName("status")->item(0)->nodeValue;
                    //                var $company = $project_data->getElementsByTagName("company");
                    //                foreach ($project_data_company as $project_data_company_data){
                    //                    var $company_id = $project_data_company_data->getElementsByTagName("id")->item(0)->nodeValue;
                    //                    var $company_name = $project_data_company_data->getElementsByTagName("name")->item(0)->nodeValue;
                    //                }
                    if ($project_status == "active") {
                        $project_array['data'][$a]['project_id'] = $project_id;
                        $project_array['data'][$a]['project_title'] = $project_name;
                        $project_array['data'][$a]['project_last_changed_on'] = $project_last_changed_on;
                        $a++;
                    }
                }
            }
            $project_array['projects'] = $a;
            if ((isset($project_array)) && (!empty($project_array))) {
                return $project_array;
            }
        }
    }

    function getToDoListsResponse($project_id) {
        $file = "xml/users_account/" . $this->ident . "/project/todolists/lists_" . $project_id . ".xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $to_do_lists = $objDOM->getElementsByTagName("todo-lists");
            foreach ($to_do_lists as $to_do_list_elements) {
                $i = 0;
                $to_do_list = $objDOM->getElementsByTagName("todo-list");
                foreach ($to_do_list as $to_do_list_data) {
                    $completed_count = $to_do_list_data->getElementsByTagName("completed-count")->item(0)->nodeValue;
                    //                $description = $to_do_list_data->getElementsByTagName("description")->item(0)->nodeValue;
                    $to_do_list_id = $to_do_list_data->getElementsByTagName("id")->item(0)->nodeValue;
                    $milestone_id = $to_do_list_data->getElementsByTagName("milestone-id")->item(0)->nodeValue;
                    //                $name = $to_do_list_data->getElementsByTagName("name")->item(0)->nodeValue;
                    //                $position = $to_do_list_data->getElementsByTagName("position")->item(0)->nodeValue;
                    //                $private = $to_do_list_data->getElementsByTagName("private")->item(0)->nodeValue;
                    $project_id = $to_do_list_data->getElementsByTagName("project-id")->item(0)->nodeValue;
                    //                $tracked = $to_do_list_data->getElementsByTagName("tracked")->item(0)->nodeValue;
                    $uncompleted_count = $to_do_list_data->getElementsByTagName("uncompleted-count")->item(0)->nodeValue;
                    $complete = $to_do_list_data->getElementsByTagName("complete")->item(0)->nodeValue;

                    $to_do_list_array[$i]["id"] = $to_do_list_id;
                    $to_do_list_array[$i]["milestone_id"] = $milestone_id;
                    $to_do_list_array[$i]["project_id"] = $project_id;
                    //                $to_do_list_array[$i]["progress"] = round(($completed_count / ($completed_count + $uncompleted_count))* 100);
                    $to_do_list_array[$i]["complete"] = $complete;
                    $to_do_list_array[$i]["completed_count"] = $completed_count;
                    $to_do_list_array[$i]["uncompleted_count"] = $uncompleted_count;


                    $i++;
                }
            }
            if ((isset($to_do_list_array)) && (!empty($to_do_list_array))) {
                return $to_do_list_array;
            }
        }
    }

    function getToDoItemsResponse($to_do_list_id) {
        $file = "xml/users_account/" . $this->ident . "/project/todoitems/items_" . $to_do_list_id . ".xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $to_do_items = $objDOM->getElementsByTagName("todo-items");

            foreach ($to_do_items as $to_do_item_elements) {
                $i = 0;
                $to_do_item = $objDOM->getElementsByTagName("todo-item");
                foreach ($to_do_item as $to_do_item_data) {
                    $item_due_at = $to_do_item_data->getElementsByTagName("due-at")->item(0)->nodeValue;
                    $item_completed = $to_do_item_data->getElementsByTagName("completed")->item(0)->nodeValue;

                    $to_do_item_array[$i]['item_due'] = $item_due_at;
                    $to_do_item_array[$i]['item_completed'] = $item_completed;

                    $i++;
                }
            }

            if ((isset($to_do_item_array)) && (!empty($to_do_item_array))) {
                return $to_do_item_array;
            }
        }
    }

    function getCategoryReponse($project_id) {
        $file = "xml/users_account/" . $this->ident . "/project/categories/cat_" . $project_id . ".xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $categories = $objDOM->getElementsByTagName("categories");
            foreach ($categories as $category_elements) {
                $category = $objDOM->getElementsByTagName("category");
                foreach ($category as $category_data) {
                    //                $elements_count = $category_data->getElementsByTagName("elements-count")->item(0)->nodeValue;
                    $category_id = $category_data->getElementsByTagName("id")->item(0)->nodeValue;
                    $category_name = $category_data->getElementsByTagName("name")->item(0)->nodeValue;
                    //                $project_id = $category_data->getElementsByTagName("project-id")->item(0)->nodeValue;
                    //                $type = $category_data->getElementsByTagName("type")->item(0)->nodeValue;
                    if (strtolower($category_name) == 'status update') {
                        $category_array = $category_id;
                        break 2;
                    }
                }
            }
            if ((isset($category_array)) && (!empty($category_array))) {
                return $category_array;
            }
        }
    }

    function getMessageReponse($project_id, $category_id) {
        $file = "xml/users_account/" . $this->ident . "/project/messages/msg_" . $project_id . "_" . $category_id . ".xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $messages = $objDOM->getElementsByTagName("posts");
            foreach ($messages as $message_elements) {
                $i = 0;
                $message = $objDOM->getElementsByTagName("post");
                foreach ($message as $message_data) {
                    //                    $attachments_count = $message_data->getElementsByTagName("attachments-count")->item(0)->nodeValue;
                    //                    $author_id = $message_data->getElementsByTagName("author-id")->item(0)->nodeValue;
                    $message_body = $message_data->getElementsByTagName("body")->item(0)->nodeValue;
                    //                    $cat_id = $message_data->getElementsByTagName("category-id")->item(0)->nodeValue;
                    //                    $cat_name = $message_data->getElementsByTagName("category-name")->item(0)->nodeValue;
                    //                    $comments_count = $message_data->getElementsByTagName("comments-count")->item(0)->nodeValue;
                    //                    $display_body = $message_data->getElementsByTagName("display-body")->item(0)->nodeValue;
                    //                    $from_client = $message_data->getElementsByTagName("from-client")->item(0)->nodeValue;
                    //                    $id = $message_data->getElementsByTagName("id")->item(0)->nodeValue;
                    //                    $milestone_id = $message_data->getElementsByTagName("milestone-id")->item(0)->nodeValue;
                    //                    $posted_on = $message_data->getElementsByTagName("posted-on")->item(0)->nodeValue;
                    //                    $private = $message_data->getElementsByTagName("private")->item(0)->nodeValue;
                    //                    $project_id = $message_data->getElementsByTagName("project-id")->item(0)->nodeValue;
                    //                    $read_by_person = $message_data->getElementsByTagName("read-by-person")->item(0)->nodeValue;
                    //                    $title = $message_data->getElementsByTagName("title")->item(0)->nodeValue;
                    //                    $use_textile = $message_data->getElementsByTagName("use-textile")->item(0)->nodeValue;
                    //                    $author_name = $message_data->getElementsByTagName("author-name")->item(0)->nodeValue;
                    //                    $extended_body = $message_data->getElementsByTagName("extended-body")->item(0)->nodeValue;
                    //                    $display_extended_body = $message_data->getElementsByTagName("display-extended-body")->item(0)->nodeValue;
                    $message_body = $this->tagstrip($message_body);
                    $message_body = strip_tags($message_body);

                    $message_array[$i] = $message_body;
                    $i++;
                }
            }
            if ((isset($message_array)) && (!empty($message_array))) {
                return $message_array;
            }
        }
    }

    function getMilestoneReponse($project_id) {
        $file = "xml/users_account/" . $this->ident . "/project/milestones/milestone_" . $project_id . ".xml";
        $string = read_file($file);
        if (!empty($string)) {
            $objDOM = new DOMDocument();
            $objDOM->formatOutput = true;
            $objDOM->preserveWhiteSpace = false;
            $objDOM->load($file);

            $milestones = $objDOM->getElementsByTagName("milestones");
            foreach ($milestones as $milestone_elements) {
                $i = 0;
                $milestone = $objDOM->getElementsByTagName("milestone");
                foreach ($milestone as $milestone_data) {
                    //                $commented_at = $milestone_data->getElementsByTagName("commented-at")->item(0)->nodeValue;
                    //                $comments_count = $milestone_data->getElementsByTagName("comments-count")->item(0)->nodeValue;
                    $milestone_completed = $milestone_data->getElementsByTagName("completed")->item(0)->nodeValue;
                    if ($milestone_completed == 'true') {
                        $completed_on = $milestone_data->getElementsByTagName("completed-on")->item(0)->nodeValue;
                    }
                    //                $completer_id = $milestone_data->getElementsByTagName("completer-id")->item(0)->nodeValue;
                    //                $created_on = $milestone_data->getElementsByTagName("created-on")->item(0)->nodeValue;
                    //                $creator_id = $milestone_data->getElementsByTagName("creator-id")->item(0)->nodeValue;
                    $id = $milestone_data->getElementsByTagName("id")->item(0)->nodeValue;
                    //                $project_id = $milestone_data->getElementsByTagName("project-id")->item(0)->nodeValue;
                    //                $responsible_party_id = $milestone_data->getElementsByTagName("responsible-party-id")->item(0)->nodeValue;
                    //                $responsible_party_type = $milestone_data->getElementsByTagName("responsible-party-type")->item(0)->nodeValue;
                    $title = $milestone_data->getElementsByTagName("title")->item(0)->nodeValue;
                    //                $wants_notification = $milestone_data->getElementsByTagName("wants-notification")->item(0)->nodeValue;
                    //                $creator_name = $milestone_data->getElementsByTagName("creator-name")->item(0)->nodeValue;
                    $milestone_deadline = $milestone_data->getElementsByTagName("deadline")->item(0)->nodeValue;
                    //                $completer_name = $milestone_data->getElementsByTagName("completer-name")->item(0)->nodeValue;
                    $responsible_party_name = $milestone_data->getElementsByTagName("responsible-party-name")->item(0)->nodeValue;

                    $milestone_array['data'][$i]['milestone_completed'] = $milestone_completed;

                    if ($milestone_completed == 'true') {
                        $milestone_array['data'][$i]['milestone_completed_on'] = new DateTime($completed_on, new DateTimeZone('America/Chicago'));
                    }

                    $milestone_array['data'][$i]['milestone_title'] = $title;
                    $milestone_array['data'][$i]['milestone_deadline'] = new DateTime($milestone_deadline, new DateTimeZone('America/Chicago'));

                    //Added for the Module
                    $milestone_array['data'][$i]['milestone_id'] = $id;
                    $milestone_array['data'][$i]['milestone_responsible'] = $responsible_party_name;
                    $i++;
                }
            }

            if ((isset($milestone_array)) && (!empty($milestone_array))) {
                return $milestone_array;
            }
        }
    }

    function tagstrip($body) {
        $patterns[0] = '/<div>/';
        $patterns[1] = '/<\/div>/';
        $patterns[2] = '/<br \/>/';
        $replacements = array();
        $replacements[0] = '';
        $replacements[1] = ' ';
        $replacements[2] = '';
        $body = preg_replace($patterns, $replacements, $body);

        $string = strip_tags($body);

        $value = 0;
        $title = '';
        while (strlen($string) > 50) {
            $value = strlen($string) - 50;
            $title .= substr($string, 0, -$value) . "";

            $string = substr($string, 50);
        }

        $string = $title;

        if (strlen($string) > 250) {
            $value = strlen($string) - 250;
            $body = substr($string, 0, -$value);
            $body .= "...";
        }

        return $body;
    }

}

?>
