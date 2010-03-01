<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

    var $intersectSQL = "
            SELECT DISTINCT r1.*  FROM
            (
            SELECT ObjectID
            FROM fieldvalues
            WHERE (FieldID = 8 AND FieldValue LIKE '%Hong Huynh%' )
            ) r1
            INNER JOIN
            (
            SELECT ObjectID
            FROM fieldvalues
            WHERE   (FieldID = 15 AND FieldValue LIKE '%0943332248%' )
            ) r2
            ON r1.ObjectID = r2.ObjectID
            INNER JOIN
            (
            SELECT ObjectID
            FROM fieldvalues
            WHERE   (FieldID = 13 AND FieldValue LIKE '%Nguyen Cong Tru, Q1%' )
            ) r3
            ON r2.ObjectID = r3.ObjectID";

    protected function buildSQLSearch($query_fields) {
        $sql = "";
        foreach ($query_fields as $id => $kv ) {
            if( strlen($kv->value) >0 ) {
                $field_sql = "SELECT DISTINCT ObjectID FROM fieldvalues WHERE ";
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

    public function search_object($FormID, $ObjectClassID, $ProcessID, $query_fields, $return_query = FALSE) {
        $this->CI->load->model('objectclass_manager');
        // $this->buildSQLSearch($query_fields);

        $seacrh_obj_sql = " SELECT DISTINCT ObjectID FROM fieldvalues ";
        $query_fields_size = count($query_fields);
        $field_operator = " OR ";
        $field_filter = "";
        foreach ($query_fields as  $kv ) {
            if( strlen($kv->value) >0 ) {
                //FIXME TODO update field type
                if(strlen($field_filter)>0) {
                    $field_filter .= $field_operator;
                }
                $field_filter .= "(FieldID = ".$kv->name." AND ";
                if($kv->type == "text" || $kv->type == "textarea") {
                    $kv->value = "'%" . $kv->value . "%'";
                    $field_filter .= " FieldValue LIKE ". $kv->value ." ) ";
                }
                else {
                    $field_filter .= " FieldValue = ". $kv->value ." ) ";
                }
            }
        }
        if( strlen($field_filter) > 0 ) {
            $seacrh_obj_sql .= (" WHERE ".$field_filter);
        }
        //echo "<br/>".($seacrh_obj_sql);

        $sql = "
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
                ) r
                WHERE r.ObjectID IN ( ".$seacrh_obj_sql." )  ";
        $query = $this->db->query($sql, array($ObjectClassID, $ObjectClassID, $ObjectClassID, $ObjectClassID));
        if($return_query) {
            return $query;
        }
        $record_set = $query->result_array();

        ApplicationHook::logInfo($this->db->last_query());

        $objects = array();
        foreach ($record_set as $record) {
            if( ! isset ($objects[$record['ObjectID']]) ) {
                $objects[ $record['ObjectID'] ] = array();
            }
            $field = array("FieldName"=> $record['FieldName']  ,
                    "FieldValue" => $record['FieldValue'] ,
                    "FieldID" => $record['FieldID']
            );
            array_push( $objects[ $record['ObjectID'] ], $field );
        }
        //echo ($this->db->last_query());

        $data = array();
        $data["in_search_mode"] = TRUE;
        $data["objects"] = $objects;
        //echo json_encode($objects);
        $data["objectClass"] = $this->CI->objectclass_manager->find_by_id($ObjectClassID);
        return $data;
    }

    public function search_object_for_table_view($FormID, $ObjectClassID, $ProcessID, $query_fields, $return_query = FALSE) {
        $this->CI->load->model('objectclass_manager');
        $seacrh_obj_sql = " SELECT DISTINCT ObjectID FROM fieldvalues ";
        $query_fields_size = count($query_fields);
        $field_operator = " OR ";
        $field_filter = "";
        foreach ($query_fields as  $kv ) {
            if( strlen($kv->value) >0 ) {                
                if(strlen($field_filter)>0) {
                    $field_filter .= $field_operator;
                }
                $field_filter .= "(FieldID = ".$kv->name." AND ";
                if($kv->type == "text" || $kv->type == "textarea") {
                    $kv->value = "'%" . $kv->value . "%'";
                    $field_filter .= " FieldValue LIKE ". $kv->value ." ) ";
                }
                else {
                    $field_filter .= " FieldValue = ". $kv->value ." ) ";
                }
            }
        }
        if( strlen($field_filter) > 0 ) {
            $seacrh_obj_sql .= (" WHERE ".$field_filter);
        }
        $sql = "
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
                ) r
                WHERE r.ObjectID IN ( ".$seacrh_obj_sql." )  ";
        $query = $this->db->query($sql, array($ObjectClassID, $ObjectClassID, $ObjectClassID, $ObjectClassID));
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
}
