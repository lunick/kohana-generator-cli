<?php defined("SYSPATH") or die("No direct script access.") ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Orm extends Cli_Generator_Abstract_Template {
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_orm", "yn", "skip")), "yes|no|y|n", false)
                   ->add_prompt("name", lang(array("model_name")))
                   ->add_more("name");

        $options->add_skip("all", "name", true);
    }
    
    public function init() {
        $orm = Cli_Database_Orm::factory($this->get_name());
        
        $writer = $this->get_new_writer();
        $writer->set_dir(model_dir())
               ->set_file($orm->get_class_name().".php")
               ->php_head_enable()
               ->add_row("class Model_" . $orm->get_class_name() . " extends ORM {")
               ->add_row();

        if($orm->table_exists())
        {
            if(mb_strtolower(Inflector::plural($orm->get_name())) != mb_strtolower($orm->get_table_name()))
            {    
                $writer->add_row("protected \$_table_name = "."'".mb_strtolower($orm->get_table_name())."'".";", 4)
                       ->add_row();
            }  

            if($orm->has_one_and_belongs_to())
            {
                $writer->add_row($orm->get_has_one())
                       ->add_row($orm->get_belongs_to());
            }
            if($orm->has_many())
            {
                $writer->add_row($orm->get_has_many());
            }

            $writer->add_row($orm->get_rules())
                   ->add_row($orm->get_filters())
                   ->add_row($orm->get_labels());
        }

        $writer->add_row("}")
               ->add_row("?>");

        $this->add_writer($writer);
    } 
}

?>
