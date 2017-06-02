<?php

namespace Bandama\Foundation\Translation;


/**
 * Translation class
 *
 * @package Bandama
 * @subpackage Foundation\Translation
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Translator {
    // Fields
    /**
     * @var array
     */
    private $translations = array();


    // Properties
    public function getTranslations() {
        return $this->translations;
    }

    // Constructors
    /**
     * Constructor
     *
     * @param array $files Translation files
     *
     * @return void
     */
    public function __construct() {
        $files = func_get_args();
        foreach($files as $file) {
            $this->addFile($file);
        }
    }


    // Public Methods
    /**
     * Translate
     *
     * @return string
     */
    public function translate($key, $language) {
        $parts = explode('-', $language); // To manage language with region (fr-CI, en-US, etc.)

        $lang = $parts[0];

        if (count($parts) == 1) {
            return $this->translateWithLang($key, $lang);
        } else if (count($parts) == 2) {
            $region = $parts[1];
            if (!isset($this->translations[$lang][$region]) || !isset($this->translations[$lang][$region][$key])) {
                return $this->translateWithLang($key, $lang);
            }

            return $this->translations[$lang][$region][$key];
        } else {
            throw new TranslationException('Invalid language');
        }
    }

    /**
    * Add translation file content
    *
    * @param string $file
    *
    * @return void
    */
    public function addFile($file) {
        $baseName = basename($file, '.php');

        $components = explode('.', $baseName);
        $language = $components[1];

        $data = require($file);

        $this->add($data, $language);
    }


    /**
     * Add translation key/value array data
     *
     * @param array $data
     * @param string $language
     *
     * @return void
     */
    public function addData($data, $language) {
        $this->add($data, $language);
    }


    // Private Msthods
    /**
     * Add translation data for a language
     *
     * @param array $data
     * @param string $language
     *
     * @return void
     */
    private function add($data, $language) {
        $parts = explode('-', $language); // To manage language with region (fr-CI, en-US, etc.)
        foreach($data as $key => $translation) {
            if (count($parts) == 1) {
                $this->translations[$language][$key] = $translation;
            } elseif (count($parts) == 2) {
                $this->translations[$parts[0]][$parts[1]][$key] = $translation;
            } else {
                throw new TranslationException('Invalid language');
            }
        }
    }

    /**
     * @param string $key
     * @param string $lang
     *
     * @return string
     */
    private function translateWithLang($key, $lang) {
        if (!isset($this->translations[$lang]) || !isset($this->translations[$lang][$key])) {
            return null;
        }

        return $this->translations[$lang][$key];
    }
}
