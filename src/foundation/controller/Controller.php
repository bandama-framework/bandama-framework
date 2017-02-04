<?php

namespace Bandama\Foundation\Controller;

/**
 * Base controller class
 *
 * @package App
 * @subpackage Foundation\Controller
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Controller {
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
        if (is_file($view)) {
            require_once($view);
        } else {
            echo $view;
        }
    }
}
