<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_List extends Cli_Generator_Abstract_Template {
    
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_list", "yn", "skip")), "yes|no|y|n", false)
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
                        ->set_file("list.php")
                        ->php_head_enable()
                        ->add_row("?>")
                        ->add_row("<p><?php echo HTML::anchor(\$route.'/new', '<i class=\"icon-plus icon-white\"></i> '.__('action.create_new'), array('class' => 'btn btn-success')); ?></p>")
                        ->add_row("<table class=\"table table-striped\">")
                        ->add_row("<caption><?php echo __('" . $name . ".table_name'); ?></caption>")
                        ->add_row("<thead>", 4)
                        ->add_row("<tr>", 8);

            foreach ($fields as $field) {
                $writer->add_row("<th><?php echo __('" . $name . "." . $field->get_name() . "'); ?></th>", 12);
            }

            $writer->add_row("<th><?php echo __('action.actions'); ?></th>", 12)
                    ->add_row("</tr>", 8)
                    ->add_row("</thead>", 4)
                    ->add_row("<tbody>", 4)
                    ->add_row("<?php foreach(\$result as \$item): ?>", 4)
                    ->add_row("<tr>", 8);

            foreach ($fields as $field) {
                $writer->add_row("<td><?php echo HTML::chars(\$item->" . $field->get_name() . "); ?></td>", 12);
            }

            $writer->add_row("<td>", 12)
                    ->add_row("<div class=\"btn-group\">", 16)
                    ->add_row("<button class=\"btn dropdown-toggle\" data-toggle=\"dropdown\">", 20)
                    ->add_row("<?php echo __('action.actions'); ?>")
                    ->add_row("<span class=\"caret\"></span>", 20)
                    ->add_row("</button>", 16)
                    ->add_row("<ul class=\"dropdown-menu\">", 20)
                    ->add_row("<li>", 24)
                    ->add_row("<?php echo HTML::anchor(\$route.'/show/'.\$item->".$pkn.", '<i class=\"icon-book\"></i> '.__('action.show')); ?>", 28)
                    ->add_row("</li>", 24)
                    ->add_row("<li>", 24)
                    ->add_row("<?php echo HTML::anchor(\$route.'/edit/'.\$item->".$pkn.", '<i class=\"icon-edit\"></i> '.__('action.edit')); ?>", 28)
                    ->add_row("</li>", 24)
                    ->add_row("<li>", 24)
                    ->add_row("<?php echo HTML::anchor(\$route.'/delete/'.\$item->".$pkn.", '<i class=\"icon-trash\"></i> '.__('action.delete')); ?>", 28)
                    ->add_row("</li>", 24)
                    ->add_row("</ul>", 20)
                    ->add_row("</div>", 16)
                    ->add_row("</td>", 12)
                    ->add_row("</tr>", 8)
                    ->add_row("<?php endforeach; ?>", 4)
                    ->add_row("</tbody>", 4)
                    ->add_row("</table>"); 
            
            $this->add_writer($writer);
            }
        }
    }
    
}
?>
