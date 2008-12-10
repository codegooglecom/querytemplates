<?php
/**
 * Fake template parsing class.
 * 
 * @access private
 * @package QueryTemplates
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/querytemplates/
 */
class QueryTemplatesParseVoid {
	protected $save;
	protected $parent;
	public function __construct($save, $parent) {
		$this->save = $save;
		$this->parent = $parent;
		$this->parent->parse = $this;
	}
	public function __call($name, $arguments) {
		return $this;
	}
	public function save() {
		return $this->save;
	}
	public function __toString() {
		return $this->save;
	}
}