<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 * @property CI_Zend $zend
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class search_indexer extends Controller {

    public function __construct() {
        parent::Controller();
    }

    /**
     * @Decorated
     */
    public function index() {

        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("Indexing database");
        
        $this->load->library('zend');
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->zend->load('Zend/Search/Lucene');
        $this->load->library('zend', 'Zend/Feed');
        $this->zend->load('Zend/Feed');

        $text = "";

        //Create index.
        $index = $this->zend->get_Zend_Search_Lucene(false);
        $feeds = array(
            'http://2minutefinance.com/feed'
        );

        //grab each feed.
        foreach ($feeds as $feed) {
            $channel = Zend_Feed::import($feed);
            $text .= ( $channel->title() . '<br />');

            //index each item.
            foreach ($channel->items as $item) {
                if ($item->link() && $item->title() && $item->description()) {
                    //create an index doc.
                    $doc = new Zend_Search_Lucene_Document();
                    $doc->addField(Zend_Search_Lucene_Field::Keyword(
                                    'link', $this->sanitize($item->link())), 'utf-8');
                    $doc->addField(Zend_Search_Lucene_Field::Text('title', $this->sanitize($item->title())), 'utf-8');
                    $doc->addField(Zend_Search_Lucene_Field::Unstored(
                                    'contents', $this->sanitize($item->description())), 'utf-8');

                    $text .= ( "\tAdding: " . $item->title() . '<br />');
                    $index->addDocument($doc);
                }
            }
        }

        $index->commit();
        $text .= ( $index->count() . ' Documents indexed.<br />' );

        $text .= "<br />Done!";
        $this->output->set_output($text);
    }

    public function sanitize($input) {
        return htmlentities(strip_tags($input));
    }

    function search() {
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');

        $index = $this->zend->get_Zend_Search_Lucene(true);

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
    function index_all_objects_in_class($ObjectClassID) {
        $this->load->model("search_manager");
        $this->load->library('zend');
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->zend->load('Zend/Search/Lucene');
        try {
            $data = $this->search_manager->search_objects_by_class($ObjectClassID);
            $data['Lucene_Indexer'] = $this->zend->get_Zend_Search_Lucene(false);
            echo $this->load->view("admin/index_all_objects_in_class", $data, TRUE);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    function test_matching() {
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');

        $index = $this->zend->get_Zend_Search_Lucene(true);
        $query = new Zend_Search_Lucene_Search_Query_MultiTerm();

       // $query->addTerm(new Zend_Search_Lucene_Index_Term("Word",'88'));
        //$query->addTerm(new Zend_Search_Lucene_Index_Term("Đồ họa",'88'));
        $query->addTerm(new Zend_Search_Lucene_Index_Term("108",'object_id'));
        
        $hits = $index->find($query);

        echo 'Index contains ' . $index->count() .
        ' documents.<br /><br />';
        echo 'Search for "' . $query . '" returned ' . count($hits) .
        ' hits<br /><br />';

        foreach ($hits as $hit) {
            echo '<br />object_id: '.$hit->object_id . '<br />';
            echo 'Score: ' . sprintf('%.2f', $hit->score) . '<br />';            
        }
    }

}
?>
