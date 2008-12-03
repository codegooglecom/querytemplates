<ul class="tags">
<?php 
 foreach($tags as $tag): 
 ?><li><?php 
 print
						$html->link($tag['Tag']['tag'],
							"/tags/view/{$tag['Tag']['id']}"
						); 
 ?></li>
<?php 
 endforeach; 
 ?>
                        
                        
                    </ul>