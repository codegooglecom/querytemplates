function templateoutput(__data) {
	if (typeof __data != 'undefined')
		for (__dataRow in __data)
			eval('var '+__dataRow+' = __data[__dataRow]');
	var __template = '';
	var print = function(value) {
		__template += value;
	}
	__template += '<ul>\
';
 for (__keye0b4c in data) {
		var row = data[__keye0b4c]; 
		if (row instanceof Function)
			continue; ;
	__template += '<li>';
 print(row); ;
	__template += '\
</li>\
';
 } 
	__template += '\
		\
		\
	</ul>';

	return __template;
}
document.write(templateoutput());