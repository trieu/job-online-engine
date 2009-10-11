<?
/*
    *---------------------------------------------------------------------------------------------------
    * UTILITY DESCRIPTION
    *---------------------------------------------------------------------------------------------------
    *    File Name:          ContentDiff.class.php
    *    Class Name:         ContentDiff()
    *    Class Description:  This text utility will allow user to pass two slightly changed texts and
    *                        will display block of text with the differences in this text.
    *                        For example:
    *                            OLD TEXT:        This is a OLD text.
    *                                            Check the result.
    *
    *                            NEW TEXT:        This is a NEW text.
    *                                            Check the result.
    *
    *                            OUTPUT:            This is a OLD text.       -- by default text will be red color
    *                                                                         with the line through it
    *
    *                                            This is a NEW text.          -- by default text will be blue color
    *
    *                                            Check the result.          -- text will be regular since it's unchaged
    *
    *    Version:            0.1
    *    BY:                 Val Vinder, Nick Ferguson
    *    Date:               07.01.2004
    *     Email:              valera_la@hotmail.com
    *
    *---------------------------------------------------------------------------------------------------
    * UTILITY LIMITATION
    *---------------------------------------------------------------------------------------------------
    * ! class only checks difference in lines and not separate words. May bee in the next version :)
    *
    *---------------------------------------------------------------------------------------------------
    * UTILITY LICENSE
    *---------------------------------------------------------------------------------------------------
    * GPL license. Feel Free to use it. If you will enchance the script share it.
    *---------------------------------------------------------------------------------------------------
    * CLASS VARIABLES
    *---------------------------------------------------------------------------------------------------
    *     $fileOld="temp/old_";            --------- location of the temparary stored old files ( i used temp dir)
    *     $fileNew="temp/new_";            --------- location of the temparary stored new files ( i used temp dir)
    *     $handleOld;                        --------- file handle for Old Files
    *     $handleNew;                        --------- file handle for New Files
    *
    *     $styleOld=' style="text-decoration: line-through;color:red;"  ';
    *                                    ----------for convinience default decoration is assigned
    *                                          it's used for displaying changed old content
    *
    *     $styleNew=' style="color:blue;" ';
    *                                     ----------for convinience default decoration is assigned
    *                                          it's used for displaying changed old content
    *
    *     $oldContentTEXT;                  ----------place holder for oldContent
    *     $newContentTEXT;                   ----------place holder for newContent
    *     $newText="";                    ----------place holder for the output
    *
    **---------------------------------------------------------------------------------------------------
    * CLASS METHODS
    *---------------------------------------------------------------------------------------------------
    *     function contentDiff($oldContent, $newContent, $styleOld="",$styleNew="")  --constructor
    *    function showDifference()    -- main method, that perform actual comparison
    *    function isOldContent()        -- perform check for an old Content, check if it's empty
    *    function writeContentToFile($oldContent,$newContent)      -- write content to the files and stores
    *                                                                 those files in the assigned temp dir
    *    function mergeTwoFiles()    -- perform merge of the two files by using unix diff command with some
    *                                    options in order to display color difference
    *    function convertToText($lineArray)   -- converts file lines array to the text delimited by n
    *    function deleteFiles()                 -- method that deletes two temp files
    *---------------------------------------------------------------------------------------------------
    * CLASS CONSTRUCTOR
    *---------------------------------------------------------------------------------------------------
    *
    *    Perfomed action:
    *
    *     1.set up file names
    *    2.create file handels
    *    3.check styles for displaying the text
    *    4.setting up old and new content
    *
    *     Passed parameters:-------
    *
    *     $oldContent                     ----------place holder for an old text
    *    $newContent                     ----------place holder for a new text
    *     $styleOld                       ----------place holder for the old style (i.e. css class name, class="old")
    *     $styleNew                          ----------place holder for the new style (i.e. css class name, class="new")
    *-------------------------------------------------------------------------------------------------------------
    * CLASS USAGE
    *-------------------------------------------------------------------------------------------------------------
    *
    *
    *-------------------------------------------------------------------------------------------------------------
*/

class ContentDiff {

    var    $fileOld="temp/";
    var $fileNew="temp/";
    var $handleOld;
    var $handleNew;
    var $styleOld=' style="text-decoration: line-through;color:red;"  ';   //for convinience default decoration is assigned
    var $styleNew=' style="color:blue;" ';   //for convinience default decoration is assigned
    var $oldContentTEXT;       //place holder for oldContent
    var $newContentTEXT;       //place holder for newContent
    var $newText="";

    /*
    * Constructor will accept four parameters
    * $oldContent -------------  place holder for an old text
    * $newContent -------------  place holder for a new text
    * $styleOld   -------------  place holder for the old style (i.e. css class name, class="oold")
    * $styleNew   -------------  place holder for the new style (i.e. css class name, class="new")
    */

    function ContentDiff($oldContent, $newContent, $styleOld="",$styleNew="") {
        $this->fileOld=$this->fileOld."old_".rand() ;
        $this->fileNew=$this->fileNew."new_".rand();
        $this->handleOld = fopen($this->fileOld,'w');
        $this->handleNew = fopen($this->fileNew,'w');
        if (!empty($styleOld))
            $this->styleOld = $styleOld;
        if (!empty($styleNew))
            $this->styleNew = $styleNew;

        $this->oldContentTEXT = $oldContent;
        $this->newContentTEXT = $newContent;


    }

    function showDifference() {
        $success = false;
        if (!$this->isOldContent())
            return true;
            
        if ($this->oldContentTEXT==$this->newContentTEXT) {
            $this->newText = $this->newContentTEXT;
            return true;
        }

        if ($this->writeContentToFile($this->oldContentTEXT,$this->newContentTEXT))
            $success = true;

        $mergedLines = $this->mergeTwoFiles();
        $this->deleteFiles();
        if($this->convertToText($mergedLines))
            $success = true;
        return $success;
    }

    function isOldContent() {
        if (!empty($this->oldContentTEXT))
            return true;
        else
            return false;
    }


    function writeContentToFile($oldContent,$newContent) {
        $success = true;
        if (fwrite($this->handleOld, $oldContent ) === FALSE) {
            $this->messages[] = array("error"=>true,"message"=>"Cannot write old content to the file for merging",);
            $success = false;
        }

        if (fwrite($this->handleNew, $newContent ) === FALSE) {
            $this->messages[] = array("error"=>true,"message"=>"Cannot write new content to file for merging",);
            $success = false;
        }

        fclose($this->handleOld);
        fclose($this->handleNew);

        return $success;
    }

    function mergeTwoFiles() {
    //diff options
        $diffOpts .= " -aBbHiws --minimal --ignore-blank-lines --ignore-space-change ";
        $diffOpts .= "--new-line-format='<font ".$this->styleNew.">%l</font>n' ";
        $diffOpts .= "--old-line-format='<font ".$this->styleOld.">%l</font>n' ";
        exec("diff ". $diffOpts.$this->fileOld." ".$this->fileNew." 2>&1",$report,$return_val);
        return $report;
    }

    function convertToText($lineArray) {
        $newText="";
        foreach($lineArray as $line)
            $newText.=$line."n";

        $this->newText = $newText;
        if (!empty($this->newText))
            return true;
        else
            return false;
    }

    function deleteFiles() {
        unlink($this->fileOld);
        unlink($this->fileNew);
    }
}
//end of class

?>  