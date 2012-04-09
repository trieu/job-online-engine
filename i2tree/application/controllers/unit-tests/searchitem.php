<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * UnitTest for using search PHP Lucene
 *
 * @property CI_Zend $zend 
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class SearchItem extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
        Zend_Search_Lucene::setDefaultSearchField('content');
    }

    /**
     * @Decorated
     */
    public function index() {
        redirect('/unit-tests/searchitem/query');
    }

    public function did_you_mean() {
        $var_1 = 'Eaihad';
        $var_2 = 'Etihad';

        echo levenshtein($var_1, $var_2);
    }

    /**
     * @Decorated
     */
    public function query() {
        try {
            $indexer = $this->zend->get_Zend_Search_Lucene();
            $query = new Zend_Search_Lucene_Search_Query_Boolean();

            $fieldName = 'content';
            $fieldValue = 'vô lê của Van Basten';


            $subquery = Zend_Search_Lucene_Search_QueryParser::parse('+(' . $fieldValue . ')');

            //  $subquery = self::makeFuzzyQuery($fieldValue, $fieldName);

            $query->addSubquery($subquery, true);

            $hits = $indexer->find($query);
            $out = "";
            $out .= 'Index contains ' . $indexer->count() . ' documents.<br /><br />';
            $out .= 'Search for "' . $query . '" returned ' . count($hits) . ' hits<br /><br />';

            foreach ($hits as $hit) {
                $out .= '<br /><b>id: ' . $hit->getDocument()->id . '</b><br />';
                $out .= 'content: ' . $hit->getDocument()->content . '<br />';
                $out .= 'Score: ' . sprintf('%.2f', $hit->score) . '<br />';
            }

            $this->output->set_output($out);
            return;
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    public function indexdata() {
        try {

            $indexer = $this->zend->get_Zend_Search_Lucene();

            $content = 'Mourinho đã nhận lời sang Man City hè này';
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('id', time()));
            $doc->addField(Zend_Search_Lucene_Field::text("content", $content, 'utf-8'));
            $indexer->addDocument($doc);

            $content = 'Torres ghi bàn, Chelsea thắng ngọt ngào ';
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('id', time()));
            $doc->addField(Zend_Search_Lucene_Field::text("content", $content, 'utf-8'));
            $indexer->addDocument($doc);

            $content = 'Ferguson: \'Tôi sẽ bảo Roy Keane xử lý Vieira\'';
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('id', time()));
            $doc->addField(Zend_Search_Lucene_Field::text("content", $content, 'utf-8'));
            $indexer->addDocument($doc);

            $content = 'Benzema tái hiện cú vô lê kinh điển của Van Basten';
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('id', time()));
            $doc->addField(Zend_Search_Lucene_Field::text("content", $content, 'utf-8'));
            $indexer->addDocument($doc);

            $content = 'Man City đứt mạch thắng tại Etihad';
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('id', time()));
            $doc->addField(Zend_Search_Lucene_Field::text("content", $content, 'utf-8'));
            $indexer->addDocument($doc);


            $indexer->commit();
            $indexer->optimize();
            echo ( $indexer->count() . ' documents indexed.<br />' );
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }

        echo "ok";
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
