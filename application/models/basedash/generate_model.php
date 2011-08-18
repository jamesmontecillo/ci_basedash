<?php

/**
 * Description of generate_model
 *
 * @author jmsmontecillo
 */
class generate_model extends CI_Model {

    function generate() {
        $params = array(
            'ident' => $this->input->post('ident'),
            'apikey' => $this->input->post('apikey'),
            'basecampUrl' => $this->input->post('basecampUrl')
        );

        $this->load->library('Generate_xml_data', $params);

        $result = $this->generate_xml_data->setGenerateXmlFiles();

        $ident = $this->input->post('ident');

        if ($result) {

            if (!empty($ident)) {
                delete_files("xml/users_account/" . $ident . "/project/", TRUE);
            }

            rename("./xml/users_account/" . $ident . "/project_new", "./xml/users_account/" . $ident . "/project");

            if (!empty($ident)) {
                delete_files("./xml/users_account/" . $ident . "/project_new", TRUE);
            }

            if ($this->input->post('from') == 'reg') {
                echo
                "   Your Basecamp projects were loaded successfully! \n
                    Please close this window \n
                    and login at the top of the page.\n
                    Thank You!
                ";
            } else if ($this->input->post('from') == 'basedash') {
                echo "You can now continue working with Basedash.";
            }
        }
    }

}

?>
