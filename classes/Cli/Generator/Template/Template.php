<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Template extends Cli_Generator_Abstract_Template {
            
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("name", lang(array("filename")))
                ->add_prompt("dir", lang(array("dir", "skip")))
                ->add_more("name");
    }
    
    public function init() {
        $writer = $this->get_new_writer();
        
        $writer->set_dir(views_dir().$this->get_subdir())
                ->set_file($this->get_name().".php")
                ->php_head_enable()
                ->add_row("?>")
                ->add_row("<!DOCTYPE html>")
                ->add_row("<html>")
                ->add_row("<head>", 4)
                ->add_row("<title></title>", 8)
                ->add_row("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">", 8)
                ->add_row("<?php echo HTML::script('assets/js/jquery.min.js') ?>", 8)
                ->add_row("<?php echo HTML::script('assets/js/bootstrap.min.js') ?>", 8)
                ->add_row("<?php echo HTML::style('assets/css/bootstrap.min.css') ?>", 8)
                ->add_row("<?php echo HTML::style('assets/css/bootstrap-responsive.min.css') ?>", 8)
                ->add_row("<!--[if lt IE 9]>", 8)
                ->add_row("<script src=\"http://html5shiv.googlecode.com/svn/trunk/html5.js\"></script>", 8)
                ->add_row("<![endif]-->", 8)
                ->add_row("</head>", 4)
                ->add_row("<body>", 4)
                ->add_row("<div class=\"container\">", 8)
                ->add_row("<?php echo \$content ?>", 12)
                ->add_row("</div>", 8)
                ->add_row("</body>", 4)
                ->add_row("</html>");
        
        $this->add_writer($writer);
    } 
    
}

?>
