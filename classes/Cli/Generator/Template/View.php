<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_View extends Cli_Generator_Abstract_Template {
               
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("name", lang(array("filename")))
                ->add_prompt("dir", lang(array("dir", "skip")))
                ->add_more("name");
    }
    
    public function init() {
        $writer = $this->get_new_writer();
        
        $writer->set_dir(views_dir().$this->get_subdir())
                ->set_file(mb_strtolower($this->get_name()).".php")
                ->php_head_enable()
                ->add_row("?>")
                ->add_row("<div class=\"hero-unit\">")
                ->add_row("<p>")
                ->add_row("This is an empty <a href=\"http://kohanaframework.org/\">"
                       . "<img alt=\"kohana\" src=\"data:image/png;base64,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\" />"
                       . "</a> page.", 4) 
                ->add_row("</p>")
                ->add_row("<p>Version: <mark><em><?php echo Kohana::version() ?></em></mark></p>")
                ->add_row("<p>Filepath is: <mark><em><?php echo __FILE__ ?></em></mark></p>")
                ->add_row("</div>");
        
        $this->add_writer($writer);
    } 
    
}

?>
