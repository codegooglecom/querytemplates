# `tagToElseIfVar` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [else](elseSyntax.md) > [tagToElseIfVar](tagToElseIfVarMethodPHP.md)
### Parameters ###
  * **$var** _string_
> > Dot-separated object path, eg Object.property.inneProperty


### Description ###
Replaces selected tag with PHP "else if" statement checking if $var evaluates  to TRUE. $var must be available inside template's scope.


$var is passed in JavaScript object notation (dot separated).


Method doesn't change selected nodes stack.  detached from it's parent.


Notice-safe.


## Example ##


### Markup ###
```
 <div>1</div>
 <div>2</div>
 <div>3</div>

```
### Data ###
```
 $data = array(
   'foo' => array(
       'bar' => array(true)
   )
 );

```
### `QueryTemplates` formula ###
```
 $template['div:eq(1)']->
     tagToElseIfVar('data.foo.bar.0')
 ;

```
### Template ###
```
 <div>1</div>
 <?php  else if ((isset($data['foo']['bar']['0']) && $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && $data->{'foo'}->{'bar'}->{'0'})) {  ?>2<?php  }  ?>
 <div>3</div>

```
### Template tree before ###
```
 div
  - Text:1
 div
  - Text:2
 div
  - Text:3

```
### Template tree after ###
```
 div
  - Text:1
 PHP
 Text:2
 PHP
 div
  - Text:3

```

---


## See also ##
  * [ifVar](ifVarMethodPHP.md)


### Comments allowed ###