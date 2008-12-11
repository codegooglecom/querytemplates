<?php
$name = substr(__FILE__, strlen(VIEWS));
$template = template($name)
	->sourceCollect('index.htm')
	->parse()
		->source('index.htm')->returnReplace()
		// find title and inject PHP code printing title var
		->find('title')
			->appendPHP('print $title_for_layout ? " &raquo; $title_for_layout" : null;')
		->end()
		// add rss feeds links
		->find('link[type*=rss]')
			->attrPHP('href', 'print $rss_url_for_content')
		->end()
		// write flash msg and main content code
		->find('#content .main.column')
			->php('
				if ($session->check("Message.flash"))
					$session->flash();
				print $content_for_layout;
			')
		->end()
		// add tags sidebar
		->find('.sidebar .tags')
			->replaceWithPHP('print $this->requestAction("/tags", array("return"))')
		->end()
		// add latest posts to sidebar
		->find('.sidebar .posts')
			->replaceWithPHP('print $this->requestAction("/posts/latest", array("return"))')
		->end()
		// fix webroot for links
		->find('a[href^=/]')
			->each(new Callback(create_function('$node, $view', '
				pq($node)->attr("href", $view->webroot.substr(pq($node)->attr("href"), 1));
			'), new CallbackParam, $this))
		->end()
		// attach debug
		->find('body > *:last')
			->afterPHP('echo $cakeDebug;')
		->end()
		// add main page link
		->find('h1 a:first')
			->attrPHP('href', 'print $this->webroot')
		->end()
;
require($template);