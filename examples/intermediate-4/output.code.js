function templateoutput(__data) {
	if (typeof __data != 'undefined')
		for (__dataRow in __data)
			eval('var '+__dataRow+' = __data[__dataRow]');
	var __template = '';
	var print = function(value) {
		__template += value;
	}
	__template += '<form>\n		<legend>Form example</legend>\n		<fieldset><dl>\n<dt><label>input[type=text]</label></dt>\n				<dd>\n					<input type="text" name="text-example" value="';
 
 	print(data['text-example']);  
;
	__template += '">\n</dd>\n				<dt><label>input[type=checkbox]</label></dt>\n				<dd>\n					';
 if (data['checkbox-example'] == true) { ;
	__template += '<input type="checkbox" name="checkbox-example" value="foo" checked>';
 } 
 else { ;
	__template += '<input type="checkbox" name="checkbox-example" value="foo">';
 } 
	__template += '\n</dd>\n				<dt>input[type=radio]</dt>\n				<dd>\n					<label>[value=first]\n						';
 if (data['radio-example'] == 'first') { ;
	__template += '<input type="radio" name="radio-example" value="first" checked>';
 } 
 else { ;
	__template += '<input type="radio" name="radio-example" value="first">';
 } 
	__template += '</label>\n				</dd>\n				<dd>\n					<label>[value=second]\n						';
 if (data['radio-example'] == 'second') { ;
	__template += '<input type="radio" name="radio-example" value="second" checked>';
 } 
 else { ;
	__template += '<input type="radio" name="radio-example" value="second">';
 } 
	__template += '</label>\n				</dd>\n				<dt><label>select</label></dt>\n				<dd>\n					<select name="select-example">';
 if (data['select-example'] == 'first') { ;
	__template += '<option value="first" selected>First</option>\n';
 } 
 else { ;
	__template += '<option value="first">First</option>\n';
 } 
 if (data['select-example'] == 'second') { ;
	__template += '<option value="second" selected>Second</option>\n';
 } 
 else { ;
	__template += '<option value="second">Second</option>\n';
 } 
	__template += '</select>\n</dd>\n				<dt><label>textarea</label></dt>\n				<dd>\n					<textarea name="textarea-example">';
 print(data['textarea-example']); ;
	__template += '</textarea>\n</dd>\n			</dl></fieldset>\n</form>';

	return __template;
}
document.write(templateoutput());