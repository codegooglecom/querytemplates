There are 3 sections of examples:
  * [Simple](#Simple.md)
  * [Intermediate](#Intermediate.md)
  * [Advanced](#Advanced.md)

After reading all 10 examples you should be able to start implementing QueryTemplates in you application. Each example contains comments describing new things introduced in it and refers to previous one in same section. Comments from previous example are removed.

# Simple #
## [Simple 1](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-1/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-1/input.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-1/output.code.php)

```
<?php
/* STEP 0 - prepare input data */
$data = array(
  'first',
  'second',
  'third'
);

/* STEP 1 - set up enviroment */
require_once('../../QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output')
  // fetches input.html from $sourcesPath (see above)
  // as source with name same as filename
  ->sourceCollect('input.html')
  // parse is delimiter which starts template parsing stage
  // everything between parse()..save() is subject to cache
  ->parse()
    // source() inside parse() returns source fetched above
    // returnReplace() pushes sources stack (full source by default)
    // to template, replacing everything
    ->source('input.html')->returnReplace()
    ->find('ul > li')
      // loopOne means 'use first for a loop and throw away rest
      // of selected elements (ul > li in this case)
      ->loopOne('data', 'row')
        // injects php code as innerHTML
        ->php('print $row')
      ->end()
    ->end()
  // save() saves template in $targetsPath
  // every string conversion triggers save, so practically it's optional
  ->save()
;

/* STEP 3 - include generated template */
require($template);
```
Same code as in **Step 2** above, but written in **classic** way (comments were stripped)
```
/* STEP 2 - create template */
$template = new QueryTemplatesTemplate('output');
$template->sourceCollect('input.html');
$template = $template->parse();
$source = $template->source('input.html');
$source->returnReplace();
$li = $template['ul > li'];
$li = $li->loopOne('data', 'row');
$li->php('print $row');
```

## [Simple 2](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-2/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-2/input.html)
  * [PHP Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-2/output.code.php)
  * [JS Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-2/output.code.js)

**PHP** version
```
<?php
/* STEP 0 - prepare input data */
$data = array(
	'first',
	'second',
	'third'
);

/* STEP 1 - set up enviroment */
require_once('../../src/QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output');
// use same file for JS and PHP template
require('template.php');

/* STEP 3 - include generated template */
require($template);
```

**JS** version
```
<?php
/* STEP 0 - prepare input data */
$data = array(
	'first',
	'second',
	'third'
);

/* STEP 1 - set up enviroment */
require_once('../../src/QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;
//QueryTemplates::$cacheTimeout = -1;

/* STEP 2 - create template */
$template = template('output', 'js');
// use same file for JS and PHP template
require('template.php');
$template->save('document.write');

/* STEP 3 - include generated template */
header("Content-Type: application/x-javascript");
print 'var data = '.QueryTemplates::toJSON($data).";\n";
print(file_get_contents($template));
```

Reusable chain
```
<?php 
/* STEP 2 - create template */
$template
	->sourceCollect('input.html')

	->parse()
		// query UL before returning markup to the template
		// client-side templates rather doesn't need doctype and <html>
		->source('input.html')->find('ul')->returnReplace()
		->find('ul > li')
			->loopOne('data', 'row')
				->varPrint('row')
			->end()
		->end()
	// save is skipped due to difference in passed arguments in PHP and JS template
//	->save()
;
```

## [Simple 3](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-3/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-3/input.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-3/output.code.php)

```
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

/* STEP 1 - set up enviroment */
require_once('../../QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output')
  ->sourceCollect('input.html')
  ->parse()
    ->source('input.html')->returnReplace()
    ->find('.my-div')
      // wraps .my-div with an 'if' statement
      // this can be done easier, as shown in next examples
      ->beforePHP('if (isset($data[1])):')
      ->afterPHP('endif;')
      ->find('ul > li')
        ->loopOne('data', 'row')
          ->find('.field1')->php('print $row["field1"]')->end()
          ->find('.field2')->php('print $row["field2"]')->end()
          ->find('.field3')->php('print $row["field3"]')->end()
        ->end()
      ->end()
    ->end()
  ->save()
;

/* STEP 3 - include generated template */
require($template);
```

## [Simple 4](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-3/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-4/input.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/simple-4/output.code.php)

```
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
require_once('../../QueryTemplates.php');
// tmp
require_once('../../../phpQuery/phpQuery/phpQuery.php');
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
        ->loopOne('data', 'row')
          // this is one of the most important methods
          // it takes an associative array ($row) and injects it's content
          // into nodes matching selector pattern
          // by default it searches for classes same as key name
          ->varsToSelector('row', $data[0])
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
```

# Intermediate #
## [Intermediate 1](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-1/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-1/input.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-1/output.code.php)

```
<?php
/* STEP 0 - prepare input data */
$data = array(
  array(
    'Model-1' => array(
      'field-1' => 'Model-1-value-1',
      'field-2' => 'Model-1-value-2',
      'field-3' => 'Model-1-value-3',
    ),
    'Model-2' => array(
      'field-1' => 'Model-2-value-1',
      'field-2' => 'Model-2-value-2',
      'field-3' => 'Model-2-value-3',
    ),
  ),
  array(
    'Model-1' => array(
      'field-1' => 'Model-1-value-1',
      'field-2' => 'Model-1-value-2',
      'field-3' => 'Model-1-value-3',
    ),
    'Model-2' => array(
      'field-1' => 'Model-2-value-1',
      'field-2' => 'Model-2-value-2',
      'field-3' => 'Model-2-value-3',
    ),
  ),
);
// model fields are required when there's possibility of empty data
$modelOneFields = array_keys($data[0]['Model-1']);
$modelTwoFields = array_keys($data[0]['Model-2']);

/* STEP 1 - set up environment */
require_once('../../QueryTemplates.php');
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
        ->loopOne('data', 'row')
          // using varsToSelector and having 2 models can lead to naming collisions
          // one of possible ways to bypass this problem is reduceing
          // matched nodes to interesting ones
          ->find('> *')->slice(1, 3)
            ->varsToSelector('row["Model-1"]', $modelOneFields)
          ->end()->end()
          // second way is to redefine selector patter in varsToSelector
          // but this requires also changing classes inside template
          ->varsToSelector('row["Model-2"]', $modelTwoFields, '.Model-2-%k')
        ->end()
      ->end()
    ->end()
  ->save()
;

/* STEP 3 - include generated template */
require($template);
```

## [Intermediate 2](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-2/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-2/input.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-2/output.code.php)

```
<?php
/* STEP 0 - prepare input data */
$data = array(
  'text-example' => 'new',
  'checkbox-example' => true,
  'radio-example' => 'second',
  'select-example' => 'second',
  'textarea-example' => 'new',
);

/* STEP 1 - set up environment */
require_once('../../QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
// QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output')
  ->sourceCollect('input.html')
  ->parse()
    ->source('input.html')->returnReplace()
    // valuesToForm fills form with passed data (which is not dynamic)
    // notice the difference between 'fill' and 'create'
    // it will select proper select[option], but won't create options inside select
    ->valuesToForm($data)
  ->save()
;

/* STEP 3 - include generated template */
require($template);
```

## [Intermediate 3](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-3/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-3/input.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-3/output.code.php)

```
<?php
/* STEP 0 - prepare input data */
$data = array(
  'text-example' => 'new',
  'checkbox-example' => true,
  'radio-example' => 'second',
  'select-example' => 'second',
  'textarea-example' => 'new',
);

/* STEP 1 - set up environment */
require_once('../../QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
// QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output')
  ->sourceCollect('input.html')
  ->parse()
    ->source('input.html')->returnReplace()
    // varsToForm acts same as valuesToForm with one difference
    // it's behaviour is based on dynamic data (from vars)
    // see output.code.php from this and previous example
    ->varsToForm('data', $data)
  ->save()
;

/* STEP 3 - include generated template */
require($template);
```

## [Intermediate 4](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-4/) ##
  * [Source](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-4/input.html)
  * [PHP Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-4/output.code.php)
  * [JS Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/intermediate-4/output.code.js)

**PHP** version
```
<?php
/* STEP 0 - prepare input data */
$data = array(
  'text-example' => 'new',
  'checkbox-example' => true,
  'radio-example' => 'second',
  'select-example' => 'second',
  'textarea-example' => 'new',
);

/* STEP 1 - set up environment */
require_once('../../src/QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;
//QueryTemplates::$cacheTimeout = -1;

/* STEP 2 - create template */
$template = template('output');
require('template.php');

/* STEP 3 - include generated template */
require($template);
```

**JS** version
```
<?php
/* STEP 0 - prepare input data */
$data = array(
  'text-example' => 'new',
  'checkbox-example' => true,
  'radio-example' => 'second',
  'select-example' => 'second',
  'textarea-example' => 'new',
);

/* STEP 1 - set up environment */
require_once('../../src/QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
//QueryTemplates::$debug = 1;
//QueryTemplates::$cacheTimeout = -1;

/* STEP 2 - create template */
$template = template('output', 'js');
require('template.php');
$template->save('document.write');

/* STEP 3 - include generated template */
header("Content-Type: application/x-javascript");
print 'var data = '.QueryTemplates::toJSON($data).";\n";
print(file_get_contents($template));
```

Reusable chain
```
<?php 
/* STEP 2 - create template */
$template
	->sourceCollect('input.html')
	->parse()
		->source('input.html')->find('form')->returnReplace()
		->varsToForm('data', $data)
;
```

# Advanced #
## [Advanced 1](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-1/) ##
  * [Source 1](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-1/input.html)
  * [Source 2](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-1/input2.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-1/output.code.php)

```
<?php
/* STEP 0 - prepare input data */
$posts = array(
  array(
    'Post' => array(
        'title' => 'Im the title',
        'body' => 'Im the body',
    ),
    'Comment' => array(
        array(
            'author' => 'Im the 1st comment of 1st post',
            'body' => "This field has same name as post's one",
        ),
        array(
            'author' => 'Im the 2nd comment of 1st post',
            'body' => 'So am i',
        ),
    ),
    'Tag' => array(
        array(
            'tag' => 'Tag1',
            'id' => "1",
        ),
        array(
            'tag' => 'Tag2',
            'id' => '2',
        ),
    ),
  )
);
$postFields = array_keys($posts[0]['Post']);
$commentFields = array_keys($posts[0]['Comment'][0]);
$tagFields = array_keys($posts[0]['Tag'][0]);

/* STEP 1 - set up environment */
require_once('../../QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
// QueryTemplates::$debug = 1;

/* STEP 2 - create template */
$template = template('output')
  ->sourceCollect('input.html', 'collect-01')
  ->parse()
    ->source('collect-01')->returnReplace()
    ->find('ul:first > li')
      ->loopOne('posts', 'r')
        ->find('> .title, > .body')
          // fills matched elements (stack) with $postFields' array content
          ->varsToStack('r["Post"]', $postFields)
        ->end()
        ->find('.comments > li')
          ->loopOne('r["Comment"]', 'comment')
            ->varsToSelector('comment', $commentFields)
        ->end()->end()
        ->find('.tags')
          // remove text nodes
          ->contents()->not('*')->remove()->end()->end()
          // add space separator
          ->find('strong')->after(' ')->end()
          ->prependPHP('tagCount = count($r["Tag"]);')
          ->find('a')
            // loopOne with 3 arguments, second is key, as in foreach
            ->loopOne('r["Tag"]', 'k', 'tag')
              ->attrPHP('href', 'print "tag/{$tag["id"]}"')
              ->php('print $tag["tag"];')
              // add comma (,) between tag names
              ->afterPHP('if ($k+1 < $tagCount) print ", ";')
          ->end()->end()
        ->end()
    // no save() used, as it's automatically triggered by require()
;

/* STEP 3 - include generated template */
require($template);
```
## [Advanced 2](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-2/) ##
  * [Source 1](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-2/input.html)
  * [Source 2](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-2/input2.html)
  * [Result](http://code.google.com/p/querytemplates/source/browse/trunk/examples/advanced-2/output.code.php)

```
<?php
/* STEP 0 - prepare input data */
$posts = array(
  array(
    'Post' => array(
        'title' => 'Im the title',
        'body' => 'Im the body',
    ),
    'Comment' => array(
        array(
            'author' => 'Im the 1st comment of 1st post',
            'body' => "This field has same name as post's one",
        ),
        array(
            'author' => 'Im the 2nd comment of 1st post',
            'body' => 'So am i',
        ),
    ),
    'Tag' => array(
        array(
            'tag' => 'Tag1',
            'id' => "1",
        ),
        array(
            'tag' => 'Tag2',
            'id' => '2',
        ),
    ),
  ),
  array(
    'Post' => array(
        'title' => 'Second title',
        'body' => 'Second body',
    ),
    'Comment' => array(
        array(
            'author' => 'Tip',
            'body' => "There isn't any tags",
        ),
    ),
  ),
);
$postFields = array_keys($posts[0]['Post']);
$commentFields = array_keys($posts[0]['Comment'][0]);
$tagFields = array_keys($posts[0]['Tag'][0]);

/* STEP 1 - set up environment */
require_once('../../src/QueryTemplates.php');
QueryTemplates::$sourcesPath = dirname(__FILE__);
QueryTemplates::$targetsPath = dirname(__FILE__);
// QueryTemplates::$debug = 1;
// Callback example
function myFunction($node) {
  // dump() method var_dumps actual stack and doesn't break the chain
  // use it for debugging
  pq($node)->dump();
}
$myFunctionCallback = new Callback('myFunction');
// intialize variable to be used as reference later
// weird syntax prevents some IDEs from resetting $row type ;)
/** @var QueryTemplatesParse */
$row; ${'row'} = null;

/* STEP 2 - create template */
$template = template('output')
  ->sourceCollect('input.html', 'collect-01')
  ->sourceQuery('input2.html')
    ->find('.fake')->contents()->collect('collect-02')
  ->sourceEnd()
  ->parse()
    ->source('collect-01')->returnReplace()
    // apply callback to all matched elements
    ->find('ul:first > li')->each($myFunctionCallback)->end()
    ->source('collect-02')->returnAppend('ul:first > li:first')
    ->find('ul:first > li')
      ->loopOne('posts', 'postNum', 'r')
        // add dynamic class
        ->addClassPHP('if (! $postNum) print "first"')
        ->find('> .title, > .body')
          ->varsToStack('r["Post"]', $postFields)
        ->end()
        // toReference saves actual matched elements inside variable
        ->toReference($row)
;
// chain can be breaked in any place
$row
  ->find('h3:first, .comments')
    // wraps matched elements with an 'if' statement
    // notice it uses one 'if' for 2 elements
    ->ifPHP('isset($r["Comment"]) && $r["Comment"]')
  ->end()
  ->find('.comments > li')
    ->loopOne('r["Comment"]', 'comment')
      ->varsToSelector('comment', $commentFields)
  ->end()->end()
  ->find('.tags')
    ->ifPHP('isset($r["Tag"]) && $r["Tag"]')
    ->contents()->not('*')->remove()->end()->end()
    ->find('strong')->after(' ')->end()
    ->prependPHP('tagCount = count($r["Tag"]);')
    ->find('a')
      ->loopOne('r["Tag"]', 'k', 'tag')
        ->attrPHP('href', 'print "tag/{$tag["id"]}"')
        ->php('print $tag["tag"];')
        ->afterPHP('if ($k+1 < $tagCount) print ", ";')
;

/* STEP 3 - include generated template */
require($template);
```