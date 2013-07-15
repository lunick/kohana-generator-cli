<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Database_Interface_Result_Relationship {
        
    /**
     * 
     * @return string
     */
    public function __construct($relationship);
    
    /**
     * 
     * @return string
     */
    public function get_referenced_table_name();
    
    /**
     * 
     * @return string
     */
    public function get_referenced_column_name();
    
    /**
     * 
     * @return string
     */
    public function get_constraint_name();
    
    /**
     * 
     * @return string
     */
    public function get_column_name();
    
    /**
     * 
     * @return string
     */
    public function get_table_name();
    
    /**
     * 
     * @return array
     */
    public function get_relationship();
}

?>
