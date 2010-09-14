<?php

//Controller is generated by MVC Schema Engine

/**
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property object_manager $object_manager
 */
class object_service extends Controller {

    function object_service() {
        parent::Controller();
        $this->load->library('curl');
    }

    function index() {
        phpinfo();
    }

    /**
     * 
     */
    public function export_data($ObjectClassID = -1) {
        $data = array();

        $this->load->model("object_manager");
        $data = $this->object_manager->get_raw_data_objects($ObjectClassID);
        echo json_encode($data);
        // $this->load->view("user/user_email_config", $data);
    }

    /**
     * 
     */
    public function import_data($ObjectClassID = -1, $justView = TRUE) {
        $url1 = 'http://tantrieuf31.summerhost.info/job-database/index.php/services/object_service/export_data/' . $ObjectClassID;
        $url2 = 'http://drd-vn-database.com/index.php/services/object_service/export_data/' . $ObjectClassID;
        $url3 = 'http://localhost/job-online-website/tiengviet.php/services/object_service/export_data/' . $ObjectClassID;
        $out = '';

        $rawData = $this->curl->loadHtml($url1);
        //echo "$rawData <BR><BR>";

        $this->load->model("object_manager");
        $rows = json_decode($rawData);

        $objects = array();
        foreach ($rows as $row) {
            $objID = $row->ObjectID;
            if (!isset($objects[$objID])) {
                $objects[$objID] = array();
                $objects[$objID]['FieldValues'] = array();
                $objects[$objID]['IdentityFieldValues'] = array();
            }
            $FieldValue = new stdClass();
            $FieldValue->FieldID = $row->FieldID;
            $FieldValue->FieldValueID = 0;
            $FieldValue->FieldValue = $row->FieldValue;
            $FieldValue->SelectedFieldValue = ($row->SelectedFieldValue == "1") ? true : false;
            array_push($objects[$objID]['FieldValues'], $FieldValue);

            if ($row->FieldID == "112") {
                $objects[$objID]['IdentityFieldValues'][$row->FieldID] = $row->FieldValue;
            }
        }

        $insertedObjNum = 0;
        //{"FieldID":112,"FieldValueID":0,"FieldValue":"tester","SelectedFieldValue":false}
        foreach ($objects as $id => $impoterdObj) {
            if ($this->object_manager->isObjectNotExisted($id, $impoterdObj['IdentityFieldValues'])) {
                $out .= ( json_encode($impoterdObj['FieldValues']) . " -> Import $id <BR><BR>" );
                if ($justView) {
                    $insertedObjNum++;
                } else {
                    $obj = new Object();
                    $obj->setObjectClassID($ObjectClassID);
                    $obj->setObjectID(-1); // add as new
                    $obj->setFieldValues($impoterdObj['FieldValues']);
                    $insertedId = $this->object_manager->save($obj);
                    if ($insertedId > 0) {
                        $out .= ( "Import $id to new $insertedId <BR>" );
                        $insertedObjNum++;
                    }
                }
            }
        }
        if ($insertedObjNum == count($objects)) {
            $out .= ( " ### Success! $insertedObjNum <BR>" );
        }

        echo $out;
        echo "<BR> Need to import $insertedObjNum / " . (count($objects)) . " objects";
    }

    public function simple_get() {
        $responce = $this->curl->simple_get('curl_test/get_message');

        echo '<h1>Simple Get</h1>';
        echo '<p>--------------------------------------------------------------------------</p>';

        if ($responce) {

            echo $responce;


            echo '<br/><p>--------------------------------------------------------------------------</p>';
            echo '<h3>Debug</h3>';
            echo '<pre>';
            print_r($this->curl->info);
            echo '</pre>';
        } else {
            echo '<strong>cURL Error</strong>: ' . $this->curl->error_string;
        }
    }

    function simple_post() {
        $responce = $this->curl->simple_post('curl_test/message', array('message' => 'Sup buddy'));

        echo '<h1>Simple Post</h1>';
        echo '<p>--------------------------------------------------------------------------</p>';

        if ($responce) {

            echo $responce;


            echo '<br/><p>--------------------------------------------------------------------------</p>';
            echo '<h3>Debug</h3>';
            echo '<pre>';
            print_r($this->curl->info);
            echo '</pre>';
        } else {
            echo '<strong>cURL Error</strong>: ' . $this->curl->error_string;
        }
    }

    function message() {
        echo "<h2>Posted Message</h2>";
        echo $_POST['message'];
    }

    function get_message() {
        echo "<h2>Get got!</h2>";
    }

    function advance() {
        $this->curl->create('curl_test/cookies')
                ->set_cookies(array('message' => 'Im advanced :-p'));

        $responce = $this->curl->execute();

        echo '<h1>Advanced</h1>';
        echo '<p>--------------------------------------------------------------------------</p>';

        if ($responce) {

            echo $responce;

            echo '<br/><p>--------------------------------------------------------------------------</p>';
            echo '<h3>Debug</h3>';
            echo '<pre>';
            print_r($this->curl->info);
            echo '</pre>';
        } else {
            echo '<strong>cURL Error</strong>: ' . $this->curl->error_string;
        }
    }

    function cookies() {
        echo "<h2>Cookies</h2>";
        print_r($_COOKIE);
    }

}

?>