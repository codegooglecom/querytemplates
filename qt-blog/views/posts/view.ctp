<?php
$name = substr(__FILE__, strlen(VIEWS));
$template = template($name)
	->sourceQuery('index.htm')
		->find('.main ul.posts > li:first')
			->contents()
				->collect('post')
			->end()
		->end()
	->sourceEnd()
	->sourceCollect('elements/post-extends.htm', 'post-extends')
	->parse()
		->source('post')->returnReplace()
		->source('post-extends')->returnAppend()
		->varsToSelector('$post["Post"]', $post['Post'], '.Post-%k')
		->find('a.title')
			->replaceWithPHP('href', '
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
		// COMMENTS
		->find('.comments ul li')
			->loopOne('$post["Comment"]', '$comment')
				->find('.body')->php('print $comment["body"]')->end()
				->find('.author')
					->php('print $comment["email"]
						? "<a href=\'mailto:{$comment["email"]}\'>{$comment["author"]}</a>"
						: $comment["author"]')
				->end()
			->end()
		->end()
		->find('.comments')
			->contents()
				->ifPHP('$post["Comment"]')
			->end()
		->end()
		// COMMENT FORM
		->find('.comment-form')
			->find('input[name="data[Post][id]"]')
				->attrPHP('value', 'print $post["Post"]["id"]')
			->end()
			->plugin('CakeForms')
			->formToCakeForm('Comment', $form)
		->end()
	->save()
;
require($template);