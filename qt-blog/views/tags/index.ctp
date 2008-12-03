<?php
$name = substr(__FILE__, strlen(VIEWS));
$template = template($name)
	->sourceQuery('index.htm')
		->find('.sidebar .tags')->collect('tags')
	->parse()
		->source('tags')->returnReplace()
		->find('li')
			->loopOne('$tags', '$tag')
				->find('a')
					// FIXME no url is created
					->replaceWithPHP('print
						$html->link($tag[\'Tag\'][\'tag\'],
							"/tags/view/{$tag[\'Tag\'][\'id\']}"
						);')
				->end()
			->end()
		->end()
	->save()
;
require($template);