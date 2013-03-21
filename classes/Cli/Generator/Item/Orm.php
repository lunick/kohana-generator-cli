<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Orm extends Cli_Generator_Abstract_Generator_Item {
        
    public function __construct($table = null) {
        parent::__construct(null, $table);
    }
    
    public function init() {
        $orm = Cli_Generator_Database_Orm::factory($this->db_table); 
        $class_name = Cli_Util_Text::class_name($this->db_table->get_name());
        
        $this->setup(Cli_Util_System::$MODEL)
                ->add_row("class Model_" . $class_name . " extends ORM {")
                ->add_row();
        
        if(Cli_Util_ConfigReader::get_key("table_names_plural") !== "auto")
        {
            if(Cli_Util_ConfigReader::get_key("table_names_plural") === false)
            {
                $this->add_row("protected \$_table_name = "."'".UTF8::strtolower($this->db_table->get_name())."'".";", 4)
                        ->add_row();
            }
        }  
        else 
        {
            if(Cli_Service_AutoDetect::table_names_plural() === false)
            {
                $this->add_row("protected \$_table_name = "."'".UTF8::strtolower($this->db_table->get_name())."'".";", 4)
                        ->add_row();
            }
        }
       
        $this->add_row($orm->get_relation_ships())
                ->add_row($orm->get_rules())
                ->add_row($orm->get_filters())
                ->add_row($orm->get_labels())
                ->add_row("}")
                ->add_row("?>");
        
        $this->set_subdirectory(Cli_Util_Text::subdirectory_from_filename($class_name));
    }    
    
    public static function factory($table = null){
        return new Cli_Generator_Item_Orm($table);
    }
}

?>
