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
/*
// PREPARE DATA
foreach( $posts as $k => $r ) {
	// link post title
	$posts[$k]['Post']['title'] = $html->link(
		$r['Post']['title'],
		'/'.$r['Post']['slug']
	);
}
// build & include template
include(
	plainTemplates::createTemplate(
		'index.htm',
		array(
			'posts',
			$posts,
			'sidebar posts ul'
		)
	)
);
*/