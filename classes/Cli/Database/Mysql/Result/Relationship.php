<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Database_Mysql_Result_Relationship implements Cli_Database_Interface_Result_Relationship {
    
    private $relationship;
    
    public function __construct($relationship) {
        $this->relationship = $relationship;
    }
        
    /**
     * 
     * @return string
     */
    public function get_referenced_table_name(){
        return $this->relationship["REFERENCED_TABLE_NAME"];
    }
    
    /**
     * 
     * @return string
     */
    public function get_referenced_column_name(){
        return $this->relationship["REFERENCED_COLUMN_NAME"];
    }
    
    /**
     * 
     * @return string
     */
    public function get_constraint_name(){
        return $this->relationship["CONSTRAINT_NAME"];
    }
    
    /**
     * 
     * @return string
     */
    public function get_column_name(){
        return $this->relationship["COLUMN_NAME"];
    }
    
    /**
     * 
     * @return string
     */
    public function get_table_name(){
        return $this->relationship["TABLE_NAME"];
    }
    
    /**
     * 
     * @return array
     */
    public function get_relationship() {
        return $this->relationship;
    }

}

?>
