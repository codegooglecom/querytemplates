<?php
/* STEP 2 - create template */
$template
	->sourceCollect('input.html')
	->parse()
		->source('input.html')->find('form')->returnReplace()
		->varsToForm('data', $data)
;