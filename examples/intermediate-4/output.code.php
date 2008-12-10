<form>
		<legend>Form example</legend>
		<fieldset><dl>
<dt><label>input[type=text]</label></dt>
				<dd>
					<input type="text" name="text-example" value="<?php 
 print is_object($data)
	? $data->text-example
	: $data['text-example']  
?>">
</dd>
				<dt><label>input[type=checkbox]</label></dt>
				<dd>
					<?php 
 if ((is_object($data) && $data->{'checkbox-example'} == true)
			|| (! is_object($data) && $data['checkbox-example'] == true)) { 
 ?><input type="checkbox" name="checkbox-example" value="foo" checked><?php 
 } 
  
 else { 
 ?><input type="checkbox" name="checkbox-example" value="foo"><?php 
 } 
 ?>
</dd>
				<dt>input[type=radio]</dt>
				<dd>
					<label>[value=first]
						<?php 
 if ((is_object($data) && $data->{'radio-example'} == 'first')
			|| (! is_object($data) && $data['radio-example'] == 'first')) { 
 ?><input type="radio" name="radio-example" value="first" checked><?php 
 } 
  
 else { 
 ?><input type="radio" name="radio-example" value="first"><?php 
 } 
 ?></label>
				</dd>
				<dd>
					<label>[value=second]
						<?php 
 if ((is_object($data) && $data->{'radio-example'} == 'second')
			|| (! is_object($data) && $data['radio-example'] == 'second')) { 
 ?><input type="radio" name="radio-example" value="second" checked><?php 
 } 
  
 else { 
 ?><input type="radio" name="radio-example" value="second"><?php 
 } 
 ?></label>
				</dd>
				<dt><label>select</label></dt>
				<dd>
					<select name="select-example"><?php 
 if ((is_object($data) && $data->{'select-example'} == 'first')
			|| (! is_object($data) && $data['select-example'] == 'first')) { 
 ?><option value="first" selected>First</option>
<?php 
 } 
  
 else { 
 ?><option value="first">First</option>
<?php 
 } 
  
 if ((is_object($data) && $data->{'select-example'} == 'second')
			|| (! is_object($data) && $data['select-example'] == 'second')) { 
 ?><option value="second" selected>Second</option>
<?php 
 } 
  
 else { 
 ?><option value="second">Second</option>
<?php 
 } 
 ?></select>
</dd>
				<dt><label>textarea</label></dt>
				<dd>
					<textarea name="textarea-example"><?php 
 print is_object($data)
	? $data->textarea-example
	: $data['textarea-example'] 
 ?></textarea>
</dd>
			</dl></fieldset>
</form>