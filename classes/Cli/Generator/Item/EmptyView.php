<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_EmptyView extends Cli_Generator_Abstract_Generator_Item {
            
    public function init() {
        $this->setup(Cli_Util_System::$VIEWS)
                ->add_row("?>")
                ->add_row("<h1>".$this->get_filename()."</h1>");
    } 
    
    public static function factory($filename){
        return new Cli_Generator_Item_EmptyView($filename);
    }
}

?>
