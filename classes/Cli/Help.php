<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Cli_Help {

    public static function tables($table_name) {
        $tables = Database::instance()->list_tables();
        echo PHP_EOL;
        echo Cli_Text::text('Table: ' . $table_name . ' doesn\'t exists!', Cli_Text::$red) . PHP_EOL;
        echo Cli_Text::text('Choose one from this list:', Cli_Text::$green) . PHP_EOL;
        self::print_tables($tables);
    }
    
    public static function options(array $options){
        echo PHP_EOL;
        echo Cli_Text::text('It can accept the following options:'.PHP_EOL, Cli_Text::$brown);
        foreach ($options as $key => $val){
            echo Cli_Text::text('--'.$key.'=param'.PHP_EOL, Cli_Text::$brown);
        }
        echo PHP_EOL;
    }
    
    public static function force(array $options){
        echo PHP_EOL;
        echo Cli_Text::text('Try --force=yes option.'.PHP_EOL,Cli_Text::$green);
        echo Cli_Text::text('More options:'.PHP_EOL, Cli_Text::$brown);
        foreach ($options as $key => $val){
            echo Cli_Text::text('--'.$key.'=param'.PHP_EOL, Cli_Text::$brown);
        }
        echo PHP_EOL;
    }
    
    public static function nothing(){
        echo PHP_EOL;
        echo Cli_Text::text('We did nothing!', Cli_Text::$green);
    }

    public static function print_tables(array $tables){
        $head_string = 'Tables in your Database';
        $head_string_length = strlen($head_string);
        $num = $head_string_length;
        $space = 10;
        
        foreach ($tables as $table){
            $tnum = strlen($table);
            if($num <= $tnum){
                $num = $tnum;
            }
        }
        $max_space = (2 * $space) + $num;
        
        echo PHP_EOL;
        //echo Cli_Util_Text::space(5);     
        echo Cli_Text::text($head_string.":", Cli_Text::$green).PHP_EOL;
        
        self::print_table_top($max_space);
        foreach ($tables as $table){
            $right = (($max_space - $space) - strlen($table));
            self::print_table_line($table, $space, $right);
        }
        self::print_table_bottom($max_space);
        
    }
    
    private static function print_table_line($text, $left, $right){
        $right = $right - 1;
        //echo Cli_Util_Text::space(5);
        echo Cli_Text::text('|', Cli_Text::$blue);
        echo Cli_Util_Text::space(($left)).Cli_Text::text($text, Cli_Text::$green).Cli_Util_Text::space(($right));
        echo Cli_Text::text('|', Cli_Text::$blue).PHP_EOL;
    }
    
    private static function print_table_top($num){
        $num = ($num-2);
        //echo Cli_Util_Text::space(5);
        echo Cli_Text::text('+', Cli_Text::$blue);
        for($i = 0; $i <= $num; ++$i){
            echo Cli_Text::text('-', Cli_Text::$blue);
        }
        echo Cli_Text::text('+', Cli_Text::$blue).PHP_EOL;
    }
    
    private static function print_table_bottom($num){
        $num = ($num-2);
        //echo Cli_Util_Text::space(5);
        echo Cli_Text::text('+', Cli_Text::$blue);
        for($i = 0; $i <= $num; ++$i){
            echo Cli_Text::text('-', Cli_Text::$blue);
        }
        echo Cli_Text::text('+', Cli_Text::$blue).PHP_EOL;
    }
    
    public static function print_line($length = 20, $color=null){
        for($i = 0; $i < $length; $i++){
            echo Cli_Text::text("-", $color);
        }
        echo PHP_EOL;
    }
}

?>
