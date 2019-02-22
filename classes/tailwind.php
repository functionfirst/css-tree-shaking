<?php
  require_once 'vendor/autoload.php';
  require_once 'classes/plugins.php';
  use Leafo\ScssPhp\Compiler;

  class Tailwind
  {
    // constructor
    public function __construct($config)
    {
      $this->config = $config;
      $this->registerPlugins();
    }

    private function registerPlugins()
    {
      $plugins = new Plugins($this->config);

      foreach($plugins->list as $plugin)
      {
        $this->plugins[] = $plugin;
      }
    }

    // Formatter Types
    public $expanded = "Leafo\ScssPhp\Formatter\Expanded"; // Standard hierarchy
    public $nested = "Leafo\ScssPhp\Formatter\Nested"; // (default) Child selectors are inndented in hierarchy
    public $compact = "Leafo\ScssPhp\Formatter\Compact"; // Single line properties
    public $compressed = "Leafo\ScssPhp\Formatter\Compressed"; // Single line, no white-space
    public $crunched = "Leafo\ScssPhp\Formatter\Crunched"; // Single line, no white-space, no comments

    public function compile()
    {
      $scss = new Compiler();
      if (isset($this->formatter))
      {
        $scss->setFormatter($this->formatter);
      }

      $str = '';

      if (isset($this->plugins)) {
        foreach ($this->plugins as $plugin)
        {
          $str .= $plugin->compile();
        }
      }

      return $scss->compile($str);
    }

    public function setFormat($format)
    {
      $this->formatter = $format;
    }

    private function getPlugins() {
      $str = '';
      foreach ($this->plugins as $plugin)
      {
        $str .= $plugin->compile();
      }
    }

    private function applyFormat() {

    }
  }