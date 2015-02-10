<?php

namespace Library;

class Param {
	private $name;
	private $pattern;
	
	public function __construct(\DOMElement $domNode) {
		$this->name = $domNode->getAttribute("name");
		$this->pattern = $domNode->getAttribute("pattern");
	}
	
	public function getName() {
		return $this->name;
	}
	public function getPattern() {
		return $this->pattern;
	}
}