<?php

require_once 'search.php';

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 * @property CI_DB_active_record $db
 * @property CI_Zend $zend
 * @property matching_engine_manager $matching_engine_manager
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class search_indexer extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->model("matching_engine_manager");
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function index() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("Matching Engine Manager");
        $this->load->view("admin/index_objects_for_matching", NULL);
    }

    protected function sanitize($input) {
        return htmlentities(strip_tags($input));
    }

    /**
     * @Decorated
     */
    public function search() {
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');

        $index = $this->zend->get_Zend_Search_Lucene();

        $query = 'newly redesigned website';
        $hits = $index->find($query);

        echo 'Index contains ' . $index->count() .
        ' documents.<br /><br />';
        echo 'Search for "' . $query . '" returned ' . count($hits) .
        ' hits<br /><br />';

        foreach ($hits as $hit) {
            echo $hit->title . '<br />';
            echo 'Score: ' . sprintf('%.2f', $hit->score) . '<br />';
            echo $hit->link . '<br /><br />';
        }
    }

    /**
     * @Secured(role = "Administrator")
     */
    public function index_all_objects($create_new_index = 'false') {
        $this->db->select("objectclass.*");
        $this->db->from("objectclass");
        $query = $this->db->get();

        $out = "";
        foreach ($query->result() as $row) {
            $out .= $this->helper_index_all_objects_in_class($row->ObjectClassID, $create_new_index);
            //after the first time, increasemental index
            $create_new_index = "false";
        }
        $this->output->set_output($out);
    }

    protected function helper_index_all_objects_in_class($ObjectClassID, $create_new_index = 'false') {
        $this->load->library('zend');
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->zend->load('Zend/Search/Lucene');
        try {
            $data = $this->matching_engine_manager->get_full_structure_objects($ObjectClassID);
            $data['Lucene_Indexer'] = $this->zend->get_Zend_Search_Lucene($create_new_index == 'true');
            $data['ObjectClassID'] = $ObjectClassID;
            return $this->load->view("admin/index_all_objects_in_class", $data, TRUE);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
        return "";
    }

    /**
     * @Secured(role = "Administrator")
     */
    public function index_all_objects_in_class($ObjectClassID) {
        $out = $this->helper_index_all_objects_in_class($ObjectClassID);
        $this->output->set_output($out);
    }

    /**
     * @Secured(role = "Administrator")
     */
    public function save_matched_class_structure($mode = "insert") {
        $data = array();
        $data['BaseClassID'] = $this->input->post("BaseClassID");
        $data['MatchedClassID'] = $this->input->post("MatchedClassID");
        $data['MatchedStructure'] = $this->input->post("MatchedStructure");
        try {
            if ($mode == "insert") {
                $this->db->insert("matched_class_structure", $data);
            } else if ($mode == "update") {
                $this->db->where('BaseClassID', $data['BaseClassID']);
                $this->db->where('MatchedClassID', $data['MatchedClassID']);
                $this->db->update('matched_class_structure', $data);
            }
        } catch (Exception $exc) {
            ApplicationHook::logError($exc->getTraceAsString());
        }
        if ($this->db->affected_rows() == 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * 
     * @Secured(role = "Administrator")
     */
    public function load_matched_class_structure() {
        $BaseClassID = $this->input->post("BaseClassID");
        $MatchedClassID = $this->input->post("MatchedClassID");
        $rs = $this->matching_engine_manager->get_matched_class_structure($BaseClassID, $MatchedClassID);        
        echo json_encode($rs);
    }

    /**
     * @Decorated
     */
    public function test_matching($ObjectID = 22) {
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');

        $BaseClassID = 2;
        $MatchedClassID = 1;
        $results = $this->matching_engine_manager->get_matched_class_structure($BaseClassID, $MatchedClassID);
        $matchStructure = new stdClass();
        if (count($results) == 1) {
            ApplicationHook::log($results[0]->MatchedStructure);
            $matchStructure = json_decode($results[0]->MatchedStructure);
        }

        $index = $this->zend->get_Zend_Search_Lucene();
        $query = new Zend_Search_Lucene_Search_Query_Boolean();

        $baseObject = $this->matching_engine_manager->get_full_structure_object($BaseClassID, $ObjectID);
        if ($baseObject != NULL) {
            $subquery = self::makeTermQuery($MatchedClassID, 'class_id');
            $query->addSubquery($subquery, true);
            $fields = $baseObject["fields"];
            foreach ($fields as $baseFieldID => $FieldValues) {
                if (isset($matchStructure->$baseFieldID)) {
                    $targetFieldId = $matchStructure->$baseFieldID;                                        
                    $subquery = Zend_Search_Lucene_Search_QueryParser::parse('+(fields:'.$targetFieldId.'@@~'.$FieldValues.'~@@)');
                    $query->addSubquery($subquery, true);                    
                }
            }
        }
//        $subquery = Zend_Search_Lucene_Search_QueryParser::parse("+(fields:88@@~Công nghệ thông tin IT~@@)");
//        $query->addSubquery($subquery, true);
//
//        $subquery = Zend_Search_Lucene_Search_QueryParser::parse("+(fields:19@@~Khuyết ật vận động / Physical disability~@@)");
//        $query->addSubquery($subquery, true);
//        $query->addTerm(new Zend_Search_Lucene_Index_Term("Đồ họa",'88'));

        $hits = $index->find($query);
        $out = "";
        $out .= 'Index contains ' . $index->count() . ' documents.<br /><br />';
        $out .= 'Search for "' . $query . '" returned ' . count($hits) . ' hits<br /><br />';

        foreach ($hits as $hit) {
            $out .= '<br /><b>object_id: ' . $hit->object_id . '</b><br />';
            $out .= 'class_id: ' . $hit->class_id . '<br />';
//            $out .= 'fields_values: ' . $hit->fields . '<br />';
            $out .= 'Score: ' . sprintf('%.2f', $hit->score) . '<br />';
            $matchedObject = $this->matching_engine_manager->get_full_structure_object($MatchedClassID, $hit->object_id);
            $out .= ( print_r($matchedObject, true) . "<br><br><br> ");
        }

        $out .= ( "<br><br><b>baseObject:</b> <br> " . print_r($baseObject, true));
        $out .= ( "<br><br><b>matchStructure:</b> <br> " . print_r($matchStructure, true));
        $this->output->set_output($out);
    }

    public static function makeTermQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Term($term);
        return $query;
    }

    public static function makeFuzzyQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Fuzzy($term);
        return $query;
    }

    public static function makeWildcardQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Wildcard($term);
        return $query;
    }

    public static function makePhraseQuery($fieldValue, $fieldName) {
        $query = new Zend_Search_Lucene_Search_Query_Phrase(array($fieldValue), null, $fieldName);
        return $query;
    }

}

?>
