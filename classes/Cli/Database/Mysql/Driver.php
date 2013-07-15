<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Database_Mysql_Driver extends Cli_Database_Abstract_Driver {
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function columns_result($table){
        $columns = $this->list_columns($table);
        $result = array();
        foreach ($columns as $column){
            $result[] = new Cli_Database_Mysql_Result_Field($column);
        }
        return $result;
    }

    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function has_primary_key($table){
        $columns = $this->list_columns($table);
        foreach ($columns as $column) {
            if (strtolower($column["key"]) == "pri") 
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function relationship_result($table){
        $relationships = $this->table_relationships($table);
        $result = array();
        foreach ($relationships as $relationship){
            $result[] = new Cli_Database_Mysql_Result_Relationship($relationship);
        }
        return $result;
    }
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function references_result($table){
        $references = $this->table_references($table);
        $result = array();
        foreach ($references as $reference){
            $result[] = new Cli_Database_Mysql_Result_Relationship($reference);
        }
        return $result;
    }

    /**
     * 
     * @param string $table
     * @return object
     */
    public function table_relationships($table){
        $sql = "SELECT * FROM information_schema.key_column_usage WHERE TABLE_NAME='" . $table . "' AND TABLE_SCHEMA='".$this->get_database_name()."' AND referenced_column_name IS NOT NULL";
        return Database::instance()->query(Database::SELECT, $sql);
    }
    
    /**
     * 
     * @param string $table
     * @return object
     */
    public function table_references($table){
        $sql = "SELECT * FROM information_schema.key_column_usage WHERE REFERENCED_TABLE_NAME='" . $table . "' AND TABLE_SCHEMA='".$this->get_database_name()."' AND referenced_column_name IS NOT NULL";
        return Database::instance()->query(Database::SELECT, $sql);
    }    
}

?>
