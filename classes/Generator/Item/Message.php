<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_Message extends Generator_Abstract_Item {
    
    public function init() {
        $this->get_file_builder()
                ->setup(Generator_Util_Kohana::$MESSAGES)
                ->add_row("return array(");
        
        $array = Generator_Util_ConfigReader::get_key("validation");
            
        foreach ($array as $key => $val){
            $this->get_file_builder()
                    ->add_row("'" . $key . "' => '" . $key . "',", 4);
        }
        
        $this->get_file_builder()
                ->add_row(");")
                ->add_row("?>");        
    }    
    
}

?>
