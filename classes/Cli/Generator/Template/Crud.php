<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Crud extends Cli_Generator_Abstract_Template{

    private $views = array(
        "Cli_Generator_Template_Delete",
        "Cli_Generator_Template_Form",
        "Cli_Generator_Template_List",
        "Cli_Generator_Template_Show",
    );
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_crud", "yn", "skip")), "yes|no|y|n", false)
                ->add_prompt("name", lang(array("model_name")))
                ->add_prompt("dir", lang(array("dir", "skip")))
                ->add_more("name");
        
        $options->add_skip("all", "name", true);
    }
    
    public function init() {
        $orm = Cli_Database_Orm::factory($this->get_name());
        
        $name = $orm->get_name();
        $path = clean_path($this->get_subdir().$orm->get_name());
        
        $writer = $this->get_new_writer();
        $writer->set_dir(controller_dir().upper_first($this->get_subdir()))
                ->set_package("Controller")
                ->php_head_enable()
                ->set_file(upper_first($orm->get_name()).".php")
                ->add_row("class Controller_" . path_to_class(clean_path($this->get_subdir().DIRECTORY_SEPARATOR.$name)) . " extends Controller_Template {")
                ->add_row()
                ->add_row("public \$template = 'templates/layout';", 4)
                ->add_row()
                ->add_row("protected \$_model = '" . upper_first($name) . "';", 4)
                ->add_row("protected \$_form_view = '" . $path . "/form';", 4)
                ->add_row("protected \$_show_view = '" . $path . "/show';", 4)
                ->add_row("protected \$_list_view = '" . $path . "/list';", 4)
                ->add_row("protected \$_delete_view = '" . $path . "/delete';", 4)
                ->add_row("protected \$_route = '/" . $path . "';", 4)
                ->add_row("protected \$_action_index = '/" . $path . "';", 4)
                ->add_row("protected \$_action_new = '/" . $path . "/new';", 4)
                ->add_row("protected \$_action_edit = '/" . $path . "/edit';", 4)
                ->add_row()

                // action_index
                ->add_row(todo("action_index"))
                ->add_row("public function action_index()", 4)
                ->add_row("{", 4)
                ->add_row("\$view = View::factory(\$this->_list_view);", 8)
                ->add_row("\$view->route = \$this->_route;", 8)
                ->add_row("\$view->result = ORM::factory(\$this->_model)->find_all();", 8)
                ->add_row("\$this->template->content = \$view;", 8)
                ->add_row("}", 4)
                ->add_row()

                // action_new
                ->add_row(todo("action_new"))
                ->add_row("public function action_new()", 4)
                ->add_row("{", 4)
                ->add_row("\$model = ORM::factory(\$this->_model);", 8)
                ->add_row()
                ->add_row("\$form = View::factory(\$this->_form_view);", 8)
                ->add_row("\$form->route = \$this->_route;", 8);

        foreach ($orm->relationship_result() as $field) {
            $primary_keys = $orm->get_primary_key_names();
            $primary_key = isset($primary_keys[0]) ? $primary_keys[0] : "id";
            $writer->add_row("\$form->" . $field->get_column_name() . " = ORM::factory('" . upper_first($orm->name($orm->get_referenced_table_name($field->get_column_name()))) . "')->find_all()->as_array('" . $primary_key . "', '" . $primary_key . "');", 8);
        }

        $writer->add_row("\$form->action = \$this->_action_new;", 8)
                ->add_row("if (\$this->request->method() === 'POST')", 8)
                ->add_row("{", 8)
                ->add_row("\$model->values(\$this->request->post());", 12)
                ->add_row()
                ->add_row("if(\$model->validation()->check())", 12)
                ->add_row("{", 12)
                ->add_row("if(\$model->save())", 16)
                ->add_row("{", 16)
                ->add_row("\$form->save_success = true;", 20)
                ->add_row("}", 16)
                ->add_row("}", 12)
                ->add_row("else", 12)
                ->add_row("{", 12)
                ->add_row("\$form->errors = \$model->validation()->errors('form-errors');", 16)
                ->add_row("\$form->values = \$this->request->post();", 16)
                ->add_row("}", 12)
                ->add_row("}", 8)
                ->add_row()
                ->add_row("\$this->template->content = \$form;", 8)
                ->add_row()
                ->add_row("}", 4)
                ->add_row()

                // action_edit
                ->add_row(todo("action_edit"))
                ->add_row("public function action_edit()", 4)
                ->add_row("{", 4)
                ->add_row("\$id = \$this->request->param('id');", 8)
                ->add_row("\$model = ORM::factory(\$this->_model, \$id);", 8)
                ->add_row()
                ->add_row("if(\$model->loaded())", 8)
                ->add_row("{", 8)
                ->add_row("\$form = View::factory(\$this->_form_view);", 12)
                ->add_row("\$form->route = \$this->_route;", 12);

        foreach ($orm->relationship_result() as $field) {
            $primary_keys = $orm->get_primary_key_names();
            $primary_key = isset($primary_keys[0]) ? $primary_keys[0] : "id";
            $writer->add_row("\$form->" . $field->get_column_name() . " = ORM::factory('" . upper_first($orm->name($orm->get_referenced_table_name($field->get_column_name()))) . "')->find_all()->as_array('" . $primary_key . "', '" . $primary_key . "');", 12);
        }

        $writer->add_row("\$form->action = \$this->_action_edit.'/'.\$id;", 12)
                ->add_row("\$form->values = \$model->as_array();", 12)
                ->add_row()
                ->add_row("if (\$this->request->method() === 'POST')", 12)
                ->add_row("{", 12)
                ->add_row("\$model->values(\$this->request->post());", 16)
                ->add_row("if(\$model->validation()->check())", 16)
                ->add_row("{", 16)
                ->add_row("if(\$model->update()){", 20)
                ->add_row("\$form->update_success = true;", 24)
                ->add_row("}", 20)
                ->add_row("}", 16)
                ->add_row("else", 16)
                ->add_row("{", 16)
                ->add_row("\$form->errors = \$model->validation()->errors('form-errors');", 20)
                ->add_row("\$form->values = \$this->request->post();", 20)
                ->add_row("}", 16)
                ->add_row("}", 12)
                ->add_row()
                ->add_row("\$this->template->content = \$form;", 12)
                ->add_row("}", 8)
                ->add_row("else", 8)
                ->add_row("{", 8)
                ->add_row("throw new HTTP_Exception_404(__('not_found', array(':id' => \$id)));", 12)
                ->add_row("}", 8)
                ->add_row("}", 4)
                ->add_row()

                // action_show
                ->add_row(todo("action_show"))
                ->add_row("public function action_show()", 4)
                ->add_row("{", 4)
                ->add_row("\$id = \$this->request->param('id');", 8)
                ->add_row("\$model = ORM::factory(\$this->_model, \$id);", 8)
                ->add_row()
                ->add_row("if(\$model->loaded())", 8)
                ->add_row("{", 8)
                ->add_row("\$view = View::factory(\$this->_show_view);", 12)
                ->add_row("\$view->model = \$model;", 12)
                ->add_row("\$view->route = \$this->_route;", 12)
                ->add_row("\$this->template->content = \$view;", 12)
                ->add_row("}", 8)
                ->add_row("else", 8)
                ->add_row("{", 8)
                ->add_row("throw new HTTP_Exception_404(__('not_found', array(':id' => \$id)));", 12)
                ->add_row("}", 8)
                ->add_row("}", 4)
                ->add_row()

                // action_delete
                ->add_row(todo("action_delete"))
                ->add_row("public function action_delete()", 4)
                ->add_row("{", 4)
                ->add_row("if(\$this->request->method() === 'POST')", 8)
                ->add_row("{", 8)
                ->add_row("if(\$this->request->post('id'))", 12)
                ->add_row("{", 12)
                ->add_row("if(ORM::factory(\$this->_model, \$this->request->post('id'))->delete())", 16)
                ->add_row("{", 16)
                ->add_row("HTTP::redirect(\$this->_action_index);", 20)
                ->add_row("}", 16)
                ->add_row("}", 12)
                ->add_row("}", 8)
                ->add_row()
                ->add_row("if(\$this->request->method() === 'GET')", 8)
                ->add_row("{", 8)
                ->add_row("\$id = \$this->request->param('id');", 12)
                ->add_row("\$model = ORM::factory(\$this->_model, \$id);", 12)
                ->add_row()
                ->add_row("if(\$model->loaded())", 12)
                ->add_row("{", 12)
                ->add_row("\$view = View::factory(\$this->_delete_view);", 16)
                ->add_row("\$view->model = \$model;", 16)
                ->add_row("\$view->route = \$this->_route;", 16)
                ->add_row("\$this->template->content = \$view;", 16)
                ->add_row("}", 12)
                ->add_row("else", 12)
                ->add_row("{", 12)
                ->add_row("throw new HTTP_Exception_404(__('not_found', array(':id' => \$id)));", 16)
                ->add_row("}", 12)
                ->add_row("}", 8)
                ->add_row("}", 4)
                ->add_row()
                ->add_row("}")
                ->add_row("?>");
        
        $this->add_writer($writer);
        
        foreach($this->views as $class){
            $this->generate_view($class);
        }
        
        if(!file_exists(views_dir()."templates".DIRECTORY_SEPARATOR."layout.php")){
            $template = new Cli_Generator_Template_Template();
            $template->set_subdir("templates")
                    ->set_name("layout")
                    ->init();
            foreach ($template->get_writers() as $writer){
                $this->add_writer($writer);
            }
        }
                
    }
    
    private function generate_view($class){
        $view = new $class;
        $view->set_name($this->get_name());
        $view->set_subdir($this->get_subdir());
        $view->init();
        foreach($view->get_writers() as $writer){
            $this->add_writer($writer);
        }
    }

}

?>
