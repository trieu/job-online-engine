<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * class_mapper for data manager
 * @author Trieu Nguyen (tantrieuf31@gmail.com)
 */
class class_mapper {

    protected $objectClass =  "";
    protected $setter_fields = array();

    /**
     * __construct
     *
     * @return void
     **/
    public function __construct($params = array()) {
        if(sizeof($params) == 1) {
            $this->parseClass($params[0]);
        }
    }

    public function parseClass($class_name) {
        if($class_name == "") {
            throw new RuntimeException("Classname can not be empty!", 400);
        }
        try {
            $this->objectClass = new ReflectionClass($class_name);
            $methods = $this->objectClass->getMethods();
            foreach ($methods as $method) {
                if($this->isSetterMethod($method)) {
                    $fieldName = strtolower(substr($method->getName(),3));
                    $this->setter_fields[$fieldName] = $method;
                }
            }
        } catch (Exception $e ) {
            echo $e->getTraceAsString();
        }
    }

    public function dataRowMappingToObject($data_row, $object) {
        try {
            foreach ($data_row as $fieldName => $fieldData) {
                $this->setter_fields[strtolower($fieldName)]->invokeArgs($object, array($fieldData) );
            }
        } catch (Exception $e ) {
            echo $e->getTraceAsString();
        }
        return $object;
    }

    public function classToArray($class_name, $obj) {
        $property_values = array();
        try {
            $this->objectClass = new ReflectionClass($class_name);
            $methods = $this->objectClass->getMethods();
            $properties = $this->objectClass->getProperties();
            foreach ($properties as $property) {
				if($property->isPrivate() || $property->isProtected()){
					$getter = $this->objectClass->getMethod('get'.($property->getName()));
					//ApplicationHook::log('get'.strtoupper($property->getName()));
					$value = $getter->invoke($obj);
					$property_values[$property->getName()] = $value;
				}
            }
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
        return $property_values;
    }

    public function DataListToDataTable($class_name, $list) {
        $data_table = array();
        $idx = 0;
        foreach ($list as $obj) {
            $data_table[$idx++] = $this->classToArray($class_name, $obj) ;
        }
        return $data_table;
    }

    public function isSetterMethod($method) {
        if(substr($method->getName(),0,3) === "set" && $method->getNumberOfRequiredParameters() ==1) {
            return TRUE;
        }
        return FALSE;
    }

    public function isGetterMethod($method) {
        if(substr($method->getName(),0,3) === "get" && $method->getNumberOfRequiredParameters() == 0) {
            return TRUE;
        }
        if(substr($method->getName(),0,2) === "is" && $method->getNumberOfRequiredParameters() == 0) {
            return TRUE;
        }
        return FALSE;
    }

}
