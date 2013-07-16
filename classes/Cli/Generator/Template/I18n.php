<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_I18n extends Cli_Generator_Abstract_Template {
    
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("name", lang(array("filename")))
                ->add_more("name");
    }
    
    public function init() {
        $tables = Database::instance()->list_tables();
        $writer = $this->get_new_writer();
                
        $writer->set_dir(i18n_dir())
               ->set_file($this->get_name().".php")
                ->set_package("i18n")
               ->php_head_enable()
               ->add_row("return array(")
               ->add_row()
               ->add_row("'save.success' => 'Save Success',", 4)
               ->add_row("'update.success' => 'Update Success',", 4)
               ->add_row("'not_found' => 'Model id : :id was not found in database!',", 4)
               ->add_row()
               ->add_row("'action.actions' => 'Actions',", 4)
               ->add_row("'action.edit' => 'Edit',", 4)
               ->add_row("'action.show' => 'Show',", 4)
               ->add_row("'action.delete' => 'Delete',", 4)
               ->add_row("'action.submit' => 'Submit',", 4)
               ->add_row("'action.back_to_the_list' => 'Back to the list',", 4)
               ->add_row("'action.create_new' => 'Create new',", 4)
               ->add_row()
               ->add_row("'auth.login' => 'Login',", 4)
               ->add_row("'auth.logout' => 'Logout',", 4)
               ->add_row("'auth.username' => 'Username',", 4)
               ->add_row("'auth.password' => 'Password',", 4)
               ->add_row("'auth.remember' => 'Remember me',", 4)
               ->add_row("'auth.login_fail' => 'Login Fail',", 4)
               ->add_row();
        
        $names = array();
        foreach ($tables as $table) {
            $orm = Cli_Database_Orm::factory($table);
            $fields = $orm->columns_result();
            $name = $orm->get_name();
            $names[] = $name;

            foreach ($fields as $field) {
                $writer->add_row("'" . $name . "." . $field->get_name() . "' => '" . upper_first($field->get_name()) . "',", 4);
            }
            
            $writer->add_row("'" . $name . ".table_name' => '" . upper_first($name) . "',", 4)
                   ->add_row("'" . $name . ".submit' => 'submit',", 4)
                   ->add_row();
        }
        
        $writer->add_row("'admin.home' => 'Home',", 4);
        
        foreach($names as $name){
            $writer->add_row("'admin." . $name . "' => '" . upper_first($name) . "',", 4);
        }
        
        $writer->add_row()->add_row("'site.home' => 'Home',", 4);
        
        foreach($names as $name){
            $writer->add_row("'site." . $name . "' => '" . upper_first($name) . "',", 4);
        }
        $writer->add_row();
        
        $array = Cli_Util_ConfigReader::get_key("validation");
            
        foreach ($array as $key => $val){
            $writer->add_row("'" . $key . "' => '" . $val . "',", 4);
        }

        $writer->add_row()->add_row(");")->add_row("?>");
        
        $this->add_writer($writer);
        
        if(!file_exists(messages_dir()."validation.php"))
        {
            $writer = $this->get_new_writer();
            $writer->set_dir(messages_dir())
                   ->set_file("validation.php")
                   ->php_head_enable()
                   ->add_row("return array(");

            $array = Cli_Util_ConfigReader::get_key("validation");
            foreach ($array as $key => $val){
                $writer->add_row("'" . $key . "' => '" . $key . "',", 4);
            }

            $writer->add_row(");")->add_row("?>");  
            $this->add_writer($writer);
        }
    }
    
}

?>
