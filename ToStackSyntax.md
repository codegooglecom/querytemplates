# `ToStack` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [ToStack](ToStackSyntax.md)

[ToStack](ToStackSyntax.md) methods injects data (dynamic / static / executable) into actually matched nodes.

## Methods ##
### PHP ###
  * [codeToStack](codeToStackMethodPHP.md)
  * [codeToStackAfter](codeToStackAfterMethodPHP.md)
  * [codeToStackAppend](codeToStackAppendMethodPHP.md)
  * [codeToStackAttr](codeToStackAttrMethodPHP.md)
  * [codeToStackBefore](codeToStackBeforeMethodPHP.md)
  * [codeToStackPrepend](codeToStackPrependMethodPHP.md)
  * [codeToStackReplace](codeToStackReplaceMethodPHP.md)
  * [valuesToStack](valuesToStackMethodPHP.md)
  * [valuesToForm](valuesToFormMethodPHP.md)
  * [valuesToStackAfter](valuesToStackAfterMethodPHP.md)
  * [valuesToStackAppend](valuesToStackAppendMethodPHP.md)
  * [valuesToStackAttr](valuesToStackAttrMethodPHP.md)
  * [valuesToStackBefore](valuesToStackBeforeMethodPHP.md)
  * [valuesToStackPrepend](valuesToStackPrependMethodPHP.md)
  * [valuesToStackReplace](valuesToStackReplaceMethodPHP.md)
  * [varsToStack](varsToStackMethodPHP.md)
  * [varsToStackAfter](varsToStackAfterMethodPHP.md)
  * [varsToStackAppend](varsToStackAppendMethodPHP.md)
  * [varsToStackAttr](varsToStackAttrMethodPHP.md)
  * [varsToStackBefore](varsToStackBeforeMethodPHP.md)
  * [varsToStackPrepend](varsToStackPrependMethodPHP.md)
  * [varsToStackReplace](varsToStackReplaceMethodPHP.md)

### JS ###
  * [valuesToStack](valuesToStackMethodJS.md)
  * [valuesToStackAfter](valuesToStackAfterMethodJS.md)
  * [valuesToStackAppend](valuesToStackAppendMethodJS.md)
  * [valuesToStackAttr](valuesToStackAttrMethodJS.md)
  * [valuesToStackBefore](valuesToStackBeforeMethodJS.md)
  * [valuesToStackPrepend](valuesToStackPrependMethodJS.md)
  * [valuesToStackReplace](valuesToStackReplaceMethodJS.md)

## Example PHP ##
### Markup ###
```
 <node1>
   <node2></node2>
 </node1>
 <node2></node2>
 <node1>
   <node2></node2>
 </node1>
```
### Data ###
```
 $foo = array('<foo/>', '<bar/>');
```
### `QueryTemplates` Formula ###
```
 $template['node1']->varsToStack('foo', array_keys($foo));
```
### Template ###
```
 <node1><?php  if (isset($foo['0'])) print $foo['0'];
 else if (isset($foo->{'0'})) print $foo->{'0'};  ?></node1><node2></node2><node1><?php  if (isset($foo['1'])) print $foo['1'];
 else if (isset($foo->{'1'})) print $foo->{'1'};  ?></node1>
```
### Template tree before ###
```
 node1
  - node2
 node2
 node1
  - node2
```
### Template tree after ###
```
 node1
  - PHP
 node2
 node1
  - PHP
```