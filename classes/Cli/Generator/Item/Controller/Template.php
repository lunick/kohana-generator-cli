<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Controller_Template extends Cli_Generator_Abstract_Item_Controller {
    
    public function init() {
        $string = Cli_Util_Text::dir_separator_to_underline_lowercase($this->get_dir_path().DIRECTORY_SEPARATOR.$this->get_filename());
        $class_name = Cli_Util_Text::class_name($string);
        $this->setup(Cli_Util_System::$CONTROLLER)
                    ->add_row("class Controller_" . $class_name . " extends Controller_Template {")
                    ->add_row()
                    ->add_row()
                    ->add_row("public \$template = 'templates/template';", 4)
                    ->add_row();
        
        if($this->get_with_views()){
            foreach ($this->get_actions() as $action){
                $view = Cli_Util_Text::dir_separator_normalize_lowercase($this->get_view_dir().DIRECTORY_SEPARATOR.$action);
                $this->add_row("/**", 4)
                        ->add_row("* @method action_$action", 4)
                        ->add_row("*/", 4)
                        ->add_row("public function action_".$action."()", 4)
                        ->add_row("{", 4)
                        ->add_row("\$this->template->content = View::factory('".$view."');", 8)
                        ->add_row("}", 4)
                        ->add_row();
            }
        }
        else
        {
            foreach ($this->get_actions() as $action){
                $this->add_row("/**", 4)
                        ->add_row("* @method action_$action", 4)
                        ->add_row("*/", 4)
                        ->add_row("public function action_".$action."()", 4)
                        ->add_row("{", 4)
                        ->add_row("\$this->template->content = '<h1>".$action."</h1>';", 8)
                        ->add_row("}", 4)
                        ->add_row();
            }
        }
            
        $this->add_row("}")->add_row("?>");            
    }    
            
    public static function factory($filename = null, $table = null){
        return new Cli_Generator_Item_Controller_Template($filename, $table);
    }
}

?>
