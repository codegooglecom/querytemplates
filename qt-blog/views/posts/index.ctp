<?php
$postFields = array_keys(ClassRegistry::getObject('post')->schema());
$name = substr(__FILE__, strlen(VIEWS));
$template = template($name)
	->sourceQuery('index.htm')
		->find('.main ul.posts')
			->collect('posts')
		->end()
	->sourceEnd()
	->parse()
		->source('posts')->returnReplace()
		->find('ul li')
			->loopOne('$posts', '$post')
				->varsToSelector('$post["Post"]', $postFields, '.Post-%k')
				->find('.Post-title')
					->php('
						print $html->link($post["Post"]["title"],
							"/posts/view/{$post["Post"]["id"]}");
					')
				->end()
				// TAGS
				->find('.tags')
					->ifPHP('isset($post["Tag"]) && $post["Tag"]')
					->find('em')
						->loopOne('$post["Tag"]', '$tag')
							->php('print
								$html->link($tag[\'tag\'],
									"/tags/view/{$tag[\'id\']}"
								);')
								// fix spaces
								->after(' ')
							->end()
						->end()
					->end()
				->end()
			->end()
		->end()
	->save()
;
require($template);