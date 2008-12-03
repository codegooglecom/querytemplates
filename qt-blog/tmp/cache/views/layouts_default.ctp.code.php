<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta name="generator" content="HTML Tidy, see www.w3.org">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/QT-Blog/templates/../css/client.generic.css" type="text/css" media="screen" charset="utf-8">
<title>QT Blog<?php 
 print $title_for_layout ? " &raquo; $title_for_layout" : null; 
 ?>
</title>
</head>
<body>
<div id="container">
            <div id="header">
                <h1><a href="<?php 
 print $this->webroot  
?>">QT Blog</a></h1>
                <p>QueryTemplates blog implementation</p>
            </div>
            <div id="content">
                <div class="sidebar column right">
                    <h3>QT Blog</h3>
                    <p>QueryTemplates Blog is an example implementation of using QueryTemplates with CakePHP framework.</p>
                    <h3>Latest posts</h3>
                    <?php 
 print $this->requestAction("/posts/latest", array("return")) 
 ?><h3>Tags</h3>
                    <?php 
 print $this->requestAction("/tags", array("return")) 
 ?><h3>Powered by</h3>
                    <ul>
<li><a href="http://cakephp.com/">CakePHP</a></li>
                        <li><a href="http://code.google.com/p/querytemplates/">QueryTemplates</a></li>
                    </ul>
</div>
                <div class="main column left"><?php 
 if ($session->check("Message.flash"))
					$session->flash();
				print $content_for_layout; 
 ?>
</div>
            </div>
            <div id="footer">
							QT Blog v0.1-alpha
            </div>
        </div>
<?php 
 echo $cakeDebug; 
 ?>
</body>
</html>
