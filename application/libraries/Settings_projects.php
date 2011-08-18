<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*     * *********************************************Config.XML********************************************* */
/**
 * Description of ProjectConfigXmlClass
 *
 * @author jmsmontecillo
 */
class Settings_projects {

    var $ident;
    var $directory;
    var $config_projects_elements;
    var $config_project;
    var $config_project_data;
    var $config_project_id;
    var $config_project_enabled;
    var $newproject;
    var $conf_projects;
    var $conf_projects_elements;
    var $conf_project;
    var $conf_project_data;
    var $conf_project_id;
    var $conf_project_enabled;
    var $conf_project_array;
    
    function Settings_projects($params){
        $this->ident = $params['ident'];
        $this->directory = "xml/users_account/" . $this->ident. "/settings/";
        $this->settings = $this->directory. "projects.xml";
    }

    function addProjectConfig($project_id, $project_enabled, $project_order) {

        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777);
            chmod( $this->directory, 0777 );
        }

        if (!file_exists($this->settings)) {
            $open_file = 'x+';

            $response =
                '<?xml version="1.0" encoding="UTF-8"?>
                <settings type="array">
                </settings>';
            $fh = fopen($this->settings, $open_file);
            fwrite($fh, $response);
            fclose($fh);
            chmod( $this->settings, 0777 );
        }

        $objDOM = new DOMDocument();
        $objDOM->formatOutput = true;
        $objDOM->preserveWhiteSpace = false;
        $objDOM->load( $this->settings );

        //Create one new item element
        $newproject = $objDOM->createElement('project');
        $newproject->appendChild($objDOM->createElement('id', $project_id));
        $newproject->appendChild($objDOM->createElement('enabled', $project_enabled));
        $newproject->appendChild($objDOM->createElement('order', $project_order));
        $objDOM->getElementsByTagName('settings')->item(0)->appendChild($newproject);
        $objDOM->save( $this->settings );
    }

    function setProjectEnabled($project_id, $project_enabled) {
        $objDOM = new DOMDocument();
        $objDOM->formatOutput = true;
        $objDOM->preserveWhiteSpace = false;
        $objDOM->load( $this->settings );

        $config_projects = $objDOM->getElementsByTagName("settings");
        $exist = 0;
        foreach ($config_projects as $config_projects_elements) {
            $config_project = $objDOM->getElementsByTagName("project");
            foreach ($config_project as $config_project_data) {
                $config_project_id = $config_project_data->getElementsByTagName("id")->item(0)->nodeValue;

                if ($project_id == $config_project_id) {
                    $config_project_enabled = $config_project_data->getElementsByTagName("enabled")->item(0);
                    $config_project_enabled->nodeValue = $project_enabled;
                    $config_project_data->replaceChild($config_project_enabled, $config_project_enabled);
                    $objDOM->save( $this->settings );
                    $exist = 1;
                }
            }
        }
        return $exist;
    }

    function setProjectOrder($project_id, $project_order) {
        $objDOM = new DOMDocument();
        $objDOM->formatOutput = true;
        $objDOM->preserveWhiteSpace = false;
        $objDOM->load( $this->settings );

        $config_projects = $objDOM->getElementsByTagName("settings");
        $exist = 0;
        foreach ($config_projects as $config_projects_elements) {
            $config_project = $objDOM->getElementsByTagName("project");
            foreach ($config_project as $config_project_data) {
                $config_project_id = $config_project_data->getElementsByTagName("id")->item(0)->nodeValue;

                if ($project_id == $config_project_id) {
                    $config_project_order = $config_project_data->getElementsByTagName("order")->item(0);
                    $config_project_order->nodeValue = $project_order;
                    $config_project_data->replaceChild($config_project_order, $config_project_order);
                    $objDOM->save( $this->settings );
                    $exist = 1;
                }
            }
        }
        return $exist;
    }

    function getProjectConfig($project_id) {

        $objDOM = new DOMDocument();
        $objDOM->formatOutput = true;
        $objDOM->preserveWhiteSpace = false;
        $objDOM->load( $this->settings );

        $conf_projects = $objDOM->getElementsByTagName("settings");
        $conf_project_config = array();
        $i = 1;
        $exist = 0;
        foreach ($conf_projects as $conf_projects_elements) {
            $conf_project = $objDOM->getElementsByTagName("project");
            foreach ($conf_project as $conf_project_data) {
                $conf_project_id = $conf_project_data->getElementsByTagName("id")->item(0)->nodeValue;

                if ($project_id == $conf_project_id) {
                    $conf_project_config['enabled'] = $conf_project_data->getElementsByTagName("enabled")->item(0)->nodeValue;
                    $conf_project_config['order'] = $conf_project_data->getElementsByTagName("order")->item(0)->nodeValue;
                    $exist = 1;
                }
                $i++;
            }
        }
        if ($exist == 0) {
            $this->addProjectConfig($project_id, 'true', $i);
            $conf_project_config['enabled'] = 'true';
            $conf_project_config['order'] = $i;
        }
        return $conf_project_config;
    }
}
?>
