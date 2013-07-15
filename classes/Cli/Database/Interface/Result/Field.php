<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Cli_Database_Interface_Result_Field {
    
    public function __construct($field);
    
    /**
     * 
     * @return int
     */
    public function get_min();
    
    /**
     * 
     * @return int
     */
    public function get_max();

    /**
     * 
     * @return string
     */
    public function get_type();

    /**
     * 
     * @return string
     */
    public function get_name();

    /**
     * 
     * @return string
     */
    public function get_key();

    /**
     * 
     * @return boolean
     */
    public function is_primary_key();

    /**
     * 
     * @return boolean
     */
    public function is_foreign_key();

    /**
     * 
     * @return array
     */
    public function field();
}

?>
