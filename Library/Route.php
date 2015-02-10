<?php

namespace Library;

class Route {

	private $name;
	private $url;
	private $method;
	private $module;
	private $action;
	private $params;
	
	public function __construct(\DOMElement $domNode) {
		$this->name = $domNode->getAttribute("name");
		$this->url = $domNode->getAttribute("url");
		$this->method = $domNode->hasAttribute("method") ? $domNode->getAttribute("method") : "GET";
		$this->module = $domNode->getAttribute("module");
		$this->action = $domNode->getAttribute("action");
		$this->params = array();

		$domParams = $domNode->getElementsByTagName("param");

		foreach ($domParams as $domParam) {
			$this->params[] = new Param($domParam);
		}
	}

	public function getName() {
		return $this->name;
	}

	public function getModule() {
		return $this->module;
	}

	public function getAction() {
		return $this->action;
	}

	public function isMatched($requestUri, $requestMethod, &$vars) {
		$url = $this->url;
		$pregMatchAll = preg_match_all("`{([^}]+)}`", $url, $matches);
		
		if ($pregMatchAll == count($this->params)) {
			/* @var $param Param */
			foreach ($this->params as $param) {
				$url = str_replace("{" . $param->getName() . "}", "(" . $param->getPattern() . ")", $url);
			}
			$pregMatch = preg_match("`^" . $url . "$`", $requestUri, $matches);

			for ($i = 1; $i < count($matches); $i++) {
				$vars[] = $matches[$i];
			}
			return $pregMatch && ($requestMethod == $this->method);
		} else {
			throw new \RuntimeException("Le nombre d'arguments dans l'url de la route ne correspond pas à son nombre d'arguments dans sa définition.");
		}
	}

	public function getParameterizedUrl(array $vars) {
		$url = $this->url;
		if (count($vars) == count($this->params)) {
			foreach ($vars as $name => $var) {
				$url = str_replace("{" . $name . "}", $var, $url);
			}
			return $url;
		} else {
			throw new \RuntimeException("Le nombre d'arguments dans l'url de la route ne correspond pas à son nombre d'arguments dans sa définition.");
		}
	}

	public function haveParam($name) {
		foreach ($this->params as $param) {
			if ($param->getName() == $name) {
				return true;
			}
		}
		return false;
	}

}
