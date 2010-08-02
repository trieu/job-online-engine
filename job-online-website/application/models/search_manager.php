<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'application/classes/FieldType.php';

/**
 * Description of search_manager
 *
 * @author Nguyen Tan Trieu
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 *
 */
class search_manager extends Model {
    protected $CI;

    function search_manager() {
        parent::Model();
        $this->CI =& get_instance();
    }

    var $get_fields_object_sql = "
                SELECT r.*
                FROM
                (
                (
                SELECT objects.ObjectID, fields.FieldID, fields.FieldName, fieldoptions.OptionName as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 4
                    AND fields.FieldTypeID < 7
                    AND fields.ValidationRules LIKE '%searchable%'
                    AND fields.FieldID IN (
                             SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = ?
                                )
                )
                INNER JOIN fieldoptions ON fieldoptions.FieldOptionID = fieldvalues.FieldValue
                WHERE objects.ObjectClassID = ?
                )
                UNION
                (
                SELECT objects.ObjectID, fields.FieldID, fields.FieldName,  fieldvalues.FieldValue as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 1
                    AND fields.FieldTypeID <= 3
                    AND fields.ValidationRules LIKE '%searchable%'
                    AND fields.FieldID IN (
                             SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = ?
                                )
                )
                WHERE objects.ObjectClassID = ?
                )
                ) r  ";
    

    protected function buildSQLSearchForANDOperator($query_fields) {
        $sql = "";
        foreach ($query_fields as $id => $kv ) {
            if( strlen($kv->value) >0 ) {
                $sql = "SELECT DISTINCT ObjectID FROM fieldvalues WHERE ";
                $field_sql .= "(FieldID = ".$kv->name." AND ";
                if($kv->type == "text" || $kv->type == "textarea") {
                    $kv->value = "'%" . $kv->value . "%'";
                    $field_sql .= " FieldValue LIKE ". $kv->value ." ) ";
                }
                else {
                    $field_sql .= " FieldValue = ". $kv->value ." ) ";
                }
                $sql .= ($field_sql . " ");
            }
        }
        ApplicationHook::logInfo( $sql );
    }

    protected function do_query_on_single_field($FieldType, $FieldID , $FieldValue) {
	$sql = " SELECT DISTINCT ObjectID FROM fieldvalues WHERE ";
        if( strlen($FieldValue) >0 ) {
                $sql .= " FieldID = $FieldID AND ";
                if($FieldType == "text" || $FieldType == "textarea") {
                    $FieldValue = "'%" . $FieldValue . "%'";
                    $sql .= " FieldValue LIKE ".$FieldValue;
                }
                else {
                    $sql .= " FieldValue = ".$FieldValue;
                }
        }
        else {
             return array();
        }
        $query = $this->db->query($sql);
       // print_r($this->db->last_query());
       // ApplicationHook::logInfo($this->db->last_query());
        return $query->result_array();
    }

    protected function union_query_result($finalSet = array(), $set2 = array()) {
        foreach ($set2 as  $e ) {
            $ObjectID = $e['ObjectID']+"";
            if( ! isset( $finalSet[ $ObjectID ] ) )  {
               $finalSet[ $ObjectID ] = $ObjectID;
            }
        }
        return $finalSet;
    }

    protected function intersect_query_result($finalSet = array(), $set2 = array()) {
        $intersectedSet = array();
        foreach ($set2 as  $e ) {
            $ObjectID = $e['ObjectID']+"";
            if( isset( $finalSet[$ObjectID] ) ){
                $intersectedSet[$ObjectID] = $ObjectID;
            }
        }
        return $intersectedSet;
    }

    protected function objectSetToIdList($finalSet, $powerOfSet) {
        $matched_object_ids = "";
        $idx = 0; $lastEleIdx = $powerOfSet-1;
        foreach ($finalSet as  $ObjectID ) {
            if($idx != $lastEleIdx){
                $matched_object_ids .= ($ObjectID.", ");
            } else {
                $matched_object_ids .= ($ObjectID);
            }
            $idx ++;
        }
        return $matched_object_ids;
    }

    public function search_object_for_table_view($ObjectClassID, $query_fields, $return_query = FALSE, $startIndex = -1, $limitSizeReturn = -1) {
        $this->CI->load->model('objectclass_manager');
        
        $finalSet = array();
        foreach ($query_fields as  $kv ) {
            $query_operator = $kv->operator;
            if($kv->type == "checkbox"){
                $query_operator = "AND";
            }
            $temSet  = $this->do_query_on_single_field($kv->type, $kv->name, $kv->value);
            if($query_operator == "" || $query_operator == "OR"){
                $finalSet = $this->union_query_result($finalSet, $temSet);
            } else if($query_operator == "AND"){
                $finalSet = $this->intersect_query_result($finalSet, $temSet);
            }
        }
        $powerOfSet = count($finalSet);
        $sql = $this->get_fields_object_sql;

        if($powerOfSet <= 0 ) {
            $sql .= " WHERE r.ObjectID IN ( -1 ) ";
        }
        else if($powerOfSet > 0){
            $filterObjectSubQuery = " WHERE r.ObjectID IN ( [matched_object_ids] ) ";
            $matched_object_ids = $this->objectSetToIdList($finalSet, $powerOfSet);
            $filterObjectSubQuery = str_replace("[matched_object_ids]",$matched_object_ids , $filterObjectSubQuery);
            $sql .= $filterObjectSubQuery;
        }
        
        $query = $this->db->query($sql, array($ObjectClassID, $ObjectClassID, $ObjectClassID, $ObjectClassID));
       // ApplicationHook::logInfo($this->db->last_query());
        if($return_query) {
            return $query;
        }
        $record_set = $query->result_array();

        $objects = array();
        $metadata_object = array();
        foreach ($record_set as $record) {
            if( ! isset ($objects[$record['ObjectID']]) ) {
                $objects[ $record['ObjectID'] ] = array();
                $objects[ $record['ObjectID'] ]["fields"] = array();
            }
            $metadata_object[$record['FieldID']] = $record['FieldName'];
            $objects[$record['ObjectID']]["fields"][$record['FieldID']] = $record['FieldValue'];
        }

        $data = array();
        $data["in_search_mode"] = TRUE;
        $data["objects"] = $objects;
        $data["metadata_object"] = $metadata_object;
        //echo json_encode($objects);
        $data["objectClass"] = $this->CI->objectclass_manager->find_by_id($ObjectClassID);
        return $data;
    }


    public function do_statistics_on_field($ObjectClassID, $query_fields) {
        $metadataSql = 'SELECT fieldoptions.FieldOptionID, fieldoptions.OptionName
                 FROM fieldoptions
                 WHERE fieldoptions.fieldID = ?';
        $countSql = 'SELECT COUNT( fieldvalues.FieldValueID ) as frequency
                 FROM fieldvalues
                 WHERE fieldvalues.FieldValue = ? ';

        $data = array();

        foreach ($query_fields as $query_field  ) {
            $fieldID = $query_field->id;
            $fieldtypeID = $query_field->type;
            if( ! FieldType::isSelectableType($fieldtypeID)) {
                continue;
            }

            $statistic_name =  "statistic_fieldID_".$fieldID;
            $data[$statistic_name] = array();

            $query = $this->db->query($metadataSql, array($fieldID));

            $countAllSql = "";
            foreach ($query->result_array() as $record) {
                if( strlen($countAllSql) > 0 ) {
                    $countAllSql .= " UNION ALL ";
                }
                $countAllSql .= str_replace("?", $record['FieldOptionID'] , $countSql);
                if($fieldtypeID == FieldType::$CHECK_BOX) {
                    $countAllSql .= " AND fieldvalues.SelectedFieldValue = 1 ";
                }


                $record['frequency'] = 0;
                array_push( $data[$statistic_name] , $record );
            }

            //ApplicationHook::logInfo($countAllSql);

            $countQuery = $this->db->query($countAllSql);
            $c = 0;
            foreach ($countQuery->result_array() as $record) {
                $data[$statistic_name][$c++]['frequency'] = (int)$record['frequency'];
            }

            //ApplicationHook::logInfo(json_encode($countQuery->result_array()));

            //just support for do statistics in ONE field only
            //break;
        }

        return $data;
    }
}
