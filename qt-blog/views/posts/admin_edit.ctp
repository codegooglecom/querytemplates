<?php
// var_dump($this->data);
// import markup from baked template (lazy)
$formMarkup = new Callback(
	create_function('$view',
		'return $view->requestAction("/admin/posts/template/edit/", array("return"));'
	), $this
);
$name = substr(__FILE__, strlen(VIEWS));
$template = template($name)
	// use baked template as markup source
	->sourceCollect($formMarkup, 'formMarkup')
	->parse()
		->source('formMarkup')->returnReplace()
		->find('fieldset:eq(1)')
			->find('.input:has(input[name*=published])')
				->replaceWith('
					<div>
						<label>Published</label>
						<input name="published" type="radio" value="1" /> YES
						<input name="published" type="radio" value="0"/> NO
					</div>')
				->end()
				->find('.input:has(input[name*=Tag])')
					->find('input[type=hidden]')->remove()->end()
					->find('select')->attr('name', 'Tag')->end()
				->end()
			->end()
		/* IMPORTED TEMPLATE PREPARATION */
		->find('form')
			// form[action] is broken like other URLs from imported template
			->attr('action', '/admin/posts/edit')
			// remove form's internal fieldset (will be readded)
			->find('fieldset:has(input[name=_method])')->remove()->end()
		->end()
		->plugin('CakeForms')
		->formToCakeForm(
			array('Post', array('action' => 'edit')), $form)
//		->dump()
	->save()
;
require($template);