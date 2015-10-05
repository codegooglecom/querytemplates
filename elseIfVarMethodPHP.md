# `elseIfVar` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [else](elseSyntax.md) > [elseIfVar](elseIfVarMethodPHP.md)
### Parameters ###
  * **$var** _string_
> > Dot-separated object path, eg Object.property.inneProperty
  * **$separate** _bool_ = `false`
> > Determines if selected elements should be wrapped together or one-by-one


### Description ###
Wraps selected tag with PHP "else if" statement checking if $var evaluates  to true. $var must be available inside template's scope.


$var is passed in JavaScript object notation (dot separated).


Optional $separate parameter determines if selected elements should be  wrapped together or one-by-one. This is usefull when stack contains non-sibling  nodes.


Method doesn't change selected nodes stack.


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
 $template['div:eq(1)']->elseIfVar('data.foo.bar.0');

```
### Template ###
```
 <div>1</div>
 <?php  else if ((isset($data['foo']['bar']['0']) && $data['foo']['bar']['0']) || (isset($data->{'foo'}->{'bar'}->{'0'}) && $data->{'foo'}->{'bar'}->{'0'})) {  ?><div>2</div>
 <?php  }  ?>
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
 div
  - Text:2
 PHP
 div
  - Text:3

```

---



### Comments allowed ###