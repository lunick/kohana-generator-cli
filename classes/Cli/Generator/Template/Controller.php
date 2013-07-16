<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Controller extends Cli_Generator_Abstract_Controller {
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("name", lang(array("controller_name")))
                ->add_prompt("action", lang(array("action_name")))
                ->add_prompt("dir", lang(array("dir", "skip")))
                ->add_more("action");
    }
    
    public function init(){
        $writer = $this->get_new_writer();
                
        $writer->set_dir(controller_dir().upper_first($this->get_subdir()).DIRECTORY_SEPARATOR)
                    ->set_file(upper_first($this->get_options_obj()->name).".php")
                    ->set_package("Controller")
                    ->php_head_enable()
                    ->add_row("class Controller_" . path_to_class(clean_path($this->get_subdir().DIRECTORY_SEPARATOR.$this->get_options_obj()->name)) . " extends Controller {")
                    ->add_row();
        
        if(!empty($this->actions))
        {
            foreach ($this->actions as $action){
                $view = strtolower(clean_path(
                        $this->get_subdir().
                        $this->get_options_obj()->name.
                        DIRECTORY_SEPARATOR.
                        $action));
                
                $writer->add_row("/**", 4)
                        ->add_row("* @method action_$action", 4)
                        ->add_row("*/", 4)
                        ->add_row("public function action_".$action."()", 4)
                        ->add_row("{", 4)
                        ->add_row("\$this->response->body(View::factory('".$view."'));", 8)
                        ->add_row("}", 4)
                        ->add_row();
                
                $view = new Cli_Generator_Template_View();
                $view->set_name($action);
                $view->set_subdir($this->get_subdir().DIRECTORY_SEPARATOR.$this->get_options_obj()->name);
                $view->init();
                foreach($view->get_writers() as $w){
                    $this->add_writer($w);
                }
            }
        }
        
        $writer->add_row("}")->add_row("?>");
        
        $this->add_writer($writer);
    }
    
}

?>
