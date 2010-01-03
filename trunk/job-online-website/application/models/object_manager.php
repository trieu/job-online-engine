<?php

require_once 'application/classes/Object.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class object_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "objects";
    }

    public function save($obj) {
        $data_array = $this->class_mapper->classToArray("Object", $obj);
        $id = -1;
        if($obj->getObjectID() > 0) {
            $id = $this->update($data_array);
            $id = $obj->getObjectID();

            $this->load->model("field_value_manager");
            ApplicationHook::logInfo("In object manager,count(obj->getFieldValues()) = ". count($obj->getFieldValues()) );
            $this->db->trans_start();
            foreach ($obj->getFieldValues() as $field_value) {
                $field_value['ObjectID'] = $id;
                $this->field_value_manager->save($field_value);
            }
            $this->db->trans_complete();
        }
        else {
            $id = $this->insert($data_array);

            $this->load->model("field_value_manager");
            ApplicationHook::logInfo("In object manager,count(obj->getFieldValues()) = ". count($obj->getFieldValues()) );
            $this->db->trans_start();
            foreach ($obj->getFieldValues() as $field_value) {
                $field_value['ObjectID'] = $id;
                $field_value['FieldValueID'] = -1;
                $this->field_value_manager->save($field_value);
            }
            $this->db->trans_complete();
        }
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return -1;
    }

    protected function update($data_array) {
        $key_field_name = "ObjectID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }


    public function delete_by_id($id) {
    }

    public function find_by_id($id) {
        $query = $this->db->get_where($this->table_name, array('ObjectID' => $id));
        foreach ($query->result_array() as $data_row) {
            $pro = new Object();
            return $pro = $this->class_mapping($data_row, "Object", $pro);
        }
    }
    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter, $this->table_name, "Object");
    }
    public function delete($object) {
    }

    public function get_dependency_instances() {
        $list = array();
        return $list;
    }
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }

    public function getAllObjectsInClass($classID) {
        $sql = "(
                SELECT objects.ObjectID, fields.FieldName, fieldoptions.OptionName as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 4
                    AND fields.FieldTypeID <= 7
                    AND fields.FieldID IN ( SELECT field_form.FieldID
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
                SELECT objects.ObjectID, fields.FieldName,  fieldvalues.FieldValue as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 1
                    AND fields.FieldTypeID <= 3
                    AND fields.FieldID IN ( SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = ?
                                )
                )
                WHERE objects.ObjectClassID = ?
                )
                ";
        $query = $this->db->query($sql, array($classID, $classID, $classID, $classID));
        $record_set = $query->result_array();
        $objects = array();
        foreach ($record_set as $record) {
            if( ! isset ($objects[$record['ObjectID']]) ) {
                $objects[ $record['ObjectID'] ] = array();
            }
            $field = array("FieldName"=> $record['FieldName']  , "FieldValue" => $record['FieldValue'] );
            array_push( $objects[ $record['ObjectID'] ], $field );
        }
        //ApplicationHook::log($this->db->last_query());
        return $objects;
    }

    function getFormID_Of_IndentityProcess($classID) {
        
    }

    /**
     *
     * @param int $objectID
     * @return Object
     */
    public function getObjectInstance($objectID) {
        $sql = "(
                SELECT objects.ObjectID, objects.ObjectClassID, fieldvalues.FieldValueID, fieldvalues.FieldID, fieldvalues.FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                AND fields.FieldTypeID >= 4
                AND fields.FieldTypeID <= 7
                )
                INNER JOIN fieldoptions ON fieldoptions.FieldOptionID = fieldvalues.FieldValue
                WHERE objects.ObjectID = ?
                )
                UNION
                (
                SELECT objects.ObjectID, objects.ObjectClassID, fieldvalues.FieldValueID, fieldvalues.FieldID, fieldvalues.FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                AND fields.FieldTypeID >= 1
                AND fields.FieldTypeID <= 3
                )
                WHERE objects.ObjectID = ?
                )
                ";
        $query = $this->db->query($sql, array($objectID, $objectID));
        $record_set = $query->result_array();
        $object = new Object();
        $fields = array();
        foreach ($record_set as $record) {
            if( $object->getObjectID() < 0 ) {
                $object->setObjectID( $record['ObjectID'] );
            }
            if( $object->getObjectClassID() < 0 ) {
                $object->setObjectClassID( $record['ObjectClassID'] );
            }
            $fields[ $record['FieldID']."FVID_".$record['FieldValueID'] ] = $record['FieldValue'];
        }
        $object->setFieldValues($fields);
        return $object;
    }

    /**
     *
     * @param int $objectID
     * @return Object
     */
    public function getObjectInstanceInForm($objectID, $FormID) {
        $sql = "(
                SELECT objects.ObjectID, objects.ObjectClassID, fieldvalues.FieldValueID, fieldvalues.FieldID, fieldvalues.FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                AND fields.FieldTypeID >= 4
                AND fields.FieldTypeID <= 7
                AND fields.FieldID IN (SELECT FieldID FROM field_form WHERE FormID = ?)
                )
                INNER JOIN fieldoptions ON fieldoptions.FieldOptionID = fieldvalues.FieldValue
                WHERE objects.ObjectID = ?
                )
                UNION
                (
                SELECT objects.ObjectID, objects.ObjectClassID, fieldvalues.FieldValueID, fieldvalues.FieldID, fieldvalues.FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                AND fields.FieldTypeID >= 1
                AND fields.FieldTypeID <= 3
                AND fields.FieldID IN (SELECT FieldID FROM field_form WHERE FormID = ?)
                )
                WHERE objects.ObjectID = ?
                )
                ";
        $query = $this->db->query($sql, array($FormID, $objectID, $FormID, $objectID));
        $record_set = $query->result_array();
        $object = new Object();
        $fields = array();
        foreach ($record_set as $record) {
            if( $object->getObjectID() < 0 ) {
                $object->setObjectID( $record['ObjectID'] );
            }
            if( $object->getObjectClassID() < 0 ) {
                $object->setObjectClassID( $record['ObjectClassID'] );
            }
            $fields[ $record['FieldID']."FVID_".$record['FieldValueID'] ] = $record['FieldValue'];
        }
        $object->setFieldValues($fields);        
        return $object;
    }
}
?>
