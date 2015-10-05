# `inputsFromValues` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [formFrom](formFromSyntax.md) > [inputsFromValues](inputsFromValuesMethodPHP.md)
### Parameters ###
  * **$data** _data_

  * **$type** _type_ = `'hidden'`



### Description ###
Creates markup with INPUT tags and prepends it to form.


If selected element isn't a FORM then find('form') is executed.


Method doesn't change selected elements stack.


## Example ##


### Markup ###
```
 <form>
   <input name='was-here-before'>
 </form>

```
### Data ###
```
 $data = array('field1' => 'foo', 'field2' => 'bar');

```
### `QueryTemplates` formula ###
```
 $template->inputsFromValues($data);

```
### Template ###
```
 <form>
   <input name='field1' value='foo'>
   <input name='field2' value='bar'>
   <input name='was-here-before'>
 </form>

```

---


## See also ##
  * [formFromValues](formFromValuesMethodPHP.md)


### Comments allowed ###