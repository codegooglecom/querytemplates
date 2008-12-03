<?php
/**
 * Template parsing class.
 * 
 * @package QueryTemplates
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/querytemplates/
 */
class QueryTemplatesParse
	extends QueryTemplatesPhpQuery
	implements IQueryTemplatesParse {
	public $dependencies = array();
	public $collected = array();
	/**
	 * Vars avaible in template scope AFTER template parsing process.
	 *
	 * @var unknown_type
	 */
	public $vars = array();
	/**
	 * Enter description here...
	 *
	 * @var QueryTemplatesTemplate
	 */
	public $parent;
	public function __construct($parent, $docId = null) {
		if ( $parent instanceof self ) {
			// new instance call from phpQuery
			// link all important vars to new object
			$this->parent =& $parent->parent;
			$this->collected =& $parent->collected;
			$this->dependencies =& $parent->dependencies;
			parent::__construct($docId);
		} else {
			$this->parent = $parent;
			$this->collectAll();
		}
	}
	private function collectAll() {
		$s = DIRECTORY_SEPARATOR;
		QueryTemplates::$sourcesPath = rtrim(QueryTemplates::$sourcesPath, $s).$s;
		// repeat all method calls stored in replicator to QueryTemplatesFetch object
		foreach($this->parent->toFetch['parts'] as $r) {
			// FIXME check if path is valid
			// QueryTemplates::$sourcesPath.$r[0]
			if ($r[0] instanceof Callback) {
				$content = phpQuery::callbackRun($r[0]);
			} else {
				$content = file_get_contents(QueryTemplates::$sourcesPath.$r[0]);
			}
			// PHP file
			if ($r[2])
				$content = phpQuery::markupToPHP($content);
			$fetch = new QueryTemplatesSourceQuery($this, $content);
			foreach($r[1]->calls as $call) {
				$fetch = call_user_method_array($call[0], $fetch, $call[1]);
			}
			$this->dependencies[] = QueryTemplates::$sourcesPath.$r[0];
		}
		foreach($this->parent->toFetch['full'] as $r) {
			if ($r[0] instanceof Callback) {
				$content = phpQuery::callbackRun($r[0]);
				$name = $r[1];
				if (! $name)
					throw new Exception('Name needed when using Callback as source');
			} else {
				$name = $r[1]
					? $r[1]
					: $r[0];
				$content = file_get_contents(QueryTemplates::$sourcesPath.$r[0]);
				$this->dependencies[] = QueryTemplates::$sourcesPath.$r[0];
			}
			$this->collected[$name] = $content;
			if ($r[2]) {
				$this->collected[$name] = phpQuery::markupToPHP(
					$this->collected[$name]
				);
			}
		}
	}
	/**
	 * Save template and return file path ready to include.
	 *
	 * @return string
	 */
	public function save($unloadDocument = true) {
		if (! $this->parent->cache) {
			$cacheTimeout = QueryTemplates::$cacheTimeout;
			QueryTemplates::$cacheTimeout = -1;
		}
		$return = QueryTemplates::saveTemplate(
			$this->toRoot(),
			$this->dependencies,
			$this->parent->name,
			$this->vars,
			null, $unloadDocument
		);
		if (! $this->parent->cache) {
			QueryTemplates::$cacheTimeout = $cacheTimeout;
		}
		return $return;
	}
	public function documentCreate($source) {
		$id = phpQuery::newDocument($source->markup())->getDocumentId();
		parent::__construct($id);
	}
	/**
	 * Saves outerHtml() as value of variable $var avaible in template scope.
	 *
	 * @param unknown_type $name
	 */
	public function saveAsVar($name) {
		$object = $this;
		while($object->previous)
			$object = $object->previous;
		$object->vars[$name] = $this->markupOuter();
		return $this;
	}
	/**
	 * Saves text() as value of variable $var avaible in template scope.
	 *
	 * @param unknown_type $name
	 */
	public function saveTextAsVar($name) {
		$object = $this;
		while($object->previous)
			$object = $object->previous;
		$object->vars[$name] = $this->text();
		return $this;
	}
	public function __toString() {
		try {
			return $this->save();
		} catch(Exception $e) {
			return '';
		}
	}
	/**
	 * Iterator override to return extended phpQuery object insted of DOMNode.
	 *
	 * @return unknown
	 * @access private
	 */
	public function current(){
		return $this->newInstance(
			array(parent::current())
		);
	}
	/**
	 * Return collected source as phpQuery object. Returned object is a separate document.
	 * Method must be ended with one of followings:
	 * - QueryTemplatesSource::returnReplace()
	 * - QueryTemplatesSource::returnAppend()
	 * - QueryTemplatesSource::returnPrepend()
	 * - QueryTemplatesSource::returnAfter()
	 * - QueryTemplatesSource::returnBefore()
	 *
	 * @param String $name
	 * @return QueryTemplatesSource
	 * @see QueryTemplatesSource
	 */
	public function source($name) {
		$this->debug("Source pickup: {$name}");
		if (! isset($this->collected[$name]))
			throw new Exception("Source '{$name}' isn\'t loaded.");
//		$this->elements = array($this->root);
		return new QueryTemplatesSource($this, $this->collected[$name]);
	}
	/**
	 * @see QueryTemplatesTemplate::templateCache()
	 * @return QueryTemplatesParse
	 */
	public function templateCache($state = null) {
		$this->parent->templateCache($state);
		return $this;
	}
	/**
	 * @see QueryTemplatesTemplate::templateName()
	 * @return QueryTemplatesParse
	 */
	public function templateName($newName = null) {
		$this->parent->templateName($state);
		return $this;
	}
}