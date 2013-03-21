<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Generator_Item_KubeMaster extends Cli_Generator_Abstract_Generator_Item {
    
    public function init() {
        $file = Kohana::$cache_dir.DIRECTORY_SEPARATOR."kube.zip";
        $min_css = Cli_Util_ConfigReader::get_key("kube_min_css_zip_path");
        $master_css = Cli_Util_ConfigReader::get_key("kube_master_zip_path");
        $css_dir = Kohana::$cache_dir.DIRECTORY_SEPARATOR."css";
        
        if(!file_exists($css_dir))
        {
            Cli_Service_Dir::factory()->mkdir($css_dir);
        }
                
        if(!file_exists($file))
        {
            @file_put_contents($file, file_get_contents(Cli_Util_ConfigReader::get_key("kube_css_framework_url")));
            Cli_Util_File::chmod($file);
        }
        
        if(!file_exists(Kohana::$cache_dir.DIRECTORY_SEPARATOR.$master_css))
        {
            $zip = new ZipArchive();
            if($zip->open($file) == TRUE)
            {
                $zip->extractTo(Kohana::$cache_dir, array($min_css, $master_css));
                $zip->close();
            }
            @copy(Kohana::$cache_dir.DIRECTORY_SEPARATOR.$master_css, $css_dir.DIRECTORY_SEPARATOR."master.css");
        }
        else
        {
            @copy(Kohana::$cache_dir.DIRECTORY_SEPARATOR.$master_css, $css_dir.DIRECTORY_SEPARATOR."master.css");
        }
        
        $content = @file_get_contents($css_dir.DIRECTORY_SEPARATOR."master.css");
        $this->setup(Cli_Util_System::$CSS)->add_row($content);
        
    }    
    
    public static function factory($filename = null, $table = null){
        return new Cli_Generator_Item_KubeMaster($filename, $table);
    }
    
}

?>
