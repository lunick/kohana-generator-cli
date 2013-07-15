<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Database extends Cli_Generator_Abstract_Template {
    
    private $search_username = "'username'   => FALSE";
    private $search_password = "'password'   => FALSE";
    private $search_database = "'database'   => 'kohana'";
       
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("database", lang(array("database")))
                ->add_prompt("username", lang(array("username")))
                ->add_prompt("password", lang(array("password")));
    }
        
    public function init() {
        $in = file_get_contents(MODPATH."database".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."database.php");
        $new_username = "'username'   => '".$this->get_options_obj()->username."'";
        $new_password = "'password'   => '".$this->get_options_obj()->password."'";
        $new_database = "'database'   => '".$this->get_options_obj()->database."'";
        
        $text = Cli_Util_Content::factory()
                ->set_text($in)
                ->search_string($this->search_username)
                ->new_string($new_username)
                ->change()
                ->search_string($this->search_password)
                ->new_string($new_password)
                ->change()
                ->search_string($this->search_database)
                ->new_string($new_database)
                ->change()
                ->get_text();
                    
        $writer = $this->get_new_writer()
                ->set_dir(config_dir())
                ->set_file("database.php")
                ->add_row($text);
        
        $this->add_writer($writer);
    }    
}

?>
