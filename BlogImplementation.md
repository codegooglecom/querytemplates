**QT Blog** is a CakePHP based blog implementation created to present various QueryTemplates usage patterns:
  * DB data injections
  * Callback sources
  * Multiple template sources
  * Form convertions

It uses CakeForms plugin, which converts pure HTML forms into PHP templates integrated with CakePHP FormHelper.

You can browse source directly via [web repository](http://code.google.com/p/querytemplates/source/browse/qt-blog/)
  * Templates sources (markup)
    * [index.htm](http://code.google.com/p/querytemplates/source/browse/qt-blog/webroot/templates/index.htm)
    * [post-extends.htm](http://code.google.com/p/querytemplates/source/browse/qt-blog/webroot/templates/elements/post-extends.htm)
  * QueryTemplates templates (logic)
    * [layouts/default.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/layouts/default.ctp)
    * [posts/admin\_add.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/posts/admin_add.ctp)
    * [posts/admin\_edit.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/posts/admin_edit.ctp)
    * [posts/index.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/posts/index.ctp)
    * [posts/latest.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/posts/latest.ctp)
    * [posts/view.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/posts/view.ctp)
    * [tags/index.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/views/tags/index.ctp)
  * Final templates files
    * [layouts/default.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/layouts_default.ctp.code.php)
    * [posts/admin\_add.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/posts_admin_add.ctp.code.php)
    * [posts/admin\_edit.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/posts_admin_edit.ctp.code.php)
    * [posts/index.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/posts_index.ctp.code.php)
    * [posts/latest.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/posts_latest.ctp.code.php)
    * [posts/view.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/posts_view.ctp.code.php)
    * [tags/index.ctp](http://code.google.com/p/querytemplates/source/browse/qt-blog/tmp/cache/views/tags_index.ctp.code.php)

## Download ##
**QT Blog** can be downloaded from [download section](http://code.google.com/p/querytemplates/downloads/list).

## Installation ##
  1. Execute DATABASE.sql
  1. Edit config/database.php with proper user data
  1. Edit webroot/index.php changing CAKE\_CORE\_INCLUDE\_PATH to your CakePHP 1.2 path