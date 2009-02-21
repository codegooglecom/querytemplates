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
	 * Prints variable $varName as elements' content.
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @TODO support filters as 2nd and later arguments
	 * Filter is a template-execution callback for value.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrint($varName) {
		return $this->_varPrint(false, $varName);
	}
	/**
	 * Prints variable $varName replacing elements.
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function varPrintReplace($varName) {
		return $this->_varPrint(false, $varName);
	}
	public function _varPrint($replace, $varName) {
		$lang = $this->parent->language;
		$languageClass = 'QueryTemplatesLanguage'.strtoupper($lang);
		if ($replace)
			$this
				->replaceWith(phpQuery::code($lang, call_user_func_array(
					array($languageClass, 'printVar'), array($varName)
				)));
		else
			$this
				->{strtolower($lang)}(call_user_func_array(
					array($languageClass, 'printVar'), array($varName)
				));
		return $this;
	}
	/**
	 * TODO doc
	 * 
	 * @param $var
	 * @param $attr
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function varPrintAttr($varName, $attr) {
		$code = $this->qt_langCode('printVar', $varName);
		return $this->qt_langMethod('attr', $attr, $code);
	}
	/**
	 * Injects executable code printing $varName's content (rows or attributes) into nodes
	 * matched by selector.
	 * 
	 * For replacing matched nodes with content use varsToSelectorReplace().
	 * For injecting vars into forms use varsToForm().
	 *
	 * Example
	 * <code>
	 * $foo = array('field1' => 'foo', 'field2' => 'bar');
	 * $template->varsToSelector('foo', $foo);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <p class='field1'><?php print $foo['field1'] ?></p>
	 * <p class='field2'><?php print $foo['field2'] ?></p>
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * @param Array|Object $varValue
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToSelectorReplace()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 *
	 * @TODO support $varName to be a function (last char == ')'), 
	 */
	public function varsToSelector($varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector('markup', $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	/**
	 * Injects executable code printing $varName's content (rows or attributes) into 
	 * document replacing nodes matched by selector.
	 * 
	 * For injecting vars inside matched nodes use varsToSelectorReplace().
	 * For injecting vars into forms use varsToForm().
	 *
	 * Example
	 * <code>
	 * $foo = array('field1' => 'foo', 'field2' => 'bar');
	 * $template->varsToSelector('foo', $foo);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php print $foo['field1'] ?>
	 * <?php print $foo['field2'] ?>
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * @param Array|Object $varValue
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToSelector()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 *
	 * @TODO support $arrayName to be a function (last char == ')'), 
	 * then prepend \$$var = $arrayName
	 */
	public function varsToSelectorReplace($varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector('replaceWith', $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function varsToSelectorAppend($varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector('append', $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function varsToSelectorPrepend($varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector('prepend', $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function varsToSelectorAfter($varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector('after', $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function varsToSelectorBefore($varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector('before', $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function varsToSelectorAttr($attr, $varName, $varFields, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToSelector(array('attr', $attr), $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback);
	}
	protected function _varsToSelector($target, $varName, $varFields, $selectorPattern, $skipKeys, $fieldCallback) {
		$loop = $this->varsParseFields($varFields);
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		foreach($loop as $f) {
			if ($skipKeys && in_array($f, $skipKeys))
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
	 * Replaces matched nodes with exacutable code printing variables contents
	 * using markup(). Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * Example
	 * <code>
	 * $foo = array('<foo/>', '<bar/>');
	 * $template['node1']->varsToStack('foo', array_keys($values));
	 * </code>
	 *
	 * Source
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <node1>
   * 	<?php
   * 		print $values[0]
   * 	?>
	 * </node1>
	 * <node1>
   * 	<?php
   * 		print $values[1]
   * 	?>
	 * </node1>
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * @param Array|Object $varFields
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * Param needs to be wrapped with array_keys for non-assosiative arrays.
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStackReplace()
	 */
	public function varsToStack($varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack('markup', $varName, $varFields, $skipKeys, $fieldCallback);
	}
	/**
	 * Replaces matched nodes with exacutable code printing variables contents
	 * using replaceWith(). Second param needs to be wrapped with array_keys for 
	 * non-assosiative arrays.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * Example
	 * <code>
	 * $foo = array('<foo/>', '<bar/>');
	 * $template['node1']->varsToStackReplace('foo', $values);
	 * </code>
	 *
	 * Source
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
	 * Result
	 * <code>
   * <?php
   * 	print $values[0]
   * ?>
	 * <node2/>
   * <?php
   * 	print $values[1]
   * ?>
	 * </code>
	 *
	 * @param String $varName
	 * Variable avaible in scope of type Array or Object.
	 * $varName should NOT start with $.
	 * @param Array|Object $varFields
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * Param needs to be wrapped with array_keys for non-assosiative arrays.
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStac()
	 */
	public function varsToStackReplace($varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack('replaceWith', $varName, $varFields, $skipKeys, $fieldCallback);
	}
	public function varsToStackAppend($varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack('append', $varName, $varFields, $skipKeys, $fieldCallback);
	}
	public function varsToStackPrepend($varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack('prepend', $varName, $varFields, $skipKeys, $fieldCallback);
	}
	public function varsToStackAfter($varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack('after', $varName, $varFields, $skipKeys, $fieldCallback);
	}
	public function varsToStackBefore($varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack('before', $varName, $varFields, $skipKeys, $fieldCallback);
	}
	public function varsToStackAttr($attr, $varName, $varFields, $skipKeys = null, $fieldCallback = null) {
		return $this->_varsToStack(array('attr', $attr), $varName, $varFields, $skipKeys, $fieldCallback);
	}
	protected function _varsToStack($target, $varName, $varValue, $skipKeys, $fieldCallback) {
		$loop = $this->varsParseFields($varValue);
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		$i = 0;
		foreach($loop as $f) {
			if ($skipKeys && in_array($f, $skipKeys))
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
	protected function varsParseFields($varFields) {
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
	public function codeToSelector($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector('markup', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToSelectorReplace($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector('replaceWith', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToSelectorAppend($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector('append', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToSelectorPrepend($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector('prepend', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToSelectorAfter($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector('after', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToSelectorBefore($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector('before', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToSelectorAttr($attr, $codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToSelector(array('attr', $attr), $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	protected function _codeToSelector($target, $codeArray, $selectorPattern, $skipKeys, $fieldCallback) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		foreach($codeArray as $f => $code) {
			if ($skipKeys && in_array($f, $skipKeys))
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
	public function codeToStack($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack('markup', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToStackReplace($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack('replaceWith', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToStackAppend($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack('append', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToStackPrepend($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack('prepend', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToStackAfter($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack('after', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToStackBefore($codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack('before', $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	public function codeToStackAttr($attr, $codeArray, $selectorPattern = '.%k', $skipKeys = null, $fieldCallback = null) {
		return $this->_codeToStack(array('attr', $attr), $codeArray, $selectorPattern, $skipKeys, $fieldCallback);
	}
	protected function _codeToStack($target, $codeArray, $selectorPattern, $skipKeys, $fieldCallback) {
		$_target = $target;
		$targetData = null;
		if (is_array($target)) {
			$targetData = array_slice($target, 1);
			$target = $target[0];
		}
		$i = 0;
		foreach($codeArray as $f => $code) {
			if ($skipKeys && in_array($f, $skipKeys))
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
	 * Injects markup from $data's content (rows or attributes) into nodes
	 * matched by selector.
	 * 
	 * For replacing matched nodes with content use valuesToSelectorReplace().
	 * For injecting values into forms use valuesToForm().
	 *
	 * Example
	 * <code>
	 * $values = array('field1' => '<foo/>', 'field2' => '<bar/>');
	 * $template['p']->valuesToSelector($values);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <p class='field1'><foo/></p>
	 * <p class='field2'><bar/></p>
	 * </code>
	 *
	 * @param Array|Object $data
	 * Associative array or Object containing markup.
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToSelectorReplace()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelector($data, $selectorPattern = '.%k', $skipKeys = null) {
		return $this->_valuesToSelector(false, $data, $selectorPattern, $skipKeys);
	}
	/**
	 * Injects markup from $data's content (rows or attributes) into document, 
	 * replacing nodes matched by selector.
	 * 
	 * For injecting markup inside matched nodes use valuesToSelector().
	 * For injecting values into forms use valuesToForm().
	 *
	 * Example
	 * <code>
	 * $values = array('field1' => '<foo/>', 'field2' => '<bar/>');
	 * $template['p']->valuesToSelector($values);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <p class='field1'>lorem ipsum</p>
	 * <node1/>
	 * <p class='field2'>lorem ipsum</p>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <foo/>
	 * <node1/>
	 * <bar/>
	 * </code>
	 *
	 * @param Array|Object $data
	 * Associative array or Object containing markup.
	 * 
	 * @param String $selectorPattern
	 * Defines pattern matching target nodes. %k represents key.
	 * Defaults to ".%k", which matches nodes with class name equivalent to 
	 * data source key.
	 * For example, to restrict match to nodes with additional class "foo" change 
	 * $selectorPattern to ".foo.%k"
	 * 
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * 
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorReplace($data, $selectorPattern = '.%k', $skipKeys = null) {
		return $this->_valuesToSelector(true, $data, $selectorPattern, $skipKeys);
	}
	protected function _valuesToSelector($replace, $data, $selectorPattern, $skipKeys) {
		foreach($data as $k => $v) {
			if ($skipKeys && in_array($f, $skipKeys))
				continue;
			$selector = str_replace(array('%k'), array($k), $selectorPattern);
			if ($v instanceof Callback)
				$v = phpQuery::callbackRun($v);
			if ($replace)
				$this->find($selector)->replaceWith($v);
			else
				$this->find($selector)->markup($v);
		}
		return $this;
	}
	/**
	 * Wrap selected elements with PHP foreach loop iterating $varName.
	 *
	 * Method doesn't change selected elements stack. Returned is source element.
	 *
	 * Example
	 * <code>
	 * $pq['node1']->loop('foo', 'bar', 'i');
	 * </code>
	 *
	 * Source
	 * <node1/>
	 *
	 * Result
	 * <code>
	 * <?php
	 * foreach($foo as $i => $bar) {
	 * ?><node1/><?php
	 * }
	 * ?>
	 * </code>
	 *
	 * @param String $varName
	 * Variable which will be looped. Must contain $ at the beggining.
	 * @param String $asVarName
	 * Name of variable being result of iteration.
	 * @param String $keyName
	 * Optional. Use it when you want to have $varName's key available.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 */
	public function loop($varName, $asVarName, $keyName = null) {
		$this->_loop($this, $varName, $asVarName, $keyName);
		return $this;
	}
	/**
	 * Acts as loop(), but affects each selected element separately.
	 * 
	 * @param $varName
	 * @param $asVarName
	 * @param $keyName
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::loop()
	 */
	public function loopSeparate($varName, $asVarName, $keyName = null) {
		foreach($this->stack() as $node)
			$this->_loop($node, $varName, $asVarName, $keyName);
		return $this;
	}
	/**
	 * Remove (detach) all matched nodes besided first one and than wrap it with
	 * PHP foreach loop iterating $varName.
	 *
	 * Method DOES change selected elements stack. Returned is first element.
	 *
	 * Example
	 * <code>
	 * $template['ul li']->loopOne('foo', 'bar', 'i');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <ul>
	 *   <li>first</li>
	 *   <li>second</li>
	 * </ul>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <ul><?php
	 * foreach($foo as $i => $bar) {
	 * ?><li>first</li><?php
	 * }
	 * ?></ul>
	 * </code>
	 *
	 * Proposed names:
	 * - loopFirst
	 *
	 * @param String $varName
	 * Variable which will be looped. Must contain $ at the beggining.
	 * @param String $asVarName
	 * Name of variable being result of iteration.
	 * @param String $keyName
	 * Optional. Use it when you want to have $varName's key available.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::loop()
	 */
	public function loopOne($varName, $asVarName, $keyName = null) {
		$return = $this->eq(0);
		$this->slice(1)->remove();
		$this->_loop($return, $varName, $asVarName, $keyName);
		return $return;
	}
	protected function _loop($pq, $varName, $asVarName, $keyName) {
		$lang = strtoupper($this->parent->language);
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		$code = call_user_func_array(
			array($languageClass, 'loopVar'), array($varName, $asVarName, $keyName)
		);
		$pq->eq(0)->{"before$lang"}($code[0]);
		$pq->slice(-1, 1)->{"after$lang"}($code[1]);
	}
	/**
	 * Creates markup with INPUT tags and prepends it to form.
	 * If selected element isn't a FORM then find('form') is executed.
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * Example
	 * <code>
	 * $data = array('field1' => 'foo', 'field2' => 'bar');
	 * $template->inputsFromValues($data);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <form>
	 *   <input name='was-here-before'>
	 * </form>
	 * </code>
	 *
	 * Result
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
	 * Example
	 * <code>
	 * $data = array(
	 *   'input-example' => 'foo',
	 *   'array-example' => 'foo',
	 *   'textarea-example' => 'foo',
	 *   'select-example' => 'foo',
	 *   'radio-example' => 'foo',
	 *   'checkbox-example' => 'foo',
	 * );
	 * $template->varsToForm('data', $data);
	 * </code>
	 *
	 * Source
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
	 * Result
	 * <code>
	 * <form>
	 *   <input name='input-example' value='<?php print $data['input-example'] ?>'>
	 *   <input name='array[array-example]' value='<?php print $data['array-example'] ?>'>
	 *   <textarea name='textarea-example'><?php print $data['textarea-example'] ?></textarea>
   *   <select name='select-example'><?php
   *     if ($data['select-example'] == 'first')
   *       print "<option value='first' selected='selected'></option>";
	 *     else
   *       print "<option value='first'></option>";
	 *   ?></select>
	 *   <?php
   *     if ($data['radio-example'] == 'foo')
   *       print "<input type='radio' name='radio-example' checked='checked' value='foo'>";
   *     else
   *       print "<input type='radio' name='radio-example' value='foo'>";
   *   ?>
	 *   <?php
   *     if ($data['checkbox-example'] == 'foo')
   *       print "<input type='checkbox' name='checkbox-example' checked='checked' value='foo'>";
   *     else
   *       print "<input type='checkbox' name='checkbox-example' value='foo'>";
   *   ?>
	 * </form>
	 * </code>
	 *
	 * @param String $arrayName
	 * @param Array|Object $arrayValue
	 * @param String $selectorPattern
	 * Defines pattern matching form fields.
	 * Defaults to "[name*='%k']", which matches fields containing variable's key in 
	 * their names. For example, to match only names starting with "foo[bar]" change 
	 * $selectorPattern to "[name^='foo[bar]'][name*='%k']"
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @TODO support select[multiple] (thou array)
	 * 
	 * @TODO JS var notation (dot separated) +optional array support
	 */
	public function varsToForm($varName, $varValue, $selectorPattern = "[name*='%k']") {
		// determine if we have real values in $varValue or just list of fields
		if (is_array($varValue) && array_key_exists(0, $varValue))
			$loop = $varValue;
		else if (is_object($varValue) && isset($varValue->{'0'}))
			$loop = $varValue;
		else
			$loop = is_object($varValue)
				? get_class_vars(get_class($varValue))
				: array_keys($varValue);
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
	 * @param Array|Object $data
	 * @param String $selectorPattern
	 * Defines pattern matching form fields.
	 * Defaults to "[name*='%k'][name*='%k[]']", which matches fields containing 
	 * $data's key in their names. For example, to match only names starting with 
	 * "foo[bar]" change $selectorPattern to "[name^='foo[bar]'][name*='%k']"
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function valuesToForm($data, $selectorPattern = "[name*='%k']") {
		$form = $this->is('form')
			? $this->filter('form')
			: $this->find('form');
		// $arrayValue represents target data
		foreach($data as $f => $v) {
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
	 * Method formFromVars acts as form helper. It creates the form without the 
	 * need of suppling a line of markup. Created form have following features:
	 * - shows data from record (array or object)
	 * - shows errors
	 * - supports default values
	 * - supports radios and checkboxes
	 * - supports select elements with optgroups 
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
	 * array('row', 'errors.row', 'data');
	 * $errors = array(
	 *   'field1' => 'one error',
	 *   'field2' => array('first error', 'second error')
	 * );
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
	 * fieldName => array(
	 *   fieldType, {options}
	 * )
	 * Where {options} can be:
	 * - label
	 * - id
	 * - multiple (only select)
	 * - optgroups (only select)
	 * - values (only radio)
	 * Ex:
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
	 * 
	 * @param $additionalData
	 * Additional data for fields. For now it's only used for populating select boxes.
	 * Ex: 
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
	 * Input wrapper template.
	 * TODO support per field templates.
	 * 
	 * @param $selectors
	 * Array of selectors indexed by it's type. Allows to customize lookups inside 
	 * inputs wrapper. Possible values are: 
	 * - error (default: .errors)
	 * - label // TODO
	 * - input (per field) // TODO
	 * 
	 * @return QueryTemplatesParse
	 * 
	 * @TODO support callbacks (per input type, before/after, maybe for errors too ?)
	 * @TODO universalize language-specific injects
	 */
	function formFromVars($varNames, $structure, $defaults = null, $additionalData = null, $template = null, $selectors = null) {
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
  <label for=""></label>
  <input type=""/>
  <ul class="errors">
    <li>error message</li>
  </ul>
</div>
EOF;
		else if (! $template && ! $varErrors)
			$template = <<<EOF
<div class="input">
  <label for=""></label>
  <input type=""/>
</div>
EOF;
		// setup $selectors
		if (! isset($selectors))
			$selectors = array();
		$selectors = array_merge(array(
			'errors' => '.errors',
		), $selectors);
		// setup lang stuff
		$lang = strtoupper($this->parent->language);
		$languageClass = 'QueryTemplatesLanguage'.$lang;
		// setup markup
		$template = $this->newInstance($template);
		$form = $this->is('form')
			? $this->filter('form')->empty()
			: $this->newInstance('<form/>');
		$formID = $form->attr('id');
		if (! $formID) {
			$formID = 'f_'.substr(md5(microtime()), 0, 5);
			$form->attr('id', $formID);
		}
		foreach($structure as $field => $info) {
			if ($field == '__form') {
				foreach($info as $attr => $value)
					$form->attr($attr, $value);
				$attr = $value = null;
				continue;
			}
			if (! is_array($info))
				$info = array($info);
			$id = isset($info['id'])
				? $info['id']
				: "{$formID}_{$field}";
			$markup = $template->clone();
			switch($info[0]) {
				// TEXTAREA
				case 'textarea':
					// TODO
					$input = $this->newInstance("<textarea></textarea>")
						->attr('id', $id);
					$markup['input:first']->replaceWith($input);
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
					$markup['label:fist']->attr('for', $id);
					break;
				// SELECT
				case 'select':
					$input = $this->newInstance("<select name='$field'/>");
					// TODO multiple
					$markup['input:first']->replaceWith($input);
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
					$markup['label:fist']->attr('for', $id);
					break;
				// RADIO
				case 'radio':
					if (! $info['values'])
						throw new Exception("'values' property needed for radio inputs");
					$inputs = array();
					$input = $markup['input:first']->
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
					$markup['label:fist']->removeAttr('for');
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
					$markup = $template->clone();
					if (! isset($info[0]))
						$info[0] = 'text';
					$input = $markup['input:first']->
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
					$markup['label:fist']->attr('for', $id);
					$code = null;
					break;
			}
			if ($markup) {
				$markup->addClass($info[0]);
				// label
				$label = isset($info['label'])
					? $info['label'] : ucfirst($field);
				$markup['label:fist'] = $label;
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
							loopOne("$varErrors.$field", 'error')->
								varPrint('error');
					$_varName = null;
				}
				$form->append($markup);
			}
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
	 * Example
	 * <code>
	 * $data = array('foo' => 'bar', 'bar' => 'foo');
	 * $template['node1']->valuesToVars($data);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <node1>
   *   <?php
	 *   $foo = 'bar';
	 *   $bar = 'foo';
	 *   ?>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * @param array $varsArray
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function valuesToVars($varsArray) {
		return $this->qt_langMethod('prepend', 
			$this->qt_langCode('valuesToVars', $varsArray)
		);
	}
	/**
	 * Replaces nodes from stack with $markup using replaceWith() insted of markup().
	 *
	 * Method doesn't change selected elements stack. Returned is source element,
	 * detached from it's parent.
	 *
	 * Example
	 * <code>
	 * $markups = array('<foo/>', '<bar/>');
	 * $template['node1']->markupToStackOuter($markups);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * Result
	 * <code>
   * <foo/>
   * <bar/>
	 * </code>
	 *
	 * @param Array|String|phpQueryObject $markup
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function valuesToStackReplace($markup) {
		if (! is_array($markup) && !($markup instanceof Iterator)) {
			$this->replaceWith($v);
		} else {
			$i = 0;
			foreach($markup as $v)
				$this->eq($i)->replaceWith($v);
		}
		return $this;
	}
	/**
	 * Replaces nodes from stack with $markup using markup() insted of replaceWith().
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * Example
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * $template['node1']->valuesToStack($values);
	 * </code>
	 *
	 * Source
	 * <code>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * <node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <node1>
   *   <foo/>
	 * </node1>
	 * <node1>
   *   <bar/>
	 * </node1>
	 * </code>
	 *
	 * @param Array|String|phpQueryObject $markup
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function valuesToStack($markup) {
		if (! is_array($markup) && !($markup instanceof Iterator)) {
			$this->markup($v);
		} else {
			$i = 0;
			foreach($markup as $v)
				$this->eq($i++)->markup($v);
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
	 * Method doesn't change selected elements stack. Returned is source element,
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
	 * to true. $var must be an object available inside template's scope.
	 * 
	 * $var is passed in JS object convention (dot separated).
	 *
	 * Method doesn't change selected elements stack. Returned is source element,
	 * detached from it's parent.
	 *
	 * Notice-safe.
	 *
	 * Example
	 * <code>
	 * $template['.if-var']->tagToIfVar('foo.bar');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <div class='if-var'><node1/></div>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * if ($foo->bar) {
	 * ?><node1/><?php
	 * }
	 * ?>
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
	 * Replaces selected tag with PHP "else if" statement containing $code as condition.
	 *
	 * Method doesn't change selected elements stack. Returned is source element,
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
	 * to true. $var must be an object available inside template's scope.
	 * 
	 * $var is passed in JS object convention (dot separated).
	 *
	 * Method doesn't change selected elements stack. Returned is source element,
	 * detached from it's parent.
	 *
	 * Notice-safe.
	 *
	 * Example
	 * <code>
	 * $template['.else-if-var']->tagToElseIfVar('foo.bar');
	 * </code>
	 *
	 * Source
	 * <code>
	 * <div class='else-if-var'><node1/></div>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * else if ($foo->bar) {
	 * ?><node1/><?php
	 * }
	 * ?>
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
	 * Replaces selected tag with PHP "else" statement.
	 *
	 * Method doesn't change selected elements stack. Returned is source element,
	 * detached from it's parent.
	 *
	 * Example
	 * <code>
	 * $template['.else']->tagToElsePHP();
	 * </code>
	 *
	 * Source
	 * <code>
	 * <div class='else'><node1/></div>
	 * </code>
	 *
	 * Result
	 * <code>
	 * <?php
	 * else {
	 * ?><node1/><?php
	 * }
	 * ?>
	 * </code>
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function tagToElsePHP() {
		return $this->_tagToElse('php');
	}
	public function _tagToElse($lang) {
		$lang = strtoupper($lang);
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
			->{"else$lang"}()
			->contents()
				->appendTo($node)->end()
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
	 * Method doesn't change selected elements stack. Returned is source element.
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
	 * to true. $var must be an object available inside template's scope.
	 * 
	 * $var is passed in JS object convention (dot separated).
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected elements stack. Returned is source element.
	 *
	 * Notice-safe.
	 *
	 * Example
	 * <code>
	 * $template['node1']->ifVar('foo.bar.1');
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
	 * if ($foo->bar->{1}) {
	 * ?><node/><?php
	 * }
	 * ?>
	 * </code>
	 *
	 * @param string $var
	 * Dot-separated object path, eg Object.property.inneProperty
	 * @param bool $separate
	 * Determines if selected elements should be wrapped together or one-by-one
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::tagToIfVar()
	 */
	public function ifVar($var, $separate = false) {
		$method = $separate
			? 'wrap' : 'wrapAll';
		$code = $this->qt_langCode('ifVar', $var);
		$this->qt_langMethod($method, $code[0], $code[1]);
		return $this;
	}
	/**
	 * TODO
	 * @param $var
	 * @param $separate
	 * @return unknown_type
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
	 * Method doesn't change selected elements stack. Returned is source element.
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
	 * to true. $var must be an object available inside template's scope.
	 * 
	 * $var is passed in JS object convention (dot separated).
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected elements stack. Returned is source element.
	 *
	 * Notice-safe.
	 *
	 * Example
	 * <code>
	 * $template['node1']->elseIfVar('foo.bar.1');
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
	 * else if ($foo->bar->{1}) {
	 * ?>
	 * <node/>
	 * <?php } ?>
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
		$this->qt_langMethod($code[0], $code[1]);
		return $this;
	}
	/**
	 * TODO description
	 * @param $var
	 * @param $separate
	 * @return unknown_type
	 */
	public function elseIfNotVar($var, $separate = false) {
		$method = $separate
			? 'wrap' : 'wrapAll';
		$code = $this->qt_langCode('elseIfNotVar', $var);
		$this->qt_langMethod($code[0], $code[1]);
		return $this;
	}
	/**
	 * Wraps selected tag with PHP "else" statement.
	 * 
	 * Optional $separate parameter determines if selected elements should be
	 * wrapped together or one-by-one. This is usefull when stack contains non-sibling
	 * nodes.
	 *
	 * Method doesn't change selected elements stack. Returned is source element.
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
	 * $lang = strtoupper($this->parent->language);
		$languageClass = 'QueryTemplatesLanguage'.$lang;
	 * @param $lang
	 * @param $separate
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
	 * @return unknown_type
	 */
	public function onlyPHP() {
		return strtolower($this->qt_lang()) == 'php'
			? $this : new QueryTemplatesVoid($this, 'endOnly');
	}
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
	 * @param unknown_type $name
	 * TODO user self::parent for storing vars
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
	 * TODO user self::parent for storing vars
	 */
	public function saveTextAsVar($name) {
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