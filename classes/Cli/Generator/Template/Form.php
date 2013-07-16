<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Form extends Cli_Generator_Abstract_Template {
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_form", "yn", "skip")), "yes|no|y|n", false)
                ->add_prompt("name", lang(array("model_name")))
                ->add_prompt("dir", lang(array("dir", "skip")))
                ->add_more("name");
        
        $options->add_skip("all", "name", true);
    }

    public function init() {
        $orm = Cli_Database_Orm::factory($this->get_name());
        
        if($orm->table_exists()){
            $fields = $orm->columns_result();
            $name = $orm->get_name();
            $primary_keys = $orm->get_primary_key_names();

            $pkn = isset($primary_keys[0]) ? $primary_keys[0] : "id";
        
            $fields_array = array();

            foreach ($fields as $field) {
                if(!$field->is_primary_key()){
                    $fields_array[] = $field->get_name();
                }
            }

            $fields_array_count = count($fields_array);
            $fields_string = "array(";
            $i = 0;

            foreach ($fields_array as $field){
                if($fields_array_count - 1 == $i){
                    $fields_string .= "'$field'"." => 'input'";
                }else{
                    $fields_string .= "'$field'"." => 'input',";
                }
                $i++;
            }

            $fields_string .= ");";

            if(!empty($pkn))
            {      
                $writer = $this->get_new_writer();
                
                $writer->set_dir(views_dir().$this->get_subdir().DIRECTORY_SEPARATOR.$orm->get_name())
                        ->set_file("form.php")
                        ->set_package("view")
                        ->php_head_enable()
                        ->add_row("?>")
                        ->add_row("<p>")
                        ->add_row("<span><?php echo HTML::anchor(\$route, '<i class=\"icon-arrow-left icon-white\"></i> '.__('action.back_to_the_list'), array('class' => 'btn btn-success')); ?></span>", 4)
                        ->add_row("</p>")
                        ->add_row("<fieldset>")
                        ->add_row("\n<legend><?php echo __('" . $name . ".table_name'); ?></legend>\n")
                        ->add_row("<?php \$classes = $fields_string ?>\n")
                        ->add_row("<?php if(isset(\$errors)): ?>")
                        ->add_row("<div class=\"alert alert-error\">")
                        ->add_row("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>")
                        ->add_row("<ul>")
                        ->add_row("<?php foreach (\$errors as \$error): ?>", 4)
                        ->add_row("<li class=\"error\"><?php echo \$error; ?></li>", 8)
                        ->add_row("<?php endforeach; ?>", 4)
                        ->add_row("</ul>")
                        ->add_row("</div>")
                        ->add_row("<?php")
                        ->add_row("foreach (\$classes as \$key => \$value):", 4)
                        ->add_row("\$error = Arr::get(\$errors, \$key);", 8)
                        ->add_row("\$classes[\$key] = !empty(\$error) ? ' error' : ' success';", 8)
                        ->add_row("endforeach;", 4)
                        ->add_row("?>")
                        ->add_row("<?php endif; ?>\n\n")
                        ->add_row()
                        ->add_row("<?php if(isset(\$save_success)): ?>")
                        ->add_row("<div class=\"alert alert-success\">")
                        ->add_row("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>")
                        ->add_row("<?php echo __('save.success') ?>", 4)
                        ->add_row("</div>")
                        ->add_row("<?php endif; ?>")
                        ->add_row()
                        ->add_row("<?php if(isset(\$update_success)): ?>")
                        ->add_row("<div class=\"alert alert-success\">")
                        ->add_row("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>")
                        ->add_row("<?php echo __('update.success') ?>", 4)
                        ->add_row("</div>")
                        ->add_row("<?php endif; ?>")
                        ->add_row()
                        ->add_row()
                        ->add_row("<?php echo Form::open(\$action, array('class' => 'forms')); ?>")
                        ->add_row("<?php if(!isset(\$values)): \$values = array(); endif; ?>");       

            foreach ($fields as $field) { 

                $label_translate = "__('" . $name . "." . $field->get_name() . "')";
                $label = "$label_translate, array('class' => 'control-label')";
                $field_name = $field->get_name();

                if(!$field->is_primary_key() && !$field->is_foreign_key())
                {
                        $writer->add_row("<div class=\"control-group<?php echo \$classes['" . $field_name . "'] ?>\">", 4)
                                ->add_row("<?php echo Form::label('" . $field_name . "', " . $label . "); ?>", 8)
                                ->add_row("<div class=\"controls\">", 8)
                                ->add_row("<?php echo Form::input('" . $field_name . "', Arr::get(\$values, '" . $field_name . "'), array('id' => '" . $field_name . "', 'placeholder' => " . $label_translate . ")); ?>", 12)
                                ->add_row("</div>", 8)
                                ->add_row("</div>", 4);
                }

                if($field->is_foreign_key())
                {   
                    $writer->add_row("<div class=\"control-group<?php echo \$classes['" . $field_name . "'] ?>\">", 4)
                            ->add_row("<?php echo Form::label('" . $field_name . "', " . $label . "); ?>", 8)
                            ->add_row("<div class=\"controls\">", 8)
                            ->add_row("<?php echo Form::select('" . $field_name . "', \$" . $field_name . ", Arr::get(\$values, '" . $field_name. "'), array('id' => '" . $field_name . "', 'placeholder' => " . $label_translate . ")); ?>", 12)
                            ->add_row("</div>", 8)
                            ->add_row("</div>", 4);   
                }

            }

            $writer->add_row("<div>", 4)
                    ->add_row("<?php echo Form::submit('submit', __('action.submit'), array('class' => 'btn btn-primary')); ?>", 4)
                    ->add_row("</div>", 4)
                    ->add_row("<?php echo Form::close(); ?>")
                    ->add_row("</fieldset>");

            $this->add_writer($writer);
            
            }
        }
    }
        
}
?>
