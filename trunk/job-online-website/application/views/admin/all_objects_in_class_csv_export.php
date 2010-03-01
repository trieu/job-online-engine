<?php 

$max_field_num = count($metadata_object);
$beginFlag = TRUE;
foreach ($metadata_object as $FieldName ) {
    if($beginFlag) {
        echo '"'.$FieldName.'"';
        $beginFlag = FALSE;
    }
    else {
        echo ',"'. $FieldName.'"';
    }
}
echo "\n";

$beginFlag = TRUE;
foreach ($objects as $objID => $data_map ) { 
      $fields = $data_map["fields"];
      foreach ($metadata_object as $FieldID => $FieldName ) {
        if( isset($fields[ $FieldID ]) ) {
            $safeStr = trim( $fields[ $FieldID ] );
            $safeStr = str_replace("\r", "", $safeStr);
            $safeStr = str_replace('"', '""', $safeStr);
            $safeStr = '"'.($safeStr).'"';

            if($beginFlag) {
                echo $safeStr;
                $beginFlag = FALSE;
            }
            else {
                echo ",".$safeStr;
            }
        }
        else {
            echo ",\"\"";
        }
    }
    echo "\n";
    $beginFlag = TRUE;
}