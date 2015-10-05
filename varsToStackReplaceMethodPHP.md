# `varsToStackReplace` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsTo](varsToSyntax.md) > [varsToStackReplace](varsToStackReplaceMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable avaible in scope of type Array or Object.  $varName should NOT start with $.
  * **$varFields** _Array|Object_
> > Variable value with all fields (keys) OR array of variable fields (keys).  Param needs to be passed thou array\_keys for non-assosiative arrays.
  * **$skipFields** _Array_ = `null`
> > Array of keys from $varValue which should be skipped.
  * **$fieldCallback** _Callback|string_ = `null`
> > Callback triggered after every insertion. Three parameters are passed to  this callback:
      * $node phpQueryObject
      * $field String
      * $target String|array


### Description ###
Injects executable code printing variable's fields replacing actually matched  nodes. Second param needs to be wrapped with array\_keys for non-assosiative  arrays.


Method doesn't change selected elements stack.


## Example ##


### Markup ###
```
 <node1>
   <node2/>
 </node1>
 <node2/>
 <node1>
   <node2/>
 </node1>

```
### Data ###
```
 $foo = new stdClass();
 $foo->first = 'foo';
 $foo->second = 'bar';

```
### `QueryTemplates` formula ###
```
 $template['node1']->
     varsToStackReplace('foo', $foo)
 ;

```
### Template ###
```
 <?php  if (isset($foo['first'])) print $foo['first'];
 else if (isset($foo->{'first'})) print $foo->{'first'};  ?><node2></node2><?php  if (isset($foo['second'])) print $foo['second'];
 else if (isset($foo->{'second'})) print $foo->{'second'};  ?>

```
### Template tree before ###
```
 node1
  - node2
 node2
 node1
  - node2

```
### Template tree after ###
```
 PHP
 node2
 PHP

```

---


## See also ##
  * [varsToSelector](varsToSelectorMethodPHP.md)
  * [varsToForm](varsToFormMethodPHP.md)


### Comments allowed ###