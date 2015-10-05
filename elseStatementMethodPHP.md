# `elseStatement` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [else](elseSyntax.md) > [elseStatement](elseStatementMethodPHP.md)
### Parameters ###
  * **$separate** _separate_ = `false`

  * **$lang** _lang_ = `null`



### Description ###
TODO description


## Example ##


### Markup ###
```
 <div>1</div>
 <div>2</div>
 <div>3</div>

```
### Data ###
```
```
### `QueryTemplates` formula ###
```
 $template['div:eq(1)']->
     elseStatement()
 ;

```
### Template ###
```
 <div>1</div>
 <?php  else {  ?><div>2</div>
 <?php  }  ?>
 <div>3</div>

```
### Template tree before ###
```
 div
  - Text:1
 div
  - Text:2
 div
  - Text:3

```
### Template tree after ###
```
 div
  - Text:1
 PHP
 div
  - Text:2
 PHP
 div
  - Text:3

```

---



### Comments allowed ###