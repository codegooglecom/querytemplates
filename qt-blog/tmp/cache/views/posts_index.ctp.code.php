<ul class="posts">
<?php 
 foreach($posts as $post): 
 ?><li class="post">
											<h2 class="Post-title"><?php 
 print $html->link($post["Post"]["title"],
							"/posts/view/{$post["Post"]["id"]}"); 
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
										</li>
<?php 
 endforeach; 
 ?>
										
									</ul>