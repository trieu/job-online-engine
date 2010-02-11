<?php

// Zend library include path
set_include_path(get_include_path() . PATH_SEPARATOR . "$_SERVER[DOCUMENT_ROOT]/job-online-website/application/libraries");

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
Zend_Loader::loadClass('Zend_Gdata_App_AuthException');
Zend_Loader::loadClass('Zend_Http_Client');

/**
 * SimpleCRUD
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Demos
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class SimpleCRUD {

    private $gdClient;

    public function gdClient() {
        return $this->gdClient;
    }

    /**
     * Constructor
     *
     * @param  string $email
     * @param  string $password
     * @return void
     */
    public function __construct($email, $password) {
        try {
            $client = Zend_Gdata_ClientLogin::getHttpClient($email, $password,
                    Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME);
        } catch (Zend_Gdata_App_AuthException $ae) {
            exit("Error: ". $ae->getMessage() ."\nCredentials provided were email: [$email] and password [$password].\n");
        }

        $this->gdClient = new Zend_Gdata_Spreadsheets($client);
        $this->currKey = '';
        $this->currWkshtId = '';
        $this->listFeed = '';
        $this->rowCount = 0;
        $this->columnCount = 0;
    }

    /**
     * promptForSpreadsheet
     *
     * @return void
     */
    public function getExistingSpreadsheets() {
        $feed = $this->gdClient->getSpreadsheetFeed();
        return $feed;

//        $input = getInput("\nSelection");
//        $currKey = explode('/', $feed->entries[$input]->id->text);
        $this->currKey = "tPF0KO8zz8gIB75IZB6fMcQ";
    }

    /**
     * promptForWorksheet
     *
     * @return void
     */
    public function promptForWorksheet() {
        $query = new Zend_Gdata_Spreadsheets_DocumentQuery();
        $query->setSpreadsheetKey("tPF0KO8zz8gIB75IZB6fMcQ");
        $feed = $this->gdClient->getWorksheetFeed($query);
        print "== Available Worksheets ==\n";
        $this->printFeed($feed);
        $input = 0; //getInput("\nSelection");
        $currWkshtId = explode('/', $feed->entries[$input]->id->text);
        $this->currWkshtId = $currWkshtId[8];

    }

    /**
     * promptForCellsAction
     *
     * @return void
     */
    public function promptForCellsAction() {
        echo "Pick a command:\n";
        echo "\ndump -- dump cell information\nupdate {row} {col} {input_value} -- update cell information\n";
        $input = getInput('Command');
        $command = explode(' ', $input);
        if ($command[0] == 'dump') {
            $this->cellsGetAction();
        } else if (($command[0] == 'update') && (count($command) > 2)) {
            $this->getRowAndColumnCount();
            if (count($command) == 4) {
                $this->cellsUpdateAction($command[1], $command[2], $command[3]);
            } elseif (count($command) > 4) {
                $newValue = implode(' ', array_slice($command,3));
                $this->cellsUpdateAction($command[1], $command[2], $newValue);
            } else {
                $this->cellsUpdateAction($command[1], $command[2], '');
            }
        } else {
            $this->invalidCommandError($input);
        }
    }

    /**
     * promptToResize
     *
     * @param  integer $newRowCount
     * @param  integer $newColumnCount
     * @return boolean
     */
    public function promptToResize($newRowCount, $newColumnCount) {
        $input = getInput('Would you like to resize the worksheet? [yes | no]');
        if ($input == 'yes') {
            return $this->resizeWorksheet($newRowCount, $newColumnCount);
        } else {
            return false;
        }
    }

    /**
     * resizeWorksheet
     *
     * @param  integer $newRowCount
     * @param  integer $newColumnCount
     * @return boolean
     */
    public function resizeWorksheet($newRowCount, $newColumnCount) {
        $query = new Zend_Gdata_Spreadsheets_DocumentQuery();
        $query->setSpreadsheetKey($this->currKey);
        $query->setWorksheetId($this->currWkshtId);
        $currentWorksheet = $this->gdClient->getWorksheetEntry($query);
        $currentWorksheet = $currentWorksheet->setRowCount(new Zend_Gdata_Spreadsheets_Extension_RowCount($newRowCount));
        $currentWorksheet = $currentWorksheet->setColumnCount(new Zend_Gdata_Spreadsheets_Extension_ColCount($newColumnCount));
        $currentWorksheet->save();
        $this->getRowAndColumnCount();
        print "Worksheet has been resized to $this->rowCount rows and $this->columnCount columns.\n";
        return true;
    }

    /**
     * promptForListAction
     *
     * @return void
     */
    public function promptForListAction() {
        echo  "\n== Options ==\n".
                "dump -- dump row information\n".
                "insert {row_data} -- insert data in the next available cell in a given column (example: insert column_header=content)\n".
                "update {row_index} {row_data} -- update data in the row provided (example: update row-number column-header=newdata\n".
                "delete {row_index} -- delete a row\n\n";

        $input = getInput('Command');
        $command = explode(' ', $input);
        if ($command[0] == 'dump') {
            $this->listGetAction();
        } else if ($command[0] == 'insert') {
            $this->listInsertAction(array_slice($command, 1));
        } else if ($command[0] == 'update') {
            $this->listUpdateAction($command[1], array_slice($command, 2));
        } else if ($command[0] == 'delete') {
            $this->listDeleteAction($command[1]);
        } else {
            $this->invalidCommandError($input);
        }
    }

    /**
     * cellsGetAction
     *
     * @return void
     */
    public function cellsGetAction() {
        $query = new Zend_Gdata_Spreadsheets_CellQuery();
        $query->setSpreadsheetKey($this->currKey);
        $query->setWorksheetId($this->currWkshtId);
        $feed = $this->gdClient->getCellFeed($query);
        $this->printFeed($feed);
    }

    /**
     * cellsUpdateAction
     *
     * @param  integer $row
     * @param  integer $col
     * @param  string  $inputValue
     * @return void
     */
    public function cellsUpdateAction($row, $col, $inputValue) {
        if (($row > $this->rowCount) || ($col > $this->columnCount)) {
            print "Current worksheet only has $this->rowCount rows and $this->columnCount columns.\n";
            if (!$this->promptToResize($row, $col)) {
                return;
            }
        }
        $entry = $this->gdClient->updateCell($row, $col, $inputValue,
                $this->currKey, $this->currWkshtId);
        if ($entry instanceof Zend_Gdata_Spreadsheets_CellEntry) {
            echo "Success!\n";
        }
    }

    /**
     * listGetAction
     *
     * @return void
     */
    public function listGetAction() {
        $query = new Zend_Gdata_Spreadsheets_ListQuery();
        $query->setSpreadsheetKey($this->currKey);
        $query->setWorksheetId($this->currWkshtId);
        $this->listFeed = $this->gdClient->getListFeed($query);
        print "entry id | row-content in column A | column-header: cell-content\n".
                "Please note: The 'dump' command on the list feed only dumps data until the first blank row is encountered.\n\n";

        $this->printFeed($this->listFeed);
        print "\n";
    }

    /**
     * listInsertAction
     *
     * @param  mixed $rowData
     * @return void
     */
    public function listInsertAction($rowData) {
        $rowArray = $this->stringToArray($rowData);
        $entry = $this->gdClient->insertRow($rowArray, $this->currKey, $this->currWkshtId);
        if ($entry instanceof Zend_Gdata_Spreadsheets_ListEntry) {
            foreach ($rowArray as $column_header => $value) {
                echo "Success! Inserted '$value' in column '$column_header' at row ". substr($entry->getTitle()->getText(), 5) ."\n";
            }
        }
    }

    /**
     * listUpdateAction
     *
     * @param  integer $index
     * @param  mixed   $rowData
     * @return void
     */
    public function listUpdateAction($index, $rowData) {
        $query = new Zend_Gdata_Spreadsheets_ListQuery();
        $query->setSpreadsheetKey($this->currKey);
        $query->setWorksheetId($this->currWkshtId);
        $this->listFeed = $this->gdClient->getListFeed($query);
        $rowArray = $this->stringToArray($rowData);
        $entry = $this->gdClient->updateRow($this->listFeed->entries[$index], $rowArray);
        if ($entry instanceof Zend_Gdata_Spreadsheets_ListEntry) {
            echo "Success!\n";
            $response = $entry->save();

        }
    }

    /**
     * listDeleteAction
     *
     * @param  integer $index
     * @return void
     */
    public function listDeleteAction($index) {
        $query = new Zend_Gdata_Spreadsheets_ListQuery();
        $query->setSpreadsheetKey($this->currKey);
        $query->setWorksheetId($this->currWkshtId);
        $this->listFeed = $this->gdClient->getListFeed($query);
        $this->gdClient->deleteRow($this->listFeed->entries[$index]);
    }

    /**
     * stringToArray
     *
     * @param  string $rowData
     * @return array
     */
    public function stringToArray($rowData) {
        $arr = array();
        foreach ($rowData as $row) {
            $temp = explode('=', $row);
            $arr[$temp[0]] = $temp[1];
        }
        return $arr;
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
            echo "<br/>".$entry->id->text."<br/>";
            if ($entry instanceof Zend_Gdata_Spreadsheets_CellEntry) {
                print $entry->title->text .' '. $entry->content->text . "<br/>";
            } else if ($entry instanceof Zend_Gdata_Spreadsheets_ListEntry) {
                print $i .' '. $entry->title->text .' | '. $entry->content->text . "<br/>";
            } else {
                print $i .' '. $entry->title->text . "<br/>";
            }
            $i++;
            echo "<br/>";
        }
    }

    /**
     * getRowAndColumnCount
     *
     * @return void
     */
    public function getRowAndColumnCount() {
        $query = new Zend_Gdata_Spreadsheets_CellQuery();
        $query->setSpreadsheetKey($this->currKey);
        $query->setWorksheetId($this->currWkshtId);
        $feed = $this->gdClient->getCellFeed($query);

        if ($feed instanceOf Zend_Gdata_Spreadsheets_CellFeed) {
            $this->rowCount = $feed->getRowCount();
            $this->columnCount = $feed->getColumnCount();
        }
    }

    /**
     * invalidCommandError
     *
     * @param  string $input
     * @return void
     */
    public function invalidCommandError($input) {
        echo 'Invalid input: '.$input."\n";
    }

    /**
     * promtForFeedtype
     *
     * @return void
     */
    public function promptForFeedtype() {

        $input = getInput('Select to use either the cell or the list feed [cells or list]');

        if ($input == 'cells') {
            while(1) {
                $this->promptForCellsAction();
            }
        } else if ($input == 'list') {
            while(1) {
                $this->promptForListAction();
            }
        } else {
            print "Invalid input. Please try again.\n";
            $this->promptForFeedtype();
        }
    }

    /**
     * run
     *
     * @return void
     */
    public function run() {
        $this->getExistingSpreadsheets();
        // $this->promptForWorksheet();
        // $this->promptForFeedtype();
    }
}



$email = "tantrieuf31.database@gmail.com";
$pass = "Mycatisfat@31";

//list all Spreadsheets

$sample = new SimpleCRUD($email, $pass);
$spreadsheets = $sample->getExistingSpreadsheets();
print "== Available Spreadsheets ==\n";
$sample->printFeed($spreadsheets);



$uri1 = "http://spreadsheets.google.com/feeds/spreadsheets/tPF0KO8zz8gIB75IZB6fMcQ";
//$currentWorksheet = $sample->gdClient()->GetWorksheetEntry($spreadsheets[0]->id->text);

//echo $currentWorksheet->id->text;

//list all Worksheets in a Spreadsheet
$query = new Zend_Gdata_Spreadsheets_DocumentQuery();
$query->setSpreadsheetKey("tPF0KO8zz8gIB75IZB6fMcQ");
$worksheets = $sample->gdClient()->getWorksheetFeed($query);
print "<br>== Available Worksheets ==\n";
$sample->printFeed($worksheets);

//list all data in a Worksheet
$query = new Zend_Gdata_Spreadsheets_ListQuery();
$query->setSpreadsheetKey("tPF0KO8zz8gIB75IZB6fMcQ");
$query->setWorksheetId("od6");
$listFeed = $sample->gdClient()->getListFeed($query);
print "entry id | row-content in column A | column-header: cell-content<br>".
        "Please note: The 'dump' command on the list feed only dumps data until ".
        "the first blank row is encountered.<br><br>";
$sample->printFeed($listFeed);
print "<br>";



?>
