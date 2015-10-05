# `varPrintAppend` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varPrint](varPrintSyntax.md) > [varPrintAppend](varPrintAppendMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable avaible in scope of type Array or Object.  $varName should NOT start with $.


### Description ###
Prints variable $varName on the end of matched elements.


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
     varPrintAppend('data.foo.bar.0')
 ;

```
### Template ###
```
 <div>
     <p>FOO<?php  if (isset($data['foo']['bar']['0'])) print $data['foo']['bar']['0'];
 else if (isset($data->{'foo'}->{'bar'}->{'0'})) print $data->{'foo'}->{'bar'}->{'0'};  ?></p>
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
  -  - PHP

```

---



### Comments allowed ###