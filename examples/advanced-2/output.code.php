<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Example: advanced-2</title>
</head>
<body>
	<ul>
<?php 
 foreach($posts as $postNum => $r): 
 ?><li class='<?php 
 if (! $postNum) print "first"  
?>'>
			<h2 class="title"><?php 
 print is_object($r["Post"])
						? $r["Post"]->title
						: $r["Post"]['title'] 
 ?>
</h2>
			<p class="body"><?php 
 print is_object($r["Post"])
						? $r["Post"]->body
						: $r["Post"]['body'] 
 ?></p>
		
	<?php 
 if (isset($r["Comment"]) && $r["Comment"]) { 
 ?><h3>Comments</h3>
	<ul class="comments">
<?php 
 foreach($r["Comment"] as $comment): 
 ?><li>
			<strong class="author"><?php 
 print is_object($comment)
						? $comment->author
						: $comment['author'] 
 ?></strong>: <span class="body"><?php 
 print is_object($comment)
						? $comment->body
						: $comment['body'] 
 ?></span>
		</li>
<?php 
 endforeach; 
 ?>
	</ul>
<?php 
 } 
  
 if (isset($r["Tag"]) && $r["Tag"]) { 
 ?><div class="tags">
<?php 
 $tagCount = count($r["Tag"]); 
 ?><strong>Tags:</strong> <?php 
 foreach($r["Tag"] as $k => $tag): 
 ?><a href="<?php 
 print "tag/{$tag["id"]}"  
?>"><?php 
 print $tag["tag"]; 
 ?></a><?php 
 if ($k+1 < $tagCount) print ", "; 
  
 endforeach; 
 ?>
</div>
<?php 
 } 
 ?>
</li>
<?php 
 endforeach; 
 ?>
		
		
	</ul>
</body>
</html>