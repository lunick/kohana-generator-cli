<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Database_Mysql_Result_Field {

    private $field;

    public function __construct($field){
        $this->field = $field;
    }

    public static function factory($field){
        return new Cli_Database_Mysql_Result_Field($field);
    }

    public function get_min(){
        return isset($this->field["min"]) ? $this->field["min"] : 0;
    }

    public function get_max(){
        if (isset($this->field["max"])) 
        {
            return $this->field["max"];
        } 
        else if (isset($this->field["character_maximum_length"])) 
        {
            return $this->field["character_maximum_length"];
        } 
        else
        {
            return 0;
        }
    }

    public function get_type(){
        return isset($this->field["data_type"]) ? $this->field["data_type"] : "";
    }

    public function get_name(){
        return isset($this->field["column_name"]) ? $this->field["column_name"] : "";
    }

    public function get_key(){
        return isset($this->field["key"]) ? $this->field["key"] : "";
    }

    public function is_primary_key(){
        return $this->get_key() == "PRI" ? true : false;
    }

    public function is_foreign_key(){
        return $this->get_key() == "MUL" ? true : false;
    }

    public function field(){
        return $this->field;
    }

}

?>
