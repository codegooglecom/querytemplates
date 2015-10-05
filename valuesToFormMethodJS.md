# `valuesToForm` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToForm](valuesToFormMethodJS.md)
### Parameters ###
  * **values** _Object_

  * **selectorPattern** _String_ = `"[name*='%k']"`
> > Defines pattern matching form fields.  Defaults to "`[name*='%k']`", which matches fields containing  $values' key in their names. For example, to match only names starting with  "foo`[bar]`" change $selectorPattern to "`[name^='foo[bar]`']`[name*='%k']`"


### Description ###
Toggles form fields values and selection states according to static values  from values parameter.


This includes:

  * `input[type=radio][checked]`
  * `input[type=checkbox][checked]`
  * `select > option[selected]`
  * `input[value]`
  * `textarea`
Inputs are selected according to $selectorPattern, where %k represents  variable's key.


Method doesn't change selected elements stack.


Example
```
var data = {
  'text-example': 'new value',
  'checkbox-example': true,
  'radio-example': 'second',
  'select-example': 'second',
  'textarea-example': 'new value',
};
$('form')
  .valuesToForm(data);
```
Source
```
 <form>
   <input type='text' name='text-example' value='old'>
   <input type='checkbox' name='checkbox-example' value='foo'>
   <input type='radio' name='radio-example' value='first' checked='checked'>
   <input type='radio' name='radio-example' value='second'>
   <select name='select-example'>
     <option value='first' selected='selected'>first</option>
     <option value='second'>second</option>
   </select>
   <textarea name='textarea-example'>old</textarea>
 </form>

```
Result
```
 <form>
   <input type='text' name='text-example' value='new'>
   <input type='checkbox' name='checkbox-example' value='foo' checked='checked'>
   <input type='radio' name='radio-example' value='first'>
   <input type='radio' name='radio-example' value='second' checked='checked'>
   <select name='select-example'>
     <option value='first'>first</option>
     <option value='second' selected='selected'>second</option>
   </select>
   <textarea name='textarea-example'>new</textarea>
 </form>

```

---


## See also ##
  * [formFromValues](ormFromValuesMethodJS.md)


### Comments allowed ###