
											<h2 class="Post-title"><?php 
 print is_object($post["Post"])
						? $post["Post"]->title
						: $post["Post"]['title'] 
 ?>
</h2>
											<div class="Post-body"><?php 
 print is_object($post["Post"])
						? $post["Post"]->body
						: $post["Post"]['body'] 
 ?>
</div>
											<p>
												Comments: <span class="Post-comments_count"><?php 
 print is_object($post["Post"])
						? $post["Post"]->comments_count
						: $post["Post"]['comments_count'] 
 ?></span>
											</p>
											<?php 
 if (isset($post["Tag"]) && $post["Tag"]) { 
 ?><p class="tags">
												Tags:
												<?php 
 foreach($post["Tag"] as $tag): 
 ?><em class="tag"><?php 
 print
						$html->link($tag['tag'],
							"/tags/view/{$tag['id']}"
						); 
 ?></em> <?php 
 endforeach; 
 ?>
											</p>
<?php 
 } 
 ?>
										<div class="related">
	<div class="comments">
<?php 
 if ($post["Comment"]) { 
 ?>
		<h3>Comments</h3>
		<ul>
<?php 
 foreach($post["Comment"] as $comment): 
 ?><li>
				<h4 class="author"><?php 
 print $comment["email"]
						? "<a href='mailto:{$comment["email"]}'>{$comment["author"]}</a>"
						: $comment["author"] 
 ?>
</h4>
				<div class="body"><?php 
 print $comment["body"] 
 ?>
</div>
			</li>
<?php 
 endforeach; 
 ?>
			
		</ul>
<?php 
 } 
 ?>
</div>
	<div class="comment-form">
		<h3>Add Comment</h3>
		<?php 
 echo $form->create("Comment", array (
)); 
 ?>
			<fieldset>
<input type="hidden" name="data[Post][id]" value='<?php 
 print $post["Post"]["id"]  
?>'><legend>Post your comment</legend>
				<div class="input text">
					<label for="CommentAuthor">
						You:<br><?php 
 			print $form->error('Comment.author', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('Comment.author',
				array (
  'type' => 'text',
  'div' => '',
  'legend' => false,
  'label' => false,
)
			); 
 ?></label>
				</div>
				<div class="input text">
					<label for="CommentEmail">
						Email (not public):<br><?php 
 			print $form->error('Comment.email', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('Comment.email',
				array (
  'type' => 'text',
  'div' => '',
  'legend' => false,
  'label' => false,
)
			); 
 ?></label>
				</div>
				<div class="input text">
					<label for="CommentUrl">
						URL:<br><?php 
 			print $form->error('Comment.url', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('Comment.url',
				array (
  'type' => 'text',
  'div' => '',
  'legend' => false,
  'label' => false,
)
			); 
 ?></label>
				</div>
				<div class="input textarea">
					<label for="CommentBody">
						Comment:<br><?php 
 			print $form->error('Comment.body', null, array (
  'before' => '<p class="errorField">',
  'class' => 'errorField',
  'after' => '</p>',
));
			print $form->input('Comment.body',
				array (
  'type' => 'textarea',
  'div' => '',
  'legend' => false,
  'label' => false,
)
			); 
 ?></label>
				</div>
				<div>
					<?php 
 					print $form->submit('Submit', array(
					'class' => '',
		 		)); 
 ?>
</div>
			</fieldset>
<?php 
 echo $form->end(); 
 ?>
	</div>
</div>
