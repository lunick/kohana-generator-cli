<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_Reset extends Generator_Abstract_Item {
    
    public function init() {
        $content = @file_get_contents(Generator_Util_ConfigReader::get_key("reset_css_url"));
        $this->get_file_builder()
                ->setup(Generator_Util_Kohana::$CSS)
                ->add_row($content);
    }    
}

?>
