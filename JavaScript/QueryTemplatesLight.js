/**
 * QueryTemplates -  DOM and CSS oriented template engine
 *
 * Light version for JavaScript.
 *
 * @version 1.0 beta1
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/querytemplates/
 * @todo form methods, mutation events support
 */
(function test($){
var QueryTemplates = {};
var valuesToSelector = function(target, values, selectorPattern, skipFields, fieldCallback){
	if (typeof selectorPattern == 'undefined')
		selectorPattern = '.%k';
	var _target = target;
	var targetData = null;
	if (target.constructor == Array) {
		targetData = target.slice(1);
		target = target[0];
	}
	if (! $.isFunction(fieldCallback))
		fieldCallback = null;
	for (k in values) {
		var v = values[k];
		if (skipFields && $.inArray(skipFields, k))
			continue;
		if ($.isFunction(v))
			v = v();
		var selector = selectorPattern.replace('%k', k);
		var node = this.find(selector);
		switch(target) {
			case 'attr':
				node[target](targetData[0], v);
				break;
			default:
				node[target](v);
			if (fieldCallback)
				fieldCallback.call(node, k, _target);
		}
	}
	return this;
};
var valuesToStack = function(target, values, skipFields, fieldCallback){
	var _target = target;
	var targetData = null;
	if (target.prototype == Array) {
		targetData = target.slice(1);
		target = target[0];
	}
	if (! $.isFunction(fieldCallback))
		fieldCallback = null;
	var i = 0;
	for (k in values) {
		var v = values[k];
		if (skipFields && $.inArray(skipFields, k))
			continue;
		if ($.isFunction(v))
			v = v();
		var node = this.eq(i++);
		switch(target) {
			case 'attr':
				node[target](targetData[0], v);
				break;
			default:
				node[target](v);
			if (fieldCallback)
				fieldCallback.call(node, v, _target);
		}
	}
	return this;
};
var valuesToLoop = function(nodes, values, rowCallback){
	if (typeof rowCallback == 'undefined')
		throw "rowCallback needs to be provided for valuesToLoop";
	var lastNode = nodes;
	for (k in values) {
		var v = values[k];
		var stack = [];
		nodes.each(function(i, node){
			stack.push($(node).clone().insertAfter(lastNode).get(0));
		});
		lastNode = $(stack);
		rowCallback.call(lastNode, v, k);
	}
	// we used those nodes as template
	nodes.remove();
	return this;
};
QueryTemplates.valuesToLoop = function(values, rowCallback) {
	return valuesToLoop(this, values, rowCallback);
};
QueryTemplates.valuesToLoopFirst = function(values, rowCallback) {
	var loopNodes = this.eq(0);
	this.slice(1).remove();
	valuesToLoop(loopNodes, values, rowCallback);
	return loopNodes;
};
QueryTemplates.valuesToLoopSeparate = function(values, rowCallback) {
	this.each(function(i, node) {
		return valuesToLoop(node, values, rowCallback);
	});
	return this;
};
QueryTemplates.valuesToForm = function(){
	// TODO
};
QueryTemplates.formFromValues = function(){
	// TODO
};
function whoisNode(node) {
	var output = [];
	if (node.tagName) {
		node = $(node);
		output.push(node.get(0).tagName.toLowerCase()
			+ (node.attr('id')
				? '#'+node.attr('id') : '')
			+ (node.attr('class')
				? '.'+node.attr('class').split(' ').join('.') : '')
			+ (node.attr('name')
				? '[name="'+node.attr('name')+'"]' : '')
			+ (node.attr('value') && typeof node.attr('value') != 'number'
				? '[value="'+node.attr('value').toString().substr(0, 15).replace("/\n/g", ' ')+'"]' : '')
			+ (node.attr('selected')
				? '[selected]' : '')
			+ (node.attr('checked')
				? '[checked]' : '')
		);
	} else {
		if ($.trim(node.textContent)) {
			output.push("Text:"+node.textContent
				.substr(0, 15)
				.replace("/\n/g", ' ')
			);
		}
	}
	return output[0];
}
function __dumpTree(node, itend) {
	if (typeof itend == 'undefined')
		itend = 0;
	var output = '';
	var whois = whoisNode(node);
	if (whois) {
		for(var i = 0; i < itend; i++)
			output += ' - ';
		output += whois+"\n";
	}
	if (node.childNodes)
		$.each(node.childNodes, function(i, chNode) {
			output += __dumpTree(chNode, itend+1);
		});
	return output;
}
QueryTemplates.dumpTree = function() {
	var output = '';
	this.each(function(i, node) {
		output += __dumpTree(node);
	});
	if (typeof console != 'undefined')
		console.log(output);
	else
		alert(output);
}
$.each(['Selector', 'Stack'], function(i, m) {
	$.each(['', 'Before', 'After', 'Prepend', 'Append', 'Attr'], function(ii, t) {
		QueryTemplates['valuesTo'+m+t] = function() {
			if (t == '')
				t = 'html';
			var params = [t];
			$.each(arguments, function(iii, a) {
				params.push(a);
			});
			return eval('valuesTo'+m).apply(this, params);
		};
	});
});
//console.log(QueryTemplates);
$.extend($.fn, QueryTemplates);
})(jQuery);