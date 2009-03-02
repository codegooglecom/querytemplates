<?php
/**
 * Class extending phpQueryObject with templating methods.
 * 
 * @abstract
 * @package QueryTemplates
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/querytemplates/
 */
abstract class QueryTemplatesPhpQuery
	extends phpQueryObject {
	/**
	 * Prints variable $varName as matched elements' content.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrint('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<p><?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?></p>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - p
	 *  -  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrint($varName) {
		return $this->_varPrint('markup', $varName);
	}
	/**
	 * Prints variable $varName replacing matched elements.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrintReplace('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintReplace($varName) {
		return $this->_varPrint('replaceWith', $varName);
	}
	/**
	 * Prints variable $varName before matched elements.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrintBefore('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?><p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - PHP
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintBefore($varName) {
		return $this->_varPrint('before', $varName);
	}
	/**
	 * Prints variable $varName after matched elements.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrintAfter('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * <?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintAfter($varName) {
		return $this->_varPrint('after', $varName);
	}
	/**
	 * Prints variable $varName on beggining of matched elements.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrintPrepend('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<p><?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - p
	 *  -  - PHP
	 *  -  - Text:FOO
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintPrepend($varName) {
		return $this->_varPrint('prepend', $varName);
	}
	/**
	 * Prints variable $varName on the end of matched elements.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrintAppend('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<p>FOO<?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?></p>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 *  -  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintAppend($varName) {
		return $this->_varPrint('append', $varName);
	}
	public function _varPrint($target, $varName) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		switch($target) {
			case 'attr':
				$this->qt_langMethod('attr', $targetData[0], 
					$this->qt_langCode('printVar', $varName)
				);
				break;
			default:
				$this->qt_langMethod($target, 
					$this->qt_langCode('printVar', $varName)
				);
		}
		return $this;
	}
	/**
	 * Prints variable $varName as attribute $attr of matched elements.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>
	 * 	<p>FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array('printMe')
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['p']->
	 * 	varPrintAttr('rel', 'data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <div>
	 * 	<p data.foo.bar.0="<?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
	 * else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?>">FOO</p>
	 * </div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - p
	 *  -  - Text:FOO
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 * 
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintAttr($attr, $varName) {
		return $this->_varPrint(array('attr', $varName), $varName);
	}
	/**
	 * Injects executable code printing variable's fields inside nodes matched by 
	 * selector. Method uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelector('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1"><?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?></p>
	 * <p class="field2"><?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?></p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - PHP
	 * p.field2
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm() 
	 */
	public function varsToSelector($varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector('markup', $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields replacing nodes matched by 
	 * selector. Method uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelectorReplace('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?>
	 * <?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToSelectorReplace($varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector('replaceWith', $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields at the end of nodes 
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelectorAppend('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1">lorem ipsum<?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?></p>
	 * <p class="field2">lorem ipsum<?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?></p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 *  - PHP
	 * p.field2
	 *  - Text:lorem ipsum
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm() 
	 */
	public function varsToSelectorAppend($varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector('append', $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields at the beggining of nodes 
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelectorPrepend('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1"><?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?>lorem ipsum</p>
	 * <p class="field2"><?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?>lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - PHP
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - PHP
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm() 
	 */
	public function varsToSelectorPrepend($varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector('prepend', $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields after nodes matched by 
	 * selector. Method uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelectorAfter('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1">lorem ipsum</p>
	 * <?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?>
	 * <p class="field2">lorem ipsum</p>
	 * <?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * PHP
	 * p.field2
	 *  - Text:lorem ipsum
	 * PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm() 
	 */
	public function varsToSelectorAfter($varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector('after', $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields before nodes matched by 
	 * selector. Method uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelectorBefore('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?><p class="field1">lorem ipsum</p>
	 * <?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?><p class="field2">lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * p.field1
	 *  - Text:lorem ipsum
	 * PHP
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm() 
	 */
	public function varsToSelectorBefore($varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector('before', $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields as attribute of nodes 
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->field1 = 'foo';
	 * $foo->field2 = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToSelectorAttr('rel', 'foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1" rel="<?php  if (isset($foo['field1'])) print $foo['field1'];
	 * else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?>">lorem ipsum</p>
	 * <p class="field2" rel="<?php  if (isset($foo['field2'])) print $foo['field2'];
	 * else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?>">lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 * @see QueryTemplatesPhpQuery::varsToForm() 
	 */
	public function varsToSelectorAttr($attr, $varName, $varFields, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_varsToSelector(array('attr', $attr), $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Internal method.
	 * 
	 * @param $target
	 * @param $varName
	 * @param $varFields
	 * @param $selectorPattern
	 * @param $skipFields
	 * @param $fieldCallback
	 * @return unknown_type
	 *
	 * @TODO support $varName to be a function (last char == ')'),
	 */
	protected function _varsToSelector($target, $varName, $varFields, $selectorPattern, $skipFields, $fieldCallback) {
		$loop = $this->_varsParseFields($varFields);
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		foreach($loop as $f) {
			if ($skipFields && in_array($f, $skipFields))
				continue;
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
			$node = $this->find($selector);
			switch($target) {
				case 'attr':
					$node->qt_langMethod('attr', $targetData[0], 
						$this->qt_langCode('printVar', "$varName.$f")
					);
					break;
				default:
					$node->qt_langMethod($target, 
						$this->qt_langCode('printVar', "$varName.$f")
					);
			}
			if ($fieldCallback)
				// TODO doc
				phpQuery::callbackRun($fieldCallback, array($node, $f, $_target));
		}
		return $this;
	}
	/**
	 * Injects executable code printing variable's fields inside actually matched 
	 * nodes. Second param needs to be wrapped with array_keys for non-assosiative
	 * arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStack('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?></node1><node2></node2><node1><?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - PHP
	 * node2
	 * node1
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStack($varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack('markup', $varName, $varFields, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields replacing actually matched 
	 * nodes. Second param needs to be wrapped with array_keys for non-assosiative
	 * arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStackReplace('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?><node2></node2><?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * node2
	 * PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStackReplace($varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack('replaceWith', $varName, $varFields, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields at the end of actually 
	 * matched nodes. Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStackAppend('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2><?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?></node1><node2></node2><node1><node2></node2><?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 *  - PHP
	 * node2
	 * node1
	 *  - node2
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStackAppend($varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack('append', $varName, $varFields, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields at the beggining of actually 
	 * matched nodes. Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStackPrepend('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?><node2></node2></node1><node2></node2><node1><?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - PHP
	 *  - node2
	 * node2
	 * node1
	 *  - PHP
	 *  - node2
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStackPrepend($varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack('prepend', $varName, $varFields, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields after actually matched 
	 * nodes. Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStackAfter('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?><node2></node2><node1><node2></node2></node1><?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * PHP
	 * node2
	 * node1
	 *  - node2
	 * PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStackAfter($varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack('after', $varName, $varFields, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields before actually matched 
	 * nodes. Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStackBefore('foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?><node1><node2></node2></node1><node2></node2><?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * node1
	 *  - node2
	 * node2
	 * PHP
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStackBefore($varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack('before', $varName, $varFields, $skipFields, $fieldCallback);
	}
	/**
	 * Injects executable code printing variable's fields as attribute of actually 
	 * matched nodes. Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $foo = new stdClass();
	 * $foo->first = 'foo';
	 * $foo->second = 'bar';
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	varsToStackAttr('rel', 'foo', $foo)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1 rel="<?php  if (isset($foo['first'])) print $foo['first'];
	 * else if (isset($foo->{'first'})) print $foo->{'first'};  ?>"><node2></node2></node1><node2></node2><node1 rel="<?php  if (isset($foo['second'])) print $foo['second'];
	 * else if (isset($foo->{'second'})) print $foo->{'second'};  ?>"><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * Variable value with all fields (keys) OR array of variable fields (keys).
	 * Param needs to be passed thou array_keys for non-assosiative arrays.
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function varsToStackAttr($attr, $varName, $varFields, $skipFields = null, $fieldCallback = null) {
		return $this->_varsToStack(array('attr', $attr), $varName, $varFields, $skipFields, $fieldCallback);
	}
	protected function _varsToStack($target, $varName, $varValue, $skipFields, $fieldCallback) {
		$loop = $this->_varsParseFields($varValue);
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		$i = 0;
		foreach($loop as $f) {
			if ($skipFields && in_array($f, $skipFields))
				continue;
			$node = $this->eq($i++);
			switch($target) {
				case 'attr':
					$node->qt_langMethod('attr', $targetData[0], 
						$this->qt_langCode('printVar', "$varName.$f")
					);
					break;
				default:
					$node->qt_langMethod($target, 
						$this->qt_langCode('printVar', "$varName.$f")
					);
			}
			if ($fieldCallback)
				// TODO doc
				phpQuery::callbackRun($fieldCallback, array($node, $f, $_target));
		}
		return $this;
	}
	protected function _varsParseFields($varFields) {
		// determine if we have real values in $varValue or just list of fields
		if (is_array($varFields) && array_key_exists(0, $varFields))
			return $varFields;
		else if (is_object($varFields) && isset($varFields->{'0'}))
			return $varFields;
		else
			return is_object($varFields)
//				? get_class_vars(get_class($varFields))
				// TODO use this in other methods
				? array_keys(get_object_vars($varFields))
				: array_keys($varFields);
	}
	/**
	 * Injects raw executable code inside nodes matched by selector. Method uses 
	 * actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelector($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1"><?php  print "abba";  ?></p>
	 * <p class="field2"><?php  foreach(array(1, 2, 3) as $i) print $i  ?></p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - PHP
	 * p.field2
	 *  - PHP
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelector($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector('markup', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code replacing nodes matched by selector. Method uses 
	 * actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelectorReplace($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  print "abba";  ?>
	 * <?php  foreach(array(1, 2, 3) as $i) print $i  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * PHP
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelectorReplace($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector('replaceWith', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code at the end of nodes matched by selector. Method 
	 * uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelectorAppend($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1">lorem ipsum<?php  print "abba";  ?></p>
	 * <p class="field2">lorem ipsum<?php  foreach(array(1, 2, 3) as $i) print $i  ?></p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 *  - PHP
	 * p.field2
	 *  - Text:lorem ipsum
	 *  - PHP
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelectorAppend($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector('append', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code at the beggining of nodes matched by selector. 
	 * Method uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelectorPrepend($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1"><?php  print "abba";  ?>lorem ipsum</p>
	 * <p class="field2"><?php  foreach(array(1, 2, 3) as $i) print $i  ?>lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - PHP
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - PHP
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelectorPrepend($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector('prepend', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code after nodes matched by selector. Method uses 
	 * actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelectorAfter($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1">lorem ipsum</p>
	 * <?php  print "abba";  ?>
	 * <p class="field2">lorem ipsum</p>
	 * <?php  foreach(array(1, 2, 3) as $i) print $i  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * PHP
	 * p.field2
	 *  - Text:lorem ipsum
	 * PHP
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelectorAfter($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector('after', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code before nodes matched by selector. Method uses 
	 * actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelectorBefore($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  print "abba";  ?><p class="field1">lorem ipsum</p>
	 * <?php  foreach(array(1, 2, 3) as $i) print $i  ?><p class="field2">lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * p.field1
	 *  - Text:lorem ipsum
	 * PHP
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelectorBefore($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector('before', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code inside attribute of nodes matched by selector. 
	 * Method uses actually matched nodes as root for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'field1' => 'print "abba";',
	 * 	'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToSelectorAttr('rel', $code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1" rel='<?php  print "abba";  ?>'>lorem ipsum</p>
	 * <p class="field2" rel="<?php  foreach(array(1, 2, 3) as $i) print $i  ?>">lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * variables key (field).
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStack()
	 */
	public function codeToSelectorAttr($attr, $codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToSelector(array('attr', $attr), $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	protected function _codeToSelector($target, $codeArray, $selectorPattern, $skipFields, $fieldCallback) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		foreach($codeArray as $f => $code) {
			if ($skipFields && in_array($f, $skipFields))
				continue;
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
			$node = $this->find($selector);
			switch($target) {
				case 'attr':
					$node->qt_langMethod('attr', $targetData[0], $code);
					break;
				default:
					$node->qt_langMethod($target, $code);
			}
			if ($fieldCallback)
				phpQuery::callbackRun($fieldCallback, array($node, $f, $_target));
		}
		return $this;
	}
	/**
	 * Injects raw executable code inside actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStack($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <?php  print "abba";  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStack($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack('markup', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code replacing actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStackReplace($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStackReplace($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack('replaceWith', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code at the beggining of actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStackAppend($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1><?php  print "abba";  ?>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * PHP
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStackAppend($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack('append', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code at the end of actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStackPrepend($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <?php  print "abba";  ?>
	 * <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * PHP
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStackPrepend($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack('prepend', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code after actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStackAfter($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStackAfter($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack('after', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code before actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStackBefore($code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStackBefore($codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack('before', $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects raw executable code inside attribute of actually matched nodes.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node2/>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $code = array(
	 * 	'print "abba";',
	 * 	'foreach(array(1, 2, 3) as $i) print $i'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	codeToStackAttr('rel', $code)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param String $codeArray
	 * Array of raw code, where key is the field.
	 * 
	 * @param Array $skipFields
	 * Array of fields from $codeArray which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::codeToSelector()
	 */
	public function codeToStackAttr($attr, $codeArray, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_codeToStack(array('attr', $attr), $codeArray, $selectorPattern, $skipFields, $fieldCallback);
	}
	protected function _codeToStack($target, $codeArray, $selectorPattern, $skipFields, $fieldCallback) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		$i = 0;
		foreach($codeArray as $f => $code) {
			if ($skipFields && in_array($f, $skipFields))
				continue;
			$node = $this->eq($i++);
			switch($target) {
				case 'attr':
					$node->qt_langMethod('attr', $targetData[0], $code);
					break;
				default:
					$node->qt_langMethod($target, $code);
			}
			if ($fieldCallback)
				// TODO doc
				phpQuery::callbackRun($fieldCallback, array($node, $f, $_target));
		}
		return $this;
	}
	/**
	 * Injects markup from $values' content (rows or attributes) into nodes
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelector($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1"><foo></foo></p>
	 * <p class="field2"><bar></bar></p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - foo
	 * p.field2
	 *  - bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelector($values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector('markup', $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) replacing nodes
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelectorReplace($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <foo></foo>
	 * <bar></bar>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * foo
	 * bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorReplace($values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector('replaceWith', $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) before nodes
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelectorBefore($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <foo></foo><p class="field1">lorem ipsum</p>
	 * <bar></bar><p class="field2">lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * foo
	 * p.field1
	 *  - Text:lorem ipsum
	 * bar
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorBefore($values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector('before', $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) after nodes
	 * matched by selector. Method uses actually matched nodes as root for the 
	 * query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelectorAfter($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1">lorem ipsum</p>
	 * <foo></foo>
	 * <p class="field2">lorem ipsum</p>
	 * <bar></bar>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * foo
	 * p.field2
	 *  - Text:lorem ipsum
	 * bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorAfter($values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector('after', $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) at the beggining of 
	 * nodes matched by selector. Method uses actually matched nodes as root 
	 * for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelectorPrepend($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1"><foo></foo>lorem ipsum</p>
	 * <p class="field2"><bar></bar>lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - foo
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - bar
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorPrepend($values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector('prepend', $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) at the end of 
	 * nodes matched by selector. Method uses actually matched nodes as root 
	 * for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelectorAppend($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1">lorem ipsum<foo></foo></p>
	 * <p class="field2">lorem ipsum<bar></bar></p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 *  - foo
	 * p.field2
	 *  - Text:lorem ipsum
	 *  - bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorAppend($values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector('append', $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) as attribute of 
	 * nodes matched by selector. Method uses actually matched nodes as root 
	 * for the query.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array(
	 * 	'field1' => '<foo/>',
	 * 	'field2' => '<bar/>'
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	valuesToSelectorAttr('rel', $values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <p class="field1" rel="&lt;foo/&gt;">lorem ipsum</p>
	 * <p class="field2" rel="&lt;bar/&gt;">lorem ipsum</p>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * p.field1
	 *  - Text:lorem ipsum
	 * p.field2
	 *  - Text:lorem ipsum
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipFields
	 * Array of fields from $values which should be skipped.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToStack()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorAttr($attr, $values, $selectorPattern = '.%k', $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToSelector(array('attr', $attr), $values, $selectorPattern, $skipFields, $fieldCallback);
	}
	protected function _valuesToSelector($target, $data, $selectorPattern, $skipFields, $fieldCallback) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		foreach($data as $k => $v) {
			if ($skipFields && in_array($f, $skipFields))
				continue;
			if ($v instanceof Callback)
				$v = phpQuery::callbackRun($v);
			$selector = str_replace(array('%k'), array($k), $selectorPattern);
//			$node = $this->find($selector)->add($this->filter($selector));
			$node = $this->find($selector);
			switch($target) {
				case 'attr':
					$node->attr($targetData[0], $v);
					break;
				default:
					$node->$target($v);
			}
			if ($fieldCallback)
				// TODO doc
				phpQuery::callbackRun($fieldCallback, array($node, $k, $_target));
		}
		return $this;
	}
	/**
	 * Wraps selected elements with executable code iterating $varName as $rowName.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <ul>
	 * 	<li class='row'>
	 * 		<span class='name'></span>
	 * 		<ul class='tags'>
	 * 			<li class='tag'>
	 * 				<span class='name'></span>
	 * 			</li>
	 * 		</ul>
	 * 	</li>
	 * </ul>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 * 	array(
	 * 		'User' => array('name' => 'foo'),
	 * 		'Tags' => array(
	 * 			array('name' => 'php'),
	 * 			array('name' => 'js'),
	 * 		),
	 * 	),
	 * 	array(
	 * 		'User' => array('name' => 'bar'),
	 * 		'Tags' => array(
	 * 			array('name' => 'perl'),
	 * 		),
	 * 	),
	 * 	array(
	 * 		'User' => array('name' => 'fooBar'),
	 * 		'Tags' => array(
	 * 			array('name' => 'php'),
	 * 			array('name' => 'js'),
	 * 			array('name' => 'perl'),
	 * 		),
	 * 	),
	 * );
	 * $userFields = array('name');
	 * $tagFields = array('name');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	find('> ul > li')->
	 * 		varsToLoop('data', 'row')->
	 * 		varsToSelector('row', $userFields, 'span.%k')->
	 * 		find('> ul > li')->
	 * 			varsToLoop('row.Tags', 'tag')->
	 * 			varsToSelector('tag', $tagFields)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <ul>
	 * <?php  if (isset($data) && (is_array($data) || is_object($data))) { foreach($data as $row):  ?><li class="row">
	 * 		<span class="name"><?php  if (isset($row['name'])) print $row['name'];
	 * else if (isset($row->{'name'})) print $row->{'name'};  ?></span>
	 * 		<ul class="tags">
	 * <?php  if (isset($row['Tags'])) $__8daca = $row['Tags']; else if (isset($row->{'Tags'})) $__8daca = $row->{'Tags'}; if (isset($__8daca) && (is_array($__8daca) || is_object($__8daca))) { foreach($__8daca as $tag):  ?><li class="tag">
	 * 				<span class="name"><?php  if (isset($tag['name'])) print $tag['name'];
	 * else if (isset($tag->{'name'})) print $tag->{'name'};  ?></span>
	 * 			</li>
	 * <?php  endforeach; }  ?>
	 * 		</ul>
	 * </li>
	 * <?php  endforeach; }  ?>
	 * </ul>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * ul
	 *  - li.row
	 *  -  - span.name
	 *  -  - ul.tags
	 *  -  -  - li.tag
	 *  -  -  -  - span.name
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * ul
	 *  - PHP
	 *  - li.row
	 *  -  - span.name
	 *  -  -  - PHP
	 *  -  - ul.tags
	 *  -  -  - PHP
	 *  -  -  - li.tag
	 *  -  -  -  - span.name
	 *  -  -  -  -  - PHP
	 *  -  -  - PHP
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable which will be looped. Must contain $ at the beggining.
	 *
	 * @param String $rowName
	 * Name of variable being result of iteration.
	 *
	 * @param String $indexName
	 * Optional. Use it when you want to have $varName's key available in the scope.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToLoop()
	 */
	public function varsToLoop($varName, $rowName, $indexName = null) {
		$this->_varsToLoop($this, $varName, $rowName, $indexName);
		return $this;
	}
	/**
	 * Wraps selected elements with executable code iterating $varName as $rowName.
	 * Acts as varsToLoop(), but affects each selected element separately.
	 * 
	 * Method doesn't change selected nodes stack.
	 *
	 * @param String $varName
	 * Variable which will be looped. Must contain $ at the beggining.
	 *
	 * @param String $rowName
	 * Name of variable being result of iteration.
	 *
	 * @param String $indexName
	 * Optional. Use it when you want to have $varName's key available in the scope.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToLoop()
	 */
	public function varsToLoopSeparate($varName, $rowName, $indexName = null) {
		foreach($this->stack() as $node)
			$this->_varsToLoop($node, $varName, $rowName, $indexName);
		return $this;
	}
	protected function _varsToLoop($pq, $varName, $asVarName, $keyName) {
		$code = $this->qt_langCode('loopVar', $varName, $asVarName, $keyName);
		$pq->
			eq(0)->qt_langMethod('before', $code[0])->end()->
			slice(-1, 1)->qt_langMethod('after', $code[1]);
	}
	/**
	 * Wraps selected elements with executable code iterating $varName as $rowName.
	 * Acts as varsToLoop(), but loops only first node from stack. Rest is removed 
	 * from the DOM.
	 *
	 * Method DOES change selected nodes stack. Returned is first node.
	 *
	 * @param String $varName
	 * Variable which will be looped. Must contain $ at the beggining.
	 *
	 * @param String $rowName
	 * Name of variable being result of iteration.
	 *
	 * @param String $indexName
	 * Optional. Use it when you want to have $varName's key available in the scope.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToLoop()
	 */
	public function varsToLoopFirst($varName, $rowName, $indexName = null) {
		$return = $this->eq(0);
		$this->slice(1)->remove();
		$this->_varsToLoop($return, $varName, $rowName, $indexName);
		return $return;
	}
	/**
	 * @deprecated
	 * @param $varName
	 * @param $asVarName
	 * @param $keyName
	 * @return unknown_type
	 */
	public function loopSeparate($varName, $asVarName, $keyName = null) {
		return $this->varsToLoopSeparate($varName, $asVarName, $keyName);
	}
	/**
	 * @deprecated
	 * @param $varName
	 * @param $asVarName
	 * @param $keyName
	 * @return unknown_type
	 */
	public function loopOne($varName, $asVarName, $keyName = null) {
		return $this->varsToLoopOne($varName, $asVarName, $keyName);
	}
	/**
	 * @deprecated
	 * @param $varName
	 * @param $asVarName
	 * @param $keyName
	 * @return unknown_type
	 */
	public function loop($varName, $asVarName, $keyName = null) {
		return $this->varsToLoop($varName, $asVarName, $keyName);
	}
	/**
	 * Method loops provided $values on actually selected nodes. Each time new row 
	 * is inserted, provided callback is triggered with $dataRow, $node and $dataIndex.
	 * Acts as valuesToLoop(), but affects each selected element separately.
	 *
	 * Method doesn't change selected nodes stack.
	 * 
	 * @param Array|Object $values
	 * Associative array or Object.
	 * 
	 * @param Callback|String $rowCallback
	 * Callback triggered for every inserted row. Should support following 
	 * parameters: 
	 * - $dataRow mixed
	 * - $node phpQueryObject
	 * - $dataIndex mixed
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToLoop() 
	 */
	public function valuesToLoopSeparate($values, $rowCallback) {
		foreach($this->stack() as $node)
			$this->_valuesToLoop($node, $values, $rowCallback);
		return $this;
	}
	/**
	 * Method loops provided $values on actually selected nodes. Each time new row 
	 * is inserted, provided callback is triggered with $dataRow, $node and $dataIndex.
	 * Acts as valuesToLoop(), but loops only first node from stack. Rest is removed 
	 * from the DOM.
	 *
	 * Method DOES change selected nodes stack. Returned is first node.
	 * 
	 * @param Array|Object $values
	 * Associative array or Object.
	 * 
	 * @param Callback|String $rowCallback
	 * Callback triggered for every inserted row. Should support following 
	 * parameters: 
	 * - $dataRow mixed
	 * - $node phpQueryObject
	 * - $dataIndex mixed
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToLoop() 
	 */
	public function valuesToLoopFirst($values, $rowCallback) {
		$return = $this->eq(0);
		$this->slice(1)->remove();
		$this->_valuesToLoop($return, $values, $rowCallback);
		return $return;
	}
	/**
	 * Method loops provided $values on actually selected nodes. Each time new row 
	 * is inserted, provided callback is triggered with $dataRow, $node and $dataIndex.
	 *
	 * Method doesn't change selected nodes stack.
	 * 
	 * == Example ==
	 *
	 * This example requires PHP 5.3. For versions before, degradate closures to normal functions.
	 *
	 * === Markup ===
	 * <code>
	 * <ul>
	 *      <li class='row'>
	 *	      <span class='name'></span>
	 *	      <ul class='tags'>
	 *		      <li class='tag'>
	 *			      <span class='tag'></span>
	 *		      </li>
	 *	      </ul>
	 *      </li>
	 * </ul>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *      array(
	 *	      'User' => array('name' => 'foo'),
	 *	      'Tags' => array(
	 *		      array('tag' => 'php'),
	 *		      array('tag' => 'js'),
	 *	      ),
	 *      ),
	 *      array(
	 *	      'User' => array('name' => 'bar'),
	 *	      'Tags' => array(
	 *		      array('tag' => 'perl'),
	 *	      ),
	 *      ),
	 *      array(
	 *	      'User' => array('name' => 'fooBar'),
	 *	      'Tags' => array(
	 *		      array('tag' => 'php'),
	 *		      array('tag' => 'js'),
	 *		      array('tag' => 'perl'),
	 *	      ),
	 *      ),
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template
	 *      ->find('> ul > li')
	 *	      ->valuesToLoop($data, function($row, $li1) {
	 *		      $li1->valuesToSelector($row['User'], 'span.%k')
	 *			      ->find('> ul > li')
	 *				      ->valuesToLoop($row['Tags'], function($tag, $li2) {
	 *					      $li2->valuesToSelector($tag);
	 *				      })
	 *		      ;
	 *	      });
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <ul>
	 * <li class="row">
	 *	      <span class="name">foo</span>
	 *	      <ul class="tags">
	 * <li class="tag">
	 *			      <span class="tag">php</span>
	 *		      </li>
	 * <li class="tag">
	 *			      <span class="tag">js</span>
	 *		      </li>
	 *	      </ul>
	 * </li>
	 * <li class="row">
	 *	      <span class="name">bar</span>
	 *	      <ul class="tags">
	 * <li class="tag">
	 *			      <span class="tag">perl</span>
	 *		      </li>
	 *	      </ul>
	 * </li>
	 * <li class="row">
	 *	      <span class="name">fooBar</span>
	 *	      <ul class="tags">
	 * <li class="tag">
	 *			      <span class="tag">php</span>
	 *		      </li>
	 * <li class="tag">
	 *			      <span class="tag">js</span>
	 *		      </li>
	 * <li class="tag">
	 *			      <span class="tag">perl</span>
	 *		      </li>
	 *	      </ul>
	 * </li>
	 * </ul>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * ul
	 *  - li.row
	 *  -  - span.name
	 *  -  - ul.tags
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * ul
	 *  - li.row
	 *  -  - span.name
	 *  -  -  - Text:foo
	 *  -  - ul.tags
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 *  -  -  -  -  - Text:php
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 *  -  -  -  -  - Text:js
	 *  - li.row
	 *  -  - span.name
	 *  -  -  - Text:bar
	 *  -  - ul.tags
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 *  -  -  -  -  - Text:perl
	 *  - li.row
	 *  -  - span.name
	 *  -  -  - Text:fooBar
	 *  -  - ul.tags
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 *  -  -  -  -  - Text:php
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 *  -  -  -  -  - Text:js
	 *  -  -  - li.tag
	 *  -  -  -  - span.tag
	 *  -  -  -  -  - Text:perl
	 * </code>
	 * 
	 * @param Array|Object $values
	 * Associative array or Object.
	 * 
	 * @param Callback|String $rowCallback
	 * Callback triggered for every inserted row. Should support following 
	 * parameters: 
	 * - $dataRow mixed
	 * - $node phpQueryObject
	 * - $dataIndex mixed
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToLoop()
	 */
	public function valuesToLoop($values, $rowCallback) {
		return $this->_valuesToLoop($this, $values, $rowCallback);
	}
	protected function _valuesToLoop($pq, $values, $rowCallback) {
		$lastNode = $pq;
		foreach($values as $k => $v) {
			$stack = array();
			foreach($pq as $node) {
				$stack[] = $node->clone()->insertAfter($lastNode)->get(0);
			}
			$lastNode = $this->newInstance($stack);
			phpQuery::callbackRun($rowCallback, array($v, $lastNode, $k));
		}
		// we used those nodes as template
		$pq->remove();
		return $this;
	}
	/**
	 * Creates markup with INPUT tags and prepends it to form.
	 * If selected element isn't a FORM then find('form') is executed.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <form>
	 *   <input name='was-here-before'>
	 * </form>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array('field1' => 'foo', 'field2' => 'bar');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->inputsFromValues($data);
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <form>
	 *   <input name='field1' value='foo'>
	 *   <input name='field2' value='bar'>
	 *   <input name='was-here-before'>
	 * </form>
	 * </code>
	 *
	 * @param $data
	 * @param $type
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::formFromValues()
	 */
	public function inputsFromValues($data, $type = 'hidden') {
		$form = $this->is('form')
			? $this->filter('form')
			: $this->find('form');
		if ($form->find('fieldset')->size())
			$form = $form->find('fieldset:first');
		$data = array_reverse($data);
		foreach($data as $field => $value) {
			$form->prepend("<input name='$field' value='$value' type='$type'>");
		}
		return $this;
	}
	/**
	 * Injects executable code which toggles form fields values and selection
	 * states according to value of variable $varName.
	 * 
	 * This includes:
	 * - input[type=radio][checked]
	 * - input[type=checkbox][checked]
	 * - select > option[selected]
	 * - input[value]
	 * - textarea
	 * 
	 * Inputs are selected according to $selectorPattern, where %k represents
	 * variable's key.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <form>
	 *   <input name='input-example'>
	 *   <input name='array[array-example]'>
	 *   <textarea name='textarea-example'></textarea>
	 *   <select name='select-example'>
	 *     <option value='first' selected='selected'></option>
	 *   </select>
	 *   <input type='radio' name='radio-example' value='foo'>
	 *   <input type='checkbox' name='checkbox-example' value='foo'>
	 * </form>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'input-example' => 'foo',
	 *   'array-example' => 'foo',
	 *   'textarea-example' => 'foo',
	 *   'select-example' => 'foo',
	 *   'radio-example' => 'foo',
	 *   'checkbox-example' => 'foo',
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template->
	 * 	varsToForm('data', $data)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <form>
	 *   <input name="input-example" value="<?php  if (isset($data['input-example'])) print $data['input-example'];
	 * else if (isset($data->{'input-example'})) print $data->{'input-example'};  ?>"><input name="array[array-example]" value="<?php  if (isset($data['array-example'])) print $data['array-example'];
	 * else if (isset($data->{'array-example'})) print $data->{'array-example'};  ?>"><textarea name="textarea-example"><?php  if (isset($data['textarea-example'])) print $data['textarea-example'];
	 * else if (isset($data->{'textarea-example'})) print $data->{'textarea-example'};  ?></textarea><select name="select-example"><?php  if ((isset($data['select-example']) && $data['select-example'] == 'first') 
	 * 	|| (isset($data->{'select-example'}) && $data->{'select-example'} == 'first')) {  ?><option value="first" selected></option>
	 * <?php  }    else {  ?><option value="first"></option>
	 * <?php  }  ?></select><?php  if ((isset($data['radio-example']) && $data['radio-example'] == 'foo') 
	 * 	|| (isset($data->{'radio-example'}) && $data->{'radio-example'} == 'foo')) {  ?><input type="radio" name="radio-example" value="foo" checked><?php  }    else {  ?><input type="radio" name="radio-example" value="foo"><?php  }    if ((isset($data['checkbox-example']) && $data['checkbox-example'] == 'foo') 
	 * 	|| (isset($data->{'checkbox-example'}) && $data->{'checkbox-example'} == 'foo')) {  ?><input type="checkbox" name="checkbox-example" value="foo" checked><?php  }    else {  ?><input type="checkbox" name="checkbox-example" value="foo"><?php  }  ?>
	 * </form>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * form
	 *  - input[name="input-example"]
	 *  - input[name="array[array-example]"]
	 *  - textarea[name="textarea-example"]
	 *  - select[name="select-example"]
	 *  -  - option[value="first"][selected]
	 *  - input[name="radio-example"][value="foo"]
	 *  - input[name="checkbox-example"][value="foo"]
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * form
	 *  - input[name="input-example"][value=PHP]
	 *  - input[name="array[array-example]"][value=PHP]
	 *  - textarea[name="textarea-example"]
	 *  -  - PHP
	 *  - select[name="select-example"]
	 *  -  - PHP
	 *  -  - option[value="first"][selected]
	 *  -  - PHP
	 *  -  - PHP
	 *  -  - option[value="first"]
	 *  -  - PHP
	 *  - PHP
	 *  - input[name="radio-example"][value="foo"][checked]
	 *  - PHP
	 *  - PHP
	 *  - input[name="radio-example"][value="foo"]
	 *  - PHP
	 *  - PHP
	 *  - input[name="checkbox-example"][value="foo"][checked]
	 *  - PHP
	 *  - PHP
	 *  - input[name="checkbox-example"][value="foo"]
	 *  - PHP
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @param Array|Object $varFields
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching form fields.
	 * Defaults to "[name*='%k']", which matches fields containing variable's key in 
	 * their names. For example, to match only names starting with "foo[bar]" change 
	 * $selectorPattern to "[name^='foo[bar]'][name*='%k']"
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 * @see QueryTemplatesPhpQuery::formFromVars()
	 * 
	 * @TODO support select[multiple] (thou array)
	 */
	public function varsToForm($varName, $varFields, $selectorPattern = "[name*='%k']") {
		$loop = $this->_varsParseFields($varFields);
		$lang = strtoupper($this->parent->language);
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		foreach($loop as $f) {
			$code = call_user_func_array(
				array($languageClass, 'printVar'), array("$varName.$f")
			);
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
			// texts, hiddens, passwords
			$this->find("input$selector:not(:radio, :checkbox)")->{"attr$lang"}('value', $code);
			// textareas
			$this->find("textarea$selector")->{strtolower($lang)}($code);
			// radios, checkboxes
			$inputs = $this->find("input$selector:radio, input$selector:checkbox");
			foreach($inputs as $input) {
//				$input = pq($input, $this->getDocumentID());
				$clone = $input->clone()->insertAfter($input);
				$value = $input->attr('value');
				$code = call_user_func_array(
					array($languageClass, 'compareVarValue'),
					array("$varName.$f", $value)
				);
//				$input->attr('checked', 'checked')->ifPHP($code, true);
				$input->attr('checked', 'checked')->{"if$lang"}($code);
				$clone->removeAttr('checked')->{"else$lang"}();
			}
			// selects
			$select = $this->find("select$selector");
			if ($select->length) {
				foreach($select['option'] as $option) {
					$option = pq($option, $this->getDocumentID());
					$clone = $option->clone()->insertAfter($option);
					$code = call_user_func_array(
						array($languageClass, 'compareVarValue'),
						array("$varName.$f", $option->attr('value'))
					);
					$option->attr('selected', 'selected')->{"if$lang"}($code, true);
					$clone->removeAttr('selected')->{"else$lang"}();
				}
			}
		}
		return $this;
	}
	/**
	 * Toggles form fields values and selection states according to static values 
	 * from $data.
	 * 
	 * This includes:
	 * - input[type=radio][checked]
	 * - input[type=checkbox][checked]
	 * - select > option[selected]
	 * - input[value]
	 * - textarea
	 * 
	 * Inputs are selected according to $selectorPattern, where %k represents
	 * variable's key.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * Example
	 * <code>
	 * $data = array(
	 *   'text-example' => 'new',
   *   'checkbox-example' => true,
   *   'radio-example' => 'second',
	 *   'select-example' => 'second',
	 *   'textarea-example' => 'new',
   * );
	 * $template->valuesToForm($data);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <form>
	 *   <input type='text' name='text-example' value='old'>
	 *   <input type='checkbox' name='checkbox-example' value='foo'>
	 *   <input type='radio' name='radio-example' value='first' checked='checked'>
	 *   <input type='radio' name='radio-example' value='second'>
   *   <select name='select-example'>
	 *     <option value='first' selected='selected'></option>
	 *     <option value='second'></option>
   *   </select>
	 *   <textarea name='textarea-example'>old</textarea>
	 * </form>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <form>
	 *   <input type='text' name='text-example' value='new'>
	 *   <input type='checkbox' name='checkbox-example' value='foo' checked='checked'>
	 *   <input type='radio' name='radio-example' value='first'>
	 *   <input type='radio' name='radio-example' value='second' checked='checked'>
   *   <select name='select-example'>
	 *     <option value='first'></option>
	 *     <option value='second' selected='selected'></option>
	 *   </select>
	 *   <textarea name='textarea-example'>new</textarea>
	 * </form>
	 * </code>
	 *
	 * @param Array|Object $values
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching form fields.
	 * Defaults to "[name*='%k']", which matches fields containing 
	 * $values' key in their names. For example, to match only names starting with 
	 * "foo[bar]" change $selectorPattern to "[name^='foo[bar]'][name*='%k']"
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 */
	public function valuesToForm($values, $selectorPattern = "[name*='%k']") {
		$form = $this->is('form')
			? $this->filter('form')
			: $this->find('form');
		// $arrayValue represents target data
		foreach($values as $f => $v) {
			// TODO addslashes to $f
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
//			if (is_array($v) || is_object($v))
//				continue;
			$input = $form->find("input$selector");
			if ($input->length) {
				switch($input->attr('type')) {
					case 'checkbox':
						if ($v)
							$input->attr('checked', 'checked');
						else
							$input->removeAttr('checked');
					break;
					case 'radio':
						$inputChecked = null;
						$input
							->filter("[value='{$v}']")
								->toReference($inputChecked)
								->attr('checked', 'checked')
							->end()
							->not($inputChecked)
								->removeAttr('checked')
							->end();
					break;
					default:
						$input->val($v);
				}
			}
			$select = $form->find("select$selector");
			if ($select->length) {
				$selected;
				$select->find('option')
					->filter("[value='{$v}']")
						->toReference($selected)
						->attr('selected', 'selected')
					->end()
					->not($selected)
						->removeAttr('selected')
					->end();
			}
			$textarea = $form->find("textarea$selector");
			if ($textarea->length)
				$textarea->markup($v);
		}
		return $this;
	}
	/**
	 * Method formFromVars acts as form helper. It creates a form without the 
	 * need of suppling a line of markup. Created form have following features:
	 * - shows data from record (array or object)
	 * - shows errors
	 * - supports default values
	 * - supports radios and checkboxes
	 * - supports select elements with optgroups
	 *  
	 * Example:
	 * <code>
	 * $structure = array(
	 *  // special field representing form element
	 * 	'__form' => array('id' => 'dasdas'),
	 * 	// TODO fieldsets
	 * //	array('Legend Label', array(
	 * //			'field1' => array('select', ...),
	 * //		),
	 * //	),
	 * 	'field2' => array('select', 
	 * 		'optgroups' => array('optgroup1', 'optgroup2'),
	 * 		'multiple' => true,	// TODO
	 * 		'label' => 'Field Name',
	 * 	),
	 * 	'field12' => array('select', 
	 * 		'label' => 'no optgroups',
	 * 	),
	 * 	'field3' => array('text',
	 * 		'label' => 'Field3 Label',
	 * 		'id' => 'someID',
	 * 	),
	 * 	'field4' => array(	// 'text' is default
	 * 		'label' => 'Field4 Label',
	 * 		'id' => 'someID2',
	 * 	),
	 * 	'field5' => 'hidden',
	 * 	'field6' => array('radio', 
	 * 		'values' => array('possibleValue1', 'possibleValue2')
	 * 	),
	 * 	'field7' => 'checkbox',
	 * 	'field234' => 'textarea',
	 * );
	 * </code>
	 * 
	 * @param $varNames
	 * Array of names of following vars:
	 * - record [0]
	 *   Represents actual record as array of fields.
	 * - errors [1]
	 *   Represents actual errors as array of fields. Field can also be an array.
	 * - additional data [2]
	 *   Same purpose as $additionalData, but during template's execution.
	 * Names should be without dollar signs. 
	 * Ex:
	 * <code>
	 * array('row', 'errors.row', 'data');
	 * $errors = array(
	 *   'field1' => 'one error',
	 *   'field2' => array('first error', 'second error')
	 * );
	 * </code>
	 * 
	 * @param $structure
	 * Form structure information. This should be easily fetchable from ORM layer.
	 * Possible types:
	 * - text (default)
	 * - password
	 * - hidden
	 * - checkbox
	 * - radio
	 * - textarea
	 * Convention:
	 * <code>
	 * 'fieldName' => array(
	 *   'fieldType', $fieldOptions
	 * )
	 * </code>
	 * Where $fieldOptions can be (`key => value` pairs):
	 * - label
	 * - id
	 * - multiple (only select)
	 * - optgroups (only select)
	 * - values (only radio)
	 * *__form* is special field name, which represents form element, as an array. 
	 * All values from it will be pushed as form attributes.
	 * If you wrap fields' array within another array, it will represent *fieldsets*, 
	 * which first value (with index 0) will be used as *legend* (optional).
	 * 
	 * @param $defaults
	 * Default field's value. Used when field isn't present within supplied record.
	 * Ex:
	 * <code>
	 * $defaults = array(
	 * 	'field2' => 'group2_1',
	 * 	'field234' => 'lorem ipsum dolor sit sit sit...',
	 * 	// TODO multipe
	 * //	'field2' => array('value2', 'dadas', 'fsdsf'),
	 * );
	 * </code>
	 * 
	 * @param $additionalData
	 * Additional data for fields. For now it's only used for populating select boxes.
	 * Example: 
	 * <code>
	 * $additionalData = array(
	 * 	'field2' => array(
	 * 		array(	// optgroup
	 * 			'foo' => 'Foo',
	 * 			'bar2' => 'Bar',
	 * 		),
	 * 		array(	// optgroup
	 * 			'group2_1' => 'group2_1',
	 * 			'group2_2' => 'group2_2',
	 * 		),
	 * 		'bar' => 'Bar',	// no optgroup
	 * 	),
	 * );
	 * </code>
	 * 
	 * @param $template
	 * Input wrapper template. This template will be used for each field. Use array 
	 * to per field template, '__default' means default.
	 * Default value:
	 * <code>
	 * <div class="input">
	 *   <label/>
	 *   <input/>
	 *   <ul class="errors">
	 *     <li/>
	 *   </ul>
	 * </div>
	 * </code>
	 * 
	 * @param $selectors
	 * Array of selectors indexed by it's type. Allows to customize lookups inside 
	 * inputs wrapper. Possible values are: 
	 * - error - selects field's error wrapper
	 *   - dafault value is '.errors'
	 * - label - selects field's label node (can be div, span, etc)
	 *   - default value is 'label:first'
	 *   - use array to per field name selector, '__default' means default
	 * - input - selects field's input node: input, textarea or select
	 *   - default value is 'input:first' 
	 *   - use array to per field name selector, '__default' means default
	 *   - %t is replaced by field node type (use it with customized per field $template)
	 *   
	 * @param $fieldCallback
	 * TODO
	 * 
	 * @return QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 * 
	 * @TODO maybe support callbacks (per input type, before/after, maybe for errors too ?)
	 */
	function formFromVars($varNames, $structure, $defaults = null, $additionalData = null, 
		$template = null, $selectors = null, $fieldCallback = null) {
		// setup $varNames
		if (! $varNames)
			throw new Exception("Record's var name (\$varNames or \$varNames[0]) is mandatory.");
		if (! is_array($varNames))
			$varNames = array($varNames);
		$varRecord = $varNames[0];
		$varErrors = isset($varNames[1]) && $varNames[1]
			? $varNames[1] : null;
		$varData = isset($varNames[2]) && $varNames[2]
			? $varNames[2] : null;
		// setup $template
		if (! $template && $varErrors)
			$template = <<<EOF
<div class="input">
  <label/>
  <input/>
  <ul class="errors">
    <li/>
  </ul>
</div>
EOF;
		else if (! $template && ! $varErrors)
			$template = <<<EOF
<div class="input">
  <label/>
  <input/>
</div>
EOF;
		// setup $selectors
		if (! isset($selectors))
			$selectors = array();
		$selectors = array_merge(array(
			'errors' => '.errors',
			'input' => 'input:first',
			'label' => 'label:first',
		), $selectors);
		// setup lang stuff
		$lang = strtoupper($this->parent->language);
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		// setup markup
//		$template = $this->newInstance($template);
		$form = $this->is('form')
			? $this->filter('form')->empty()
			: $this->newInstance('<form/>');
		if ($structure['__form']) {
			foreach($structure['__form'] as $attr => $value)
				$form->attr($attr, $value);
			$attr = $value = null;
			unset($structure['__form']);
		}
		$formID = $form->attr('id');
		if (! $formID) {
			$formID = 'f_'.substr(md5(microtime()), 0, 5);
			$form->attr('id', $formID);
		}
		// no fieldsets
		if (! isset($structure[0])) {
			$structure = array($structure);
		}
		foreach($structure as $fieldsetFields) {
			$fieldset = $this->newInstance('<fieldset/>');
			if (is_string($fieldsetFields[0])) {
				$fieldset->append("<legend>{$fieldsetFields[0]}</legend>");
				unset($fieldsetFields[0]);
			}
			foreach($fieldsetFields as $field => $info) {
	//			if ($field == '__form')
	//				continue;
//				if (is_int($field)) {
//					// TODO fieldset
//					continue;
//				}
				if (! is_array($info))
					$info = array($info);
				$id = isset($info['id'])
					? $info['id']
					: "{$formID}_{$field}";
				// setup markup
//				$markup = $template->clone();
				if (is_array($template)) {
					if (isset($template[$field])) {
						$markup = $template[$field];
					} else if (isset($template['__default'])) {
						$markup = $template['__default'];
					} else {
						throw new Exception("No $selectorType selector for field $field. Provide "
							."default one or one selector for all fields");
					}
				} else {
					$markup = $template;
				}
				$markup = $this->newInstance($markup);
				// setup selectors
				$inputSelector = $labelSelector = null;
				foreach(array('input', 'label') as $selectorType) {
					if (is_array($selectors[$selectorType])) {
						if (isset($selectors[$selectorType][$field])) {
							${$selectorType.'Selector'} = $selectors[$selectorType][$field];
						} else if (isset($selectors[$selectorType]['__default'])) {
							${$selectorType.'Selector'} = $selectors[$selectorType]['__default'];
						} else {
							throw new Exception("No $selectorType selector for field $field. Provide "
								."default one or one selector for all fields");
						}
					} else {
						${$selectorType.'Selector'} = $selectors[$selectorType];
					}
				}
				switch($info[0]) {
					case 'textarea':
					case 'select':
						$inputSelector = str_replace('%t', $info[0], $inputSelector);
						break;
					default:
						$inputSelector = str_replace('%t', 'input', $inputSelector);
				}
				switch($info[0]) {
					// TEXTAREA
					case 'textarea':
						// TODO
						$input = $this->newInstance("<textarea></textarea>")
							->attr('id', $id);
						$markup[$inputSelector]->replaceWith($input);
						if (isset($defaults[$field])) {
							$input->{"$lang"}(
								self::formFromVars_CodeValue(compact(
									'input', 'languageClass', 'field', 'defaults', 'varRecord'
								))
							);
						} else {
							$input->{"$lang"}(
								$input->qt_langCode('printVar', "$varRecord.$field")
							);
						}
						$markup[$labelSelector]->attr('for', $id);
						break;
					// SELECT
					case 'select':
						$input = $this->newInstance("<select name='$field'/>");
						// TODO multiple
						$markup[$inputSelector]->replaceWith($input);
						if (isset($info['optgroups'])) {
							foreach($info['optgroups'] as $optgroup)
								$input->append("<optgroup label='$optgroup'/>");
						}
						// inputFromValues
						if (isset($additionalData[$field])) {
							$target = null;
							$selected = '';
							foreach($additionalData[$field] as $value => $label) {
								// optgroup
								if (is_array($label)) {
									$target = $input["optgroup:eq($value)"];
									foreach($label as $_value => $_label) {
										$selected = '';
										// TODO multiple
										if ($defaults && isset($defaults[$field]) 
											&& $defaults[$field] == $_value)
											$selected = "selected='selected'";
										$target->append("<option value='$_value' $selected>$_label</option>");
									}
								// no optgroup
								} else {
									// TODO multiple
									if ($defaults && isset($defaults[$field]) 
										&& $defaults[$field] == $value)
										$selected = "selected='selected'";
									$input->append("<option value='$value' $selected>$label</option>");
								}
							}
							$target = null;
							$selected = null;
							$input['> *']->ifNotVar($varRecord);
						}
						if ($varData) {
							if (isset($info['optgroups'])) {
								$optgroupsDefault = $input['> optgroup'];
								foreach($info['optgroups'] as $optgroup)
									$input->append("<optgroup label='$optgroup'><option/></optgroup>");
								$optgroups = $input['> optgroup']->not($optgroupsDefault);
								if (isset($defaults[$field]))
									$optgroups->elseStatement();
								foreach($optgroups as $k => $group) {
									$option = $group['option']->loop("$varData.$field.$k", 'value', 'label');
									$option->varPrintAttr('value', 'value')->
										varPrint('label');
								}
								// TODO field without optgroup (when optgroups present)
							} else {
								$option = $input->append("<option/>");
								if (isset($defaults[$field]))
									$option->elseStatement();
								$option = $input['> option:last']->loop("$varData.$field", 'value', 'label');
								$option->varPrintAttr('value', 'value')->
									varPrint('label');
							}
						}
		//				if (! $varData && ! isset($additionalData[$field])) {
		//					throw new Exception("\$additionalData['$field'] should be present to "
		//						."populate select element. Otherwise remove \$structure['$field'].");
		//				}
						$optgroups = $optgroupsDefault = $option = null;
						$markup[$labelSelector]->attr('for', $id);
						break;
					// RADIO
					case 'radio':
						if (! $info['values'])
							throw new Exception("'values' property needed for radio inputs");
						$inputs = array();
						$input = $markup[$inputSelector]->
							attr('type', 'radio')->
							attr('name', $field)->
							attr('value', $info['values'][0])->
							removeAttr('checked');
						$inputs[] = $input;
						$lastInput = $input;
						// inputFromValues
						// XXX not safe ?
						foreach(array_slice($info['values'], 1) as $value) {
							$lastInput = $input->clone()->
								insertAfter($input)->
								attr('value', $value);
							$inputs[] = $lastInput;
						}
						if (isset($defaults[$field])) {
							phpQuery::pq($inputs)->clone()->
								insertBefore($inputs->eq(0))->
								filter("[value='{$defaults[$field]}']")->
									attr('checked', 'checked')->
								end()->
								ifNotVar("varRecord.$field");
							$inputs->elseStatement();
						}
						foreach($inputs as $input) {
			//				$input = pq($input, $this->getDocumentID());
							$clone = $input->clone()->insertAfter($input);
			//				$input->attr('checked', 'checked')->ifPHP($code, true);
							$code = $this->qt_langCode('compareVarValue', 
								"$varRecord.$field", $input->attr('value')
							);
							$input->attr('checked', 'checked')->{"if$lang"}($code);
							$clone->removeAttr('checked')->{"else$lang"}();
						}
						$inputs = null;
						$markup[$labelSelector]->removeAttr('for');
						break;
					case 'hidden':
						$markup = null;
						$input = $this->newInstance('<input/>')->
							attr('type', 'hidden')->
							attr('name', $field)->
							attr('id', $id);
						$target = $form['fieldset']->length
							? $form['fieldset:first']
							: $form;
						$code = isset($defaults[$field])
							? self::formFromVars_CodeValue(compact(
									'input', 'languageClass', 'field', 'defaults', 'varRecord'
								))
							: $input->qt_langCode('printVar', "$varRecord.$field");
						$input->qt_langMethod('attr', 'value', $code);
						$target->prepend($input);
						$target = $code = null;
						break;
					// TEXT, HIDDEN, PASSWORD, others
					default:
//						$markup = $template->clone();
						if (! isset($info[0]))
							$info[0] = 'text';
						$input = $markup[$inputSelector]->
							attr('type', $info[0])->
							attr('name', $field)->
							attr('id', $id)->
							removeAttr('checked');
						$code = isset($defaults[$field])
							? self::formFromVars_CodeValue(compact(
									'input', 'languageClass', 'field', 'defaults', 'varRecord'
								))
							: $input->qt_langCode('printVar', "$varRecord.$field");
						$input->qt_langMethod('attr', 'value', $code);
						$markup[$labelSelector]->attr('for', $id);
						$code = null;
						break;
				}
				if ($markup) {
					$markup->addClass($info[0]);
					// label
					$label = isset($info['label'])
						? $info['label'] : ucfirst($field);
					$markup[$labelSelector] = $label;
					if ($varErrors) {
						$varNamePHP = QueryTemplatesLanguage::get('php', 'varNameArray', "$varErrors.$field");
						$varNameJS = QueryTemplatesLanguage::get('js', 'varName', "$varErrors.$field");
						$markup[ $selectors['errors'] ]->
							ifVar("$varErrors.$field")->
							onlyPHP()->
								beforePHP("if (! is_array($varNamePHP)) 
									$varNamePHP = array($varNamePHP);")->
							endOnly()->
							onlyJS()->
								beforeJS("if (typeof $varNameJS != 'object') 
									var $varNameJS = array($varNameJS);")->
							endOnly()->
							find('>*')->
								varsToLoopFirst("$varErrors.$field", 'error')->
									varPrint('error');
						$_varName = null;
					}
					$fieldset->append($markup);
				}
			}
			$form->append($fieldset);
		}
		$input = $code = null;
		$this->append($form);
		return $this;
	}
	protected static function formFromVars_CodeValue($params) {
		extract($params);
		$code = array(
			'if' => call_user_func_array(
				array($languageClass, 'ifVar'),
				array("$varRecord.$field")
			),
			'printVar' => call_user_func_array(
				array($languageClass, 'printVar'),
				array("$varRecord.$field")
			),
			'else' => call_user_func_array(
				array($languageClass, 'elseStatement'),
				array()
			),
			'printValue' => call_user_func_array(
				array($languageClass, 'printValue'),
				array($defaults[$field])
			),
		);
		return $code['if'][0].
				$code['printVar'].
			$code['if'][1].
			$code['else'][0].
				$code['printValue'].
			$code['else'][1];
	}
	/**
	 * Behaves as var_export, dumps variables from $varsArray as $key = value for
	 * later use during template execution. Variables are prepended into selected 
	 * elemets.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 * 
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->valuesToVars($values);
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * <node1><?php  $0 = '<foo/>';
	 * $1 = '<bar/>';  ?><node2></node2></node1>
	 * </code>
	 * 
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * </code>
	 * 
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - PHP
	 *  - node2
	 * </code>
	 *
	 * @param array $varsArray
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function varsFromValues($varsArray) {
		return $this->qt_langMethod('prepend', 
			$this->qt_langCode('valuesToVars', $varsArray)
		);
	}
	/**
	 * @deprecated
	 */
	public function valuesToVars($varsArray) {
		return varsFromValues($varsArray);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStack($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><foo></foo></node1><node1><bar></bar></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - foo
	 * node1
	 *  - bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStack($values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack('markup', $values, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStackReplace($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <foo></foo><bar></bar>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * foo
	 * bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStackReplace($values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack('replaceWith', $values, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStackBefore($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <foo></foo><node1><node2></node2></node1><bar></bar><node1><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * foo
	 * node1
	 *  - node2
	 * bar
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStackBefore($values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack('before', $values, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStackAfter($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2></node1><foo></foo><node1><node2></node2></node1><bar></bar>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * foo
	 * node1
	 *  - node2
	 * bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStackAfter($values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack('after', $values, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStackPrepend($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><foo></foo><node2></node2></node1><node1><bar></bar><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - foo
	 *  - node2
	 * node1
	 *  - bar
	 *  - node2
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStackPrepend($values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack('prepend', $values, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStackAppend($values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1><node2></node2><foo></foo></node1><node1><node2></node2><bar></bar></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 *  - foo
	 * node1
	 *  - node2
	 *  - bar
	 * </code>
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStackAppend($values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack('append', $values, $skipFields, $fieldCallback);
	}
	/**
	 * Injects markup from $values' content (rows or attributes) inside actually 
	 * selected nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * <node1>
	 * 	<node2></node2>
	 * </node1>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['node1']->
	 * 	valuesToStackAttr('rel', $values)
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <node1 rel="&lt;foo/&gt;"><node2></node2></node1><node1 rel="&lt;bar/&gt;"><node2></node2></node1>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * node1
	 *  - node2
	 * node1
	 *  - node2
	 * </code>
	 *
	 * @param String $attr
	 * Target attribute name.
	 *
	 * @param Array|Object $values
	 * Associative array or Object containing markup, text or instance of Callback.
	 * 
	 * @param Callback|string $fieldCallback
	 * Callback triggered after every insertion. Three parameters are passed to 
	 * this callback:
	 * - $node phpQueryObject
	 * - $field String
	 * - $target String|array
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToStackAttr($attr, $values, $skipFields = null, $fieldCallback = null) {
		return $this->_valuesToStack(array('attr', $attr), $values, $skipFields, $fieldCallback);
	}
	protected function _valuesToStack($target, $data, $skipFields, $fieldCallback) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		$i = 0;
		foreach($data as $k => $v) {
			if ($skipFields && in_array($f, $skipFields))
				continue;
			if ($v instanceof Callback)
				$v = phpQuery::callbackRun($v);
			$node = $this->eq($i++);
			switch($target) {
				case 'attr':
					$node->attr($targetData[0], $v);
					break;
				default:
					$node->$target($v);
			}
			if ($fieldCallback)
				// TODO doc
				phpQuery::callbackRun($fieldCallback, array($node, $v, $_target));
		}
		return $this;
	}
	/**
	 * Returns array being result of running $method on all stack elements.
	 *
	 * @param string $method
	 * Method used for output.
	 * @return array
	 */
	public function stackToMethod($method = 'markupOuter') {
		$result;
		$avaibleMethods = array(
			'htmlOuter', 'xmlOuter', 'text', 'val', 'html', 'xml', 'markup', 'markupOuter'
		);
		if (! $avaibleMethods[$method])
			return $this;
		foreach($this as $pq) {
			$result[] = call_user_func_array(array($pq, $method), array());
		}
		return $result;
	}
	/**
	 * Removes selected element and moves it's children into parent node.
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function unWrap() {
		return $this->after($this->contents())->remove();
	}
	/**
	 * Replaces selected tag with PHP "if" statement containing $code as condition.
	 *
	 * Method doesn't change selected nodes stack.
	 * detached from it's parent.
	 *
	 * Example
	 * <code>
	 * $template['.if']->tagToIfPHP('$foo == 1');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <div class='if'><node1/></div>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * if ($foo == 1) {
	 * ?><node1/><?php
	 * }
	 * ?>
	 * </code>
	 *
	 * @param string $code
	 * Valid PHP condition code
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function tagToIfPHP($code) {
		return $this->_tagToIf('php', $code);
	}
	private function _tagToIf($lang, $code) {
		$lang = strtoupper($lang);
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->{"if$lang"}($code)
				->contents()
					->insertAfter($this)->end()
				->remove();
		}
		return $this;
	}
	/**
	 * Replaces selected tag with PHP "if" statement checking if $var evaluates
	 * to TRUE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 *
	 * Method doesn't change selected nodes stack.
	 * detached from it's parent.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	tagToIfVar('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  if ((isset($data['foo']['bar']['0']) && $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && $data->{'foo'}->{'bar'}->{'0'})) {  ?>2<?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::ifVar()
	 */
	public function tagToIfVar($var) {
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->ifVar($var)
				->contents()
					->insertAfter($node)->end()
				->remove();
		}
		return $this;
	}
	/**
	 * Replaces selected tag with PHP "if" statement checking if $var evaluates
	 * to FALSE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 *
	 * Method doesn't change selected nodes stack.
	 * detached from it's parent.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	tagToIfNotVar('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  if ((isset($data['foo']['bar']['0']) && ! $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && ! $data->{'foo'}->{'bar'}->{'0'})) {  ?>2<?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::ifVar()
	 */
	public function tagToIfNotVar($var) {
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->ifNotVar($var)
				->contents()
					->insertAfter($node)->end()
				->remove();
		}
		return $this;
	}
	/**
	 * Replaces selected tag with PHP "else if" statement containing $code as condition.
	 *
	 * Method doesn't change selected nodes stack.
	 * detached from it's parent.
	 *
	 * Example
	 * <code>
	 * $template['.else-if']->tagToElseIfPHP('$foo == 1');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <div class='else-if'><node1/></div>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * else if ($foo == 1) {
	 * ?><node1/><?php
	 * }
	 * ?>
	 * </code>
	 *
	 * @param string $code
	 * Valid PHP condition code
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function tagToElseIfPHP($code) {
		return $this->_tagToElseIf('php', $code);
	}
	private function _tagToElseIf($lang, $code) {
		$lang = strtoupper($lang);
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->{"elseIf$lang"}($code)
				->contents()
					->insertAfter($node)->end()
				->remove();
		}
		return $this;
	}
	/**
	 * Replaces selected tag with PHP "else if" statement checking if $var evaluates
	 * to TRUE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 *
	 * Method doesn't change selected nodes stack.
	 * detached from it's parent.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	tagToElseIfVar('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  else if ((isset($data['foo']['bar']['0']) && $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && $data->{'foo'}->{'bar'}->{'0'})) {  ?>2<?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::ifVar()
	 */
	public function tagToElseIfVar($var) {
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->elseIfVar($var)
				->contents()
					->insertAfter($node)->end()
				->remove();
		}
		return $this;
	}
	/**
	 * Replaces selected tag with PHP "else if" statement checking if $var evaluates
	 * to FALSE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 *
	 * Method doesn't change selected nodes stack.
	 * detached from it's parent.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	tagToElseIfNotVar('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  else if ((isset($data['foo']['bar']['0']) && ! $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && ! $data->{'foo'}->{'bar'}->{'0'})) {  ?>2<?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::ifVar()
	 */
	public function tagToElseIfNotVar($var) {
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->elseIfNotVar($var)
				->contents()
					->insertAfter($node)->end()
				->remove();
		}
		return $this;
	}
		public function tagToElseStatement() {
		return $this->_tagToElse($this->qt_lang());
	}
	public function tagToElsePHP() {
		return $this->_tagToElse('php');
	}
	public function _tagToElse($lang) {
		$lang = strtoupper($lang);
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
			->{"else$lang"}()
			->contents()
				->insertAfter($node)->end()
			->remove();
		}
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "if" statement containing $code as condition.
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * Example
	 * <code>
	 * $template['node1']->tagToElseIf('$foo == 1');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <node1/>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * else if ($foo == 1) {
	 * ?><node1/><?php
	 * }
	 * ?>
	 * </code>
	 *
	 * @param string $code
	 * Valid PHP condition code
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function ifPHP($code, $separate = false) {
		return $this->_if('php', $code, $separate);
	}
	public function _if($lang, $code, $separate = false) {
		$lang = strtoupper($lang);
		$method = $separate
			? 'wrap'
			: 'wrapAll';
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		$code = call_user_func_array(
			array($languageClass, 'ifCode'), array($code)
		);
		$this->{$method.$lang}($code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "if" statement checking if $var evaluates
	 * to TRUE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	ifVar('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  if ((isset($data['foo']['bar']['0']) && $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && $data->{'foo'}->{'bar'}->{'0'})) {  ?><div>2</div>
	 * <?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * div
	 *  - Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::elseStatement()
	 */
	public function ifVar($var, $separate = false) {
		$method = $separate
			? 'wrap' : 'wrapAll';
		$code = $this->qt_langCode('ifVar', $var);
		$this->qt_langMethod($method, $code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "if" statement checking if $var evaluates
	 * to FALSE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	ifNotVar('data.foo.bar.0')
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  if ((isset($data['foo']['bar']['0']) && ! $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && ! $data->{'foo'}->{'bar'}->{'0'})) {  ?><div>2</div>
	 * <?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * div
	 *  - Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::elseStatement()
	 */
	public function ifNotVar($var, $separate = false) {
		$method = $separate
			? 'wrap' : 'wrapAll';
		$code = $this->qt_langCode('ifNotVar', $var);
		$this->qt_langMethod($method, $code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "else if" statement containing $code as condition.
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * Example
	 * <code>
	 * $template['node1']->elseIfPHP('$foo == 1');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <node1/>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * else if ($foo == 1) {
	 * ?><node1/><?php
	 * }
	 * ?>
	 * </code>
	 *
	 * @param string $code
	 * Valid PHP condition code
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function elseIfPHP($code, $separate = false) {
		$lang = strtoupper($lang);
		$method = $separate
			? 'wrap'
			: 'wrapAll';
		$lang = $this->parent->language;
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		$code = call_user_func_array(
			array($languageClass, 'elseIfCode'), array($code)
		);
		$this->{$method.$lang}($code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "else if" statement checking if $var evaluates
	 * to true. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * Notice-safe.
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 * 
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->elseIfVar('data.foo.bar.0');
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  else if ((isset($data['foo']['bar']['0']) && $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && $data->{'foo'}->{'bar'}->{'0'})) {  ?><div>2</div>
	 * <?php  }  ?>
	 * <div>3</div>
	 * </code>
	 * 
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 * 
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * div
	 *  - Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function elseIfVar($var, $separate = false) {
		$method = $separate
			? 'wrap' : 'wrapAll';
		$code = $this->qt_langCode('elseIfVar', $var);
		$this->qt_langMethod($method, $code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "else if" statement checking if $var evaluates
	 * to FALSE. $var must be available inside template's scope.
	 * 
	 * $var is passed in JavaScript object notation (dot separated).
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 *
	 * Notice-safe.
	 * 
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 * $data = array(
	 *   'foo' => array(
	 *   	'bar' => array(true)
	 *   )
	 * );
	 * </code>
	 * 
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->elseIfNotVar('data.foo.bar.0');
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  else if ((isset($data['foo']['bar']['0']) && ! $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && ! $data->{'foo'}->{'bar'}->{'0'})) {  ?><div>2</div>
	 * <?php  }  ?>
	 * <div>3</div>
	 * </code>
	 * 
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 * 
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * div
	 *  - Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function elseIfNotVar($var, $separate = false) {
		$method = $separate
			? 'wrap' : 'wrapAll';
		$code = $this->qt_langCode('elseIfNotVar', $var);
		$this->qt_langMethod($method, $code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "else" statement.
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected nodes stack.
	 * 
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function elsePHP($separate = false) {
		return $this->elseStatement($separate, 'php');
	}
	/**
	 * TODO description
	 *
	 * == Example ==
	 *
	 * === Markup ===
	 * <code>
	 * <div>1</div>
	 * <div>2</div>
	 * <div>3</div>
	 * </code>
	 *
	 * === Data ===
	 * <code>
	 *
	 * </code>
	 *
	 * === `QueryTemplates` formula ===
	 * <code>
	 * $template['div:eq(1)']->
	 * 	elseStatement()
	 * ;
	 * </code>
	 *
	 * === Template ===
	 * <code>
	 * 
	 * <div>1</div>
	 * <?php  else {  ?><div>2</div>
	 * <?php  }  ?>
	 * <div>3</div>
	 * </code>
	 *
	 * === Template tree before ===
	 * <code>
	 * div
	 *  - Text:1
	 * div
	 *  - Text:2
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * === Template tree after ===
	 * <code>
	 * div
	 *  - Text:1
	 * PHP
	 * div
	 *  - Text:2
	 * PHP
	 * div
	 *  - Text:3
	 * </code>
	 *
	 * @param $separate
	 * @param $lang
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function elseStatement($separate = false, $lang = null) {
		$lang = $lang 
			? strtoupper($lang)
			: $this->qt_lang();
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		$code = call_user_func_array(
			array($languageClass, 'elseStatement'), array()
		);
		return $separate
			? $this
				->{"before$lang"}($code[0])
				->{"after$lang"}($code[1])
			: $this
				->filter(':first')->{"before$lang"}($code[0])->end()
				->filter(':last')->{"after$lang"}($code[1])->end();
	}
	/**
	 * Honors code between onlyPHP and endOnly, only for PHP templates.
	 * 
	 * TODO: Is theres something wrong with this name ?
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function onlyPHP() {
		return strtolower($this->qt_lang()) == 'php'
			? $this : new QueryTemplatesVoid($this, 'endOnly');
	}
	/**
	 * TODO Move to jsCode plugin.
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function onlyJS() {
		return strtolower($this->qt_lang()) == 'js'
			? $this : new QueryTemplatesVoid($this, 'endOnly');
	}
	public function endOnly() {
		return $this;
	}
	/**
	 * Saves markupOuter() as value of variable $var avaible in template scope.
	 *
	 * @param String $name
	 * New variable name.
	 * 
	 * @TODO user self::parent for storing vars
	 * @TODO support second $method param
	 */
	public function varsFromStack($name) {
		$object = $this;
		while($object->previous)
			$object = $object->previous;
		$object->vars[$name] = $this->markupOuter();
		return $this;
	}
	public function saveAsVar($name) {
		return $this->varsFromStack($name);
	}
	public function saveTextAsVar($name) {
		return $this->varsFromStackText($name);
	}
	/**
	 * Saves text() as value of variable $var avaible in template scope.
	 *
	 * @param String $name
	 * New variable name.
	 * 
	 * @TODO user self::parent for storing vars
	 */
	public function varsFromStackText($name) {
		$object = $this;
		while($object->previous)
			$object = $object->previous;
		$object->vars[$name] = $this->text();
		return $this;
	}
	/**
	 * @todo use attr() function (encoding issues etc)
	 * @see src/phpQuery-stock/phpQueryObject#attrAppend()
	 */
	public function attrAppend($attr, $value) {
		foreach($this->stack(1) as $node )
			$node->setAttribute($attr,
				$node->getAttribute($attr).$value
			);
		return $this;
	}
	public function attrPrepend($attr, $value) {
		foreach($this->stack(1) as $node )
			$node->setAttribute($attr,
				$value.$node->getAttribute($attr)
			);
		return $this;
	}
}