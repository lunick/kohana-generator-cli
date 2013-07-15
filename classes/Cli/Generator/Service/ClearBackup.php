<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Service_ClearBackup extends Cli_Generator_Abstract_Service {
        
    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("all", lang(array("all_backup_delete", "yn", "skip")))
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
                    ->delete_backup($dir);
                $files = array_merge($files, $result);
            }
        }
        else
        {
            $result = Cli_Util_Backup::factory()
                    ->delete_backup(APPPATH);
            $files = array_merge($files, $result);
            
            $result = Cli_Util_Backup::factory()
                    ->delete_backup(assets_dir());
            $files = array_merge($files, $result);
        }
        Cli_Help::deleted($files);
    }

    public function help() {
        return Cli_Help::directory_helper();
    }    
    
    
    
}

?>
