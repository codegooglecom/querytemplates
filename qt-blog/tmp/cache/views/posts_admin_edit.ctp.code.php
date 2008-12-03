
<div class="posts form">
<?php 
 echo $form->create("Post", array (
  'url' => '/admin/posts/edit',
  'action' => 'edit',
)); 
 ?>
<fieldset>
<legend>Edit Post</legend>
	<?php 
 			print $form->hidden('id',
				array(
					'class' => '',
					'legend' => false,
					'label' => false,
			)); 
 ?><div class="input text">
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
<div class="input text">
<label for="comments_count">Comments Count</label><?php 
 			print $form->error('comments_count', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('comments_count',
				array (
  'type' => 'text',
  'div' => '',
  'legend' => false,
  'label' => false,
  'id' => 'PostCommentsCount',
)
			); 
 ?>
</div>
<div class="input text">
<label for="slug">Slug</label><?php 
 			print $form->error('slug', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('slug',
				array (
  'type' => 'text',
  'div' => '',
  'legend' => false,
  'label' => false,
  'id' => 'PostSlug',
)
			); 
 ?>
</div>

					<div class="input radio">
						<label>Published</label>
						<?php 
 			print $form->error('published', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('published',
				array (
  'type' => 'radio',
  'div' => '',
  'legend' => false,
  'label' => false,
  'options' => 
  array (
    1 => false,
  ),
)
			); 
 ?> YES
						<?php 
 					print $form->input('published',
						array (
  'type' => 'radio',
  'options' => 
  array (
    0 => false,
  ),
  'div' => '',
  'legend' => false,
  'label' => false,
)
					); 
 ?> NO
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
<li><a href="/CakePHP-QT-blog/src/admin/posts/delete" onclick="return confirm('Are you sure you want to delete # ?');">Delete</a></li>
		<li><a href="/CakePHP-QT-blog/src/admin">List Posts</a></li>
		<li>
<a href="/CakePHP-QT-blog/src/admin/comments">List Comments</a> </li>
		<li>
<a href="/CakePHP-QT-blog/src/admin/comments/add">New Comment</a> </li>
		<li>
<a href="/CakePHP-QT-blog/src/admin/tags">List Tags</a> </li>
		<li>
<a href="/CakePHP-QT-blog/src/admin/tags/add">New Tag</a> </li>
	</ul>
</div>
