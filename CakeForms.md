CakeForms plugin automatically converts HTML markup forms into executable PHP code using CakePHP's default FormHelper. It's used to rapidly mix designed template with CakePHP form controls. It also handles error messages.

It's use is quite simple
```
// load plugin
->plugin('CakeForms')
// find form in the template
->find('form')
  // convert form
  ->formToCakeForm(
    array('Post', array('action' => 'edit')), $form
  );
```

Sample output ([see full file](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/posts_admin_edit.ctp.code.php))
```
<div class="input textarea">
<label for="body">Body</label><?php 
 print $form->error('body', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
                        print $form->input('body',
                                array (
  'type' => 'textarea',
  'div' => '',
  'legend' => false,
  'label' => false,
  'id' => 'PostBody',
)
                        ); 
 ?>
</div>
```

For further reading see
  * [Class API reference](http://meta20.net/querytemplates-api/QueryTemplates/QueryTemplatesPlugins/phpQueryObjectPlugin_CakeForms.html)
  * [QT Blog](http://code.google.com/p/querytemplates/wiki/BlogImplementation) which uses CakeForms