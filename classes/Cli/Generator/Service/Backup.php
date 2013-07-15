<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Service_Backup extends Cli_Generator_Abstract_Service {
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $help = Cli_Help::directory_helper();
        $prompt->add_prompt("all", lang(array("generate_all_backup", "yn", "skip")))
                ->add_prompt("dir", lang(array("dir")));
        
        $options->add_skip("all", "dir", true);
    }

    public function run() {
        $files = array();
        if(isset($this->get_options_obj()->dir))
        {
            $dir = get_path($this->get_options_obj()->dir);
            
            if(!empty($dir)){
                $result = Cli_Util_Backup::factory()
                            ->make_backup($dir);
                $files = array_merge($files, $result);
            }
        }
        else
        {
            $result = Cli_Util_Backup::factory()
                            ->make_backup(APPPATH);
            $files = array_merge($files, $result);
            
            $result = Cli_Util_Backup::factory()
                            ->make_backup(assets_dir());
            $files = array_merge($files, $result);
        }
        Cli_Help::generated($files);
    }

    public function help() {
        return Cli_Help::directory_helper();
    }    
    
    
    
}

?>
