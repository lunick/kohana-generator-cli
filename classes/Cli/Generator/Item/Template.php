<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_Template extends Cli_Generator_Abstract_Generator_Item {
            
    public function init() {
        $this->setup(Cli_Util_System::$VIEWS)
                ->add_row("?>")
                ->add_row("<!DOCTYPE html>")
                ->add_row("<html>")
                ->add_row("<head>", 4)
                ->add_row("<title></title>", 8)
                ->add_row("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">", 8)
                ->add_row("<?php echo HTML::script('assets/js/jquery.min.js') ?>", 8)
                ->add_row("<?php echo HTML::style('assets/css/kube.min.css') ?>", 8)
                ->add_row("<?php echo HTML::style('assets/css/master.css') ?>", 8)
                ->add_row("<!--[if lt IE 9]>", 8)
                ->add_row("<script src=\"http://html5shiv.googlecode.com/svn/trunk/html5.js\"></script>", 8)
                ->add_row("<![endif]-->", 8)
                ->add_row("</head>", 4)
                ->add_row("<body>", 4)
                ->add_row("<div id=\"page\">", 8)
                ->add_row("<?php echo \$content ?>", 12)
                ->add_row("</div>", 8)
                ->add_row("</body>", 4)
                ->add_row("</html>");
    } 
    
    public static function factory($filename = null, $table = null){
        return new Cli_Generator_Item_Template($filename, $table);
    }
}

?>
