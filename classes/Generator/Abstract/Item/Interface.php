<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
interface Generator_Abstract_Item_Interface {
        
    public function init();
    
    public function get_file_builder();
}

?>
