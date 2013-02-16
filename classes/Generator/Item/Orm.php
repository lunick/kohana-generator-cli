<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_Orm extends Generator_Abstract_Item {
        
    public function __construct($table = null) {
        parent::__construct(null, $table);
    }
    
    public function init() {
        $orm = Generator_Database_Orm::factory($this->db_table); 
        
        $this->get_file_builder()
                ->setup(Generator_Util_Kohana::$MODEL)
                ->add_row("class Model_" . Generator_Util_Text::class_name($this->db_table->get_name()) . " extends ORM {")
                ->add_row();
        
        if(Generator_Util_ConfigReader::get_key("table_names_plural") !== "auto")
        {
            if(Generator_Util_ConfigReader::get_key("table_names_plural") === false)
            {
                $this->get_file_builder()
                        ->add_row("protected \$_table_name = "."'".UTF8::strtolower($this->db_table->get_name())."'".";", 4)
                        ->add_row();
            }
        }  
        else 
        {
            if(Generator_Service_AutoDetect::table_names_plural() === false)
            {
                $this->get_file_builder()
                        ->add_row("protected \$_table_name = "."'".UTF8::strtolower($this->db_table->get_name())."'".";", 4)
                        ->add_row();
            }
        }
       
        $this->get_file_builder()
                ->add_row($orm->get_relation_ships())
                ->add_row($orm->get_rules())
                ->add_row($orm->get_filters())
                ->add_row($orm->get_labels())
                ->add_row("}")
                ->add_row("?>");
    }    
}

?>
