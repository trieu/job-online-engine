<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 * @property CI_DB_active_record $db
 * @property CI_Zend $zend
 * @property matching_engine_manager $matching_engine_manager
 * @property search_manager $search_manager
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class intelligent_search_service extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->model("matching_engine_manager");
        $this->load->model("search_manager");
    }

    /**
     * @Secured(role = "GroupOperator")
     */
    public function get_matched_class_structures($BaseClassID) {
        $rs = $this->matching_engine_manager->get_matched_class_structures($BaseClassID);
        echo json_encode($rs);
    }

    /**
     * @Secured(role = "GroupOperator")
     */
    public function search_from_matched_structure() {
        setlocale(LC_CTYPE, 'vn_VN.utf-8');
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');

        $BaseClassID = $this->input->post("BaseClassID");
        $MatchedClassID = $this->input->post("MatchedClassID");
        $ObjectID = $this->input->post("ObjectID");
        $matchStructure = $this->input->post("matchStructure");

        if (isset($matchStructure)) {
            $matchStructure = json_decode($matchStructure);
        }
        $baseObject = $this->matching_engine_manager->get_full_structure_object($BaseClassID, $ObjectID);

        $index = $this->zend->get_Zend_Search_Lucene();
        $query = new Zend_Search_Lucene_Search_Query_Boolean();
        $hits = array();

        try {
            if ($baseObject != NULL) {
                $subquery = self::makeTermQuery($MatchedClassID, 'class_id');
                $query->addSubquery($subquery, true);
                $fields = $baseObject["fields"];
                foreach ($fields as $baseFieldID => $FieldValues) {
                    if (isset($matchStructure->$baseFieldID)) {
                        $targetFieldId = $matchStructure->$baseFieldID;
                        $subquery = Zend_Search_Lucene_Search_QueryParser::parse('+(fields:' . $targetFieldId . '@@~' . $FieldValues . '~@@)');
                        $query->addSubquery($subquery, true);
                    }
                }
            }
            $hits = $index->find($query);
        } catch (Exception $exc) {
            ApplicationHook::logError($exc->getTraceAsString());
        }

        $matched_object_ids = "";
        $idx = 0;
        $lastEleIdx = count($hits) - 1;
        foreach ($hits as $hit) {
            if ($idx != $lastEleIdx) {
                $matched_object_ids .= ( $hit->object_id . ", ");
            } else {
                $matched_object_ids .= ( $hit->object_id );
            }
            $idx++;
        }
        if ($matched_object_ids != "") {
            $data = $this->search_manager->search_objects_by_id_list($MatchedClassID, $matched_object_ids);
            echo $this->load->view("admin/all_objects_in_class", $data, TRUE);
        } else {
            echo "Not found interesting things!";
        }
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
