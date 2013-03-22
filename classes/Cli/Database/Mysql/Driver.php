<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Database_Mysql_Driver {
    
    public static function factory(){
        return new Cli_Database_Mysql_Driver();
    }
    
    public function get_database_name(){
        $config = Database::instance()->__toString();
        $loaded_config = Kohana::$config->load("database")->get($config);          
        return $loaded_config["connection"]["database"];
    }
    
    public function table_relationships($table){
        $sql = "SELECT * FROM information_schema.key_column_usage WHERE TABLE_NAME='" . $table . "' AND TABLE_SCHEMA='".$this->get_database_name()."' AND referenced_column_name IS NOT NULL";
        return Database::instance()->query(Database::SELECT, $sql);
    }
    
    public function table_references($table){
        $sql = "SELECT * FROM information_schema.key_column_usage WHERE REFERENCED_TABLE_NAME='" . $table . "' AND TABLE_SCHEMA='".$this->get_database_name()."' AND referenced_column_name IS NOT NULL";
        return Database::instance()->query(Database::SELECT, $sql);
    }
    
    public function list_tables(){
        return Database::instance()->list_tables();
    }
    
    public function list_columns($table){
        return Database::instance()->list_columns($table);
    }
    
    public function columns_result($table){
        $columns = $this->list_columns($table);
        $result = array();
        foreach ($columns as $column){
            $result[] = Cli_Database_Mysql_Result_Field::factory($column);
        }
        return $result;
    }
    
    public function relationship_result($table){
        $relationships = $this->table_relationships($table);
        $result = array();
        foreach ($relationships as $relationship){
            $result[] = Cli_Database_Mysql_Result_Relationship::factory($relationship);
        }
        return $result;
    }
    
    public function references_result($table){
        $references = $this->table_references($table);
        $result = array();
        foreach ($references as $reference){
            $result[] = Cli_Database_Mysql_Result_Relationship::factory($reference);
        }
        return $result;
    }
    
    public function list_column_names($table){
        $columns = $this->list_columns($table);
        $names = array();
        foreach ($columns as $column){
            $names[] = $column["column_name"];
        }
        return $names;
    }
    
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
        
    public function get_primary_key_names($table){
        $fields = $this->columns_result($table);
        $primary_keys = array();
        foreach ($fields as $field){
            if ($field->is_primary_key())
            {
                $primary_keys[] = $field->get_name();
            }
        }
        return $primary_keys;
    }
    
    public function get_foreign_key_names($table){
        $fields = $this->relationship_result($table);
        $foreign_keys = array();
        foreach ($fields as $field){
            $foreign_keys[] = $field->get_column_name();
        }
        return $foreign_keys;
    }
    
    public function is_switch_table($table){
        $column_names_count = count($this->list_column_names($table));
        $foreign_keys_count = count($this->get_foreign_key_names($table));
        return $foreign_keys_count == $column_names_count ? true : false;
    }
    
    public function name($table){
        $config = Cli_Util_ConfigReader::get_config();
        if ($config->table_names_plural != "auto") 
        {
            return $config->table_names_plural ? strtolower(Inflector::singular($table)) : strtolower($table);
        } 
        else 
        {
            return Cli_Service_AutoDetect::table_names_plural() ? strtolower(Inflector::singular($table)) : strtolower($table);
        }
    }
    
    public function get_referenced_table_name($table, $key){
        $references = $this->relationship_result($table);
        foreach($references as $obj){
            if($obj->get_column_name() == $key){
                return $obj->get_referenced_table_name();
            }
        }
        return null;
    }
}

?>
