<div>
    <h3 class="vietnamese_english"><?php echo $objectClass->getObjectClassName() ?> </h3>
    <div>
    <?php
        $total_records = count($objects);
        echo lang("result_number_label").$total_records;
    ?>
    </div>
</div>

<?php if($total_records > 0) { ?>
<div style="width: 1100px; height: 520px; overflow: auto" >
    <table border="1" style="margin: 10px 0 0 5px">
        <thead>
            <tr>
                <th>ID</th>
                <?php
                $max_field_num = count($metadata_object);
                foreach ($metadata_object as $FieldID => $FieldName ) {
                    echo "<th>".$FieldName." - FieldID: ".$FieldID."</th>";
                }
                ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($objects as $objID => $data_map ) { ?>
            <tr id="object_row_<?php echo $objID ?>" >
                <td><?php echo $objID ?></td>
                <?php
                    $LuceneDoc = new Zend_Search_Lucene_Document();
                    $LuceneDoc->addField(Zend_Search_Lucene_Field::Keyword('object_id', $objID) );
                    $LuceneDoc->addField(Zend_Search_Lucene_Field::Keyword('class_id', $ObjectClassID) );
                    
                    $fields = $data_map["fields"];
                    $fields_values = "";
                    foreach ($metadata_object as $FieldID => $FieldName ) {
                        $FieldValue =& $fields[$FieldID];
                        if( isset($FieldValue) ) {
                            $FieldValue = str_replace("/", "", $FieldValue);
                            $FieldValue = str_replace(";", "", $FieldValue);
                            $FieldValue = str_replace("*", "", $FieldValue);
                            $FieldValue = str_replace("?", "", $FieldValue);
                            $FieldValue = str_replace("~", "", $FieldValue);
                            $FieldValue = str_replace(".", "", $FieldValue);
//                          $LuceneDoc->addField(Zend_Search_Lucene_Field::Text($FieldID, ($FieldValue), 'utf-8' ) );
                            $fields_values .= ($FieldID."@@".$FieldValue."@@ ");
                            echo "<td><span class='data_cell_f_".$FieldID ."'>". $FieldValue ."</span></td>";
                        }
                        else {
                            echo "<td><span>&nbsp;</span></td>";
                        }
                    }
                    //$fields_values = htmlentities(strip_tags($fields_values));
                    $LuceneDoc->addField(Zend_Search_Lucene_Field::Unstored("fields", $fields_values, 'utf-8' ) );
                    $Lucene_Indexer->addDocument($LuceneDoc);
                 ?>
                <td>
                    <div>
                        <?php echo anchor('user/public_object_controller/view/'.$objID , 'View', array('title' => 'Edit')) ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
    $Lucene_Indexer->commit();
    $Lucene_Indexer->optimize();
    echo ( $Lucene_Indexer->count() . ' documents indexed.<br />' );
?>
 <?php } else { ?>
<div>
    <b> <?php echo lang("no_result_text")?> </b>
</div>
<?php } ?>