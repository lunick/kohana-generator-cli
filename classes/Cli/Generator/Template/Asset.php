<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Asset extends Cli_Generator_Abstract_Template {
        
    public function init() {
        $bootstrap_cache_zip_file = Kohana::$cache_dir.DIRECTORY_SEPARATOR."bootstrap.zip";
        $bootstrap_cache_dir = Kohana::$cache_dir.DIRECTORY_SEPARATOR."bootstrap";
        $jquery_cache_file = Kohana::$cache_dir.DIRECTORY_SEPARATOR."jquery.min.js";
                
        $jquery_content = null;
        if(!file_exists($jquery_cache_file))
        {
            $jquery_content = file_get_contents(Cli_Util_ConfigReader::get_key("jquery_url"));
            file_put_contents($jquery_cache_file, $jquery_content);
        }
        else
        {
            $jquery_content = file_get_contents($jquery_cache_file);
        }
        
        $this->add_writer(
                $this->get_new_writer()
                ->set_dir(assets_js_dir())
                ->set_file("jquery.min.js")
                ->add_row($jquery_content)
        );
        
        if(!file_exists($bootstrap_cache_zip_file))
        {
            @file_put_contents($bootstrap_cache_zip_file, file_get_contents(Cli_Util_ConfigReader::get_key("bootstrap_url")));
            gchmod($bootstrap_cache_zip_file);
        }
        
        if(!file_exists($bootstrap_cache_dir))
        {
            $zip = new ZipArchive();
            if($zip->open($bootstrap_cache_zip_file) == TRUE)
            {
                $zip->extractTo(Kohana::$cache_dir);
                $zip->close();
            }
        }
        
        $css_files = Cli_Util_Dir::factory()
                ->set_file_end_criteria(array("css"))
                ->read_dir($bootstrap_cache_dir)
                ->get_files();
        
        $js_files = Cli_Util_Dir::factory()
                ->set_file_end_criteria(array("js"))
                ->read_dir($bootstrap_cache_dir)
                ->get_files();
        
        $img_files = Cli_Util_Dir::factory()
                ->set_file_end_criteria(array("png"))
                ->read_dir($bootstrap_cache_dir)
                ->get_files();
        
        foreach ($css_files as $file){
            $this->add_writer(
                $this->get_new_writer()
                        ->set_dir(assets_css_dir())
                        ->set_file(pathinfo($file, PATHINFO_BASENAME))
                        ->add_row(file_get_contents($file))
            );
        }
        
        foreach ($js_files as $file){
            $this->add_writer(
                $this->get_new_writer()
                        ->set_dir(assets_js_dir())
                        ->set_file(pathinfo($file, PATHINFO_BASENAME))
                        ->add_row(file_get_contents($file))
            );
        }
        
        foreach ($img_files as $file){
            $this->add_writer(
                $this->get_new_writer()
                        ->set_dir(assets_img_dir())
                        ->set_file(pathinfo($file, PATHINFO_BASENAME))
                        ->add_row(file_get_contents($file))
            );
        }
        
    }  
   
}

?>
