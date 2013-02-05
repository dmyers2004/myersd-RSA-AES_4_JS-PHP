<form id="example-form" name="example-form" class="form-horizontal" method="post" action="/<?=$uri ?>">

  <div class="control-group">
    <label class="control-label" for="inputEmail">Text</label>
    <div class="controls">
      <input type="text" name="text" id="inputEmail" value="johndoe@deer.com">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">TextArea</label>
    <div class="controls">
      <textarea rows="3" name="textarea">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.
Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.
Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.
Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</textarea>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">Checkbox</label>
    <div class="controls">
      <label class="checkbox">
			<input type="checkbox" name="checkbox" value="1">
				Option one is this and that—be sure to include why it's great
			</label>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">Radio Button</label>
    <div class="controls">
			<label class="radio">
			  <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
			  Option one is this and that—be sure to include why it's great
			</label>
			<label class="radio">
			  <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
			  Option two can be something else and selecting it will deselect option one
			</label>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">Color</label>
    <div class="controls">
      <select name="color">
      	<option value="red">Red</option>
      	<option value="blue">Blue</option>
      	<option value="green">Green</option>
      	<option value="yellow">Yellow</option>
      	<option value="white">White</option>
			</select>
    </div>
  </div>
	<input id="form-submit" class="btn" type="button" value="Submit">
	<input type="hidden" name="onetime" value="onetime123">
</form>