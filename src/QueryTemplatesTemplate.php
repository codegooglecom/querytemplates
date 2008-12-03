<?php
require(dirname(__FILE__).'/QueryTemplatesParseVoid.php');
require(dirname(__FILE__).'/QueryTemplatesSourceReplicator.php');
require(dirname(__FILE__).'/IQueryTemplatesTemplate.php');
require(dirname(__FILE__).'/IQueryTemplatesParse.php');
if (! class_exists('Callback')) {
	$included = @include_once('Callback.php');
	if (! $included)
		require_once(dirname(__FILE__)."/phpQuery/Callback.php");
}
/**
 * Class defining main namespace of the template.
 * 
 * Use template() function as shortcut.
 * 
 * @package QueryTemplates
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/querytemplates/
 */
class QueryTemplatesTemplate
	implements IQueryTemplatesTemplate {
	public $name;
	public $cache = true;
	/**
	 * @access private
	 */
	public $toFetch = array(
		// [0] path, [1] name, [2] parse php tags
		'full'	=> array(),
		// [0] path, [1] replicator object, [2] parse php tags
		'parts'	=> array(),
	);
	/**
	 * Enter description here...
	 *
	 * @param string $name Optional.
	 */
	public function __construct($name = null) {
		$this->name = $name;
	}
	/**
	 * Fetches file or URL and returns phpQuery object with additional collect()
	 * method to collect specific part(s) of document.
	 *
	 * It has to be ended with one of followings:
	 * - sourceEnd()
	 * - parse()
	 * - any other source*() method
	 *
	 * @param string|Callback $path
	 * @return QueryTemplatesSourceQuery
	 * @TODO content-type
	 */
	public function sourceQuery($path) {
		return $this->_sourceFetch($path, true);
	}
	/**
	 * Fetches file or URL and collects it content.
	 *
	 * @param string|Callback $path
	 * @param String $name Optional. Defaults to file name.
	 * @return QueryTemplatesTemplate
	 * @TODO content-type
	 */
	public function sourceCollect($path, $name = null) {
		return $this->_sourceFetch($path, false, $name);
	}
	/**
	 * @access private
	 *
	 */
	protected function _sourceFetch($path, $onlySomeParts = false, $name = null, $php = false) {
		if (! $onlySomeParts) {
			$this->toFetch['full'][] = array($path, $name, $php);
			return $this;
		} else {
			$replicator = new QueryTemplatesSourceReplicator($this);
			$this->toFetch['parts'][] = array($path, $replicator, $php);
			return $replicator;
		}
	}
	/**
	 * Fetches PHP source file or URL and collects it content.
	 *
	 * @param string|Callback $path
	 * @param string $name
	 * @return QueryTemplatesTemplate
	 * @see QueryTemplatesTemplate::sourceCollect()
	 */
	public function sourceCollectPHP($path, $name = null) {
		return $this->_sourceFetch($path, false, $name, true);
	}
	/**
	 * Fetches PHP souce file or URL and returns phpQuery object with
	 * additional collect() method to collect specific part(s) of document.
	 *
	 * @param string|Callback $path
	 * @param string $name
	 * @return QueryTemplatesSourceQuery
	 * @see QueryTemplatesTemplate::sourceQuery()
	 */
	public function sourceQueryPHP($path, $name = null) {
		return $this->_sourceFetch($path, true, $name, true);
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $name
	 * @return unknown
	 * @TODO sourceTemplate
	 */
	public function sourceTemplate($name) {
	}
	/**
	 * Start template parsing stage and changes namespace to @see QueryTemplatesParse.
	 *
	 * @return String|QueryTemplatesParse
	 */
	public function parse() {
		if (! $this->name)
			$this->name = $this->generateName();
		//check cache
//		$this->includeFunctions();
		if ($includePath = QueryTemplates::loadTemplate($this->name))
			return new QueryTemplatesParseVoid($includePath);
		$this->includeClasses();
		return new QueryTemplatesParse($this);
	}
	/**
	 * Disable or enables cache engine for this template.
	 * 
	 * Chainable when $state is passed. Otherwise returns actual
	 * cache's setting.
	 *
	 * @param Bool $state
	 * False to disable cache, True to enable. 
	 * @return QueryTemplatesTemplate
	 * @see QueryTemplates::$cacheTimeout
	 */
	public function templateCache($state = null) {
		if (isset($state)) {
			$this->cache = isset($state);
			return $this;
		} else {
			$this->cache;
		}
	}
  /**
	 * @access private
	 */
	protected function generateName() {
		$name = '';
		foreach($this->toFetch['parts'] as $r)
			$name .= QueryTemplates::$templatesDir.$r[0];
		foreach($this->toFetch['full'] as $r)
			$name .= QueryTemplates::$templatesDir.$r[0];
		return md5($name);
	}
	/**
	 * @access private
	 */
	protected function includeClasses() {
		$dir = dirname(__FILE__);
		if (! class_exists('phpQuery')) {
			$included = @include_once('phpQuery.php');
			if (! $included)
				require_once("$dir/phpQuery/phpQuery.php");
		}
		phpQuery::$debug = QueryTemplates::$debug;
		require_once("$dir/QueryTemplatesPhpQuery.php");
		require_once("$dir/QueryTemplatesSourceQuery.php");
		require_once("$dir/QueryTemplatesSource.php");
		require_once("$dir/QueryTemplatesParse.php");
	}
	/**
	 * Returns or changes template's name.
	 *
	 * @param unknown_type $newName
	 */
	function templateName($newName = null) {
		if ($newName)
			$this->parent->name = $newName;
		else
			return $this->parent->name;
	}
}

/**
 * Create new template using QueryTemplates.
 *
 * @param string $name
 * @return QueryTemplatesTemplate
 */
function template($name = null) {
	return new QueryTemplatesTemplate($name);
}