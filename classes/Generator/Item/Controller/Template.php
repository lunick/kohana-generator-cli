<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_Controller_Template extends Generator_Abstract_Item {
    
    private $actions = array();
        
    public function init() {
        $this->get_file_builder()
                    ->setup(Generator_Util_Kohana::$CONTROLLER)
                    ->add_row("class Controller_" . Generator_Util_Text::class_name($this->filename) . " extends Controller_Template {")
                    ->add_row()
                    ->add_row()
                    ->add_row("public \$template = 'templates/template';", 4)
                    ->add_row();
        
        foreach ($this->get_actions() as $action){
            $this->get_file_builder()
                    ->add_row("/**", 4)
                    ->add_row("* @method action_$action", 4)
                    ->add_row("*/", 4)
                    ->add_row("public function action_".$action."()", 4)
                    ->add_row("{", 4)
                    ->add_row("\$this->template->content = 'action_".$action."';", 8)
                    ->add_row("}", 4)
                    ->add_row();
        }
            
        $this->get_file_builder()
                ->add_row("}")
                ->add_row("?>");            
    }    
        
    public function set_actions(array $actions){
        $this->actions = $actions;
        return $this;
    }
    
    public function get_actions(){
        return $this->actions;
    }    
}

?>
