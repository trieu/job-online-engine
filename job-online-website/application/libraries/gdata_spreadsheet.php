<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Zend library include path
set_include_path(get_include_path() . PATH_SEPARATOR . "$_SERVER[DOCUMENT_ROOT]/job-online-website/application/libraries");

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
Zend_Loader::loadClass('Zend_Gdata_App_AuthException');
Zend_Loader::loadClass('Zend_Http_Client');

/**
 * Simple library for Google Spreadsheet API
 * @author Trieu Nguyen (tantrieuf31@gmail.com)
 */
class gdata_spreadsheet {

    private $gdClient;
    private $currSpreadsheetId = '';
    private $currWorkSheetId = '';
    private $rowCount = 0;
    private $columnCount = 0;

    /**
     * Constructor
     *
     * @param	string $class class name
     */
    function __construct($params = array()) {

    }

    /**
     * connect to Google Spreadsheet
     *
     * @param  string $email
     * @param  string $password
     * @param  string $spreadsheetId
     * @param  string $worksheetId
     * @return void
     */
    public function connect($email, $password, $spreadsheetId, $worksheetId) {
        try {
            $client = Zend_Gdata_ClientLogin::getHttpClient($email, $password, Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME);
            $this->gdClient = new Zend_Gdata_Spreadsheets($client);
            $this->currSpreadsheetId = $spreadsheetId;
            $this->currWorkSheetId = $worksheetId;
        } catch (Zend_Gdata_App_AuthException $ae) {
            exit("Error: ". $ae->getMessage() ."\nCredentials provided were email: [$email] and password [$password].\n");
        }
    }

    /**
     * getRowAndColumnCount
     *
     * @return void
     */
    public function countRowAndCollumn() {
        $query = new Zend_Gdata_Spreadsheets_CellQuery();
        $query->setSpreadsheetKey($this->currSpreadsheetId);
        $query->setWorksheetId($this->currWorkSheetId);
        $feed = $this->gdClient->getCellFeed($query);

        if ($feed instanceOf Zend_Gdata_Spreadsheets_CellFeed) {
            $this->rowCount = $feed->getRowCount();
            $this->columnCount = $feed->getColumnCount();
        }
    }

    public function getCurrSpreadsheetId() {
        return $this->currSpreadsheetId;
    }

    public function getCurrWorkSheetId() {
        return $this->currWorkSheetId;
    }

    public function getRowCount() {
        return $this->rowCount;
    }

    public function getColumnCount() {
        return $this->columnCount;
    }

    public function insertRowIntoWorkSheet($rowArray) {
        $entry = $this->gdClient->insertRow($rowArray, $this->currSpreadsheetId, $this->currWorkSheetId);
        if ($entry instanceof Zend_Gdata_Spreadsheets_ListEntry) {
            return TRUE;
        }
        return FALSE;
    }

    public function updateRowIntoWorkSheet($rowArray, $selectionQuery = FALSE ) {
        $query = new Zend_Gdata_Spreadsheets_ListQuery();
        $query->setSpreadsheetKey($this->currSpreadsheetId);
        $query->setWorksheetId($this->currWorkSheetId);
        if($selectionQuery) {
            $query->setSpreadsheetQuery( $selectionQuery );
        }        
        $listFeed = $this->gdClient->getListFeed($query);
        if($listFeed != NULL) {
            ApplicationHook::logInfo("entries size: ".sizeof($listFeed->entries));
            foreach($listFeed->entries as $entry) {
                $updatedEntry = $this->gdClient->updateRow($entry, $rowArray);
                if ($updatedEntry instanceof Zend_Gdata_Spreadsheets_ListEntry) {
                    $response = $updatedEntry->save();
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function searchRows($selectionQuery = FALSE ) {
        $query = new Zend_Gdata_Spreadsheets_ListQuery();
        $query->setSpreadsheetKey($this->currSpreadsheetId);
        $query->setWorksheetId($this->currWorkSheetId);
        if($selectionQuery) {
            $query->setSpreadsheetQuery( $selectionQuery );
        }        
        $listFeed = $this->gdClient->getListFeed($query);
        if($listFeed != NULL) {
           return $listFeed;
        }
        return FALSE;
    }


    /**
     * printFeed
     *
     * @param  Zend_Gdata_Gbase_Feed $feed
     * @return void
     */
    public function printFeed($feed) {
        $i = 0;
        foreach($feed->entries as $entry) {
            ApplicationHook::logInfo( "<br/>id: ".$entry->id->text."<br/>");
            if ($entry instanceof Zend_Gdata_Spreadsheets_CellEntry) {
                ApplicationHook::logInfo( $entry->title->text .' '. $entry->content->text . "<br/>");
            } else if ($entry instanceof Zend_Gdata_Spreadsheets_ListEntry) {
                ApplicationHook::logInfo($i .' '. $entry->title->text .' | '. $entry->content->text . "<br/>");
            } else {
                ApplicationHook::logInfo( $i .' '. $entry->title->text . "<br/>");
            }
            $i++;
        }
    }
}

?>
