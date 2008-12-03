<?php
/**
 * Class extending phpQueryObject with templating methods.
 * 
 * @abstract
 * @package QueryTemplates
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/querytemplates/
 * 
 * @TODO safe variable interactions (if isset), as option
 */
abstract class QueryTemplatesPhpQuery
	extends phpQueryObject {
	/**
	 * Injects PHP code printing $varName's content (rows or attributes) into nodes
	 * matched by selector.
	 * 
	 * For replacing matched nodes with content use varsToSelectorReplace().
	 * For injecting vars into forms use varsToForm().
	 *
	 * Example
	 * <code>
	 * $foo = array('field1' => 'foo', 'field2' => 'bar');
	 * // notice single quotes
	 * $template->varsToSelector('$foo', $foo);
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
	 * Variable avaible in scope of type Array or Object. $varName should start with $.
	 * @param Array|Object $varValue
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * @param String $selectorPattern
	 * By default it's class selector, where $varName's key (field) is a class name.
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::varsToSelectorReplace()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 *
	 * @TODO support $arrayName to be a function (last char == ')'), 
	 * then prepend \$$var = $arrayName
	 */
	public function varsToSelector($varName, $varValue, $selectorPattern = '.%k', $skipKeys = null) {
		return $this->_varsToSelector(false, $varName, $varValue, $selectorPattern, $skipKeys);
	}
	/**
	 * Injects PHP code printing $varName's content (rows or attributes) into 
	 * document replacing nodes matched by selector.
	 * 
	 * For injecting vars inside matched nodes use varsToSelectorReplace().
	 * For injecting vars into forms use varsToForm().
	 *
	 * Example
	 * <code>
	 * $foo = array('field1' => 'foo', 'field2' => 'bar');
	 * // notice single quotes
	 * $template->varsToSelector('$foo', $foo);
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
	 * Variable avaible in scope of type Array or Object. $varName should start with $.
	 * @param Array|Object $varValue
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * @param String $selectorPattern
	 * By default it's class selector, where $varName's key (field) is a class name.
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
	public function varsToSelectorReplace($varName, $varValue, $selectorPattern = '.%k', $skipKeys = null) {
		return $this->_varsToSelector(true, $varName, $varValue, $selectorPattern, $skipKeys);
	}
	protected function _varsToSelector($replace, $varName, $varValue, $selectorPattern, $skipKeys) {
		// determine if we have real values in $varValue or just list of fields
		if (is_array($varValue) && array_key_exists(0, $varValue))
			$loop = $varValue;
		else if (is_object($varValue) && isset($varValue->{'0'}))
			$loop = $varValue;
		else
			$loop = is_object($varValue)
				? get_class_vars(get_class($varValue))
				: array_keys($varValue);
		foreach($loop as $f) {
			if ($skipKeys && in_array($f, $skipKeys))
				continue;
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
			if ($replace)
				$this->find($selector)
					->replaceWith(phpQuery::php(
						"print is_object({$varName})
							? {$varName}->{$f}
							: {$varName}['{$f}']
					"));
			else
				$this->find($selector)
					->php("print is_object({$varName})
						? {$varName}->{$f}
						: {$varName}['{$f}']
					");
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
	 * $template['node1']->varsToStack('$values', $values);
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
	 * Variable avaible in scope of type Array or Object. $varName should start with $.
	 * @param Array|Object $varValue
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStackReplace()
	 */
	public function varsToStack($varName, $varValue, $skipKeys = null) {
		return $this->_varsToStack(false, $varName, $varValue, $skipKeys);
	}
	/**
	 * Replaces nodes from stack with $markup using replaceWith() insted of markup().
	 *
	 * Method doesn't change selected elements stack.
	 *
	 * Example
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * $template['node1']->varsToStackReplace('$values', $values);
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
	 * Variable avaible in scope of type Array or Object. $varName should start with $.
	 * @param Array|Object $varValue
	 * $varName's value with all keys (fields) OR array of $varName's keys (fields).
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 *
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @see QueryTemplatesPhpQuery::varsToStac()
	 */
	public function varsToStackReplace($varName, $varValue, $skipKeys = null) {
		return $this->_varsToStack(true, $varName, $varValue, $skipKeys);
	}
	protected function _varsToStack($replace, $varName, $varValue, $skipKeys = null) {
		// determine if we have real values in $varValue or just list of fields
		if (is_array($varValue) && array_key_exists(0, $varValue))
			$loop = $varValue;
		else if (is_object($varValue) && isset($varValue->{'0'}))
			$loop = $varValue;
		else
			$loop = is_object($varValue)
				? get_class_vars(get_class($varValue))
				: array_keys($varValue);
		$i = 0;
		foreach($loop as $f) {
			if ($skipKeys && in_array($f, $skipKeys))
				continue;
			if ($replace)
				$this->eq($i++)->replaceWith(phpQuery::php(
						"print is_object({$varName})
							? {$varName}->{$f}
							: {$varName}['{$f}']
					"));
			else
				$this->eq($i++)->php("print is_object({$varName})
						? {$varName}->{$f}
						: {$varName}['{$f}']
					");
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
	 * $values = array('<foo/>', '<bar/>');
	 * // notice single quotes
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
	 * By default it's class selector, where $data's key (field) is a class name.
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
	 * Injects markup from $data's content (rows or attributes) into document 
	 * replacing nodes matched by selector.
	 * 
	 * For injecting markup inside matched nodes use valuesToSelector().
	 * For injecting values into forms use valuesToForm().
	 *
	 * Example
	 * <code>
	 * $values = array('<foo/>', '<bar/>');
	 * // notice single quotes
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
	 * @param String $selectorPattern
	 * By default it's class selector, where $data's key (field) is a class name.
	 * @param Array $skipKeys
	 * Array of keys from $varValue which should be skipped.
	 * 
	 * @return QueryTemplatesPhpQuery|QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToSelector()
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 */
	public function valuesToSelectorReplace($data, $selectorPattern = '.%k', $skipKeys = null) {
		return $this->_valuesToSelector(true, $data, $selectorPattern, $skipKeys);
	}
	protected function _valuesToSelector($replace, $data, $selectorPattern, $skipKeys) {
		$isObject = is_object($data);
		foreach($data as $k => $f) {
			if ($skipKeys && in_array($f, $skipKeys))
				continue;
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
			if ($replace)
				$this->find($selector)
					->replaceWith(phpQuery::php($isObject
						? "print {$varName}->{$f}"
						: "print {$varName}['{$f}']"
					));
			else
				$this->find($selector)
					->php($isObject
						? "print {$varName}->{$f}"
						: "print {$varName}['{$f}']"
					);
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
	 * $pq['node1']->loop('$foo', '$bar', '$i');
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
	 * 
	 * @param $varName
	 * @param $asVarName
	 * @param $keyName
	 * @return unknown_type
	 * @todo
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
	 * $template['ul li']->loopOne('$foo', '$bar', '$i');
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
		$as = $keyName
			? "{$asVarName} => {$keyName}"
			: $asVarName;
		$pq->eq(0)->beforePHP("foreach({$varName} as {$as}):");
		$pq->slice(-1, 1)->afterPHP("endforeach;");
	}
	/**
	 * Creates markup with INPUT tags and prepends it to form.
	 * If selected element isn't a FORM than find('form') is executed.
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
			? $self->filter('form')
			: $self->find('form');
		if ($form->find('fieldset')->size())
			$form = $form->find('fieldset:first');
		$data = array_reverse($data);
		foreach($data as $field => $value) {
			$form->prepend("<input name='$field' value='$value' type='$type'>");
		}
		return $this;
	}
	/**
	 * Injects PHP code printing $arrayName's keys into form inputs.
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
	 * // notice single quotes
	 * $template->varsToForm('$data', $data);
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
   *       print "<input type='radio' name='radio-example' checked='checked'>";
   *     else
   *       print "<input type='radio' name='radio-example'>";
   *   ?>
	 *   <?php
   *     if ($data['checkbox-example'] == 'foo')
   *       print "<input type='checkbox' name='checkbox-example' checked='checked'>";
   *     else
   *       print "<input type='checkbox' name='checkbox-example'>";
   *   ?>
	 * </form>
	 * </code>
	 *
	 * @param String $arrayName
	 * @param Array|Object $arrayValue
	 * @param String $selectorPattern
	 * Defaults to name attribute containing variable's key.
	 * 
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 * @TODO support select[multiple] (thou array)
	 */
	public function varsToForm($varName, $varValue, $selectorPattern = "[name*='%k']") {
		// determine if we have real values in $varValue or just list of fields
		if (is_array($varValue) && array_key_exists(0, $varValue))
			$loop = $varValue;
		else if (is_object($varValue) && isset($varValue->{'0'}))
			$loop = $varValue;
		else
			// TODO support objects
			$loop = array_keys($varValue);
		foreach($loop as $f) {
			$code = "print is_object($varName)
					? {$varName}->$f
					: {$varName}['$f']";
			// TODO addslashes
			$selector = str_replace(array('%k'), array($f), $selectorPattern);
			// texts, hiddens, passwords
			$this->find("input$selector:not(:radio, :checkbox)")->attrPHP('value', $code);
			// textareas
			$this->find("textarea$selector")->php($code);
			// radios, checkboxes
			$inputs = $this->find("input$selector:radio, input$selector:checkbox");
			foreach($inputs as $input) {
//				$input = pq($input, $this->getDocumentID());
				$clone = $input->clone()->insertAfter($input);
				// TODO addslashes needed
				$code = "(is_object($varName) && {$varName}->{'$f'} == '".$input->attr('value')."')
					|| (! is_object($varName) && {$varName}['$f'] == '".$input->attr('value')."')";
//				$input->attr('checked', 'checked')->ifPHP($code, true);
				$input->attr('checked', 'checked')->ifPHP($code);
				// FIXME!!!
				$clone->removeAttr('checked')->elsePHP();
			}
			// selects
			$select = $this->find("select$selector");
			if ($select->length) {
				foreach($select['option'] as $option) {
					$option = pq($option, $this->getDocumentID());
					$clone = $option->clone()->insertAfter($option);
					// TODO addslashes needed
					$code = "(is_object($varName) && {$varName}->{'$f'} == '".$option->attr('value')."')
						|| (! is_object($varName) && {$varName}['$f'] == '".$option->attr('value')."')";
					$option->attr('selected', 'selected')->ifPHP($code, true);
					$clone->removeAttr('selected')->elsePHP();
				}
			}
		}
		return $this;
	}
	/**
	 * Toggles form fields selection states. This means radio checked, checkbox
	 * checked, select selected and
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
	 * @param $data
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
	 * Behaves as var_export, dumps variables from $varsArray as $key = value for
	 * later use during template execution.
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
   * <?php
	 * $foo = 'bar';
	 * $bar = 'foo';
	 * ?><node1>
	 *   <node2/>
	 * </node1>
	 * </code>
	 *
	 * @param array $varsArray
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function valuesToVars($varsArray) {
		$lines = array();
		foreach($varsArray as $var => $value) {
			$lines[] = "\$$var = ".var_export($value, true);
		}
		$this->prependPHP(
			implode(";\n", $lines)
		);
		return $this;
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
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->ifPHP($code)
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
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
				->elseIfVar($code)
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
		foreach($this as $node) {
			$node = pq($node, $this->getDocumentID())
			->elsePHP()
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
		$method = $separate
			? 'wrapPHP'
			: 'wrapAllPHP';
		$this->$method("if ($code) {", "}");
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
			? 'wrapPHP'
			: 'wrapAllPHP';
		$varName = implode('->', explode('.', $var));
		$this->$method("if (isset($varName) && $varName) {", "}");
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
		$method = $separate
			? 'wrapPHP'
			: 'wrapAllPHP';
		$this->$method("else if ($code) {", "}");
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
			? 'wrapPHP'
			: 'wrapAllPHP';
		$varName = implode('->', explode('.', $var));
		$this->$method("else if (isset($varName) && $varName) {", "}");
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
		return $separate
			? $this
				->filter(':first')->beforePHP('else {')->end
				->filter(':last')->afterPHP('}')->end()
			: $this
				->beforePHP('else {')
				->afterPHP('}');
	}
	/**
	 * @see phpQueryObject::_clone()
	 * @return QueryTemplatesParse|QueryTemplatesPhpQuery
	 */
	public function _clone() {
		// TODO clone also $this->parent ?
		return parent::_clone();
	}
}