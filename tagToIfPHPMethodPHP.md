# `tagToIfPHP` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [if](ifSyntax.md) > [tagToIfPHP](tagToIfPHPMethodPHP.md)
### Parameters ###
  * **$code** _string_
> > Valid PHP condition code


### Description ###
Replaces selected tag with PHP "if" statement containing $code as condition.


Method doesn't change selected nodes stack.  detached from it's parent.


Example
```
 $template['.if']->tagToIfPHP('$foo == 1');

```
Source
```
 <div class='if'><node1/></div>

```
Result
```
 <?php
 if ($foo == 1) {
 ?><node1/><?php
 }
 ?>

```

---



### Comments allowed ###