<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * 
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Help {
    
    public static function box($string){
        $string = $string;
        $line = '+'.char('-', mb_strlen($string)+2).'+';
        return $line.PHP_EOL."| ".$string." |".PHP_EOL.$line;
    }

    public static function directory_helper(){
        $string = infoline(self::box(lang("dir_alias"))).PHP_EOL;
        $string .= infoline("controller: ");
        $string .= paramline(CONTROLLER).PHP_EOL;
        $string .= infoline("model: ");
        $string .= paramline(MODEL).PHP_EOL;
        $string .= infoline("views: ");
        $string .= paramline(VIEWS).PHP_EOL;
        $string .= infoline("js: ");
        $string .= paramline(JS).PHP_EOL;
        $string .= infoline("css: ");
        $string .= paramline(CSS).PHP_EOL;
        $string .= infoline("img: ");
        $string .= paramline(IMG).PHP_EOL;
        $string .= infoline("assets: ");
        $string .= paramline(ASSETS).PHP_EOL;
        $string .= infoline("i18n: ");
        $string .= paramline(I18N).PHP_EOL;
        $string .= infoline("config: ");
        $string .= paramline(CONFIG).PHP_EOL;
        $string .= infoline("messages: ");
        $string .= paramline(MESSAGES).PHP_EOL;
        $string .= infoline("logs: ");
        $string .= paramline(LOGS).PHP_EOL;
        return $string;
    }
    
    public static function deleted(array $files){
        if(!empty($files))
        {
            foreach ($files as $file){
                print_info("Deleted: ");
                println_param(clean_path($file));
            }
        }
    }
    
    public static function generated(array $files){
        if(!empty($files))
        {
            foreach ($files as $file){
                print_info("Generated: ");
                println_param(clean_path($file));
            }
        }
    }
        
    public static function print_dbtables(){
        $tables = Database::instance()->list_tables();
        $string = lang(array("tables_in_database")).":";
        $string_length = $width = mb_strlen($string)+2;
        $longest = 0;
        foreach ($tables as $table){
            $length = mb_strlen($table)+1;
            if($longest < $length)
            {
                $longest = $length;
            }
        }
        
        if($width < $longest){ $width = $longest; }
        
        $lines = char("-", $width);
        $empty = space($width - $string_length);
        $head = '+'.$lines.'+'.PHP_EOL.'| '.$string.$empty.' |'.PHP_EOL.'+'.$lines.'+';
        
        println_info($head);
        foreach ($tables as $table){
            print_info("| ");
            print_param($table);
            $empty = space($width - mb_strlen($table)-1);
            println_info($empty."|");
        }
        println_info('+'.$lines.'+');
    }
    
    public static function check_dbconnection(){
        echo PHP_EOL;
        try {
            Database::instance()->connect();
            println_info(Cli_Help::box('Connection: ok!'));
            println_info();
        }  catch (Exception $e){
            println_error(Cli_Help::box('Connection: failed!'));
            println_info();
        }
    }
    
    public static function clear_cache(){
        Cli_Help::deleted(remove_all(cache_dir()));
    }
    
    public static function clear_log(){
        Cli_Help::deleted(remove_all(logs_dir()));
    }
    
    public static function print_help($key=null){
        if($key != null)
        {
            println_info();
            if(Generator_Register::command_exists($key)){
                $info = lang(array($key));
                if(!empty($info))
                {
                    println_info(Cli_Help::box($info));
                    print_info(lang(array("use")).": ");
                    echo paramline("php index.php g ".$key).PHP_EOL;
                }

                $class = Generator_Register::get_class($key);
                if($class !== false)
                {
                    $class = new $class;
                    if($class instanceof Cli_Generator_Interface_Help)
                    {
                        $string = $class->help();
                        if($string){
                            echo $string;
                        }                    
                    }
                }
            }
            else
            {
                println_error("This command ".$key." not available!");
            }
            println_info();
        }
        
    }
    
    public static function print_commands(){
        $register = Generator_Register::get_register();
        $more_info = lang("more_info");
        foreach ($register as $key => $array){
            $info = lang(array($key));
            if(!empty($info))
            {
                print_info($info.": ");
                echo paramline("php index.php g ".$key).PHP_EOL;
                print_info($more_info.": ");
                echo paramline("php index.php command ".$key).PHP_EOL;
                println_param(char("-", 60));
            }
        }
    }
    
}

?>
