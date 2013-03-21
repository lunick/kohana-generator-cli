<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Message extends Cli_Generator_Abstract_Generator_Item {
    
    public function init() {
        $this->setup(Cli_Util_System::$MESSAGES)
                ->add_row("return array(");
        
        $array = Cli_Util_ConfigReader::get_key("validation");
            
        foreach ($array as $key => $val){
            $this->add_row("'" . $key . "' => '" . $key . "',", 4);
        }
        
        $this->add_row(");")->add_row("?>");        
    }    
    
    public static function factory($filename = null, $table = null){
        return new Cli_Generator_Item_Message($filename, $table);
    }
    
}

?>
