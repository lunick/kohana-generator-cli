<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Database_Mysql_Result_Field implements Cli_Database_Interface_Result_Field {

    private $field;

    public function __construct($field){
        $this->field = $field;
    }

    /**
     * 
     * @return int
     */
    public function get_min(){
        return isset($this->field["min"]) ? $this->field["min"] : 0;
    }

    /**
     * 
     * @return int
     */
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

    /**
     * 
     * @return string
     */
    public function get_type(){
        return isset($this->field["data_type"]) ? $this->field["data_type"] : "";
    }

    /**
     * 
     * @return string
     */
    public function get_name(){
        return isset($this->field["column_name"]) ? $this->field["column_name"] : "";
    }

    /**
     * 
     * @return string
     */
    public function get_key(){
        return isset($this->field["key"]) ? $this->field["key"] : "";
    }

    /**
     * 
     * @return boolean
     */
    public function is_primary_key(){
        return $this->get_key() == "PRI" ? true : false;
    }

    /**
     * 
     * @return boolean
     */
    public function is_foreign_key(){
        return $this->get_key() == "MUL" ? true : false;
    }

    /**
     * 
     * @return array
     */
    public function field(){
        return $this->field;
    }

}

?>
