<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class crawler_api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
        Zend_Search_Lucene::setDefaultSearchField('content');
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
            $id = $this->getId();
            if (write_file('./js-data/' . $id . '.js', $data)) {


                $indexer = $this->zend->get_Zend_Search_Lucene();
                $doc = new Zend_Search_Lucene_Document();
                $doc->addField(Zend_Search_Lucene_Field::Keyword('id', $id));
                $doc->addField(Zend_Search_Lucene_Field::Keyword('userid', '1'));
                $doc->addField(Zend_Search_Lucene_Field::UnStored("content", $content, 'utf-8'));
                $indexer->addDocument($doc);
                $indexer->commit();
                $indexer->optimize();

                $status = array("status" => "ok");
            }
        }

        $this->output->set_output(json_encode($status));
    }

    // seed with microseconds
    private function getId() {
        $toks = explode(' ', microtime());
        return (float) $toks[0] + (float) $toks[1];
    }

}
