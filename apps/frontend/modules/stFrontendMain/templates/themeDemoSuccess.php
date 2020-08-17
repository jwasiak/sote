<?php st_theme_use_stylesheet('stThemeDemo.css') ?>
<div id="content_demo" class="tinymce_html">

<h1>Description of the elements present in the store</h1>
<br/>
<h2>Headers</h2>
<br/>
<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>
<br/>
<h2>Paragraph</h2>
<p>
Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, <a href="">tincidunt nec, gravida vehicula</a>, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.
</p>
<p>
Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.
</p>

<h2>List</h2>

<dl>
<dt>Title definition list - element dt</dt>
<dd>Division of definition list - element dd</dd>
</dl>

<h3>Numbered List</h3>
<ol>
<li>Example 1
    <ol>
        <li>Example 1</li>
        <li>Example 2
            <ol>
                <li>Level 2 - 1</li>
                <li>Level 2 - 2</li>                
            </ol>
        </li>        
    </ol>
</li>
<li>Example 2</li>
<li>Example 3</li>
</ol>
<br/><br/>
<h3>Unordered List</h3>
<ul>
<li>Example 1
    <ul>
        <li>Example 1</li>
        <li>Example 2
            <ul>
                <li>Level 2 - 1</li>
                <li>Level 2 - 2</li>                
            </ul>
        </li>        
    </ul>
</li>
<li>Example 2</li>
<li>Example 3</li>
</ul>
<br/><br/>
<h2>Forms</h2>

<p>Text box</p>
<form>
    <input type="text" id="text_field">
</form>

<p>Text area</p>
<form>
    <textarea id="text_area"></textarea>
</form>

<p>The selection of options ( select )</p>
<select name="select_element">
    <option value="1">Opcja 1</option>
    <option value="2">Opcja 2</option>
    <option value="3">Opcja 3</option>
</select>

<p>Radio buttons</p>
<p>
<input type="radio" value="radio_1" name="radio_button"><label>Radio 1</label><br/>
<input type="radio" value="radio_1" name="radio_button"><label>Radio 2</label><br/>
<input type="radio" value="radio_1" name="radio_button"><label>Radio 3</label><br/>
</p>

<p>Checkbox</p>
<p>
<input type="checkbox" value="check_1" name="checkboxes"><label>Checkox 1</label><br/>
<input type="checkbox" value="check_1" name="checkboxes"><label>Checkox 2</label><br/>
<input type="checkbox" value="check_1" name="checkboxes"><label>Checkox 3</label><br/>
</p>

<p>File upload</p>
<p>
<input type="file" name="file" class="file">
</p>
<p>
<input type="reset" value="Clear" class="button">
<input type="submit" value="Submit" class="button">
</p>

<p>Button</p>
<button>Button</button>
<br/><br/>
<br/><br/>
<h2>Table</h2>

<table cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <th>Table header 1</th>
            <th>Table header 2</th>
            <th>Table header 3</th>
        </tr>
        <tr>
            <td>Cell 1</td>
            <td>Cell 2</td>
            <td>Cell 3</td>
        </tr>
        <tr>
            <td>Cell 1</td>
            <td>Cell 2</td>
            <td>Cell 3</td>
        </tr>
        <tr>
            <td>Cell 1</td>
            <td>Cell 2</td>
            <td>Cell 3</td>
        </tr>
    </tbody>
</table>
<br/><br/>
<h2>The various elements – abbr, acronym, pre, code, sub, sup, etc</h2>
<p>Lorem <sup>superscript</sup> dolor <sub>subscript</sub> amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. <cite>cite</cite>. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. <acronym title="National Basketball Association">NBA</acronym> Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.  <abbr title="Avenue">AVE</abbr></p>

<pre>

Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit.
 Nullam dignissim convallis est.
 Quisque aliquam. Donec faucibus.
Nunc iaculis suscipit dui.
Nam sit amet sem.
Aliquam libero nisi, imperdiet at,
 tincidunt nec, gravida vehicula,
 nisl.
Praesent mattis, massa quis
luctus fermentum, turpis mi
volutpat justo, eu volutpat
enim diam eget metus.
Maecenas ornare tortor.
Donec sed tellus eget sapien
 fringilla nonummy.
<acronym title="National Basketball Association">NBA</acronym>
Mauris a ante. Suspendisse
 quam sem, consequat at,
commodo vitae, feugiat in,
nunc. Morbi imperdiet augue
 quis tellus.
<abbr title="Avenue">AVE</abbr>
</pre>

<blockquote><p>
	“This stylesheet is going to help so freaking much.” <br>-Blockquote
</p></blockquote>

<div style="margin-top:30px; padding-top:30px; border-top:1px solid #ccc;">
    <h2>Elements used in the shop ( box , box with a header)</h2>
    <br/><br/>
    <h3>Box box class and the class roundies</h3>
    <div class="box roundies space5">
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus.
    </div>
    <br/><br/>
    <h3>Box box class and class roundies with head in the midst of</h3>
    <div class="box roundies" id="box-1">
        <h3 class="head">Boxing news</h3>
        <div class="content">
            <p style="text-align: left;">Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est.</p> 
        </div>
    </div>

</div>

</div>