<?php 
$field_num_vector =  array();
foreach ($objects as $objID => $fields ) {
    $field_num_vector[$objID] = count($fields);
}
function cmp($a,$b) {
    if($a > $b) {
        return -1;
    }
    else if($a < $b) {
        return +1;
    }
    return 0;
}
uasort($field_num_vector, 'cmp');
$max_field_num = 0;
$max_field_key =  key($field_num_vector);
if($max_field_key != NULL) {
    $max_field_num = $field_num_vector[ $max_field_key ];
}
$fields = $objects[ key($field_num_vector) ];
$beginFlag = TRUE;
foreach ($fields as $field ) {
    if($beginFlag) {
        echo '"'.$field['FieldName'].'"';
        $beginFlag = FALSE;
    }
    else {
        echo ',"'. $field['FieldName'].'"';
    }
}
echo "\n";

$beginFlag = TRUE;
foreach ($objects as $objID => $fields ) {
    for ($i = 0; $i < $max_field_num ; $i++ ) {
        if( isset ($fields[ $i ])) {
            $safeStr = trim($fields[ $i ]['FieldValue']);
            $safeStr = str_replace("\r", "", $safeStr); 
            $safeStr = '"'.addslashes($safeStr).'"';

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