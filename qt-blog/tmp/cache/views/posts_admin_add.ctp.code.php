
<div class="posts form">
<?php 
 echo $form->create("Post", array (
  'url' => NULL,
)); 
 ?>
<fieldset>
<legend>Add Post</legend>
	<div class="input text">
<label for="title">Title</label><?php 
 print $form->error('title', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('title',
				array (
  'type' => 'text',
  'div' => '',
  'legend' => false,
  'label' => false,
  'id' => 'PostTitle',
)
			); 
 ?>
</div>
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



<div class="input select">
<label for="Tag">Tag</label><?php 
 print $form->error('Tag', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('Tag',
				array (
  'type' => 'select',
  'div' => '',
  'legend' => false,
  'label' => false,
  'id' => 'TagTag',
  'multiple' => 'multiple',
)
			); 
 ?>
</div>	</fieldset>
<div class="submit"><input type="submit" value="Submit"></div>
<?php 
 echo $form->end(); 
 ?>
</div>
<div class="actions">
	<ul>
<li><a href="/QT-Blog/admin">List Posts</a></li>
		<li>
<a href="/QT-Blog/admin/comments">List Comments</a> </li>
		<li>
<a href="/QT-Blog/admin/comments/add">New Comment</a> </li>
		<li>
<a href="/QT-Blog/admin/tags">List Tags</a> </li>
		<li>
<a href="/QT-Blog/admin/tags/add">New Tag</a> </li>
	</ul>
</div>
