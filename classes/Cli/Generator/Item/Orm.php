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
        $orm = Cli_Database_Orm::factory($this->table);
        $class_name = Cli_Util_Text::class_name($orm->get_name());
        
        $this->setup(Cli_Util_System::$MODEL)
                ->add_row("class Model_" . $class_name . " extends ORM {")
                ->add_row();
        
        if(Cli_Util_ConfigReader::get_key("table_names_plural") !== "auto")
        {
            if(Cli_Util_ConfigReader::get_key("table_names_plural") === false)
            {
                $this->add_row("protected \$_table_name = "."'".UTF8::strtolower($this->table)."'".";", 4)
                        ->add_row();
            }
        }  
        else 
        {
            if(Cli_Service_AutoDetect::table_names_plural() === false)
            {
                $this->add_row("protected \$_table_name = "."'".UTF8::strtolower($this->table)."'".";", 4)
                        ->add_row();
            }
        }
       
        if($orm->has_one_and_belongs_to())
        {
            $this->add_row($orm->get_has_one())
                 ->add_row($orm->get_belongs_to());
        }
        if($orm->has_many())
        {
            $this->add_row($orm->get_has_many());
        }
        
        $this->add_row($orm->get_rules())
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
