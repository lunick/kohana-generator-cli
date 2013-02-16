<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Cli_Text {

    public static $black = '0;30';
    public static $dark_gray = '1;30';
    public static $blue = '0;34';
    public static $light_blue = '1;34';
    public static $green = '0;32';
    public static $light_green = '1;32';
    public static $cyan = '0;36';
    public static $light_cyan = '1;36';
    public static $red = '0;31';
    public static $light_red = '1;31';
    public static $purple = '0;35';
    public static $light_purple = '1;35';
    public static $brown = '0;33';
    public static $yellow = '1;33';
    public static $light_gray = '0;37';
    public static $white = '1;37';

    public static function text($text, $color=null) {
        return !isset($color) ? $text : "\033[" . $color . "m".$text."\033[0m";
    }

}

?>
