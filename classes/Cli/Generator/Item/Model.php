<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Model extends Cli_Generator_Abstract_Generator_Item {
        
    public function __construct($table = null) {
        parent::__construct(null, $table);
    }
    
    public function init() { 
        $orm = Cli_Database_Orm::factory($this->table);
        $class_name = Cli_Util_Text::class_name($orm->get_name());
        
        $this->setup(Cli_Util_System::$MODEL)
                ->add_row("class Model_" . $class_name . " extends Model {")
                ->add_row()      
                ->add_row("}")
                ->add_row("?>");
        
        $this->set_subdirectory(Cli_Util_Text::subdirectory_from_filename($class_name));
    }    
    
    public static function factory($table = null){
        return new Cli_Generator_Item_Model($table);
    }
}

?>
