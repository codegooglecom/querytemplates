<?php
$name = substr(__FILE__, strlen(VIEWS));
$template = template($name)
	->sourceQuery('index.htm')
		->find('.sidebar ul.posts')->collect('posts')
	->sourceEnd()
	->parse()
		->source('posts')->returnReplace()
		->find('li')
			->loopOne('posts', 'post')
				->find('a')
					->replaceWithPHP('
						print $html->link($post["Post"]["title"],
							"/posts/view/{$post["Post"]["id"]}");
					')
				->end()
			->end()
		->end()
	->save()
;
require($template);