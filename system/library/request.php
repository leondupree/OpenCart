<?php
final class Request {
	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();
	
  	public function __construct() {
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->cookie = $this->clean($_COOKIE);
		$this->files = $this->clean($_FILES);
		$this->server = $this->clean($_SERVER);
	}
	
  	public function clean(&$data) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
	    		$data[$key] = $this->clean($value);
	  		}
		} else {
	  		$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
		}
	
		return $data;
	}
}
?>