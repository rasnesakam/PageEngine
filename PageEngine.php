<?php

class PageEngine
{
    private $includes;
    private $title;
    private $layout, $content;
    private $layoutDir;
    private $sections;
  	private $body;

    public function __construct($includes = "assets/includes/"){
        $this->includes = $includes;
        $this->content = function($engine){};
        $this->sections = array();
    }

    public function setTitle($title){
        $this->title = $title;
    }
  
    public function setSection($sectionName,callable $content){
        $this->sections[$sectionName] = $content;
    }

    public function getSection($sectionName){
        if (array_key_exists($sectionName,$this->sections))
            if(is_callable($this->sections[$sectionName]))
                return ($this->sections[$sectionName])();
    }

    public function layoutContent(callable $layout){
      $this->layout = $layout;
    }
  
    public function layoutFromDir($layoutDir){
        $this->layoutDir = $layoutDir;
    }
  
  	public function bodyContent(callable $content){
    	$this->body = $content;
    }

    public function content(callable $content){
        ob_start();
      	($content)($this);
      	ob_end_clean();
        return $this;
    }

    public function render()
    {
        if ($this->layout != null)
            require_once $this->layout;
        else {
            if (is_callable($this->body))
                ($this->body)($this);
        }
    }

}

?>
