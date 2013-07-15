<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Cli_Database_Abstract_Driver implements Cli_Database_Interface_Driver {
        
    /**
     * 
     * @return string
     */
    public function get_database_name(){
        $config = Database::instance()->__toString();
        $loaded_config = Kohana::$config->load("database")->get($config);          
        return $loaded_config["connection"]["database"];
    }
        
    /**
     * 
     * @return array
     */
    public function list_tables(){
        return Database::instance()->list_tables();
    }
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function list_columns($table){
        return Database::instance()->list_columns($table);
    }
        
    /**
     * 
     * @param string $table
     * @return array
     */
    public function list_column_names($table){
        $columns = $this->list_columns($table);
        $names = array();
        foreach ($columns as $column){
            $names[] = $column["column_name"];
        }
        return $names;
    }
            
    /**
     * 
     * @param string $table
     * @return array
     */
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
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function get_foreign_key_names($table){
        $fields = $this->relationship_result($table);
        $foreign_keys = array();
        foreach ($fields as $field){
            $foreign_keys[] = $field->get_column_name();
        }
        return $foreign_keys;
    }
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function is_switch_table($table){
        $column_names_count = count($this->list_column_names($table));
        $foreign_keys_count = count($this->get_foreign_key_names($table));
        return $foreign_keys_count == $column_names_count ? true : false;
    }
    
    /**
     * 
     * @param string $table
     * @return string
     */
    public function name($table){
        $config = Cli_Util_ConfigReader::get_config();
        if ($config->table_names_plural != "auto") 
        {
            return $config->table_names_plural ? strtolower(Inflector::singular($table)) : strtolower($table);
        } 
        else 
        {
            return $this->table_names_plural() ? strtolower(Inflector::singular($table)) : strtolower($table);
        }
    }
    
    /**
     * 
     * @param string $table
     * @param string $key
     * @return string or null
     */
    public function get_referenced_table_name($table, $key){
        $references = $this->relationship_result($table);
        foreach($references as $obj){
            if($obj->get_column_name() == $key){
                return $obj->get_referenced_table_name();
            }
        }
        return null;
    }
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function table_exists($table){
        return in_array($table, $this->list_tables());
    }
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function real_table_name($table){
        $ptable = Inflector::plural($table);
        $stable = Inflector::singular($table);
        if($this->table_exists($table)){
            return $table;
        }
        elseif($this->table_exists($ptable))
        {
            return $ptable;
        }
        elseif($this->table_exists($stable))
        {
            return $stable;
        }
        return false;
            
    }
    
    /**
     * 
     * @return boolean
     */
    public function table_names_plural() {
        $tables = Database::instance()->list_tables();
        $disabled = array("users", "user_tokens", "roles", "roles_users");
        
        foreach ($tables as $table) {
            if (!in_array($table, $disabled)) 
            {
                if ($table === Inflector::singular($table)) 
                {
                    return false;
                }
            }
        }

        return true;
    }
}

?>
