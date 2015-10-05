# `varsToLoop` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsTo](varsToSyntax.md) > [varsToLoop](varsToLoopMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable which will be looped. Must contain $ at the beggining.
  * **$rowName** _String_
> > Name of variable being result of iteration.
  * **$indexName** _String_ = `null`
> > Optional. Use it when you want to have $varName's key available in the scope.


### Description ###
Wraps selected elements with executable code iterating $varName as $rowName.


Method doesn't change selected nodes stack.


## Example ##


### Markup ###
```
 <ul>
     <li class='row'>
         <span class='name'></span>
         <ul class='tags'>
             <li class='tag'>
                 <span class='name'></span>
             </li>
         </ul>
     </li>
 </ul>

```
### Data ###
```
 $data = array(
     array(
         'User' => array('name' => 'foo'),
         'Tags' => array(
             array('name' => 'php'),
             array('name' => 'js'),
         ),
     ),
     array(
         'User' => array('name' => 'bar'),
         'Tags' => array(
             array('name' => 'perl'),
         ),
     ),
     array(
         'User' => array('name' => 'fooBar'),
         'Tags' => array(
             array('name' => 'php'),
             array('name' => 'js'),
             array('name' => 'perl'),
         ),
     ),
 );
 $userFields = array('name');
 $tagFields = array('name');

```
### `QueryTemplates` formula ###
```
 $template->
     find('> ul > li')->
         varsToLoop('data', 'row')->
         varsToSelector('row', $userFields, 'span.%k')->
         find('> ul > li')->
             varsToLoop('row.Tags', 'tag')->
             varsToSelector('tag', $tagFields)
 ;

```
### Template ###
```
 <ul>
 <?php  if (isset($data) && (is_array($data) || is_object($data))) { foreach($data as $row):  ?><li class="row">
         <span class="name"><?php  if (isset($row['name'])) print $row['name'];
 else if (isset($row->{'name'})) print $row->{'name'};  ?></span>
         <ul class="tags">
 <?php  if (isset($row['Tags'])) $__8daca = $row['Tags']; else if (isset($row->{'Tags'})) $__8daca = $row->{'Tags'}; if (isset($__8daca) && (is_array($__8daca) || is_object($__8daca))) { foreach($__8daca as $tag):  ?><li class="tag">
                 <span class="name"><?php  if (isset($tag['name'])) print $tag['name'];
 else if (isset($tag->{'name'})) print $tag->{'name'};  ?></span>
             </li>
 <?php  endforeach; }  ?>
         </ul>
 </li>
 <?php  endforeach; }  ?>
 </ul>

```
### Template tree before ###
```
 ul
  - li.row
  -  - span.name
  -  - ul.tags
  -  -  - li.tag
  -  -  -  - span.name

```
### Template tree after ###
```
 ul
  - PHP
  - li.row
  -  - span.name
  -  -  - PHP
  -  - ul.tags
  -  -  - PHP
  -  -  - li.tag
  -  -  -  - span.name
  -  -  -  -  - PHP
  -  -  - PHP
  - PHP

```

---


## See also ##
  * [valuesToLoop](valuesToLoopMethodPHP.md)


### Comments allowed ###