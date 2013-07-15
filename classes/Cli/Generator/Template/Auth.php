<?php defined('SYSPATH') or die('No direct script access.') ?>
<?php

/**
 * @author burningface
 * @license GPL 
 * @copyright (c) 2013 
 *
 */
final class Cli_Generator_Template_Auth extends Cli_Generator_Abstract_Template {

    public function prompt(\Cli_Generator_Interface_InteractivePrompt $prompt, \Cli_Generator_Interface_Options $options) {
        $prompt->add_prompt("route", lang(array("add_route", "yn", "skip")), "yes|no|y|n", false);
    }
    
    public function init() {
        $writer = $this->get_new_writer();
        
        $writer->set_dir(controller_dir()."Auth")
                ->set_file("Auth.php")
                ->php_head_enable()
                ->add_row("class Controller_Auth_Auth extends Controller_Template {")
                ->add_row()
                ->add_row("public \$template = 'templates/layout';", 4)
                ->add_row()
                ->add_row("public function action_login(){", 4)
                ->add_row("\$auth = Auth::instance();", 8)
                ->add_row("if(!\$auth->logged_in())", 8)
                ->add_row("{", 8)
                ->add_row("\$form = View::factory('auth/form');", 12)
                ->add_row("\$form->action = 'auth/login';", 12)
                ->add_row()
                ->add_row("if(\$this->request->method() === 'POST'){", 12)
                ->add_row("\$validation = Validation::factory(\$this->request->post())", 16)
                ->add_row("->rules('username', array(", 24)
                ->add_row("array('not_empty'),", 28)
                ->add_row("array('min_length',array(':value', 5))))", 28)
                ->add_row("->rules('password', array(", 24)
                ->add_row("array('not_empty'),", 28)
                ->add_row("array('min_length',array(':value', 5))));", 28)
                ->add_row()
                ->add_row("if(\$validation->check())", 16)
                ->add_row("{", 16)
                ->add_row("\$login = \$auth->login(", 20)
                ->add_row("\$this->request->post('username'),", 28)
                ->add_row("\$this->request->post('password'),", 28)
                ->add_row("(boolean)\$this->request->post('remember'));", 28)
                ->add_row()
                ->add_row("if(\$login)", 20)
                ->add_row("{", 20)
                ->add_row("\$this->user_login(\$auth);", 24)
                ->add_row("}", 20)
                ->add_row("else", 20)
                ->add_row("{", 20)
                ->add_row("\$form->errors = array(__('auth.login_fail'));", 24)
                ->add_row("}", 20)
                ->add_row("}", 16)
                ->add_row("else", 16)
                ->add_row("{", 16)
                ->add_row("\$form->errors = \$validation->errors('form-errors');", 20)
                ->add_row("\$form->values = \$this->request->post();", 20)
                ->add_row("}", 16)
                ->add_row("}", 12)
                ->add_row("\$this->template->content = \$form;", 12)
                ->add_row("}", 8)
                ->add_row("else", 8)
                ->add_row("{", 8)
                ->add_row("\$this->user_login(\$auth);", 12)
                ->add_row("}", 8)
                ->add_row("}", 4)
                ->add_row()
                ->add_row("public function action_logout(){", 4)
                ->add_row("Auth::instance()->logout();", 8)
                ->add_row("HTTP::redirect('auth/login');", 8)
                ->add_row("}", 4)
                ->add_row()
                ->add_row("private function user_login(Auth &\$auth){", 4)
                ->add_row("\$user = \$auth->get_user();", 8)
                ->add_row("if(\$user->has('roles', ORM::factory('Role', array('name' => 'admin'))))", 8)
                ->add_row("{", 8)
                ->add_row("HTTP::redirect(Kohana::\$config->load('login')->admin['uri']);", 12)
                ->add_row("}", 8)
                ->add_row("else if(\$user->has('roles', ORM::factory('Role', array('name' => 'login'))))", 8)
                ->add_row("{", 8)
                ->add_row("HTTP::redirect(Kohana::\$config->load('login')->login['uri']);", 12)
                ->add_row("}", 8)
                ->add_row("else", 8)
                ->add_row("{", 8)
                ->add_row("HTTP::redirect('auth/logout');", 12)
                ->add_row("}", 8)
                ->add_row("}", 4)
                ->add_row("}")
                ->add_row("?>");
        
        $this->add_writer($writer);
        
        //form
        $writer = $this->get_new_writer();
        
        $writer->set_dir(views_dir() . "auth".DIRECTORY_SEPARATOR)
               ->set_file("form.php")
               ->php_head_enable()
               ->add_row("?>")
               ->add_row("<div class=\"hero-unit\">")
               ->add_row("<div class=\"row\">", 4)
               ->add_row("<div class=\"offset4 span5\">", 8)
               ->add_row("<fieldset>", 8)
               ->add_row("<legend><?php echo __('auth.login'); ?></legend>", 8)
               ->add_row("<?php \$classes = array('username' => 'input', 'password' => 'input', 'remember' => 'input'); ?>", 8)
               ->add_row("<?php if(isset(\$errors)): ?>", 8)
               ->add_row("<div class=\"alert alert-error\">", 8)
               ->add_row("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>", 8)
               ->add_row("<ul>", 8)
               ->add_row("<?php foreach (\$errors as \$error): ?>", 12)
               ->add_row("<li class=\"error\"><?php echo \$error; ?></li>", 16)
               ->add_row("<?php endforeach; ?>", 12)
               ->add_row("</ul>", 8)
               ->add_row("</div>", 8)
               ->add_row("<?php", 8)
               ->add_row("foreach (\$classes as \$key => \$value):", 12)
               ->add_row("\$error = Arr::get(\$errors, \$key);", 16)
               ->add_row("\$classes[\$key] = !empty(\$error) ? ' error' : ' success';", 16)
               ->add_row("endforeach;", 12)
               ->add_row("?>", 8)
               ->add_row("<?php endif; ?>", 8)
               ->add_row("<?php if(isset(\$save_success)): ?>", 8)
               ->add_row("<div class=\"alert alert-success\">", 8)
               ->add_row("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>", 8)
               ->add_row("<?php echo __('save.success') ?>", 12)
               ->add_row("</div>", 8)
               ->add_row("<?php endif; ?>", 8)
               ->add_row("<?php if(isset(\$update_success)): ?>", 8)
               ->add_row("<div class=\"alert alert-success\">", 8)
               ->add_row("<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>", 12)
               ->add_row("<?php echo __('update.success') ?>", 12)
               ->add_row("</div>", 8)
               ->add_row("<?php endif; ?>", 8)
               ->add_row()
               ->add_row("<?php echo Form::open(\$action, array('class' => 'forms')); ?>", 8)
               ->add_row("<?php if(!isset(\$values)): \$values = array(); endif; ?>", 8)
               ->add_row("<div class=\"control-group<?php echo \$classes['username'] ?>\">", 12)
               ->add_row("<?php echo Form::label('username', __('auth.username'), array('class' => 'control-label')); ?>", 16)
               ->add_row("<div class=\"controls\">", 16)
               ->add_row("<?php echo Form::input('username', Arr::get(\$values, 'username'), array('id' => 'username', 'placeholder' => __('auth.username'))); ?>", 20)
               ->add_row("</div>", 16)
               ->add_row("</div>", 12)
               ->add_row("<div class=\"control-group<?php echo \$classes['password'] ?>\">", 12)
               ->add_row("<?php echo Form::label('password', __('auth.password'), array('class' => 'control-label')); ?>", 16)
               ->add_row("<div class=\"controls\">", 16)
               ->add_row("<?php echo Form::password('password', Arr::get(\$values, 'password'), array('id' => 'password', 'placeholder' => __('auth.password'))); ?>", 20)
               ->add_row("</div>", 16)
               ->add_row("</div>", 12)
               ->add_row("<div class=\"control-group<?php echo \$classes['remember'] ?>\">", 12)
               ->add_row("<?php echo Form::label('remember', Form::checkbox('remember', 1, (boolean)Arr::get(\$values, 'remember'), array('id' => 'remember')).__('auth.remember'), array('class' => 'checkbox')); ?>", 16)
               ->add_row("</div>", 12)
               ->add_row("<div>", 12)
               ->add_row("<?php echo Form::submit('submit', __('auth.login'), array('class' => 'btn btn-primary')); ?>", 12)
               ->add_row("</div>", 12)
               ->add_row("<?php echo Form::close(); ?>", 8)
               ->add_row("</fieldset>", 8)
               ->add_row("</div>", 8)
               ->add_row("</div>", 4)
               ->add_row("</div>");
        
        $this->add_writer($writer);
        
        $auth_in = MODPATH.DIRECTORY_SEPARATOR."auth".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."auth.php";
        $auth_out = config_dir()."auth.php";
        
        if(!file_exists($auth_out))
        {
            $text_in = file_get_contents($auth_in);
            $text_out = Cli_Util_Content::factory()
                ->set_text($text_in)
                ->search_string("File")
                ->new_string("ORM")
                ->change()
                ->search_string("NULL")
                ->new_string("'".sha1(uniqid().time())."'")
                ->change()
                ->get_text();
            
            $writer = $this->get_new_writer();
            
            $writer->set_dir(config_dir())
                    ->set_file("auth.php")
                    ->add_row($text_out);
                    
            $this->add_writer($writer);
        }
        
        $login_config = config_dir()."login.php";
        if(!file_exists($login_config))
        {
            $writer = $this->get_new_writer();
            $writer->set_dir(config_dir())
                    ->set_file("login.php")
                    ->php_head_enable()
                    ->add_row("return array(")
                    ->add_row()
                    ->add_row("'admin' => array('uri' => '/admin'),", 4)
                    ->add_row("'login' => array('uri' => '/user'),", 4)
                    ->add_row()
                    ->add_row(");")
                    ->add_row("?>");
            $this->add_writer($writer);
        }
        
        if($this->get_options_obj()->route)
        {
            $this->bootstrap();
        }
        
    }
    
    private function bootstrap(){
        $bootstrap = "bootstrap.php";
        
        $route_start = "Route::set";
        $cookie = "Cookie::\$salt";
        $cookie_string = "Cookie::\$salt = '".sha1(uniqid().time())."';\n\n";
        $bootstrap_in = file_get_contents(APPPATH.$bootstrap);
        $cookie_exists = Cli_Util_Content::factory()
                ->set_text($bootstrap_in)
                ->search_string($cookie)
                ->find();
        if(!$cookie_exists)
        {
            $start_out = Cli_Util_Content::factory()
                    ->set_text($bootstrap_in)
                    ->search_string($route_start)
                    ->cut_before()
                    ->get_text();
            
            $end_out = Cli_Util_Content::factory()
                    ->set_text($bootstrap_in)
                    ->search_string($route_start)
                    ->cut_after()
                    ->get_text();
            
            $bootstrap_in = $start_out.$cookie_string.$route_start.$end_out;
            
        }
        
        $default_route = "Route::set('default', '(<controller>(/<action>(/<id>)))')";
        
        $route = $this->routes();
                
        try{
            Route::get("login");
        }  catch (Exception $e){
        
        
            $bootstrap_in = Cli_Util_Content::factory()
                ->set_text($bootstrap_in)
                ->search_string($default_route)
                ->cut_before()
                ->new_string($route)
                ->append()
                ->get_text();
            
            $writer = $this->get_new_writer();
            $writer->set_dir(APPPATH)
                    ->set_file($bootstrap)
                    ->add_row($bootstrap_in);
            $this->add_writer($writer);
        }
    }
    
    private function routes(){
        return "\nRoute::set('site', '(<directory>(/<controller>(/<action>(/<id>))))', array('directory' => 'site'), array('*'))
            ->defaults(array(
                'directory' => 'site',
                'controller' => 'welcome',
                'action' => 'index',
        ));\n\nRoute::set('admin', '(<directory>(/<controller>(/<action>(/<id>))))', array('directory' => 'admin'), array('*'))
            ->defaults(array(
                'directory' => 'admin',
                'controller' => 'welcome',
                'action' => 'index',
        ));\n\nRoute::set('login', '(<controller>(/<action>))')
            ->defaults(array(
                'directory' => 'auth',
                'controller' => 'auth',
                'action' => 'login',
        ));\n\nRoute::set('logout', '(<controller>(/<action>))')
            ->defaults(array(
                'directory' => 'auth',
                'controller' => 'auth',
                'action' => 'logout',
        ));\n\nRoute::set('default', '(<controller>(/<action>(/<id>)))')
            ->defaults(array(
                'controller' => 'welcome',
                'action'     => 'index',
        ));";
    }
}

?>
