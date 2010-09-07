<?php
//Controller is generated by MVC Schema Engine

/**
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property VehicleDBUtils $VehicleDBUtils
 * @property Xe $xe
 * @property Gps_markers $gps_markers
 */

class c_message_handler extends Controller {
   

    function c_message_handler() {
        parent::Controller();        
    }

    function index() {
        $this->load->view('comet-ajax/view');
    }

    public function get_messages() {
        $filename  = 'system/application/views/comet-ajax/data.txt';       
        $currentmodif = filemtime($filename);
        
        // return a json array
        $response = array();
        $response['msg']       = file_get_contents($filename);
        $response['timestamp'] = $currentmodif;
        echo json_encode($response);
        flush();
    }

    public function process_data() {
        $filename  = 'system/application/views/comet-ajax/data.txt';

        // store new message in the file
        $msg = isset($_POST['msg']) ? $_POST['msg'] : '';
        if ($msg != '') {
            file_put_contents($filename,$msg);
            echo "Server received!";
            die();
        }

        // infinite loop until the data file is not modified
        $lastmodif    = isset($_POST['timestamp']) ? $_POST['timestamp'] : 0;
        $currentmodif = filemtime($filename);
        while ($currentmodif <= $lastmodif) // check if the data file has been modified
        {
            usleep(10000); // sleep 10ms to unload the CPU

            clearstatcache();
            $currentmodif = filemtime($filename);
        }

        // return a json array
        $response = array();
        $response['msg']       = file_get_contents($filename);
        $response['timestamp'] = $currentmodif;
        echo json_encode($response);
        flush();
    }



}


?>