<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Form extends Cli_Generator_Abstract_Generator_Item {
        
    public function __construct($table = null) {
        parent::__construct(null, strtolower($table));
    }

    public function init() {
        $driver = Cli_Database_Mysql_Driver::factory();
        $fields = $driver->columns_result($this->table);
        $name = $driver->name($this->table);
        $primary_keys = $driver->get_primary_key_names($this->table);
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
            $this->setup(Cli_Util_System::$VIEWS)
                    ->add_row("?>")
                    ->add_row("<fieldset>")
                    ->add_row("\n<legend><?php echo __('" . $name . ".table_name'); ?></legend>\n")
                    ->add_row("<?php \$classes = $fields_string ?>\n")
                    ->add_row("<?php if(isset(\$errors)): ?>")
                    ->add_row("<ul>")
                    ->add_row("<?php foreach (\$errors as \$error): ?>", 4)
                    ->add_row("<li class=\"error\"><?php echo \$error; ?></li>", 8)
                    ->add_row("<?php endforeach; ?>", 4)
                    ->add_row("</ul>")
                    ->add_row("<?php")
                    ->add_row("foreach (\$classes as \$key => \$value):", 4)
                    ->add_row("\$error = Arr::get(\$errors, \$key);", 8)
                    ->add_row("\$classes[\$key] = !empty(\$error) ? 'input-error' : 'input-success';", 8)
                    ->add_row("endforeach;", 4)
                    ->add_row("?>")
                    ->add_row("<?php endif; ?>\n\n")
                    ->add_row("<?php echo Form::open(\$action, array('class' => 'forms')); ?>")
                    ->add_row("<?php if(!isset(\$values)): \$values = array(); endif; ?>")
                    ->add_row("<ul>");       
        
        foreach ($fields as $field) { 
               
            $label = "__('" . $name . "." . $field->get_name() . "'), array('class' => 'bold')";
            $field_name = $field->get_name();
            
            if(!$field->is_primary_key() && !$field->is_foreign_key())
            {
                    $this->add_row("<li>", 4)
                            ->add_row("<?php echo Form::label('" . $field_name . "', " . $label . "); ?>", 8)
                            ->add_row("<?php echo Form::input('" . $field_name . "', Arr::get(\$values, '" . $field_name . "'), array('id' => '" . $field_name . "', 'class' => \$classes['" . $field_name . "'])); ?>", 8)
                            ->add_row("</li>", 4);
            }
                
            if($field->is_foreign_key())
            {   
                $this->add_row("<li>", 4)
                        ->add_row("<?php echo Form::label('" . $field_name . "', " . $label . "); ?>", 8)
                        ->add_row("<?php echo Form::select('" . $field_name . "', \$" . $field_name . ", Arr::get(\$values, '" . $field_name. "'), array('id' => '" . $field_name . "', 'class' => \$classes['" . $field_name . "'])); ?>", 8)
                        ->add_row("</li>", 4);   
            }
                
        }
        
        $this->add_row("<li>", 4)
                ->add_row("<?php echo Form::submit('submit', __('action.submit'), array('class' => 'btn')); ?>", 4)
                ->add_row("</li>", 4)
                ->add_row("<li>", 4)
                ->add_row("<?php echo HTML::anchor(\$route, __('action.back_to_the_list')); ?>", 4)
                ->add_row("</li>", 4)
                ->add_row("</ul>")
                ->add_row("<?php echo Form::close(); ?>")
                ->add_row("</fieldset>");
        }
    }
    
    public static function factory($table = null){
        return new Cli_Generator_Item_Form($table);
    }
    
}
?>
