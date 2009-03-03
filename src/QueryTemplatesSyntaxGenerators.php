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
class QueryTemplatesSyntaxGenerators extends QueryTemplatesSyntaxConditions {
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
	 *
	 * @param $record
	 * @param $structure
	 * @param $errors
	 * @param $defaults
	 * @param $defaultData
	 * @param $template
	 * @param $selectors
	 * @param $fieldCallback
	 * @return unknown_type
	 */
	function formFromValues($record, $structure, $errors = null, $defaults = null, $defaultData = null,
		$template = null, $selectors = null, $fieldCallback = null) {
		// setup $template
		if (! $template && ! is_null($errors))
			$template = <<<EOF
<div class="input">
  <label/>
  <input/>
  <ul class="errors">
    <li/>
  </ul>
</div>
EOF;
		else if (! $template && is_null($errors))
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

			}
		}
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
	 *   Overloads $defaultData during template's execution.
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
	 * 	'field2' => array('value2', 'dadas', 'fsdsf'),
	 * );
	 * </code>
	 *
	 * @param $defaultData
	 * Additional data for fields. For now it's only used for populating select boxes.
	 * Example:
	 * <code>
	 * $defaultData = array(
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
	 * Callback triggered after preparation of each field.
	 *
	 * @return QueryTemplatesParse
	 * @see QueryTemplatesPhpQuery::valuesToForm()
	 * @see QueryTemplatesPhpQuery::varsToForm()
	 *
	 * @TODO maybe support callbacks (per input type, before/after, maybe for errors too ?)
	 * @TODO record, data, structure, defaultRecord, defaultData
	 */
	function formFromVars($varNames, $structure, $defaultRecord = null, $defaultData = null,
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
		if ($varErrors)
			$defaultTemplate = <<<EOF
<div class="input">
  <label/>
  <input/>
  <ul class="errors">
    <li/>
  </ul>
</div>
EOF;
		else
			$defaultTemplate = <<<EOF
<div class="input">
  <label/>
  <input/>
</div>
EOF;
		if (is_array($template))
			$template = $defaultTemplate;
		else if (! is_array($template) && ! $template['__default'])
			$template['__default'] = $defaultTemplate;
		// setup $selectors
		if (! isset($selectors))
			$selectors = array();
		$selectors = array_merge(array(
			'errors' => '.errors',
			'input' => 'input:first',
			'label' => 'label:first',
		), $selectors);
		// setup lang stuff
//		$lang = strtoupper($this->parent->language);
//		$languageClass = 'QueryTemplatesLanguage'.$lang;
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
			if (is_string($fieldsetFields['__label'])) {
				$fieldset->append("<legend>{$fieldsetFields['__label']}</legend>");
				unset($fieldsetFields['__label']);
			}
			foreach($fieldsetFields as $field => $info) {
				if (! is_array($info))
					$info = array($info);
				$id = isset($info['id'])
					? $info['id']
					: "{$formID}_{$field}";
				if (is_array($template)) {
					if (isset($template[$field])) {
						$markup = $template[$field];
					} else if (isset($template['__default'])) {
						$markup = $template['__default'];
					}
//					else {
//						throw new Exception("No $selectorType selector for field $field. Provide "
//							."default one or one selector for all fields");
//					}
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
						$input = $this->newInstance("<textarea></textarea>")
							->attr('id', $id);
						$markup[$inputSelector]->replaceWith($input);
						if (isset($defaultRecord[$field])) {
							$input->qt_langMethod('markup',
								self::formFromVars_CodeValue($this, compact(
									'input', 'field', 'defaultRecord', 'varRecord'
								))
							);
						} else {
							$input->qt_langMethod('markup',
								$input->qt_langCode('printVar', "$varRecord.$field")
							);
						}
						$markup[$labelSelector]->attr('for', $id);
						break;
					// SELECT
					case 'select':
						if (! isset($defaultData[$field]) && ! $varData)
							throw new Exception("\$defaultData['$field'] or \$varNames[2] should be present to "
								."populate select element. Otherwise remove \$structure['$field'].");
						$input = $this->newInstance("<select name='$field'/>");
						$markup[$inputSelector]->replaceWith($input);
						if (isset($info['multiple'])) {
							$input->attr('multiple', true);
						} else {
							$info['multiple'] = false;
						}
						// setup var names
						$varNameRecordAPHP = QueryTemplatesLanguage::get('php',
							'varNameArray', "$varRecord.$field"
						);
						$varNameRecordOPHP = QueryTemplatesLanguage::get('php',
							'varNameObject', "$varRecord.$field"
						);
						$varNameRecordJS = QueryTemplatesLanguage::get('js',
							'varName', "$varRecord.$field"
						);
						$varNameDataAPHP = QueryTemplatesLanguage::get('php',
							'varNameArray', "$varData.$field"
						);
						$varNameDataOPHP = QueryTemplatesLanguage::get('php',
							'varNameObject', "$varData.$field"
						);
						$varNameDataJS = QueryTemplatesLanguage::get('js',
							'varName', "$varData.$field"
						);
						// default_default and record_default callback
						if (! function_exists('optionDefault_34fsdfas23das')) {
						function optionDefault_34fsdfas23das($self, $scope) {
							$self->removeAttr('selected');
							extract($scope);
							if ($useRecord) {
								$unselected = $self->clone();
								$self->
									after($unselected)->
									attr('selected', 'selected')->
									ifCode($self->qt_langCode(
										'compareVarValue', "$varRecord.$field", $self->attr('value')
									))
								;
								$unselected->elseStatement();
							} else {
								if ($defaultRecord[$field] == $self->attr('value'))
									$self->attr('selected', 'selected');
							}
						}}
						$optionDefaultCallback = new Callback('optionDefault_34fsdfas23das');
						// default_default and record_default callback
						if (! function_exists('loop_90qwnby8sgddasju')) {
						function loop_90qwnby8sgddasju($useRecord, $scope, $rowData, $nodes, $rowIndex) {
							extract($scope);
							$scope['useRecord'] = $useRecord;
							// optgroup
							if (is_array($rowData)) {
								$label = isset($rowData['__label'])
									? $rowData['__label'] : '';
								$nodes->
									filter('option')->remove()->end()->
									filter('optgroup')->
										attr('label', $label)->
										find('option')->
											valuesToLoop($rowData, new CallbackBody('$scope, $data, $node, $index', "
												extract(\$scope);
												if (\$index == '__label')
													return;
												\$node->
													filter('option')->
														attr('value', \$index)->
														markup(\$data)->
														callback(\$optionDefaultCallback, \$scope)->
													end()
											", $scope, new CallbackParam, new CallbackParam, new CallbackParam
											), '>option:last')->
										end()->
									end()
								;
							// single option
							} else {
								$nodes->
									filter('optgroup')->remove()->end()->
									filter('option')->
										attr('value', $rowIndex)->
										markup($rowData)->
										callback($optionDefaultCallback, $scope)->
									end()
								;
							}
						}}
						// setup callbacks for default_default and record_default
						$scope = compact('defaultData', 'defaultRecord', 'varRecord', 'varData', 'field', 'optionDefaultCallback');
						$loopDefaultCallback = new Callback('loop_90qwnby8sgddasju',
							false, $scope, new CallbackParam, new CallbackParam, new CallbackParam
						);
						$loopRecordCallback = new Callback('loop_90qwnby8sgddasju',
							true, $scope, new CallbackParam, new CallbackParam, new CallbackParam
						);
						// setup callbacks for default_data and record_data
						if (! function_exists('optionDefaultData_7d12kajs78ascnb2')) {
						function optionDefaultData_7d12kajs78ascnb2($self, $scope) {
							extract($scope);
							$unselected = $self->removeAttr('selected')->clone();
							$self->
								after($unselected)->
								ifCode($self->qt_langCode(
									'compareVarValue', "$varRecord.$field", $defaultRecord[$field]
								))->
								attr('selected', 'selected')
							;
							$unselected->elseStatement();
						}}
						$optionDefaultDataCallback = new Callback('optionDefaultData_7d12kajs78ascnb2',
							new CallbackParam, compact('varRecord', 'field', 'defaultRecord')
						);
						if (! function_exists('optionRecordData_6434fwfa')) {
						function optionRecordData_6434fwfa($self, $scope) {
							extract($scope);
							$unselected = $self->removeAttr('selected')->clone();
							$self->
								after($unselected)->
								ifCode($self->qt_langCode(
									'compareVarVar', "$varRecord.$field", 'value'
								))->
								attr('selected', 'selected')
							;
							$unselected->elseStatement();
						}}
						$optionRecordDataCallback = new Callback('optionRecordData_6434fwfa',
							new CallbackParam, compact('varRecord', 'field', 'defaultRecord')
						);
						// create templates
						$optionTemplate = $this->newInstance("<optgroup><option/></optgroup><option/>");
						$template = array(
							'default_default' => $optionTemplate->clone(),
							'record_default' => $optionTemplate->clone(),
							'default_data' => $optionTemplate->clone(),
							'record_data' => $optionTemplate->clone(),
						);
						foreach($template as $optionTemplate) {
							$input->append($optionTemplate);
						}
						// apply conditions
						if (isset($defaultData[$field])) {
							$conditionDataPHP = $varData
								? " && ! isset($varNameDataOPHP) && ! isset($varNameDataAPHP)" : '';
							$conditionDataJS = $varData
								? " && typeof $varNameDataJS == 'undefined'" : '';
							$template['default_default']->
								onlyPHP()->
									ifPHP("! isset($varNameRecordAPHP) && ! isset($varNameRecordOPHP)$conditionDataPHP")->
								endOnly()->
								onlyJS()->
									ifJS("typeof $varNameRecordJS == 'undefined'$conditionDataJS")->
								endOnly()
							;
							$template['record_default']->
								onlyPHP()->
									ifPHP("(isset($varNameRecordAPHP) || isset($varNameRecordOPHP))$conditionDataPHP")->
								endOnly()->
								onlyJS()->
									ifJS("typeof $varNameRecordJS != 'undefined'$conditionDataJS")->
								endOnly()
							;
						}
						if ($varData) {
							$template['default_data']->
								onlyPHP()->
									ifPHP("! isset($varNameRecordAPHP) && ! isset($varNameRecordOPHP)
										&& (isset($varNameDataOPHP) || isset($varNameDataAPHP))")->
								endOnly()->
								onlyJS()->
									ifJS("typeof $varNameRecordJS == 'undefined'
										&& typeof $varNameDataJS != 'undefined'")->
								endOnly()
							;
							$template['record_data']->
								onlyPHP()->
									ifPHP("(isset($varNameRecordAPHP) || isset($varNameRecordOPHP))
										&& (isset($varNameDataOPHP) || isset($varNameDataAPHP))")->
								endOnly()->
								onlyJS()->
									ifJS("typeof $varNameRecordJS != 'undefined'
										&& typeof $varNameDataJS != 'undefined'")->
								endOnly()
							;
						}
						// loop values & inject code
						if (isset($defaultData[$field])) {
							$loopTargets = array(
								'default_default' => $input['>php:eq(1), >js:eq(1)'],
								'record_default' => $input['>php:eq(3), >js:eq(3)'],
							);
							$template['default_default']->
								valuesToLoopBefore($defaultData[$field], $loopDefaultCallback, $loopTargets['default_default'])
							;
							$template['record_default']->
								valuesToLoopBefore($defaultData[$field], $loopRecordCallback, $loopTargets['record_default'])
							;
						}
						if ($varData) {
							foreach(array('default_data', 'record_data') as $templateType) {
	 							$template[$templateType]->
									varsToLoop("$varData.$field", 'label', 'value')->
									filter('optgroup')->
										onlyPHP()->
											// if it's an optgroup
											// TODO dedicated method
											ifPHP('is_array("$value")')->
											// TODO support objects
											// TODO dedicated method
											attrPHP('label', "print isset({$varNameRecordAPHP}[\$value]['__label'])
												? {$varNameRecordAPHP}[\$value]['__label'] : ''")->
										endOnly()->
										onlyJS()->
											// if it's an optgroup
											// TODO dedicated method
											ifJS('typeof value == "object"')->
											attrJS('label', "print(typeof {$varNameRecordJS}[value]['__label'] != 'undefined'
												? {$varNameRecordJS}[value]['__label'] : ''")->
										endOnly()->
		//								varPrintAttr('label', "$varData.$field")->
										find('option')->
											varsToLoop('label', '_label', '_value')->
											// TODO dedicated method
											onlyPHP()->
												beforePHP('if ($_value == "__label") continue;')->
											endOnly()->
											onlyJS()->
												beforeJS('if (_value == "__label") continue;')->
											endOnly()->
											varPrintAttr('value', '_value')->
											varPrint('_label')->
											callback($templateType == 'default_data'
												? $optionDefaultDataCallback : $optionRecordDataCallback)->
										end()->
									end()->
									filter('option')->
										varPrintAttr('value', 'value')->
										varPrint('label')->
										// if not an optgroup
										elseStatement()->
										callback($templateType == 'default_data'
											? $optionDefaultDataCallback : $optionRecordDataCallback)->
									end()
	 							;
							}
						}
						// unset used vars
						$template = $templateType = $optionRecordDataCallback =
							$scope = $loopDefaultCallback = $loopRecordCallback = 
							$optionTemplate = $conditionDataPHP = $conditionDataJS = 
							$optionDefaultDataCallback = $optionRecordDataCallback = 
							$varNameRecordAPHP = $varNameRecordOPHP = $varNameRecordJS =
							$varNameDataAPHP = $varNameDataOPHP = $varNameDataJS = 
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
						if (isset($defaultRecord[$field])) {
							phpQuery::pq($inputs)->clone()->
								insertBefore($inputs->eq(0))->
								filter("[value='{$defaultRecord[$field]}']")->
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
							$input->attr('checked', 'checked')->qt_langMethod('if', $code);
							$clone->removeAttr('checked')->qt_langMethod('else');
						}
						$inputs = null;
						$markup[$labelSelector]->removeAttr('for');
						break;
					// HIDDEN
					case 'hidden':
						$markup = null;
						$input = $this->newInstance('<input/>')->
							attr('type', 'hidden')->
							attr('name', $field)->
							attr('id', $id);
						$target = $form['fieldset']->length
							? $form['fieldset:first']
							: $form;
						$code = isset($defaultRecord[$field])
							? self::formFromVars_CodeValue($this, compact(
									'input', 'field', 'defaultRecord', 'varRecord'
								))
							: $input->qt_langCode('printVar', "$varRecord.$field");
						$input->qt_langMethod('attr', 'value', $code);
						$target->prepend($input);
						$target = $code = null;
						break;
					// TEXT, PASSWORD, others
					default:
//						$markup = $template->clone();
						if (! isset($info[0]))
							$info[0] = 'text';
						$input = $markup[$inputSelector]->
							attr('type', $info[0])->
							attr('name', $field)->
							attr('id', $id)->
							removeAttr('checked');
						$code = isset($defaultRecord[$field])
							? self::formFromVars_CodeValue($this, compact(
									'input', 'field', 'defaultRecord', 'varRecord'
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
						$varNamePHP = QueryTemplatesLanguage::get('php',
							'varNameArray', "$varErrors.$field"
						);
						$varNameJS = QueryTemplatesLanguage::get('js',
							'varName', "$varErrors.$field"
						);
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
						$varNamePHP = $varNameJS = null;
					}
					if ($fieldCallback)
						phpQuery::callbackRun($fieldCallback, array($markup));
					$fieldset->append($markup);
				}
			}
			$form->append($fieldset);
		}
		$input = $code = null;
		$this->append($form);
		return $this;
	}
	protected static function formFromVars_CodeValue($self, $scope) {
		extract($scope);
		$code = array(
			'if' => $self->qt_langCode('ifVar', "$varRecord.$field"),
			'printVar' => $self->qt_langCode('printVar', "$varRecord.$field"),
			'else' => $self->qt_langCode('elseStatement'),
			'printValue' => $self->qt_langCode('printValue', $defaultRecord[$field]),
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
	/**
	 * @deprecated
	 */
	public function saveAsVar($name) {
		return $this->varsFromStack($name);
	}
	/**
	 * @deprecated
	 */
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
}