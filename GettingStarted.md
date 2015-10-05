QuerieTemplates works in following steps
  * prepare HTML/XML markup
  * prepare data which will be injected into tempalte (optional)
  * create template from one or more sources, quering them if neccessary
  * query template and inject data
  * save template as PHP source file and include it

You can find [examples here on the wiki](Examples.md) and download [example blog implementation](http://code.google.com/p/querytemplates/downloads/list) using CakePHP framework.

## Data sources ##
  * **values** (static)
    * eg user messages, something what can be saved inside template
  * **vars** (variables, dynamic)
    * eg DB queries results, rss feeds, generaly fetched data
Each data source can be an array or object. Difference between values and vars is that vars are injected as literally variables and values are injected as "hardcoded" strings. This means you can use same data source (array or object) in 2 different ways, but the source is still the same.

## Data targets ##
  * **selector**
    * eg varsToSelector() propagates variable (array, object) contents replacing nodes matched by selector pattern based on variable key's
  * **form**
    * eg valuesToForm() switches form state according to passed values
  * **stack**
    * eg valuesToStackReplace() replaces actually stacked nodes with passed values (array or object)

You can find list of data injection methods on [Data Injection Methods page](DataInjectionMethods.md) and [Syntax reference](Syntax.md).