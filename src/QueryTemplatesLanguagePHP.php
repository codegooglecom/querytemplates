<?php
require_once(dirname(__FILE__)."/QueryTemplatesLanguage.php");
abstract class QueryTemplatesLanguagePHP 
	extends QueryTemplatesLanguage {
	public static function printVar($varName) {
		$callbacks = self::callbacks(self::filterVarNameCallbacks($varName));
		if (! strpos($varName, '.')) {
			return <<<EOF
if (isset(\$$varName)) print {$callbacks[0]}\$$varName{$callbacks[1]};
EOF;
		}
		$varNameArray = self::varNameArray($varName);
		$varNameObject = self::varNameObject($varName);
		return <<<EOF
if (isset($varNameArray)) print {$callbacks[0]}$varNameArray{$callbacks[1]};
else if (isset($varNameObject)) print {$callbacks[0]}$varNameObject{$callbacks[1]};
EOF;
	}
	public static function printValue($value) {
		$value = self::addslashes($value);
		return "print '$value';";
	}
	public static function loopVar($varName, $asVarName, $keyName) {
		$as = $keyName
			? "{$asVarName} => \${$keyName}"
			: $asVarName;
		$preCode = '';
		if (strpos($varName, '.')) {
			$varNameObject = self::varNameObject($varName);
			$varNameArray = self::varNameArray($varName);
			$varName = '$__'.substr(md5($varName), 0, 5);
			$preCode = "if (isset($varNameArray)) $varName = $varNameArray; ";
			$preCode .= "else if (isset($varNameObject)) $varName = $varNameObject; ";
		} else
			$varName = '$'.$varName;
		$wrapper = self::ifCode(
			"isset($varName) && (is_array($varName) || is_object($varName))"
		);
		return array(
			"$preCode{$wrapper[0]} foreach({$varName} as \${$as}):",
			"endforeach; {$wrapper[1]}"
		);
	}
	public static function compareVarValue($varName, $value, $strict = false) {
		if (is_bool($value)) {
			$value = $value
				 ? 'true' : 'false';
		} else {
			$value = "'".self::addslashes($value)."'";
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
			"else if ($code) {",
			"}"
		);
	}
	public static function ifVar($var) {
		if (! strpos($var, '.')) {
			$code = "isset($var) && $var";
		} else {
			list($object, $array) = self::varName($var);
			$code = "(isset($array) && $array) || (isset($object) && $object)";
		}
		return self::ifCode($code);
	}
	public static function ifNotVar($var) {
		if (! strpos($var, '.')) {
			$code = "isset($var) && ! $var";
		} else {
			list($object, $array) = self::varName($var);
			$code = "(isset($array) && ! $array) || (isset($object) && ! $object)";
		}
		return self::ifCode($code);
	}
	public static function elseIfVar($var) {
		$code = self::ifVar($var);
		return array(
			"else ".$code[0],
			"}"
		);
	}
	public static function elseIfNotVar($var) {
		$code = self::ifNotVar($var);
		return array(
			"else ".$code[0],
			"}"
		);
	}
	public static function elseStatement() {
		return array(
			"else {",
			"}"
		);
	}
	public static function varName($varName) {
		if (strpos($varName, '.')) {
			$varNameObject = self::varNameObject($varName);
			$varNameArray = self::varNameArray($varName);
		} else
			$varNameObject = $varNameArray = '$'.$varName;
		return array($varNameObject, $varNameArray);
	}
	public static function varNameObject($name) {
		$return = '';
		foreach(explode('.', $name) as $v) {
			if (! $return)
				$return = "\$$v";
			else {
				$v = self::addslashes($v);
				$return .= "->{'$v'}";
			}
		}
		return $return;
	}
	public static function varNameArray($name) {
		$return = '';
		foreach(explode('.', $name) as $v) {
			if (! $return)
				$return = "\$$v";
			else {
				$v = self::addslashes($v);
				$return .= "['$v']";
			}
		}
		return $return;
	}
	public static function valuesToVars($varsArray) {
		$lines = array();
		foreach($varsArray as $var => $value) {
			$lines[] = "\$$var = ".var_export($value, true).";";
		}
		return implode("\n", $lines);
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
			$varsCode = "<"."?php\n";
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