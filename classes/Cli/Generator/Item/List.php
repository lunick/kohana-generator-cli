<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_List extends Cli_Generator_Abstract_Generator_Item {
            
    public function __construct($table = null) {
        parent::__construct(null, strtolower($table));
    }

    public function init() {
        $fields = $this->db_table->get_table_fields();
        $name = $this->db_table->get_name();
        $pkn = $this->db_table->get_primary_key_name();
        
        if(!empty($pkn))
        {      
            $this->setup(Cli_Util_System::$VIEWS)
                    ->add_row("?>")
                    ->add_row("<table class=\"width-100 striped\">")
                    ->add_row("<caption><?php echo __('" . $name . ".table_name'); ?></caption>")
                    ->add_row("<thead class=\"thead-gray\">", 4)
                    ->add_row("<tr>", 8);
        
        foreach ($fields as $field) {
            $this->add_row("<th><?php echo __('" . $name . "." . $field->get_name() . "'); ?></th>", 12);
        }
            
        $this->add_row("<th><?php echo __('action.actions'); ?></th>", 12)
                ->add_row("</tr>", 8)
                ->add_row("</thead>", 4)
                ->add_row("<tfoot>", 4)
                ->add_row("<tr>", 8);
        
        foreach ($fields as $field) {
            $this->add_row("<td>&nbsp;</td>", 12);
        }
        $this->add_row("<td><?php echo HTML::anchor(\$route.'/new', __('action.create_new')); ?></td>", 12)
                ->add_row("</tr>", 8)
                ->add_row("</tfoot>", 4)
                ->add_row("<tbody>", 4)
                ->add_row("<?php foreach(\$result as \$item): ?>", 4)
                ->add_row("<tr>", 8);

        foreach ($fields as $field) {
            $this->add_row("<td><?php echo HTML::chars(\$item->" . $field->get_name() . "); ?></td>", 12);
        }

        $this->add_row("<td>", 12)
                ->add_row("<ul>", 16)
                ->add_row("<li>", 20)
                ->add_row("<?php echo HTML::anchor(\$route.'/show/'.\$item->".$pkn.", __('action.show')); ?>", 24)
                ->add_row("</li>", 20)
                ->add_row("<li>", 20)
                ->add_row("<?php echo HTML::anchor(\$route.'/edit/'.\$item->".$pkn.", __('action.edit')); ?>", 24)
                ->add_row("</li>", 20)
                ->add_row("<li>", 20)
                ->add_row("<?php echo Form::open(\$route.'/delete'); ?>", 24)
                ->add_row("<?php echo Form::hidden('id', \$item->".$pkn."); ?>", 24)
                ->add_row("<?php echo Form::submit('submit', __('action.delete'), array('class' => 'btn btn-small')); ?>", 24)
                ->add_row("<?php echo Form::close(); ?>", 24)
                ->add_row("</li>", 20)
                ->add_row("</ul>", 16)
                ->add_row("</td>", 12)
                ->add_row("</tr>", 8)
                ->add_row("<?php endforeach; ?>", 4)
                ->add_row("</tbody>", 4)
                ->add_row("</table>");
        }
    }
    
    public static function factory($table = null){
        return new Cli_Generator_Item_List($table);
    }
    
}
?>
