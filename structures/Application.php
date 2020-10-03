<?php

namespace Structures;

abstract class Application extends \Structures\Base
{
    /**
     * @var object|null $app
     */
    public static $app = null;
	
    /**
     * @var array $extensions
     */
    protected $extensions = [];
	
    /**
     * @var float $phpVersion
     */
    protected $minPHPVersion = 7.2;

    /**
     * @var array $instances
     */
    protected $objects = [];
	
    /**
     * @var array $settings
     */
    protected $settings = [];
	
    /**
     * @return object
     */
    final public static function create()
    {
        if (is_null(static::$app)) {
            static::$app = new static();
        }
        
        return static::$app;
    }

    /**
     * @var string $name
     * @var object $object
     */
    final public function setObject($name, $object)
    {
        if (!isset($this->objects[$name])) {
            $this->objects[$name] = $object;
        }

        return $this;
    }

    /**
     * @var string $name
     * @return object
     */
    final public function getObject($name)
    {
        if (isset($this->objects[$name])) {
            return $this->objects[$name];
        }
    }
	
    /**
     * @var array $settings
     * @return object
     */
    final public function loadSettings($settings = [])
    {
        $this->settings = is_array($settings) ?
            array_merge($this->settings, $settings) : [];

        return $this;
    }
	
    /**
     * @param float $version
     * @return object
     */
    final public function setPHPVersion($version)
    {
        $this->minPHPVersion = is_float($version) ? $version : 7.2;

        return $this;
    }

    /**
     * @return float
     */
    final public function getPHPVersion()
    {
        return $this->minPHPVersion;
    }

    /**
     * @param string|array $extension
     * @return object
     */
    final public function pushExtension($extension)
    {
        if (is_string($extension)) {
            $this->extensions[] = $extension;
        } elseif (is_array($extension)) {
            foreach ($extension as $key => $value) {
                if (!is_string($value)) {
                    unset($extension[$key]);
                }
            }
            unset($key, $value);
            if (count($extension) > 0) {
                $this->extensions = array_merge($this->extensions, $extension);
            }
        }

        return $this;
    }

    /**
     * Constructor
     */
    protected function __construct() {}
	
    /**
     * @return void
     */
    final protected function checkingEnvironment()
    {
        if (((float) PHP_VERSION) < $this->minPHPVersion) {
            throw new ErrorException;
        }
        foreach ($this->extensions as $extension) {
            if (!extension_loaded($extension)) {
                throw new ErrorException;
            }
        }
        unset($extension);
    }
	
    /**
     * @abstract
     */
    abstract public function run();
}