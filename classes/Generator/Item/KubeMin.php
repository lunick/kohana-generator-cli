<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Item_KubeMin extends Generator_Abstract_Item {
    
    public function init() {
        $file = Kohana::$cache_dir.DIRECTORY_SEPARATOR."kube.zip";
        $min_css = Generator_Util_ConfigReader::get_key("kube_min_css_zip_path");
        $master_css = Generator_Util_ConfigReader::get_key("kube_master_zip_path");
        $css_dir = Kohana::$cache_dir.DIRECTORY_SEPARATOR."css";
        
        if(!file_exists($css_dir)){
            @mkdir($css_dir, 0777);
        }
                
        if(!file_exists($file)){
            @file_put_contents($file, file_get_contents(Generator_Util_ConfigReader::get_key("kube_css_framework_url")));
            @chmod($file, 0777);
        }
        
        if(!file_exists(Kohana::$cache_dir.DIRECTORY_SEPARATOR.$min_css))
        {
            $zip = new ZipArchive();
            if($zip->open($file) == TRUE)
            {
                $zip->extractTo(Kohana::$cache_dir, array($min_css, $master_css));
                $zip->close();
            }
            @copy(Kohana::$cache_dir.DIRECTORY_SEPARATOR.$min_css, $css_dir.DIRECTORY_SEPARATOR."kube.min.css");
        }
        else
        {
            @copy(Kohana::$cache_dir.DIRECTORY_SEPARATOR.$min_css, $css_dir.DIRECTORY_SEPARATOR."kube.min.css");
        }
        
        
        $content = @file_get_contents($css_dir.DIRECTORY_SEPARATOR."kube.min.css");
        $this->get_file_builder()
                ->setup(Generator_Util_Kohana::$CSS)
                ->add_row($content);
    }    
}

?>
