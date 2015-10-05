# `codeToStackAppend` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [codeTo](codeToSyntax.md) > [codeToStackAppend](codeToStackAppendMethodPHP.md)
### Parameters ###
  * **$codeArray** _String_
> > Array of raw code, where key is the field.
  * **$skipFields** _Array_ = `null`
> > Array of fields from $codeArray which should be skipped.
  * **$fieldCallback** _Callback|string_ = `null`
> > Callback triggered after every insertion. Three parameters are passed to  this callback:
      * $node phpQueryObject
      * $field String
      * $target String|array
  * **$selectorPattern**  = `'.%k'`



### Description ###
Injects raw executable code at the beggining of actually matched nodes.


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
 $code = array(
     'print "abba";',
     'foreach(array(1, 2, 3) as $i) print $i'
 );

```
### `QueryTemplates` formula ###
```
 $template->
     codeToStackAppend($code)
 ;

```
### Template ###
```
 <node1><node2></node2></node1><node2></node2><node1><node2></node2></node1><?php  print "abba";  ?>

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
 node1
  - node2
 node2
 node1
  - node2
 PHP

```

---


## See also ##
  * [codeToSelector](codeToSelectorMethodPHP.md)


### Comments allowed ###