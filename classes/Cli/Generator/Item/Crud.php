<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Crud extends Cli_Generator_Abstract_Generator_Item {
    
    public function __construct($table = null) {
        parent::__construct(null, $table);
    }
    
    public function init() {
        $driver = Cli_Database_Mysql_Driver::factory();
        $name = $driver->name($this->table);
        
        $subdirectory = $this->get_subdirectory();
        $route = $subdirectory == null ? $name : Cli_Util_Text::dir_separator_normalize_lowercase($subdirectory.DIRECTORY_SEPARATOR.$name);
        $path = $subdirectory == null ? "" : Cli_Util_Text::dir_separator_normalize_lowercase($subdirectory).DIRECTORY_SEPARATOR;
        $filename = $subdirectory == null ? $name : Cli_Util_Text::dir_separator_normalize_lowercase($subdirectory.DIRECTORY_SEPARATOR.$name);
                
        $this->setup(Cli_Util_System::$CONTROLLER)
                ->add_row("class Controller_" . Cli_Util_Text::class_name($filename) . " extends Controller_Template {")
                ->add_row()
                ->add_row("public \$template = 'templates/template';", 4)
                ->add_row()
                ->add_row("protected \$_model = '" . Cli_Util_Text::name($name) . "';", 4)
                ->add_row("protected \$_form_view = '".$path."forms/" . $name . "';", 4)
                ->add_row("protected \$_show_view = '".$path."shows/" . $name . "';", 4)
                ->add_row("protected \$_list_view = '".$path."lists/" . $name . "';", 4)
                ->add_row("protected \$_route = '/" . $route . "';", 4)
                ->add_row("protected \$_action_index = '/" . $route . "';", 4)
                ->add_row("protected \$_action_new = '/" . $route ."/new';", 4)
                ->add_row("protected \$_action_edit = '/" . $route ."/edit';", 4)
                ->add_row()

                // action_index
                ->add_row(self::meta("action_index"))
                ->add_row("public function action_index()", 4)
                ->add_row("{", 4)
                ->add_row("\$view = View::factory(\$this->_list_view);", 8)
                ->add_row("\$view->route = \$this->_route;", 8)
                ->add_row("\$view->result = ORM::factory(\$this->_model)->find_all();", 8)
                ->add_row("\$this->template->content = \$view;", 8)
                ->add_row("}", 4)
                ->add_row()

                // action_new
                ->add_row(self::meta("action_new"))
                ->add_row("public function action_new()", 4)
                ->add_row("{", 4)
                ->add_row("\$model = ORM::factory(\$this->_model);", 8)
                ->add_row()
                ->add_row("\$form = View::factory(\$this->_form_view);", 8)
                ->add_row("\$form->route = \$this->_route;", 8);
                        
        foreach ($driver->relationship_result($this->table) as $field) {
            $primary_keys = $driver->get_primary_key_names($this->table);
            $primary_key = isset($primary_keys[0]) ? $primary_keys[0] : "id"; 
            $this->add_row("\$form->" . $field->get_column_name() . " = ORM::factory('" . Cli_Util_Text::name($driver->name($driver->get_referenced_table_name($this->table, $field->get_column_name()))) . "')->find_all()->as_array('" . $primary_key . "', '" . $primary_key . "');", 8);
        }

        $this->add_row("\$form->action = \$this->_action_new;", 8)
                ->add_row("if (isset(\$_POST['submit']))", 8)
                ->add_row("{", 8)
                ->add_row("\$model->values(\$_POST);", 12)
                ->add_row()
                ->add_row("if(\$model->validation()->check())", 12)
                ->add_row("{", 12)
                ->add_row("\$model->save();", 16)
                ->add_row("}", 12)
                ->add_row("else", 12)
                ->add_row("{", 12)
                ->add_row("\$form->errors = \$model->validation()->errors('form-errors');", 16)
                ->add_row("\$form->values = \$_POST;", 16)
                ->add_row("}", 12)
                ->add_row("}", 8)
                ->add_row()
                ->add_row("\$this->template->content = \$form;", 8)
                ->add_row()
                ->add_row("}", 4)
                ->add_row()

                // action_edit
                ->add_row(self::meta("action_edit"))
                ->add_row("public function action_edit()", 4)
                ->add_row("{", 4)
                ->add_row("\$id = \$this->request->param('id');", 8)
                ->add_row("\$model = ORM::factory(\$this->_model, \$id);", 8)
                ->add_row()
                ->add_row("if(\$model->loaded())", 8)
                ->add_row("{", 8)
                ->add_row("\$form = View::factory(\$this->_form_view);", 12)
                ->add_row("\$form->route = \$this->_route;", 12);

        foreach ($driver->relationship_result($this->table) as $field) {
            $primary_keys = $driver->get_primary_key_names($this->table);
            $primary_key = isset($primary_keys[0]) ? $primary_keys[0] : "id"; 
            $this->add_row("\$form->" . $field->get_column_name() . " = ORM::factory('" . Cli_Util_Text::name($driver->name($driver->get_referenced_table_name($this->table, $field->get_column_name()))) . "')->find_all()->as_array('" . $primary_key . "', '" . $primary_key . "');", 12);
        }

        $this->add_row("\$form->action = \$this->_action_edit.'/'.\$id;", 12)
                ->add_row("\$form->values = \$model->as_array();", 12)
                ->add_row()
                ->add_row("if (isset(\$_POST['submit']))", 12)
                ->add_row("{", 12)
                ->add_row("\$model->values(\$_POST);", 16)
                ->add_row("if(\$model->validation()->check())", 16)
                ->add_row("{", 16)
                ->add_row("if(\$model->update()){", 20)
                ->add_row("HTTP::redirect(\$this->request->referrer());", 24)
                ->add_row("}", 20)
                ->add_row("}", 16)
                ->add_row("else", 16)
                ->add_row("{", 16)
                ->add_row("\$form->errors = \$model->validation()->errors('form-errors');", 20)
                ->add_row("\$form->values = \$_POST;", 20)
                ->add_row("}", 16)
                ->add_row("}", 12)
                ->add_row()
                ->add_row("\$this->template->content = \$form;", 12)
                ->add_row()
                ->add_row("}", 8)
                ->add_row("else", 8)
                ->add_row("{", 8)
                ->add_row("throw new HTTP_Exception_404(__('not_found', array(':id' => \$id)));", 12)
                ->add_row("}", 8)
                ->add_row("}", 4)
                ->add_row()

                // action_show
                ->add_row(self::meta("action_show"))
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
                ->add_row(self::meta("action_delete"))
                ->add_row("public function action_delete()", 4)
                ->add_row("{", 4)
                ->add_row("if(isset(\$_POST['id']))", 8)
                ->add_row("{", 8)
                ->add_row("ORM::factory(\$this->_model, \$_POST['id'])->delete();", 12)
                ->add_row("}", 8)
                ->add_row()
                ->add_row("HTTP::redirect(\$this->_action_index);", 8)
                ->add_row("}", 4)
                ->add_row()
                ->add_row("}")
                ->add_row("?>");
    }

    private static function meta($comment = null) {
        return "    /**
     * @method $comment
     */";
    }
 
    public static function factory($table = null){
        return new Cli_Generator_Item_Crud($table);
    }
    
}

?>
