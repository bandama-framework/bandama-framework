<?php

namespace Bandama\Foundation\Session;

/**
 * Class for managing flash session variables
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see SessionInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Flash {
    // Fields
    /**
     * @var Session Session object
     */
    private $session;

    /**
     * @var string Session flash message key
     */
    const BANDAMA_FLASH_KEY = 'banadama_flash';



    // Constructors
    /**
     * Constructor
     *
     * $param Session $session Session object
     *
     * @return void
     */
    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }


    // Public Methods
    /**
     * Set flash message
     *
     * @param string $message Flash message
     * @param string $type Flash message type e.g (success, error, warning)
     *
     * @return void
     */
    public function set($message, $type = 'success') {
        $this->session->set(self::BANDAMA_FLASH_KEY, array('message' => $message, 'type' => $type));
    }

    /**
     * Get flash message
     *
     * @return mixed
     */
    public function get() {
        $flash = $this->session->get(self::BANDAMA_FLASH_KEY);
        $this->session->delete(self::BANDAMA_FLASH_KEY);

        return $flash;
    }
}