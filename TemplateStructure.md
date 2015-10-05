## Minimal template structure ##
```
// intialize 
require(template()
   // fetch sources
  ->sourceCollect('myfile.html')
  // start parsing
  ->parse()
    // inject sources
    ->source('myfile.html')->returnReplace()
    // inject data
    ->find('.target')->php('print $data')->end()
  // save for inclusion
  ->save()
);
```
Last 2 methods /end() and save()/ can be omitted, as every toString conversion triggers save(), which saves whole template, not actually matched stack.