<?php

/**
 * Description of SetResponseClass
 *
 * @author jmsmontecillo
 */
class Response_set {

    var $params = array();
    var $ident;
    var $apikey;
    var $basecampUrl;
    var $CI;
    var $diretory = array();
    var $project_dir;
    var $request;
    var $response;
    var $filename;
    var $project_id;
    var $to_do_list_id;
    var $category_id;
    var $dir;
    var $open_file;
    var $fh;
    var $xml;
    var $token;
    var $result;
    var $pad;
    var $matches;
    var $indent;
    var $line;

    function Response_set($params) {
        $this->ident = $params['ident'];
        $this->apikey = $params['apikey'];
        $this->basecampUrl = $params['basecampUrl'];
        $this->CI = & get_instance();

        $this->CI->load->library('Rest');
        $this->CI->rest->initialize(
                array(
                    'server' => $this->basecampUrl,
                    'http_user' => $this->apikey,
                    'http_pass' => 'X',
                    'http_auth' => 'basic' // or 'digest'  
        ));
    }

    //first thing to do is to generate all the directories needed
    function GenerateDirectories() {
        //Clear the project directory if exist
        if (!empty($this->ident)) {
            delete_files("xml/users_account/" . $this->ident . "/project_new/", TRUE);
        }
        //Create the users directory first      
        $directory[] = "xml/users_account/" . $this->ident;
        //Then Create the subdir of the user
        $directory[] = "xml/users_account/" . $this->ident . "/settings/";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/todolists";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/todoitems";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/categories";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/messages";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/milestones";
        $directory[] = "xml/users_account/" . $this->ident . "/project_new/calendar";
        foreach ($directory as $project_dir) {
            $this->CreateDirectory($project_dir);
        }
    }

    function createProjectConfig() {
        $filename = "xml/users_account/" . $this->ident . "/settings/projects.xml";
        if (!file_exists($filename)) {
            $response =
                    '<?xml version="1.0" encoding="UTF-8"?>' .
                    '<settings type="array">' .
                    '</settings>';

            $response = $this->formatXmlString($response);
            $this->CreateFileXml($filename, $response);
        }
    }

    function createDashletConfig() {
        $filename = "xml/users_account/" . $this->ident . "/settings/dashlet.xml";

        if (!file_exists($filename)) {
            $response =
                    '<?xml version="1.0" encoding="UTF-8"?>
                    <settings type="array">
                      <dashlet>
                        <width>1380</width>
                      </dashlet>
                    </settings>';

            $response = $this->formatXmlString($response);

            $this->CreateFileXml($filename, $response);
        }
    }

    function setEverything() {
        $this->GenerateDirectories();
        $this->createProjectConfig();
        $this->createDashletConfig();
    }

    function setAccountResponse() {
        $this->CI->rest->get('account.xml');
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/account.xml";

        $this->CreateFileXml($filename, $response);
    }

    function setProjectResponse() {
        $this->CI->rest->get('projects.xml');
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/projects.xml";

        $this->CreateFileXml($filename, $response);
    }

    function setToDoListsResponse($project_id) {

        $this->CI->rest->get("projects/" . $project_id . "/todo_lists.xml?filter=all");
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/todolists/lists_" . $project_id . ".xml";

        $this->CreateFileXml($filename, $response);
    }

    function setToDoItemsResponse($to_do_list_id) {
        $this->CI->rest->get("todo_lists/" . $to_do_list_id . "/todo_items.xml");
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/todoitems/items_" . $to_do_list_id . ".xml";

        $this->CreateFileXml($filename, $response);
    }

    function createCategoryPost($project_id) {

        $post_category =
                array(
                    'category' => array(
                        'type' => 'post',
                        'name' => 'Status Update'
                    )
        );
        $response = $this->CI->rest->post('projects/' . $project_id . '/categories.xml', $post_category);
        return $response;
    }

    function setCategoryReponse($project_id) {
        $this->CI->rest->get('projects/' . $project_id . '/categories.xml?type=post');
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/categories/cat_" . $project_id . ".xml";

        $this->CreateFileXml($filename, $response);
    }

    function setMessageReponse($project_id, $category_id) {
        $this->CI->rest->get('projects/' . $project_id . '/cat/' . $category_id . '/posts.xml');
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/messages/msg_" . $project_id . "_" . $category_id . ".xml";

        $this->CreateFileXml($filename, $response);
    }

    function setMilestoneReponse($project_id) {

        $this->CI->rest->get('projects/' . $project_id . '/milestones/list.xml');
//        $this->CI->rest->get('projects/' . $project_id . '/calendar_entries/milestones.xml');
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/milestones/milestone_" . $project_id . ".xml";

        $this->CreateFileXml($filename, $response);
    }

    function setMilestoneReponseNew($project_id) {

        $this->CI->rest->get('projects/' . $project_id . '/calendar_entries/milestones.xml');
        $request = $this->CI->rest->get_response();
        $response = $this->formatXmlString($request);

        $filename = "xml/users_account/" . $this->ident . "/project_new/calendar/milestone_" . $project_id . ".xml";

        $this->CreateFileXml($filename, $response);
    }

    function CreateDirectory($dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
            return true;
        }
        return false;
    }

    function CreateFileXml($filename, $response) {
        $open_file = 'x+';

        if (file_exists($filename)) {
            $open_file = 'w';
        }

        $fh = fopen($filename, $open_file);
        fwrite($fh, $response);
        fclose($fh);
        chmod($filename, 0777);
        return true;
    }

    function formatXmlString($xml) {
        // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
        $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

        // now indent the tags
        $token = strtok($xml, "\n");
        $result = ''; // holds formatted version as it is built
        $pad = 0; // initial indent
        $matches = array(); // returns from preg_matches()
        // scan each line and adjust indent based on opening/closing tags
        while ($token !== false) :

            // test for the various tag states
            // 1. open and closing tags on same line - no change
            if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
                $indent = 0;
            // 2. closing tag - outdent now
            elseif (preg_match('/^<\/\w/', $token, $matches)) :
                $pad--;
            // 3. opening tag - don't pad this one, only subsequent tags
            elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
                $indent = 1;
            // 4. no indentation needed
            else :
                $indent = 0;
            endif;

            // pad the line with the required number of leading spaces
            $line = str_pad($token, strlen($token) + $pad, ' ', STR_PAD_LEFT);
            $result .= $line . "\n"; // add to the cumulative result, with linefeed
            $token = strtok("\n"); // get the next token
            $pad += $indent; // update the pad size for subsequent lines
        endwhile;

        return $result;
    }

}