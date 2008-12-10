function templateoutput(__data) {
	if (typeof __data != 'undefined')
		for (__dataRow in __data)
			eval('var '+__dataRow+' = __data[__dataRow]');
	var __template = '';
	var print = function(value) {
		__template += value;
	}
	__template += '<ul>\n';
 for (keyf4f3ad9d8e8519648bf0e01652885044 in data) {
		var row = data[keyf4f3ad9d8e8519648bf0e01652885044]; 
		if (row instanceof Function)
			continue; ;
	__template += '<li>';
 print(row); ;
	__template += '\n</li>\n';
 } 
	__template += '\n		\n		\n	</ul>';

	return __template;
}
document.write(templateoutput());