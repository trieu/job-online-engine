<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mydata extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    static $PREFIX_JS_DATA = 'setDataCallback(';
    static $SUFFIX_JS_DATA = ');;';

    /**
     * @Decorated
     */
    public function view() {
        $id = $this->input->get('id', TRUE);
        $data_url = base_url("/js-data/$id.js");
        $data = array('data_url' => $data_url);
        $this->load->view('unit-tests/crawler_data_view', $data);
    }

    /**
     * @Api
     */
    public function get() {
        $this->load->helper('file');
        $id = $this->input->get('id', TRUE);
        $js_str = read_file("./js-data/$id.js");
        if (is_string($js_str)) {
            $json_str = str_replace(self::$PREFIX_JS_DATA, '', $js_str);
            $json_str = str_replace(self::$SUFFIX_JS_DATA, '', $json_str);
            // $output = json_decode($json_str);
            $this->output->set_output($json_str);
        } else {
            $status = array("message" => "$id is found in database");
            $output = json_encode($status);
            $this->output->set_output($output);
        }
    }

    /**
     * @Api   
     */
    public function post() {
        $this->load->helper('file');
        $content = $this->input->get_post('content');
            $url = $this->input->get_post('url');

        $status = array("status" => "fail");
        if (is_string($content)) {
            $arr_data = array("content" => $content, "url" => $url);
            $data = self::$PREFIX_JS_DATA . ' ' . json_encode($arr_data) . ' ' . self::$SUFFIX_JS_DATA;
            if (write_file('./js-data/123.js', $data)) {
                $status = array("status" => "ok");
            }
        }

        $this->output->set_output(json_encode($status));
    }

}
