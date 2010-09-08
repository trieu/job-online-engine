<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
class matching_engine_manager extends Model {

    protected $CI;

    function matching_engine_manager() {
        parent::Model();
        $this->CI = & get_instance();
    }

    protected $GET_FULL_FIELDS_OBJECT_SQL = "
                SELECT r.*
                FROM
                (
                (
                SELECT objects.ObjectID, fields.FieldID, fields.FieldName, fieldoptions.OptionName as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 4
                    AND fields.FieldTypeID <= 7
                    AND fields.FieldID IN (
                             SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ObjectClassID = ?
                                )
                )
                INNER JOIN fieldoptions ON fieldoptions.FieldOptionID = fieldvalues.FieldValue
                WHERE objects.ObjectClassID = ?
                )
                UNION
                (
                SELECT objects.ObjectID, fields.FieldID, fields.FieldName, fieldvalues.FieldValue as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 1
                    AND fields.FieldTypeID <= 3                   
                    AND fields.FieldID IN (
                             SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ObjectClassID = ?
                                )
                )
                WHERE objects.ObjectClassID = ?
                )
                ) r                 
                ";

    protected $GET_FULL_RAW_FIELDS_OBJECT_SQL = "                      
                SELECT objects.ObjectID, fields.FieldID, fields.FieldName, fieldvalues.FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (
                    fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldID IN (
                             SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ObjectClassID = ?
                                )
                )                
                ";

    public function get_full_structure_object($ObjectClassID, $ObjectID) {
        $this->CI->load->model('objectclass_manager');

//        $sql = $this->GET_FULL_RAW_FIELDS_OBJECT_SQL . " WHERE objects.ObjectID = ? ";
        $sql = $this->GET_FULL_FIELDS_OBJECT_SQL. " WHERE r.ObjectID = ? ";
        $query = $this->db->query($sql, array($ObjectClassID,$ObjectClassID,$ObjectClassID,$ObjectClassID, $ObjectID));
        //ApplicationHook::logInfo($this->db->last_query());

        $record_set = $query->result_array();
        $objects = array();
        $metadata_object = array();
        foreach ($record_set as $record) {
            if (!isset($objects[$record['ObjectID']])) {
                $objects[$record['ObjectID']] = array();
                $objects[$record['ObjectID']]["fields"] = array();
            }
            $metadata_object[$record['FieldID']] = $record['FieldName'];

            $FieldValue = & $objects[$record['ObjectID']]["fields"][$record['FieldID']];
            if (isset($FieldValue)) {
                $FieldValue .= ( " ; " . $record['FieldValue']);
            } else {
                $FieldValue = $record['FieldValue'];
            }
        }
        if (count($objects) == 1) {
            return $objects[$ObjectID];
        }
        return NULL;
    }

    public function get_full_structure_objects($ObjectClassID) {
        $this->CI->load->model('objectclass_manager');

//        $sql = $this->GET_FULL_RAW_FIELDS_OBJECT_SQL . " WHERE objects.ObjectClassID = ? ";
//        $query = $this->db->query($sql, array($ObjectClassID, $ObjectClassID));

        $sql = $this->GET_FULL_FIELDS_OBJECT_SQL;
        $query = $this->db->query($sql, array($ObjectClassID,$ObjectClassID,$ObjectClassID,$ObjectClassID));

        $record_set = $query->result_array();
        $objects = array();
        $metadata_object = array();
        foreach ($record_set as $record) {
            if( ! isset ($objects[$record['ObjectID']]) ) {
                $objects[ $record['ObjectID'] ] = array();
                $objects[ $record['ObjectID'] ]["fields"] = array();
            }
            $metadata_object[$record['FieldID']] = $record['FieldName'];

            $FieldValue =& $objects[$record['ObjectID']]["fields"][$record['FieldID']];
            if( isset( $FieldValue ) ){
                $FieldValue .= (" ".$record['FieldValue']);
            } else {
                $FieldValue = $record['FieldValue'];
            }
        }

        $data = array();
        $data["in_search_mode"] = TRUE;
        $data["objects"] = $objects;
        $data["metadata_object"] = $metadata_object;
        //echo json_encode($objects);
        $data["objectClass"] = $this->CI->objectclass_manager->find_by_id($ObjectClassID);
        return $data;
    }

    public function get_matched_class_structure($BaseClassID, $MatchedClassID) {
        $filter = array();
        $filter['BaseClassID'] = $BaseClassID;
        $filter['MatchedClassID'] = $MatchedClassID;
        $query = $this->db->get_where('matched_class_structure', $filter);
        return $query->result();
    }

     public function get_matched_class_structures($BaseClassID) {
        $filter = array();
        $filter['BaseClassID'] = $BaseClassID;
        $this->db->select("matched_class_structure.MatchedClassID, objectclass.ObjectClassName, matched_class_structure.MatchedStructure");
        $this->db->from("matched_class_structure");
        $this->db->join("objectclass", "objectclass.ObjectClassID = matched_class_structure.MatchedClassID");
        $this->db->where("matched_class_structure.BaseClassID", $BaseClassID);
        
        $query = $this->db->get();
        return $query->result();
    }

}
