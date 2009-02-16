<?php
abstract class QueryTemplatesLanguagePHP {
	public static function printVar($varName) {
		if (! mb_strpos($varName, '.')) {
		return <<<EOF
if (isset(\$$varName)) print \$$varName;
EOF;
		}
		$varNameArray = self::varNameArray($varName);
		$varNameObject = self::varNameObject($varName);
		return <<<EOF
if (isset($varNameArray)) print $varNameArray;
else if (isset($varNameObject)) print $varNameObject;
EOF;
	}
	public static function printValue($value) {
		$value = self::addslashes($value);
		return "print '$value';";
	}
	public static function addslashes($target, $char = "'") {
		return str_replace($char, '\\'.$char, $target);
	}
	public static function loopVar($varName, $asVarName, $keyName) {
		$as = $keyName
			? "{$asVarName} => \${$keyName}"
			: $asVarName;
		if (strpos($varName, '.')) {
			$varNameObject = self::varNameObject($varName);
			$varNameArray = self::varNameArray($varName);
			$varName = "isset($varNameArray) ? $varNameArray : $varNameObject";
		} else
			$varName = '$'.$varName;
		return array(
			"foreach({$varName} as \${$as}):",
			"endforeach;"
		);
	}
	public static function varNameObject($name) {
		$return = '';
		foreach(explode('.', $name) as $v) {
			if (! $return)
				$return = "\$$v";
			else
				$return .= "->{'$v'}";
		}
		return $return;
	}
	public static function varNameArray($name) {
		$return = '';
		foreach(explode('.', $name) as $v) {
			if (! $return)
				$return = "\$$v";
			else
				$return .= "['$v']";
		}
		return $return;
	}
	public static function compareVar($varName, $value, $strict = false) {
		if (is_bool($value)) {
			$value = $value
				 ? 'true' : 'false';
		} else {
			$value = "'".str_replace("'", "\\'", $value)."'";
		}
		$strict = $strict
			? '=' : '';
		if (strpos($varName, '.')) {
			$varNameObject = self::varNameObject($varName);
			$varNameArray = self::varNameArray($varName);
//			$varName = "(isset($varNameArray) ? $varNameArray : $varNameObject)";
		} else {
			$varNameObject = $varNameArray = "\$$varName";
		}
		return <<<EOF
(isset($varNameArray) && $varNameArray ==$strict $value) 
	|| (isset($varNameObject) && $varNameObject ==$strict $value)
EOF;
//(is_object(\$$varName) && \${$varName}->{'$f'} ==$strict $value) || (! is_object(\$$varName) && \${$varName}['$f'] ==$strict $value)
	}
	public static function ifCode($code) {
		return array(
			"if ($code) {",
			"}"
		);
	}
	public static function elseIfCode($code) {
		return array(
			"if ($code) {",
			"}"
		);
	}
	public static function ifVar($var) {
		$varNameArray = self::varNameArray($var);
		$varNameObject = self::varNameObject($var);
		return array(
			"if ((isset($varNameArray) && $varNameArray) || (isset($varNameObject) && $varNameObject)) {",
			"}"
		);
	}
	public static function elseIfVar($var) {
		$varName = implode('->', explode('.', $var));
		return array(
			"else if (isset(\$$varName) && \$$varName) {",
			"}"
		);
	}
	public static function elseStatement() {
		return array(
			"else {",
			"}"
		);
	}
	public static function initialize() {
	}
	/**
	 * @param $template
	 * @param $name
	 * @param $callback
	 * @return unknown_type
	 */
	public static function templateWrapper($content, $name, $vars, $saveParams) {
		$varsCode = '';
		if ($vars) {
			$varsCode = "<?php\n";
			foreach($vars as $var => $val) {
				$varsCode .= "\$$var = ".var_export($val, true).";\n";
			}
			$varsCode .= "?>";
		}
		// FIXME just a quick fix for orphaned ELSE statement, breaks nodes structure
		$content = str_replace('?'.'><?'.'php', '', $content);
		return $varsCode.$content;
	}
	public static function postFilterDom($dom) {
		return $dom;
	}
	public static function postFilterMarkup($markup, $isDocumentFragment) {
		// it's important to convert markup to PHP AFTER using Tidy
		if (QueryTemplates::$htmlTidy && function_exists('tidy_parse_string'))
			$markup = QueryTemplates::htmlTidy($markup, $isDocumentFragment);
		if (QueryTemplates::$xmlBeautifier)
			$markup = QueryTemplates::xmlBeautifier($markup);
		return phpQuery::markupToPHP($markup);
	}
}