# `formFromVars` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [formFrom](formFromSyntax.md) > [formFromVars](formFromVarsMethodPHP.md)
### Parameters ###
  * **$varNames** _String|Array_
> > Array of names of following vars:
      * record `[0]`
> > > Represents actual record as array of fields.
      * errors `[1]`
> > > Represents actual errors as array of fields. Field can also be an array.
      * data `[2]`
> > > Overloads $defaultData during template's execution.  Names should be without dollar signs.  Ex:
```
 array('row', 'errors.row', 'data');
 $errors`['row']` = array(
   'field1' => 'one error',
   'field2' => array('first error', 'second error')
 );

```

  * **$structure** _Array_

> > Form structure information. This should be easily fetchable from ORM layer.  Possible types:
      * text (default)
      * password
      * hidden
      * checkbox
      * radio
      * textarea  Convention:
```
 'fieldName' => array(
   'fieldType', $fieldOptions
 )

```
> > Where $fieldOptions can be (`key => value` pairs):
      * label
      * id
      * multiple (only select)  // TODO
      * values (only radio, MANDATORY)
      * value (only checkbox, optional)  There can be special field **`__form`**, which represents form element, as an array.  All values from it will be pushed as form attributes.  If you wrap fields' array within another array, it will represent **fieldsets**,  which value with index **`__label`** will be used as legend (optional).
  * **$defaultRecord** _Array_ = `null`
> > Default field's value. Used when field isn't present within supplied record.  Ex:
```
 $defaultRecord = array(
     'text-field' => 'text-field default value',
     'select-field' => 'bar2',
     'select-field-optgroups-multiple' => array('group2_1', 'group2_2'),
     'checkbox-field' => false,
 );

```

  * **$defaultData** _Array_ = `null`
> > Additional data for fields. For now it's only used for populating select boxes.  Example:
```
 $defaultData = array(
     'select-field-optgroups' => array(
         array(    // 1st optgroup
             '__label' => 'optgroup 1 label',
             'group1_1' => 'group1_1 label',
             'group1_2' => 'group1_2 label',
         ),
         array(    // 2nd optgroup
             '__label' => 'optgroup 2 label',
             'group2_1' => 'group2_1 label',
             'group2_2' => 'group2_2 label',
         ),
         'bar' => 'Bar',    // no optgroup
     ),
 );

```

  * **$template** _Array|String_ = `null`
> > Input wrapper template. This template will be used for each field. Use array  to per field template, 'default' means default.  All types allowed in $structure can be used as per-type default template  when indexed like '$type' ex 'checkbox'.  To each input wrapper will be added a class which is field's type.  Example:
```
 $templates`['__checkbox']` = '
 <div class="input">
     <div>Checkbox field below</div>
   <label/>
   <input/>
 </div>';

```
> > Default template is:
```
 <div class="input">
   <label/>
   <input/>
   <ul class="errors">
     <li/>
   </ul>
 </div>

```

  * **$selectors** _Array_ = `null`
> > Array of selectors indexed by it's type. Allows to customize lookups inside  inputs wrapper. Possible values are:
      * error - selects field's error wrapper
        * dafault value is '.errors'
      * label - selects field's label node (can be div, span, etc)
        * default value is 'label:first'
        * use array to per field name selector, 'default' means default
      * input - selects field's input node: input, textarea or select
        * default value is 'input:first'
        * use array to per field name selector, 'default' means default
        * %t is replaced by field node type (use it with customized per field $template)
  * **$fieldCallback** _Array|String|Callback_ = `null`
> > Callback triggered after preparation of each field.


### Description ###
EXPERIMENTAL - works, but not for production code


Method formFromVars acts as flexible form helper. It creates customized  exacutable form without the need of suppling a line of markup.


Form code is executed during template-execution and creates final form  using record from variable.


Created form have following features:

  * shows data from record (array or object)
  * shows errors
  * supports default values
  * supports radios and checkboxes
  * supports select elements with optgroups
  * overloadable $defaultData
  * overloadable $defaultRecord
Created form can be customized using:

  * input wrapper template (per field name, per field type and default)
  * selectors (for input, label and errors)
  * callbacks (per field)
## Example ##
```
 $structure = array(
     '__form' => array('id' => 'myFormId'),
     array(
         '__label' => 'Fieldset 1 legend',
         'default-field' => array(    // 'text' is default
             'label' => 'default-field label',
             'id' => 'default-field-id',
         ),
         'text-field' => array('text',
             'label' => 'text-field label',
             'id' => 'text-field-id',
         ),
         'hidden-field' => 'hidden',
         'checkbox-field' => 'checkbox',
     ),
     array(
         '__label' => 'Fieldset 2 legend',
         'select-field' => array('select',
             'label' => 'select-field label',
         ),
         'select-field-optgroups-multiple' => array('select',
             'label' => 'select-field-optgroups label',
         ),
         'radio-field' => array('radio',
             'values' => array('possibleValue1', 'possibleValue2')
         ),
         'textarea-field' => 'textarea',
     ),
 );

```

---


## See also ##
  * [varsToForm](varsToFormMethodPHP.md)
  * [valuesToForm](valuesToFormMethodPHP.md)
  * [formFromValues](formFromValuesMethodPHP.md)


### Comments allowed ###