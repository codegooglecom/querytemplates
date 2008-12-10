<?php
abstract class QueryTemplatesLanguageJS {
	public static function printVar($varName, $f = null) {
		if (! isset($f))
			return <<<EOF
	print({$varName});
EOF;
		return <<<EOF
	print({$varName}['$f']);
EOF;
	}
	public static function loopVar($varName, $asVarName, $keyName) {
		$as = $keyName
			? "{$asVarName} => {$keyName}"
			: $asVarName;
		if (! $keyName)
			$keyName = '__key'.substr(md5(microtime()), 0, 5);
		return array(
			"	for ($keyName in $varName) {
		var $asVarName = {$varName}[$keyName]; 
		if ($asVarName instanceof Function)
			continue;",
			"	}"
		);
	}
	public static function compareVar($varName, $f, $value, $strict = false) {
		if (is_bool($value)) {
			$value = $value
				 ? 'true' : 'false';
		} else {
			$value = "'".str_replace("'", "\\'", $value)."'";
		}
		$strict = $strict
			? '=' : '';
		return <<<EOF
{$varName}['$f'] ==$strict $value
EOF;
	}
	public static function ifCode($code) {
		return array(
			"	if ($code) {",
			"	}"
		);
	}
	public static function elseIfCode($code) {
		return array(
			"	if ($code) {",
			"	}"
		);
	}
	public static function ifVar($var) {
		return array(
			"	if (typeof $var != undefined && $var) {",
			"	}"
		);
	}
	public static function elseIfVar($var) {
		$varName = implode('->', explode('.', $var));
		return array(
			"	else if (typeof $var != undefined && $var) {",
			"	}"
		);
	}
	public static function elseStatement() {
		return array(
			"	else {",
			"	}"
		);
	}
	public static function initialize() {
		phpQuery::plugin('jsCode');
	}
	/** 
	 * @param $content
	 * @param $name
	 * @param $vars
	 * @param $saveParams
	 * @return unknown_type
	 */
	public static function templateWrapper($content, $name, $vars, $saveParams) {
		$varsCode = '';
		if ($vars) {
			$varsCode .= "\n";
			foreach($vars as $varName => $varValue) {
				$varValue = is_array($varValue) || is_object($varValue)
					? QueryTemplates::toJSON($varValue)
					: "'".phpQuery::$plugins->jsVarValue($varValue)."'"; 
				$varsCode .= "\tvar $varName = $varValue;\n";
			}
		}
		$callbackActive = isset($saveParams[1]) && $saveParams[1]
			? '()' : '';
		$callback = isset($saveParams[0]) && $saveParams[0]
			? "\n{$saveParams[0]}(template$name$callbackActive);"
			: '';
		return <<<EOF
function template$name(__data) {{$varsCode}
	if (typeof __data != 'undefined')
		for (__dataRow in __data)
			eval('var '+__dataRow+' = __data[__dataRow]');
	var __template = '';
	var print = function(value) {
		__template += value;
	}
$content
	return __template;
}$callback
EOF;
	}
	public static function postFilterDom($dom) {
		return $dom;
	}
	public static function postFilterMarkup($markup, $isDocumentFragment) {
		return phpQuery::$plugins->markupToJS($markup);
	}
}