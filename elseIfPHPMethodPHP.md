# `elseIfPHP` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [else](elseSyntax.md) > [elseIfPHP](elseIfPHPMethodPHP.md)
### Parameters ###
  * **$code** _string_
> > Valid PHP condition code
  * **$separate** _bool_ = `false`
> > Determines if selected elements should be wrapped together or one-by-one


### Description ###
Wraps selected tag with PHP "else if" statement containing $code as condition.


Optional $separate parameter determines if selected elements should be  wrapped together or one-by-one. This is usefull when stack contains non-sibling  nodes.


Method doesn't change selected nodes stack.


Example
```
 $template['node1']->elseIfPHP('$foo == 1');

```
Source
```
 <node1/>

```
Result
```
 <?php
 else if ($foo == 1) {
 ?><node1/><?php
 }
 ?>

```

---



### Comments allowed ###