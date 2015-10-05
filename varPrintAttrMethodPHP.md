# `varPrintAttr` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varPrint](varPrintSyntax.md) > [varPrintAttr](varPrintAttrMethodPHP.md)
### Parameters ###
  * **$attr** _String_
> > Target attribute name.
  * **$varName** _String_
> > Variable avaible in scope of type Array or Object.  $varName should NOT start with $.


### Description ###
Prints variable $varName as attribute $attr of matched elements.


## Example ##


### Markup ###
```
 <div>
     <p>FOO</p>
 </div>

```
### Data ###
```
 $data = array(
   'foo' => array(
       'bar' => array('printMe')
   )
 );

```
### `QueryTemplates` formula ###
```
 $template['p']->
     varPrintAttr('rel', 'data.foo.bar.0')
 ;

```
### Template ###
```
 <div>
     <p data.foo.bar.0="<?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
 else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?>">FOO</p>
 </div>

```
### Template tree before ###
```
 div
  - p
  -  - Text:FOO

```
### Template tree after ###
```
 div
  - p
  -  - Text:FOO

```

---



### Comments allowed ###