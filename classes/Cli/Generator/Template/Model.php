<?php defined("SYSPATH") or die("No direct script access.") ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Model extends Cli_Generator_Abstract_Template {
            
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_model", "yn", "skip")), "yes|no|y|n", false)
                ->add_prompt("name", lang(array("model_name")))
                ->add_more("name");
        
        $options->add_skip("all", "name", true);
    }
    
    public function init() {
        $writer = $this->get_new_writer();
        $orm = Cli_Database_Orm::factory($this->get_name());
        
        $writer->set_dir(model_dir())
                ->set_file($orm->get_class_name().".php")
                ->php_head_enable()
                ->add_row("class Model_" . $orm->get_class_name() . " extends Model {")
                ->add_row()      
                ->add_row("}")
                ->add_row("?>");
        
        $this->add_writer($writer);
    } 
}

?>
