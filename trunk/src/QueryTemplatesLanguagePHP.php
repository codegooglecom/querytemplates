<?php
abstract class QueryTemplatesLanguagePHP {
	public static function printVar($varName, $f = null) {
		if (! isset($f))
			return <<<EOF
print \${$varName};
EOF;
		return <<<EOF
print is_object(\${$varName})
	? \${$varName}->{$f}
	: \${$varName}['{$f}']
EOF;
	}
	public static function loopVar($varName, $asVarName, $keyName) {
		$as = $keyName
			? "{$asVarName} => \${$keyName}"
			: $asVarName;
		return array(
			"foreach(\${$varName} as \${$as}):",
			"endforeach;"
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
(is_object(\$$varName) && \${$varName}->{'$f'} ==$strict $value)
			|| (! is_object(\$$varName) && \${$varName}['$f'] ==$strict $value)
EOF;
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
		$varName = implode('->', explode('.', $var));
		return array(
			"if (isset(\$$varName) && \$$varName) {",
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