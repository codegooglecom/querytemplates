# `valuesToStackReplace` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToStackReplace](valuesToStackReplaceMethodPHP.md)
### Parameters ###
  * **$values** _Array|Object_
> > Associative array or Object containing markup, text or instance of Callback.
  * **$fieldCallback** _Callback|string_ = `null`
> > Callback triggered after every insertion. Three parameters are passed to  this callback:
      * $node phpQueryObject
      * $field String
      * $target String|array
  * **$skipFields**  = `null`



### Description ###
Injects markup from $values' content (rows or attributes) inside actually  selected nodes.


Method doesn't change selected nodes stack.


## Example ##


### Markup ###
```
 <node1>
     <node2></node2>
 </node1>
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
     valuesToStackReplace($values)
 ;

```
### Template ###
```
 <foo></foo><bar></bar>

```
### Template tree before ###
```
 node1
  - node2
 node1
  - node2

```
### Template tree after ###
```
 foo
 bar

```

---


## See also ##
  * [valuesToSelector](valuesToSelectorMethodPHP.md)
  * [valuesToForm](valuesToFormMethodPHP.md)


### Comments allowed ###