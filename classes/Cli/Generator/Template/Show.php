<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Show extends Cli_Generator_Abstract_Template {
            
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_show", "yn", "skip")), "yes|no|y|n", false)
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

            if(!empty($pkn))
            {
                $writer = $this->get_new_writer();
                
                $writer->set_dir(views_dir().$this->get_subdir().DIRECTORY_SEPARATOR.$orm->get_name())
                        ->set_file("show.php")
                        ->php_head_enable()
                        ->add_row("?>")
                        ->add_row("<p>")
                        ->add_row("<span><?php echo HTML::anchor(\$route, '<i class=\"icon-arrow-left icon-white\"></i> '.__('action.back_to_the_list'), array('class' => 'btn btn-success')); ?></span>", 4)
                        ->add_row("<span><?php echo HTML::anchor(\$route.'/edit/'.\$model->id, '<i class=\"icon-edit icon-white\"></i> '.__('action.edit'), array('class' => 'btn btn-success')); ?></span>", 4)
                        ->add_row("</p>")
                        ->add_row("<fieldset>")
                        ->add_row()
                        ->add_row("<legend><?php echo __('" . $name . ".table_name'); ?></legend>", 4)
                        ->add_row();

                foreach ($fields as $field) {
                    $writer->add_row("<div><strong><?php echo __('" . $name . "." . $field->get_name() . "'); ?>:</strong> <?php echo HTML::chars(\$model->" . $field->get_name() . "); ?></div>", 4);
                }

                $writer->add_row()
                        ->add_row("</fieldset>");

                $this->add_writer($writer);
            }
        }
    }    
 
}

?>
