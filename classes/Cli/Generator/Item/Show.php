<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Show extends Cli_Generator_Abstract_Generator_Item {
    
    public function __construct($table = null) {
        parent::__construct(null, strtolower($table));
    }
    
    public function init() {
        $driver = Cli_Database_Mysql_Driver::factory();
        $fields = $driver->columns_result($this->table);
        $name = $driver->name($this->table);
        $primary_keys = $driver->get_primary_key_names($this->table);
        $pkn = isset($primary_keys[0]) ? $primary_keys[0] : "id";
        
        if(!empty($pkn))
        {            
            $this->setup(Cli_Util_System::$VIEWS)
                    ->add_row("?>")
                    ->add_row("<fieldset>")
                    ->add_row("\n<legend><?php echo __('" . $name . ".table_name'); ?></legend>\n");

            foreach ($fields as $field) {
                $this->add_row("<div><strong><?php echo __('" . $name . "." . $field->get_name() . "'); ?>:</strong> <?php echo HTML::chars(\$model->" . $field->get_name() . "); ?></div>");
            }

            $this->add_row("\n<ul>")
                    ->add_row("<li><?php echo HTML::anchor(\$route, __('action.back_to_the_list')); ?></li>", 4)
                    ->add_row("<li><?php echo HTML::anchor(\$route.'/edit/'.\$model->".$pkn.", __('action.edit')); ?></li>", 4)
                    ->add_row("<li>", 4)
                    ->add_row("<?php echo Form::open(\$route.'/delete'); ?>", 8)
                    ->add_row("<?php echo Form::hidden('id', \$model->".$pkn."); ?>", 8)
                    ->add_row("<?php echo Form::submit('submit', __('action.delete'), array('class' => 'btn btn-small')); ?>", 8)
                    ->add_row("<?php echo Form::close(); ?>", 8)
                    ->add_row("</li>", 4)
                    ->add_row("</ul>")
                    ->add_row("</fieldset>");   
        }
    }    
    
    public static function factory($table = null){
        return new Cli_Generator_Item_Show($table);
    }
}

?>
