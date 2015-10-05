# `tagToElseIfPHP` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [else](elseSyntax.md) > [tagToElseIfPHP](tagToElseIfPHPMethodPHP.md)
### Parameters ###
  * **$code** _string_
> > Valid PHP condition code


### Description ###
Replaces selected tag with PHP "else if" statement containing $code as condition.


Method doesn't change selected nodes stack.  detached from it's parent.


Example
```
 $template['.else-if']->tagToElseIfPHP('$foo == 1');

```
Source
```
 <div class='else-if'><node1/></div>

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