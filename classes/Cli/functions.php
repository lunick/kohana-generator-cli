<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
define("CONTROLLER", 1);
define("MODEL", 2);
define("VIEWS", 3);
define("JS", 4);
define("CSS", 5);
define("IMG", 6);
define("ASSETS", 7);
define("I18N", 8);
define("CONFIG", 9);
define("MESSAGES", 10);
define("LOGS", 11);

function get_path($key){
    $with_name = array(
        "controller" => controller_dir(),
        "model" => model_dir(),
        "views" => views_dir(),
        "js" => assets_js_dir(),
        "css" => assets_css_dir(),
        "img" => assets_img_dir(),
        "assets" => assets_dir(),
        "i18n" => i18n_dir(),        
        "config" => config_dir(),
        "messages" => messages_dir(),
        "logs" => logs_dir(),
    );
    $with_key = array(
        CONTROLLER => controller_dir(),
        MODEL => model_dir(),
        VIEWS => views_dir(),
        JS => assets_js_dir(),
        CSS => assets_css_dir(),
        IMG => assets_img_dir(),
        ASSETS => assets_dir(),
        I18N => i18n_dir(),
        CONFIG => config_dir(),
        MESSAGES => messages_dir(),
        LOGS => logs_dir(),        
    );
      
    if(array_key_exists($key, $with_name)){ return $with_name[$key]; }
    if(array_key_exists($key, $with_key)){ return $with_key[$key]; }
    return null;
}

function read_generator_line($prompt){
    $line = readline(infoline($prompt));
    $line_array = explode(" ", $line);
    if(isset($line_array[0]))
    {
        return trim($line_array[0]);
    }
    else
    {
        return null;
    }
}

function infoline($text=null){
    return "\033[0;32m".$text."\033[0m";
}

function errorline($text=null){
    return "\033[41m".$text."\033[0m";
}

function paramline($text=null){
    return "\033[0;33m".$text."\033[0m";
}

function print_info($text=null){
    if(!empty($text))
    {
        echo infoline($text);
    }
}

function print_error($text=null){
    if(!empty($text))
    {
        echo errorline($text);
    }
}

function print_param($text=null){
    if(!empty($text))
    {
        echo paramline($text);
    }
}

function println_info($text=null){
    print_info($text);
    echo PHP_EOL;
}

function println_error($text=null){
    print_error($text);
    echo PHP_EOL;
}

function println_param($text=null){
    print_param($text);
    echo PHP_EOL;
}

function upper_first($string){
    return ucfirst(mb_strtolower($string));
}

function lang($keys=null){
    $string = "";
    if(!empty($keys))
    {
        if(is_array($keys))
        {
            foreach ($keys as $key){
                $string .= I18n::get($key, "generator-".I18n::$lang)." ";
            }
        }
        else
        {
            $string = I18n::get($keys, "generator-".I18n::$lang)." ";
        }
    }
    return trim($string);
}

function path_to_class($path){
    if(end_with($path, ".php"))
    {
        $path = remove_from_string($path, ".php");
    }
    $path = remove_from_string($path, APPPATH);
    $path = remove_from_string($path, "classes");
    $array = explode_string(DIRECTORY_SEPARATOR, $path);
    return string_from_array($array, "_", true);
}

function controller_view_path($class){
    $class = mb_strtolower($class);
    $base = APPPATH."views";
    $controller = "controller";
    $class = remove_from_string($class, $controller);
    $array = explode_string("_", $class);
    return $base.DIRECTORY_SEPARATOR.string_from_array($array, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
}

function class_to_path($class){
    $base = APPPATH."classes";
    $array = explode_string("_", $class);
    return $base.DIRECTORY_SEPARATOR.string_from_array($array, DIRECTORY_SEPARATOR, true).".php";
}

function clean_path($path){
    $search = DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR;
    while(mb_strpos($path, $search) !== false){
        $path = str_replace($search, DIRECTORY_SEPARATOR, $path);
        $path = clean_path($path);
    }
    return $path; 
}

function clean_underline($path){
    $search = "__";
    while(mb_strpos($path, $search) !== false){
        $path = str_replace($search, "_", $path);
        $path = clean_path($path);
    }
    return $path;
}

function php_file($path){
    return $path.".php";
}

function string_from_array(&$array, $concat_s = null, $upperfirst = false){
    $count = count($array);
    $i = 0;
    $re_string = "";
    while ($i < $count){
        if($concat_s != null)
        {
            if($i < $count-1)
            {
                $re_string .= $upperfirst ? upper_first($array[$i]).$concat_s : mb_strtolower($array[$i]).$concat_s;
            }
            else
            {
                $re_string .= $upperfirst ? upper_first($array[$i]) : mb_strtolower($array[$i]);
            }
        }
        else
        {
            $re_string .= $upperfirst ? upper_first($array[$i]) : mb_strtolower($array[$i]);
        }
        ++$i;
    }
    return $re_string;
}

function explode_string($delimiter, $string){
    $array = explode($delimiter, $string);
    $re_array = array();
    foreach ($array as $val){
        if($val != $delimiter && $val != null)
        {
            $re_array[] = $val;
        }
    }
    return $re_array;
}

/**
* patched by alrusdi
* thanks!
*/
function space($num=0){
    if(0 < $num)
    {
        return str_repeat(" ", $num);
    }
}

function char($char, $num=0){        
    return str_repeat($char, $num);
}

function delete_file($path){
    gchmod($path);
    @unlink($path);
    return $path;
}

function end_with($string, $end){
    $path_length = mb_strlen($string);
    $end_length = mb_strlen($end);
    $start = $path_length - $end_length;
    $end_string = mb_substr($string, $start, $path_length);
    return $end_string === $end ? true : false;
}

function remove_all($dir_path, $with_dir=false, $deleted_files=array()){
    $deleted = array();
    if(!empty($deleted_files)){ $deleted = array_merge($deleted, $deleted_files); }
    if(file_exists($dir_path)){
        $dir_handle = opendir($dir_path);
        while(($file = readdir($dir_handle)) != false){
            if($file != "." && $file != "..")
            {
                $file_path = $dir_path.DIRECTORY_SEPARATOR.$file;
                gchmod($file_path);
                if(is_dir($file_path))
                {
                    remove_all($file_path, true, $deleted);
                }
                else
                {
                    @unlink($file_path);
                    $deleted[] = $file_path;
                }
            }
        }
        closedir($dir_handle);
        if($with_dir){ 
            rmdir($dir_path); 
            $deleted[] = $dir_path;
        }
    }
    return $deleted;
}

function gchmod($filename){
    chmod($filename, 0777);
}

function gmkdirs($path){
    if(!file_exists($path))
    {
        $array = explode_string(DIRECTORY_SEPARATOR, remove_from_string($path, DOCROOT));
        $path = DOCROOT.DIRECTORY_SEPARATOR;

        foreach($array as $name){
            $path .= clean_path($name.DIRECTORY_SEPARATOR);
            if(!file_exists($path))
            {
                if(is_writable(dirname($path)))
                {
                    @mkdir($path);
                    gchmod($path);
                }
                else 
                {
                    println_error("Not writable: $path !");
                }
            }
        }
    }
    return $path;
}

function remove_from_string($path, $string){
    $len = mb_strlen($string);
    $pos = mb_strpos($path, $string);
    
    if($pos !== false)
    {
        if($pos === 0)
        {
            $path = mb_substr($path, $pos+$len, mb_strlen($path));
        }
        elseif ($pos+$len === mb_strlen($path)) 
        {
            $path = mb_substr($path, 0, $pos);
        }
        else 
        {
            $start = mb_substr($path, 0, $pos);
            $end = mb_substr($path, $pos+$len, mb_strlen($path));
            $path = $start.$end;
        }
    }
    return clean_underline(clean_path($path));
}

function create_file($path, $file, $data=null, $overwrite=false){
    if(!file_exists($path.DIRECTORY_SEPARATOR.$file) || $overwrite)
    {
        file_put_contents($path.DIRECTORY_SEPARATOR.$file, $data);
    }
}

function todo($comment = null) {
        return "    /**
     * @todo $comment
     */";
}

function cache_dir(){
    $path = Kohana::$cache_dir;
    return gmkdirs($path);
}

function controller_dir(){
    $path = APPPATH."classes".DIRECTORY_SEPARATOR."Controller".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function model_dir(){
    $path = APPPATH."classes".DIRECTORY_SEPARATOR."Model".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function config_dir(){
    $path = APPPATH."config".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function i18n_dir(){
    $path = APPPATH."i18n".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function logs_dir(){
    $path = APPPATH."logs".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function messages_dir(){
    $path = APPPATH."messages".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function views_dir(){
    $path = APPPATH."views".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function assets_dir(){
    $path = DOCROOT."assets".DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function assets_img_dir(){
    $path = DOCROOT."assets" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function assets_js_dir(){
    $path = DOCROOT."assets" . DIRECTORY_SEPARATOR . "js" . DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

function assets_css_dir(){
    $path = DOCROOT."assets" . DIRECTORY_SEPARATOR . "css" . DIRECTORY_SEPARATOR;
    return gmkdirs($path);
}

?>