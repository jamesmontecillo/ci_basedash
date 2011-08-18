<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ProjectDashletXmlClass
 *
 * @author jmsmontecillo
 */
class Settings_dashlets {
    var $ident;
    var $directory;
    var $settings;
    
    function Settings_dashlets($params){
        $this->ident = $params['ident'];
        $this->directory = "xml/users_account/" . $this->ident. "/settings/";
        $this->settings = $this->directory . "dashlet.xml";
    }
    
    function addDashlet($conf_dashlet) {

        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0777);
            chmod( $this->directory, 0777 );
        }
        if (!file_exists($this->settings)) {
            $open_file = 'x+';

            $response =
                '<?xml version="1.0" encoding="UTF-8"?>
                <settings type="array">
                  <dashlet>
                    <width>1380</width>
                  </dashlet>
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
        $newproject = $objDOM->createElement('dashlet');
        $newproject->appendChild($objDOM->createElement('width', $conf_dashlet));
        $objDOM->getElementsByTagName('settings')->item(0)->appendChild($newproject);
        $objDOM->save( $this->settings );
    }

    function updateDashlet($dashlet) {
        $objDOM = new DOMDocument();
        $objDOM->formatOutput = true;
        $objDOM->preserveWhiteSpace = false;
        $objDOM->load( $this->settings );

        $config_projects = $objDOM->getElementsByTagName("settings");
        $exist = 0;
        foreach ($config_projects as $config_projects_elements) {
            $config_project = $objDOM->getElementsByTagName("dashlet");
            foreach ($config_project as $config_project_data) {
                $config_dashlet = $config_project_data->getElementsByTagName("width")->item(0);
                $config_dashlet->nodeValue = $dashlet;
                $config_project_data->replaceChild($config_dashlet, $config_dashlet);
                $objDOM->save( $this->settings );
                $exist = 1;
            }
        }
        return $exist;
    }

    function getDashlet() {
        $objDOM = new DOMDocument();
        $objDOM->formatOutput = true;
        $objDOM->preserveWhiteSpace = false;
        $objDOM->load( $this->settings );
        $conf_projects = $objDOM->getElementsByTagName("settings");
        $conf_dashlet = '1380';
        foreach ($conf_projects as $conf_projects_elements) {
            $conf_project = $objDOM->getElementsByTagName("dashlet");
            foreach ($conf_project as $conf_project_data) {
                $conf_dashlet = $conf_project_data->getElementsByTagName("width")->item(0)->nodeValue;
            }
        }       
        return $conf_dashlet;
    }
}
?>
