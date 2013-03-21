<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Jquery extends Cli_Generator_Abstract_Generator_Item {
    
    public function init() {
        $content = @file_get_contents(Cli_Util_ConfigReader::get_key("jquery_url"));
        $this->setup(Cli_Util_System::$JS)->add_row($content);
    }    
    
    public static function factory($filename = null, $table = null){
        return new Cli_Generator_Item_Jquery($filename, $table);
    }
    
}

?>
