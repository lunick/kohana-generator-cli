<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Database_Interface_Driver {
        
    /**
     * 
     * @return string
     */
    public function get_database_name();
    
    /**
     * 
     * @param string $table
     * @return object
     */
    public function table_relationships($table);
    
    /**
     * 
     * @param string $table
     * @return object
     */
    public function table_references($table);
    
    /**
     * 
     * @return array
     */
    public function list_tables();
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function list_columns($table);
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function columns_result($table);
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function relationship_result($table);
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function references_result($table);
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function list_column_names($table);
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function has_primary_key($table);
        
    /**
     * 
     * @param string $table
     * @return array
     */
    public function get_primary_key_names($table);
    
    /**
     * 
     * @param string $table
     * @return array
     */
    public function get_foreign_key_names($table);
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function is_switch_table($table);
    
    /**
     * 
     * @param string $table
     * @return string
     */
    public function name($table);
    
    /**
     * 
     * @param string $table
     * @param string $key
     * @return string or null
     */
    public function get_referenced_table_name($table, $key);
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function table_exists($table);
    
    /**
     * 
     * @param string $table
     * @return boolean
     */
    public function real_table_name($table);
    
    /**
     * 
     * @return boolean
     */
    public function table_names_plural();
}

?>
