# `ToSelector` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [ToSelector](ToSelectorSyntax.md)

[ToSelector](ToSelectorSyntax.md) methods injects data (dynamic / static / executable) into nodes matched by **dynamic selector pattern**, based on provided **fields list**.

## Methods ##
### PHP ###
  * [codeToSelector](codeToSelectorMethodPHP.md)
  * [codeToSelectorAfter](codeToSelectorAfterMethodPHP.md)
  * [codeToSelectorAppend](codeToSelectorAppendMethodPHP.md)
  * [codeToSelectorAttr](codeToSelectorAttrMethodPHP.md)
  * [codeToSelectorBefore](codeToSelectorBeforeMethodPHP.md)
  * [codeToSelectorPrepend](codeToSelectorPrependMethodPHP.md)
  * [codeToSelectorReplace](codeToSelectorReplaceMethodPHP.md)
  * [valuesToSelector](valuesToSelectorMethodPHP.md)
  * [valuesToSelectorAfter](valuesToSelectorAfterMethodPHP.md)
  * [valuesToSelectorAppend](valuesToSelectorAppendMethodPHP.md)
  * [valuesToSelectorAttr](valuesToSelectorAttrMethodPHP.md)
  * [valuesToSelectorBefore](valuesToSelectorBeforeMethodPHP.md)
  * [valuesToSelectorPrepend](valuesToSelectorPrependMethodPHP.md)
  * [valuesToSelectorReplace](valuesToSelectorReplaceMethodPHP.md)
  * [varsToSelector](varsToSelectorMethodPHP.md)
  * [varsToSelectorAfter](varsToSelectorAfterMethodPHP.md)
  * [varsToSelectorAppend](varsToSelectorAppendMethodPHP.md)
  * [varsToSelectorAttr](varsToSelectorAttrMethodPHP.md)
  * [varsToSelectorBefore](varsToSelectorBeforeMethodPHP.md)
  * [varsToSelectorPrepend](varsToSelectorPrependMethodPHP.md)
  * [varsToSelectorReplace](varsToSelectorReplaceMethodPHP.md)

### JS ###
  * [valuesToSelector](valuesToSelectorMethodJS.md)
  * [valuesToSelectorAfter](valuesToSelectorAfterMethodJS.md)
  * [valuesToSelectorAppend](valuesToSelectorAppendMethodJS.md)
  * [valuesToSelectorAttr](valuesToSelectorAttrMethodJS.md)
  * [valuesToSelectorBefore](valuesToSelectorBeforeMethodJS.md)
  * [valuesToSelectorPrepend](valuesToSelectorPrependMethodJS.md)
  * [valuesToSelectorReplace](valuesToSelectorReplaceMethodJS.md)


## Example PHP ##
### Markup ###
```
 <p class='field1'>lorem ipsum</p>
 <p class='field2'>lorem ipsum</p>
```
### Data ###
```
 $foo = array('field1' => 'foo', 'field2' => 'bar');
```
### `QueryTemplates` Formula ###
```
 $template->varsToSelector('foo', $foo);
```
### Template ###
```
 <p class="field1"><?php  if (isset($foo['field1'])) print $foo['field1'];
 else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?></p>
 <p class="field2"><?php  if (isset($foo['field2'])) print $foo['field2'];
 else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?></p>
```
### Template tree before ###
```
 p.field1
  - Text:lorem ipsum
 p.field2
  - Text:lorem ipsum
```
### Template tree after ###
```
 p.field1
  - PHP
 p.field2
  - PHP
```