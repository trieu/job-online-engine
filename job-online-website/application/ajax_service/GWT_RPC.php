<?php

class GWT_Message {
    private $answer;

    public function setAnswer($answer) {
        $this->answer = $answer;
    }

    public function getAnswer() {
        return $this->answer;
    }
}


class GWT_RPC {

    public static function response($obj) {
        $a = new GWT_Message();
        if(is_string($obj)) {
            $a->setAnswer($obj);
        }
        else if(is_object($obj)) {
                $a->setAnswer(GWT_RPC::array2json(GWT_RPC::classToArray($obj)));
            }
        $text1 = GWT_RPC::array2json(GWT_RPC::classToArray($a));
        echo ($text1);
        return;
    //DONE
    }

    public static function classToArray($obj) {
        $objClass = new ReflectionClass(get_class($obj));
        $methods = $objClass->getMethods();
        $properties = $objClass->getProperties();
        $property_values = array();
        foreach ($properties as $property) {
            try {
                $getter = $objClass->getMethod('get'.strtoupper($property->getName()));
                $value = $getter->invoke($obj);
                if(is_string($value)){
                    $property_values[$property->getName()."@String"] = $value;
                }
                else if(is_int($value)) {
                    $property_values[$property->getName()."@Integer"] = $value;
                }
            } catch (ReflectionException $e) {
                echo $e->getTraceAsString();
            }
        }
        return ($property_values);
    }

    /**
     * return a javascript object from a php array
     * @param array $data tableau de paires cles valeurs
     * @param sting $indentchr caractere utilisé pour l'indentation
     * @param int   $indentlvl utilisé par la fonction lors des appels récursifs.
     * @return str json
     */
    public static function array2json2(array $data,$indentchr=null,$indentlvl=0) {
        $indent = (is_null($indentchr))? '' : str_repeat($indentchr,$indentlvl);
        $indent2= is_null($indentchr)?'':"\n$indent$indentchr";
        $indentlvl++;
        $rows = array();
        foreach($data as $k=>$v) {
            $rows[] = "$k:".(is_array($v)?array2json($v,$indentchr,$indentlvl):(is_int($v)?$v:"'".preg_replace(array("!'!","!\r?\n!"),array("\'","\\n"),$v)."'"));
        }
        return '{'.$indent2.implode(",$indent2",$rows).(is_null($indent)?'':"\n$indent").'}';
    }

    public static function array2json(array $arr) {
        $parts = array();
        $is_list = false;

        if (count($arr)>0) {
        //Find out if the given array is a numerical array
            $keys = array_keys($arr);
            $max_length = count($arr)-1;
            if(($keys[0] === 0) and ($keys[$max_length] === $max_length)) {//See if the first key is 0 and last key is length - 1
                $is_list = true;
                for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
                    if($i !== $keys[$i]) { //A key fails at position check.
                        $is_list = false; //It is an associative array.
                        break;
                    }
                }
            }

            foreach($arr as $key=>$value) {
                $str = ( !$is_list ? '"' . $key . '":' : '' );
                if(is_array($value)) { //Custom handling for arrays
                    $parts[] = $str . array2json($value);
                } else {
                //Custom handling for multiple data types
                    if (is_numeric($value) && !is_string($value)) {
                        $str .= $value; //Numbers
                    } elseif(is_bool($value)) {
                        $str .= ( $value ? 'true' : 'false' );
                    } elseif( $value === null ) {
                        $str .= 'null';
                    } else {
                        $str .= '"' . addslashes($value) . '"'; //All other things
                    }
                    $parts[] = $str;
                }
            }
        }
        $json = implode(',',$parts);

        if($is_list) return '[' . $json . ']';//Return numerical JSON
        return '{' . $json . '}';//Return associative JSON
    }
}
?>