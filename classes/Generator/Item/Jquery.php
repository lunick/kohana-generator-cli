<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_Jquery extends Generator_Abstract_Item {
    
    public function init() {
        $content = @file_get_contents(Generator_Util_ConfigReader::get_key("jquery_url"));
        $this->get_file_builder()
                ->setup(Generator_Util_Kohana::$JS)
                ->add_row($content);
    }    
}

?>
