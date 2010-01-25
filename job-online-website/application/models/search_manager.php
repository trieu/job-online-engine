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

    function search_object() {
        $this->CI->load->model('objectclass_manager');        

        $FormID = $this->input->post("FormID");
        $ObjectClassID = $this->input->post("ObjectClassID");
        $ProcessID = $this->input->post("ProcessID");
        $query_fields = json_decode( $this->input->post("query_fields") );

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
                if($kv->type == "text" || $kv->type == "textarea") {
                    $kv->value = "'%" . $kv->value . "%'";
                    $field_filter .= "(FieldID = ".$kv->name." AND ";
                    $field_filter .= "FieldValue LIKE ". $kv->value ." ) ";
                }
                else {
                    $field_filter .= " `FieldValue` = '". $kv->value ."' ";
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
                WHERE r.ObjectID IN ( ".$seacrh_obj_sql." )
                ";
        $query = $this->db->query($sql, array($ObjectClassID, $ObjectClassID, $ObjectClassID, $ObjectClassID));
        $record_set = $query->result_array();

        //echo "<br/>".($this->db->last_query());

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
        $data["objectClass"] = $this->CI->objectclass_manager->find_by_id($ObjectClassID);

        
        return $data;
    }
}
