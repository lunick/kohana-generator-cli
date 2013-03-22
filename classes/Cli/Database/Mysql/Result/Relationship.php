<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Database_Mysql_Result_Relationship {
    
    private $relationship;
    
    public function __construct($relationship) {
        $this->relationship = $relationship;
    }
    public static function factory($relationship){
        return new Cli_Database_Mysql_Result_Relationship($relationship);
    }
    
    public function get_referenced_table_name(){
        return $this->relationship["REFERENCED_TABLE_NAME"];
    }
    
    public function get_referenced_column_name(){
        return $this->relationship["REFERENCED_COLUMN_NAME"];
    }
    
    public function get_constraint_name(){
        return $this->relationship["CONSTRAINT_NAME"];
    }
    
    public function get_column_name(){
        return $this->relationship["COLUMN_NAME"];
    }
    
    public function get_table_name(){
        return $this->relationship["TABLE_NAME"];
    }
    
    public function get_relationship() {
        return $this->relationship;
    }

}

?>
