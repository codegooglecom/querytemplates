<ul class="posts">
<?php 
 foreach($posts as $post): 
 ?><li><?php 
 
						print $html->link($post["Post"]["title"],
							"/posts/view/{$post["Post"]["id"]}");
					 
 ?></li>
<?php 
 endforeach; 
 ?>
                        
                        
                    </ul>