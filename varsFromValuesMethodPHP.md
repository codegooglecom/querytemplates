# `varsFromValues` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsFrom](varsFromSyntax.md) > [varsFromValues](varsFromValuesMethodPHP.md)
### Parameters ###
  * **$varsArray** _array_



### Description ###
Behaves as var\_export, dumps variables from $varsArray as $key = value for  later use during template execution. Variables are prepended into selected  elemets.


Method doesn't change selected elements stack.


## Example ##


### Markup ###
```
 <node1>
     <node2></node2>
 </node1>

```
### Data ###
```
 $values = array('<foo/>', '<bar/>');

```
### `QueryTemplates` formula ###
```
 $template['node1']->
   varsFromValues($values)
 ;

```
### Template ###
```
 <node1><?php  $0 = '<foo/>';
 $1 = '<bar/>';  ?><node2></node2></node1>

```
### Template tree before ###
```
 node1
  - node2

```
### Template tree after ###
```
 node1
  - PHP
  - node2

```

---



### Comments allowed ###