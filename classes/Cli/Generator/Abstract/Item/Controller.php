<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
abstract class Cli_Generator_Abstract_Item_Controller extends Cli_Generator_Abstract_Generator_Item {
    
    private $actions = array();
    private $with_views = false;
    private $view_dir = null;    
    
    public function set_actions(array $actions){
        $this->actions = $actions;
        return $this;
    }
    
    public function get_actions(){
        return $this->actions;
    }
    
    public function get_with_views() {
        return $this->with_views;
    }

    public function set_with_views($with_views) {
        $this->with_views = $with_views;
        return $this;
    }
    
    public function get_view_dir() {
        return $this->view_dir;
    }

    public function set_view_dir($view_dir) {
        $this->view_dir = $view_dir;
        return $this;
    }
    
    public function set_subdirectory($subdirectory) {
        $text = Cli_Util_Text::dir_separator_to_underline_upperfirst($subdirectory);
        $text = Cli_Util_Text::path_from_name($text, Cli_Util_System::$CONTROLLER);
        return parent::set_subdirectory($text);
    }
}

?>
