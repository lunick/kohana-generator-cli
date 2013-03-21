<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_I18n extends Cli_Generator_Abstract_Generator_Item {
    
    public function init() {
        $tables = Database::instance()->list_tables();
        
        $this->setup(Cli_Util_System::$I18n)
                ->add_row("return array(")
                ->add_row("'action.actions' => 'Actions',", 4)
                ->add_row("'action.edit' => 'Edit',", 4)
                ->add_row("'action.show' => 'Show',", 4)
                ->add_row("'action.delete' => 'Delete',", 4)
                ->add_row("'action.submit' => 'Submit',", 4)
                ->add_row("'action.back_to_the_list' => 'Back to the list',", 4)
                ->add_row("'action.create_new' => 'Create new',", 4)
                ->add_row("'not_found' => 'Model id : :id was not found in database!',", 4)
                ->add_row();
        
        foreach ($tables as $table) {

            $db_table = Cli_Generator_Database_Table::factory($table);
            $fields = $db_table->get_table_fields();
            
            $name = $db_table->get_name();

            foreach ($fields as $field) {
                $this->add_row("'" . $name . "." . $field->get_name() . "' => '" . Cli_Util_Text::upper_first($field->get_name()) . "',", 4);
            }
            
            $this->add_row("'" . $name . ".table_name' => '" . Cli_Util_Text::upper_first($name) . "',", 4)
                    ->add_row();
        }
        
        $array = Cli_Util_ConfigReader::get_key("validation");
            
        foreach ($array as $key => $val){
            $this->add_row("'" . $key . "' => '" . $val . "',", 4);
        }

        $this->add_row(");")->add_row("?>");
    }
    
    public static function factory($filename = null, $table = null){
        return new Cli_Generator_Item_I18n($filename, $table);
    }
    
}

?>
