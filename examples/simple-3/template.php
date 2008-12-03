<?php
/* STEP 0 - prepare input data */
$data = array(
	array(
		'field1' => 'value1',
		'field2' => 'value2',
		'field3' => 'value3',
	),
	array(
		'field1' => 'lorem',
		'field2' => 'ipsum',
		'field3' => 'dolor',
	),
);

/* STEP 1 - set up environment */
require_once('../../src/QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output')
	->sourceCollect('input.html')
	->parse()
		->source('input.html')->returnReplace()
		->find('.my-div')
			->find('ul > li')
				->loopOne('$data', '$row')
					// this is one of the most important methods
					// it takes an associative array ($row) and injects it's content
					// into nodes matching selector pattern
					// by default it searches for classes same as key name
					->varsToSelector('$row', $data[0])
				->end()
			->end()
			// replace matched node (.my-div) with an 'if' statement
			// 'tagTo...' methods remove node, so no lookups are possible futher!
			// thats why this should be done AFTER all operations on nodes
			// contained inside particular node
			->tagToIfPHP('isset($data[1])')
		->end()
	->save()
;

/* STEP 3 - include generated template */
require($template);