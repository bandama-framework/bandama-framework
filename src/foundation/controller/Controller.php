<?php

namespace Bandama\Foundation\Controller;

/**
 * Base controller class
 *
 * @package Bandama
 * @subpackage Foundation\Controller
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.2
 * @since 1.0.2 Bug fixed in render method
 * @since 1.0.1 Adding view path field and extacting params parameter of render method into render method
 * @since 1.0.0 Class creation
 */
class Controller {
    // Fields
    protected $viewPath;

    // Constructors
    /**
     * Default constructor
     *
     * @return void
     */
    public function __construct() {
    }

    // Public Methods

    /**
     * Render the content of view file or text
     *
     * @param string View path of view file or text
     * @param array View parameters
     *
     * @return string
     */
    public function render($view, $params = array()) {
        $viewPath = $this->viewPath;
        $viewPath = rtrim($viewPath, '/').'/';
        extract($params);
        if (is_file($view)) {
            require_once($view);
        } else if (is_file($viewPath.str_replace(':', '/', $view))) {
            require_once($viewPath.str_replace(':', '/', $view));
        } else {
            echo $view;
        }
    }
}
