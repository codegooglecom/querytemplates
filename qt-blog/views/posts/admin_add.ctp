<?php
$name = substr(__FILE__, strlen(VIEWS));
$formMarkup = new Callback(
	create_function('$view', '
		return $view->requestAction("/admin/posts/template/add/", array("return"));
	'), $this
);
$template = template($name)
	->sourceCollect($formMarkup, 'formMarkup')
	->parse()
		->source('formMarkup')->returnReplace()
		->find('form')
			->find('div:has(input[name*=published]),
				div:has(input[name*=slug]),
				div:has(input[name*=comments])')
				->remove()
			->end()
			->find('.input:has(input[name*=Tag])')
				->find('input[type=hidden]')->remove()->end()
			->end()
			// remove form's internal fieldset (will be readded)
			->find('fieldset:has(input[name=_method])')->remove()->end()
		->end()
		->plugin('CakeForms')
		// 'url' => null turns off [action] inheritance
		->formToCakeForm(array('Post', array('url' => null)), $form)
	->save()
;
require($template);