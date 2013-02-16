<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php
/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
class Generator_Exception_FileExists extends Kohana_Exception {
    
    public function __construct(Generator_File_Writer $writer, array $variables = NULL, $code = 0, \Exception $previous = NULL) {
        $message = "File exists: ". $writer->get_file_path();
        parent::__construct($message, $variables, $code, $previous);
        
    }
}

?>
