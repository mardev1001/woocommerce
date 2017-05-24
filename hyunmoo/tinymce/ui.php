<?php
$page = $_GET['page'];
header( 'Cache-Control: private' );
?>
<!DOCTYPE html>
<head>
	<script type="text/javascript" src="../../../../wp-includes/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<link rel='stylesheet' href='shortcode.css' type='text/css' media='all' />
<?php
if( $page == 'alert' ){
 ?>
 	<script type="text/javascript">
		var Addalert = {
			e: '',
			init: function(e) {
				Addalert.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var alerttype = jQuery('#alerttype').val();
				var alertcontent = jQuery('#alertcontent').val();

				var output = '[alert ';
				
				if(alerttype) {
					output += 'type="'+alerttype+'"';
				}
				if(alertcontent==""){
					output += ']';
				}else{
					output += ']'+alertcontent+'[/alert]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addalert.init, Addalert);

	</script>
	<title>Add Alert</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Type :</td>
		<td><select id="alerttype" name="alerttype">
			<option value="success">Success</option>
			<option value="info">Info</option>
			<option value="warning">Warning</option>
			<option value="danger">Danger</option>
		</select></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="alertcontent" name="alertcontent"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addalert.insert(Addalert.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'button' ){
 ?>
 	<script type="text/javascript">
		var AddButtons = {
			e: '',
			init: function(e) {
				AddButtons.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var buttontype = jQuery('#buttontype').val();
				var buttonsize = jQuery('#buttonsize').val();
				var buttonlink = jQuery('#buttonlink').val();
				var buttontext = jQuery('#buttontext').val();

				var output = '[button ';
				
				if(buttontype) {
					output += 'type="'+buttontype+'" ';
				}
				if(buttonsize) {
					output += 'size="'+buttonsize+'" ';
				}
				if(buttonlink) {
					output += 'link="'+buttonlink+'" ';
				}
				if( jQuery('#buttontarget').is(':checked') ) {
					output += 'target="blank" ';
				}

				if(buttontext==""){
					output += ']';
				}else{
					output += ']'+buttontext+'[/button]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(AddButtons.init, AddButtons);

	</script>
	<title>Add Buttons</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Type :</td>
		<td><select id="buttontype" name="buttontype">
			<option value="default">Default</option>
			<option value="secondary">Secondary</option>
			<option value="warning">Warning</option>
			<option value="primary">Primary</option>
			<option value="success">Success</option>
			<option value="info">Info</option>
			<option value="danger">Danger</option>
		</select></td>
	</tr>
	<tr>
		<td>Size :</td>
		<td><select id="buttonsize" name="buttonsize">
			<option value="medium">Medium</option>
			<option value="small">Small</option>
			<option value="extrasmall">Extra Small</option>
			<option value="large">Large</option>
		</select></td>
	</tr>
	<tr>
		<td>Link :</td>
		<td><input id="buttonlink" name="buttonlink" type="text" value="http://" /></td>
	</tr>
	<tr>
		<td>Open Link in a new window :</td>
		<td><input id="buttontarget" name="buttontarget" type="checkbox" value="true" /></td>
	</tr>
	<tr>
		<td>Button Text :</td>
		<td><input id="buttontext" name="buttontext" type="text" value="" /></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:AddButtons.insert(AddButtons.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php }else if( $page == 'parallax' ){
 ?>
 	<script type="text/javascript">
		var Addparallax = {
			e: '',
			init: function(e) {
				Addparallax.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var parallaxspeed = jQuery('#parallaxspeed').val();
				var parallaxbgurl = jQuery('#parallaxbgurl').val();
				var parallaxheight = jQuery('#parallaxheight').val();
				var parallaxcontentstyle = jQuery('#parallaxcontentstyle').val();
				var parallaxcontent = jQuery('#parallaxcontent').val();

				var output = '[parallax ';
				
				if(parallaxspeed) {
					output += 'speed="'+parallaxspeed+'" ';
				}
				if(parallaxbgurl) {
					output += 'bgurl="'+parallaxbgurl+'" ';
				}
				if(parallaxheight) {
					output += 'height="'+parallaxheight+'" ';
				}
				if(parallaxcontentstyle) {
					output += 'contentstyle="'+parallaxcontentstyle+'" ';
				}
				if(parallaxcontent==""){
					output += ']';
				}else{
					output += ']'+parallaxcontent+'[/parallax]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addparallax.init, Addparallax);

	</script>
	<title>Add Parallax</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Speed:</td>
		<td><input id="parallaxspeed" name="parallaxspeed" type="text" value="0" /><br><small>Please Input value from 0 to 1.</small></td>
	</tr>
	<tr>
		<td>Background URL:</td>
		<td><input id="parallaxbgurl" name="parallaxbgurl" type="text" value="http://" /></td>
	</tr>
	<tr>
		<td>Height:</td>
		<td><input id="parallaxheight" name="parallaxheight" type="text" value="100" /></td>
	</tr>
	<tr>
		<td>Content Style:</td>
		<td><input id="parallaxcontentstyle" name="parallaxcontentstyle" type="text" value="padding-top:20px" /></td>
	</tr>
	<tr>
		<td>Parallax Content:</td>
		<td><textarea id="parallaxcontent" name="parallaxcontent" value="" /></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addparallax.insert(Addparallax.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'circle' ){
 ?>
 	<script type="text/javascript">
		var AddCircle = {
			e: '',
			init: function(e) {
				AddCircle.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var circlebgimg = jQuery('#circlebgimg').val();
				var circlebgcolor = jQuery('#circlebgcolor').val();
				var circleborderradius = jQuery('#circleborderradius').val();
				var circlesize = jQuery('#circlesize').val();
				var circleborder = jQuery('#circleborder').val();
				var circlecontentstyle = jQuery('#circlecontentstyle').val();
				var circlecontent = jQuery('#circlecontent').val();

				var output = '[circle ';
				
				if(circlebgimg) {
					output += 'bgimg="'+circlebgimg+'" ';
				}
				if(circlebgcolor) {
					output += 'bgcolor="'+circlebgcolor+'" ';
				}
				if(circleborderradius) {
					output += 'borderradius="'+circleborderradius+'" ';
				}
				if(circlesize) {
					output += 'size="'+circlesize+'" ';
				}
				if(circleborder) {
					output += 'border="'+circleborder+'" ';
				}
				if(circlecontentstyle) {
					output += 'contentstyle="'+circlecontentstyle+'" ';
				}
				if(circlecontent==""){
					output += ']';
				}else{
					output += ']'+circlecontent+'[/circle]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(AddCircle.init, AddCircle);

	</script>
	<title>Add Circle</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Background Image:</td>
		<td><input id="circlebgimg" name="circlebgimg" type="text" value="" /></td>
	</tr>
	<tr>
		<td>Background Color:</td>
		<td><input id="circlebgcolor" name="circlebgcolor" type="text" value="#000" /></td>
	</tr>
	<tr>
		<td>Border Radius:</td>
		<td><input id="circleborderradius" name="circleborderradius" type="text" value="50%" /></td>
	</tr>
	<tr>
		<td>Size:</td>
		<td><input id="circlesize" name="circlesize" type="text" value="200px" /></td>
	</tr>
	<tr>
		<td>Border:</td>
		<td><input id="circleborder" name="circleborder" type="text" value="1px solid #ddd" /></td>
	</tr>
	<tr>
		<td>Content Style:</td>
		<td><input id="circlecontentstyle" name="circlecontentstyle" type="text" value="padding:20px" /></td>
	</tr>
	<tr>
		<td>Content:</td>
		<td><input id="circlecontent" name="circlecontent" type="text" value="" /></td>
	</tr>
	<tr><td colspan="2" align="center"><a class="add" href="javascript:AddCircle.insert(AddCircle.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'docviewer' ){
 ?>
 	<script type="text/javascript">
		var Adddocviewer = {
			e: '',
			init: function(e) {
				Adddocviewer.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var docviewerlink = jQuery('#docviewerlink').val();
				var docviewerstyle = jQuery('#docviewerstyle').val();
				var docviewerwidth = jQuery('#docviewerwidth').val();
				var docviewerheight = jQuery('#docviewerheight').val();

				var output = '[docviewer ';
				
				if(docviewerlink) {
					output += 'url="'+docviewerlink+'" ';
				}
				if(docviewerstyle) {
					output += 'style="'+docviewerstyle+'" ';
				}
				if(docviewerwidth) {
					output += 'width="'+docviewerwidth+'" ';
				}
				if(docviewerheight){
					output += 'height="'+docviewerheight+'" ';
				}
				output +="]";
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Adddocviewer.init, Adddocviewer);

	</script>
	<title>Add Docviewer</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>URL :</td>
		<td><input id="docviewerlink" name="docviewerlink" type="text" value="http://" /></td>
	</tr>
	<tr>
		<td>Style :</td>
		<td><input id="docviewerstyle" name="docviewerstyle" type="text" value="border: none, margin: 0 auto" /></td>
	</tr>
	<tr>
		<td>Width :</td>
		<td><input id="docviewerwidth" name="docviewerwidth" type="text" value="700" /></td>
	</tr>
	<tr>
		<td>Height :</td>
		<td><input id="docviewerheight" name="docviewerheight" type="text" value="500" /></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Adddocviewer.insert(Adddocviewer.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'donate' ){
 ?>
 	<script type="text/javascript">
		var Adddonate = {
			e: '',
			init: function(e) {
				Adddonate.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var donateemail = jQuery('#donateemail').val();
				var donatename = jQuery('#donatename').val();
				var donatecurrency = jQuery('#donatecurrency').val();
				var donateimage = jQuery('#donateimage').val();

				var output = '[donate ';
				
				if(donateemail) {
					output += 'email="'+donateemail+'" ';
				}
				if(donatename) {
					output += 'name="'+donatename+'" ';
				}
				if(donatecurrency) {
					output += 'currency="'+donatecurrency+'" ';
				}
				if(donateimage){
					output += 'image="'+donateimage+'" ';
				}
				output +="]";
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Adddonate.init, Adddonate);

	</script>
	<title>Add Donate</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Email :</td>
		<td><input id="donateemail" name="donateemail" type="text" value="" /></td>
	</tr>
	<tr>
		<td>Name :</td>
		<td><input id="donatename" name="donatename" type="text" value="Donate" /></td>
	</tr>
	<tr>
		<td>Currency :</td>
		<td><input id="donatecurrency" name="donatecurrency" type="text" value="USD" /></td>
	</tr>
	<tr>
		<td>Image :</td>
		<td><input id="donateimage" name="donateimage" type="text" value="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" /></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Adddonate.insert(Adddonate.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'heading' ){
 ?>
 	<script type="text/javascript">
		var Addheading = {
			e: '',
			init: function(e) {
				Addheading.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var headingalign = jQuery('#headingalign').val();
				var headingcolor = jQuery('#headingcolor').val();
				var headingfontsize = jQuery('#headingfontsize').val();
				var headingbgcolor = jQuery('#headingbgcolor').val();
				var headingotherstyle = jQuery('#headingotherstyle').val();
				var headingcontent = jQuery('#headingcontent').val();

				var output = '[h1 ';
				
				if(headingalign) {
					output += 'textalign="'+headingalign+'" ';
				}
				if(headingcolor) {
					output += 'color="'+headingcolor+'" ';
				}
				if(headingfontsize) {
					output += 'fontsize="'+headingfontsize+'" ';
				}
				if(headingbgcolor) {
					output += 'bgcolor="'+headingbgcolor+'" ';
				}
				if(headingotherstyle) {
					output += 'otherstyle="'+headingotherstyle+'" ';
				}
				if(headingcontent==""){
					output += ']';
				}else{
					output += ']'+headingcontent+'[/h1]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addheading.init, Addheading);

	</script>
	<title>Add Heading</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Text align :</td>
		<td><select id="headingalign" name="headingalign">
        	<option value="left">Left</option>
            <option value="center">Center</option>
            <option value="right">Right</option>
        </select></td>
	</tr>
	<tr>
		<td>Color :</td>
		<td><input type="text" id="headingcolor" name="headingcolor" value="#333"></td>
	</tr>
	<tr>
		<td>Font size :</td>
		<td><input type="text" id="headingfontsize" name="headingfontsize" value="30"></td>
	</tr>
	<tr>
		<td>Background Color :</td>
		<td><input type="text" id="headingbgcolor" name="headingbgcolor" value="rgba(0,0,0,0.7)"></td>
	</tr>
	<tr>
		<td>Other Style :</td>
		<td><input type="text" id="headingotherstyle" name="headingotherstyle" value="padding:5px"></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="headingcontent" name="headingcontent"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addheading.insert(Addheading.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php }else if( $page == 'blockquote' ){
 ?>
 	<script type="text/javascript">
		var Addblockquote = {
			e: '',
			init: function(e) {
				Addblockquote.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var blockquotecolor = jQuery('#blockquotecolor').val();
				var blockquotefontsize = jQuery('#blockquotefontsize').val();
				var blockquoteauthor = jQuery('#blockquoteauthor').val();
				var blockquotecontent = jQuery('#blockquotecontent').val();

				var output = '[hmblockquote ';
				
				if(blockquotecolor) {
					output += 'color="'+blockquotecolor+'" ';
				}
				if(blockquotefontsize) {
					output += 'fontsize="'+blockquotefontsize+'" ';
				}
				if(blockquoteauthor) {
					output += 'author="'+blockquoteauthor+'" ';
				}
				if(blockquotecontent==""){
					output += ']';
				}else{
					output += ']'+blockquotecontent+'[/hmblockquote]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addblockquote.init, Addblockquote);

	</script>
	<title>Add blockquote</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Color :</td>
		<td><input type="text" id="blockquotecolor" name="blockquotecolor" value="#555"></td>
	</tr>
	<tr>
		<td>Font size :</td>
		<td><input type="text" id="blockquotefontsize" name="blockquotefontsize" value="15"></td>
	</tr>
	<tr>
		<td>Author :</td>
		<td><input type="text" id="blockquoteauthor" name="blockquoteauthor" value="Author"></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="blockquotecontent" name="blockquotecontent"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addblockquote.insert(Addblockquote.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'highlight' ){
 ?>
 	<script type="text/javascript">
		var Addhighlight = {
			e: '',
			init: function(e) {
				Addhighlight.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var highlightcolor = jQuery('#highlightcolor').val();
				var highlightcontent = jQuery('#highlightcontent').val();

				var output = '[highlight ';
				
				if(highlightcolor) {
					output += 'color="'+highlightcolor+'"';
				}
				if(highlightcontent==""){
					output += ']';
				}else{
					output += ']'+highlightcontent+'[/highlight]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addhighlight.init, Addhighlight);

	</script>
	<title>Add Highlight</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Color :</td>
		<td><input type="text" id="highlightcolor" name="highlightcolor" value="yellow"></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="highlightcontent" name="highlightcontent"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addhighlight.insert(Addhighlight.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'productcatslider' ){
 ?>
 	<script type="text/javascript">
		var Addproductcatslider = {
			e: '',
			init: function(e) {
				Addproductcatslider.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var prodcatparent = jQuery('#prodcatparent').val();
				var prodcatdisplayitem = jQuery('#prodcatdisplayitem').val();
				
				var output = '[hm_product_categories_slider ';
				
				if(prodcatparent) {
					output += 'parent="'+prodcatparent+'" ';
				}
				if(prodcatdisplayitem) {
					output += 'displayitem="'+prodcatdisplayitem+'" ';
				}
				output += ']';
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addproductcatslider.init, Addproductcatslider);

	</script>
	<title>Add Product Category Slider</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Parent :</td>
		<td><input type="text" id="prodcatparent" name="prodcatparent" value=""></td>
	</tr>
	<tr>
		<td>Display Item Number :</td>
		<td><select id="prodcatdisplayitem" name="prodcatdisplayitem">
		<option value="false">False</option>
		<option value="true">True</option>
		</select></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addproductcatslider.insert(Addproductcatslider.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'productcatlist' ){
 ?>
 	<script type="text/javascript">
		var Addproductcatlist = {
			e: '',
			init: function(e) {
				Addproductcatlist.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var prodcatparent = jQuery('#prodcatparent').val();
				var prodcatdisplayitem = jQuery('#prodcatdisplayitem').val();

				var output = '[hm_product_categories_list ';
				
				if(prodcatparent) {
					output += 'parent="'+prodcatparent+'" ';
				}
				if(prodcatdisplayitem) {
					output += 'displayitem="'+prodcatdisplayitem+'" ';
				}
				output += ']';
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addproductcatlist.init, Addproductcatlist);

	</script>
	<title>Add Product Category List</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Parent :</td>
		<td><input type="text" id="prodcatparent" name="prodcatparent" value=""></td>
	</tr>
	<tr>
		<td>Display Item Number :</td>
		<td><select id="prodcatdisplayitem" name="prodcatdisplayitem">
		<option value="false">False</option>
		<option value="true">True</option>
		</select></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addproductcatlist.insert(Addproductcatlist.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'list' ){
 ?>
 	<script type="text/javascript">
		var Addlist = {
			e: '',
			init: function(e) {
				Addlist.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var isnumeric = jQuery('#isnumeric').val();
				var listcontent = jQuery('#listcontent').val();
				listcontent =  listcontent.replace(/\n/g,"<br />");
				var output = '[list ';
				
				if(isnumeric) {
					output += 'is_numeric="'+isnumeric+'"';
				}
				if(listcontent==""){
					output += ']';
				}else{
					output += ']'+listcontent+'[/list]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addlist.init, Addlist);

	</script>
	<title>Add List</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Is Numeric :</td>
		<td><select id="isnumeric" name="isnumeric">
            <option value="no">No</option>
        	<option value="yes">Yes</option>
        </select></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="listcontent" name="listcontent"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addlist.insert(Addlist.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'map' ){
 ?>
 	<script type="text/javascript">
		var Addmap = {
			e: '',
			init: function(e) {
				Addmap.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var mapelement = jQuery('#mapelement').val();
				var mapwidth = jQuery('#mapwidth').val();
				var mapheight = jQuery('#mapheight').val();
				var mapzoom = jQuery('#mapzoom').val();
				var mapcenter = jQuery('#mapcenter').val();
				var mapscroll = jQuery('#mapscroll').val();
				var mapaddress = jQuery('#mapaddress').val();

				var output = '[map ';
				
				if(mapelement) {
					output += 'element="'+mapelement+'" ';
				}
				if(mapwidth) {
					output += 'width="'+mapwidth+'" ';
				}
				if(mapheight) {
					output += 'height="'+mapheight+'" ';
				}
				if(mapzoom) {
					output += 'zoom="'+mapzoom+'" ';
				}
				if(mapcenter) {
					output += 'center="'+mapcenter+'" ';
				}
				if(mapscroll) {
					output += 'scroll="'+mapscroll+'" ';
				}
				if(mapaddress) {
					output += 'address="'+mapaddress+'" ';
				}
				output += ']';
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addmap.init, Addmap);

	</script>
	<title>Add Map</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Element :</td>
		<td><input type="text" id="mapelement" name="mapelement" value="map_canvas"></td>
	</tr>
	<tr>
		<td>Width :</td>
		<td><input type="text" id="mapwidth" name="mapwidth" value="100%"></td>
	</tr>
	<tr>
		<td>Height :</td>
		<td><input type="text" id="mapheight" name="mapheight" value="500px"></td>
	</tr>
	<tr>
		<td>Zoom :</td>
		<td><input type="text" id="mapzoom" name="mapzoom" value="7"></td>
	</tr>
	<tr>
		<td>Center :</td>
		<td><input type="text" id="mapcenter" name="mapcenter" value="38.9613433, 125.8279959"></td>
	</tr>
	<tr>
		<td>Scroll :</td>
		<td><select id="mapscroll" name="mapscroll">
            <option value="false">false</option>
        	<option value="true">true</option>
        </select></td>
	</tr>
	<tr>
		<td>Address :</td>
		<td><input type="text" id="mapaddress" name="mapaddress" value="Pyongyang,Korea"></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addmap.insert(Addmap.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'paragraph' ){
 ?>
 	<script type="text/javascript">
		var Addparagraph = {
			e: '',
			init: function(e) {
				Addparagraph.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var paragraphfontsize = jQuery('#paragraphfontsize').val();
				var paragraphcolor = jQuery('#paragraphcolor').val();
				var paragraphbgcolor = jQuery('#paragraphbgcolor').val();
				var paragraphotherstyle = jQuery('#paragraphotherstyle').val();
				var dropcap = jQuery('#dropcap').val();
				var paragraphcontent = jQuery('#paragraphcontent').val();

				var output = '[p ';
				
				if(paragraphfontsize) {
					output += 'fontsize="'+paragraphfontsize+'" ';
				}
				if(paragraphcolor) {
					output += 'color="'+paragraphcolor+'" ';
				}
				if(paragraphbgcolor) {
					output += 'bgcolor="'+paragraphbgcolor+'" ';
				}
				if(paragraphotherstyle) {
					output += 'otherstyle="'+paragraphotherstyle+'" ';
				}
				if(dropcap) {
					output += 'dropcap="'+dropcap+'" ';
				}
				if(paragraphcontent==""){
					output += ']';
				}else{
					output += ']'+paragraphcontent+'[/p]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addparagraph.init, Addparagraph);

	</script>
	<title>Add Paragraph</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
    	<td>Font Size :</td>
        <td><input type="text" name="paragraphfontsize" id="paragraphfontsize" value="14"></td>
    </tr>
	<tr>
    	<td>Color :</td>
        <td><input type="text" name="paragraphcolor" id="paragraphcolor" value="#747474"></td>
    </tr>
	<tr>
		<td>Background Color :</td>
		<td><input type="text" id="paragraphbgcolor" name="paragraphbgcolor" value="rgba(0,0,0,0.7)"></td>
	</tr>
	<tr>
		<td>Other Style :</td>
		<td><input type="text" id="paragraphotherstyle" name="paragraphotherstyle" value="padding:5px"></td>
	</tr>
	<tr>
		<td>Dropcap :</td>
		<td><select id="dropcap" name="dropcap">
            <option value="no">No</option>
        	<option value="yes">Yes</option>
        </select></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="paragraphcontent" name="paragraphcontent"></textarea></td>
	</tr>

	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addparagraph.insert(Addparagraph.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'pricingcolumn' ){
 ?>
 	<script type="text/javascript">
		var Addpricingcolumn = {
			e: '',
			init: function(e) {
				Addpricingcolumn.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var pricingcolumntitle = jQuery('#pricingcolumntitle').val();
				var pricingcolumnhighlight = jQuery('#pricingcolumnhighlight').val();

				var output = '[pricing_column ';
				
				if(pricingcolumntitle) {
					output += 'title="'+pricingcolumntitle+'" ';
				}
				if(pricingcolumnhighlight) {
					output += 'highlight="'+pricingcolumnhighlight+'" ';
				}
				output+="][/pricing_column]"
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addpricingcolumn.init, Addpricingcolumn);

	</script>
	<title>Add Pricing Column</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Title :</td>
		<td><input type="text" id="pricingcolumntitle" name="pricingcolumntitle"></td>
	</tr>
	<tr>
		<td>Highlight :</td>
		<td><select id="pricingcolumnhighlight" name="pricingcolumnhighlight">
            <option value="no">No</option>
        	<option value="yes">Yes</option>
        </select></td>
	</tr>
	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addpricingcolumn.insert(Addpricingcolumn.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'pricingrow' ){
 ?>
 	<script type="text/javascript">
		var Addpricingrow = {
			e: '',
			init: function(e) {
				Addpricingrow.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var pricingrowprice = jQuery('#pricingrowprice').val();
				var pricingrowcurrency = jQuery('#pricingrowcurrency').val();
				var pricingrowtime = jQuery('#pricingrowtime').val();

				var output = '[pricing_row ';
				
				if(pricingrowprice) {
					output += 'price="'+pricingrowprice+'" ';
				}
				if(pricingrowcurrency) {
					output += 'currency="'+pricingrowcurrency+'" ';
				}
				if(pricingrowtime) {
					output += 'time="'+pricingrowtime+'" ';
				}
				output+="][/pricing_row]"
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addpricingrow.init, Addpricingrow);

	</script>
	<title>Add Pricing Column</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Price :</td>
		<td><input type="text" id="pricingrowprice" name="pricingrowprice"></td>
	</tr>
	<tr>
		<td>Currency :</td>
		<td><input type="text" id="pricingrowcurrency" name="pricingrowcurrency"></td>
	</tr>
	<tr>
		<td>Time :</td>
		<td><input type="text" id="pricingrowtime" name="pricingrowtime"></td>
	</tr>
	<tr><td colspan="2" align="center"><a class="add" href="javascript:Addpricingrow.insert(Addpricingrow.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'socialicon' ){
 ?>
 	<script type="text/javascript">
		var Addsocialicon = {
			e: '',
			init: function(e) {
				Addsocialicon.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var socialiconcolor = jQuery('#socialiconcolor').val();
				var socialiconname = jQuery('#socialiconname').val();
				var socialiconlink = jQuery('#socialiconlink').val();

				var output = '[social_icon ';
				
				if(socialiconcolor) {
					output += 'color="'+socialiconcolor+'" ';
				}
				if(socialiconname) {
					output += 'icon="'+socialiconname+'" ';
				}
				if(socialiconlink) {
					output += 'href="'+socialiconlink+'" ';
				}
				if( jQuery('#socialicontarget').is(':checked') ) {
					output += 'target="blank" ';
				}
			
				output+="][/social_icon]"
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addsocialicon.init, Addsocialicon);

	</script>
	<title>Add Social Icon</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Color :</td>
		<td><input type="text" id="socialiconcolor" name="socialiconcolor"></td>
	</tr>
	<tr>
		<td>Icon Name :</td>
		<td><select id="socialiconname" name="socialiconname">
		<option value="facebook">Facebook</option>
		<option value="adn">Adn</option>
		<option value="android">Android</option>
		<option value="apple">Apple</option>
		<option value="bitbucket">Bitbucket</option>
		<option value="btc">Bitcoin</option>
		<option value="css3">Css3</option>
		<option value="dribbble">Dribbble</option>
		<option value="dropbox">Dropbox</option>
		<option value="flickr">Flickr </option>
		<option value="foursquare">Foursquare</option>
		<option value="github">Github</option>
		<option value="gittip">Gittip</option>
		<option value="html5">Html5</option>
		<option value="instagram">Instagram</option>
		<option value="linkedin">Linkedin</option>
		<option value="linux">Linux</option>
		<option value="maxcdn">Maxcdn</option>
		<option value="pagelines">Pagelines</option>
		<option value="pinterest">Pinterest</option>
		<option value="renren">Renren</option>
		<option value="skype">Skype</option>
		<option value="stack exchange">Stack Exchange</option>
		<option value="stack overflow">Stack Overflow</option>
		<option value="trello">Trello</option>
		<option value="tumblr">Tumblr</option>
		<option value="twitter">Twitter</option>
		<option value="vimeo">Vimeo</option>
		<option value="vk">Vk</option>
		<option value="weibo">Weibo</option>
		<option value="windows">Windows</option>
		<option value="xing">Xing</option>
		<option value="youtube">Youtube</option>
		<option value="google plus">Google Plus</option>
		</select></td>
	</tr>
	<tr>
		<td>Link :</td>
		<td><input type="text" id="socialiconlink" name="socialiconlink"></td>
	</tr>
	<tr>
		<td>Open Link in a new window :</td>
		<td><input id="socialicontarget" name="socialicontarget" type="checkbox" value="true" /></td>
	</tr>
    <tr><td colspan="2" align="center"><a class="add" href="javascript:Addsocialicon.insert(Addsocialicon.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'tab' ){
 ?>
 	<script type="text/javascript">
		var Addtab = {
			e: '',
			init: function(e) {
				Addtab.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var tabtitle = jQuery('#tabtitle').val();
				var tabcontent = jQuery('#tabcontent').val();

				var output = '[tab ';
				
				if(tabtitle) {
					output += 'title="'+tabtitle+'" ';
				}
				if(tabcontent) {
					output+=']'+tabcontent+'[/tab]';
				}
			
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addtab.init, Addtab);

	</script>
	<title>Add Tab</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Title :</td>
		<td><input type="text" id="tabtitle" name="tabtitle"></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="tabcontent" name="tabcontent"></textarea></td>
	</tr>
    <tr><td colspan="2" align="center"><a class="add" href="javascript:Addtab.insert(Addtab.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'testimonial' ){
 ?>
 	<script type="text/javascript">
		var Addtestimonial = {
			e: '',
			init: function(e) {
				Addtestimonial.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var testimonialname = jQuery('#testimonialname').val();
				var testimonialrole = jQuery('#testimonialrole').val();
				var testimonialimage = jQuery('#testimonialimage').val();
				var testimonialcontent = jQuery('#testimonialcontent').val();

				var output = '[testimonial ';
				
				if(testimonialname) {
					output += 'name="'+testimonialname+'" ';
				}
				if(testimonialrole) {
					output += 'role="'+testimonialrole+'" ';
				}
				if(testimonialimage) {
					output += 'image="'+testimonialimage+'" ';
				}
				if(testimonialcontent) {
					output+=']'+testimonialcontent+'[/testimonial]';
				}
			
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addtestimonial.init, Addtestimonial);

	</script>
	<title>Add Testimonial</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Name :</td>
		<td><input type="text" id="testimonialname" name="testimonialname"></td>
	</tr>
	<tr>
		<td>Role :</td>
		<td><input type="text" id="testimonialrole" name="testimonialrole"></td>
	</tr>
	<tr>
		<td>Image Link :</td>
		<td><input type="text" id="testimonialimage" name="testimonialimage"></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="testimonialcontent" name="testimonialcontent"></textarea></td>
	</tr>
    <tr><td colspan="2" align="center"><a class="add" href="javascript:Addtestimonial.insert(Addtestimonial.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'toggle' ){
 ?>
 	<script type="text/javascript">
		var Addtoggle = {
			e: '',
			init: function(e) {
				Addtoggle.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var toggleopen = jQuery('#toggleopen').val();
				var toggletitle = jQuery('#toggletitle').val();
				var togglecontent = jQuery('#togglecontent').val();

				var output = '[toggle ';
				
				if(toggleopen) {
					output += 'open="'+toggleopen+'" ';
				}
				if(toggletitle) {
					output += 'title="'+toggletitle+'" ';
				}
				if(togglecontent) {
					output+=']'+togglecontent+'[/toggle]';
				}
			
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addtoggle.init, Addtoggle);

	</script>
	<title>Add Toggle</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Open :</td>
		<td><select id="toggleopen" name="toggleopen">
        	<option value="no">No</option><option value="yes">Yes</option></select>
        </td>
	</tr>
	<tr>
		<td>Title :</td>
		<td><input type="text" id="toggletitle" name="toggletitle"></td>
	</tr>
	<tr>
		<td>Content :</td>
		<td><textarea id="togglecontent" name="togglecontent"></textarea></td>
	</tr>
    <tr><td colspan="2" align="center"><a class="add" href="javascript:Addtoggle.insert(Addtoggle.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'vimeo' ){
 ?>
 	<script type="text/javascript">
		var Addvimeo = {
			e: '',
			init: function(e) {
				Addvimeo.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var viemolink = jQuery('#viemolink').val();
				var vimeowidth = jQuery('#vimeowidth').val();
				var vimeoheight = jQuery('#vimeoheight').val();
				var vimeoalign = jQuery('#vimeoalign').val();

				var output = '[vimeo ';
				
				if(viemolink) {
					output += 'href="'+viemolink+'" ';
				}
				if(vimeowidth) {
					output += 'width="'+vimeowidth+'" ';
				}
				if(vimeoheight) {
					output += 'height="'+vimeoheight+'" ';
				}
				if(vimeoalign) {
					output += 'align="'+vimeoalign+'" ';
				}
				output+='][/vimeo]'
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addvimeo.init, Addvimeo);

	</script>
	<title>Add Vimeo</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Link :</td>
		<td><input type="text" id="viemolink" name="viemolink"></td>
	</tr>
	<tr>
		<td>Width :</td>
		<td><input type="text" id="vimeowidth" name="vimeowidth"></td>
	</tr>
	<tr>
		<td>Height :</td>
		<td><input type="text" id="vimeoheight" name="vimeoheight"></td>
	</tr>
	<tr>
		<td>Align :</td>
		<td><select id="vimeoalign" name="vimeoalign"><option value="">None</option><option value="left">Left</option><option value="right">Right</option></select></td>
	</tr>
   <tr><td colspan="2" align="center"><a class="add" href="javascript:Addvimeo.insert(Addvimeo.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } else if( $page == 'youtube' ){
 ?>
 	<script type="text/javascript">
		var Addyoutube = {
			e: '',
			init: function(e) {
				Addyoutube.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function createGalleryShortcode(e) {

				var youtubelink = jQuery('#youtubelink').val();
				var youtubewidth = jQuery('#youtubewidth').val();
				var youtubeheight = jQuery('#youtubeheight').val();
				var youtubealign = jQuery('#youtubealign').val();

				var output = '[youtube ';
				
				if(youtubelink) {
					output += 'href="'+youtubelink+'" ';
				}
				if(youtubewidth) {
					output += 'width="'+youtubewidth+'" ';
				}
				if(youtubeheight) {
					output += 'height="'+youtubeheight+'" ';
				}
				if(youtubealign) {
					output += 'align="'+youtubealign+'" ';
				}
				output+='][/youtube]'
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);
				tinyMCEPopup.close();
				
			}
		}
		tinyMCEPopup.onInit.add(Addyoutube.init, Addyoutube);

	</script>
	<title>Add Youtube</title>

</head>
<body>
<div align="center">
<table id="GalleryShortcode">
	<tr>
		<td>Link :</td>
		<td><input type="text" id="youtubelink" name="youtubelink"></td>
	</tr>
	<tr>
		<td>Width :</td>
		<td><input type="text" id="youtubewidth" name="youtubewidth"></td>
	</tr>
	<tr>
		<td>Height :</td>
		<td><input type="text" id="youtubeheight" name="youtubeheight"></td>
	</tr>
	<tr>
		<td>Align :</td>
		<td><select id="vimeoalign" name="youtubealign"><option value="">None</option><option value="left">Left</option><option value="right">Right</option></select></td>
	</tr>
    <tr><td colspan="2" align="center"><a class="add" href="javascript:Addyoutube.insert(Addyoutube.e)">Insert into post</a></td></tr>
</table>
</div>  
<?php } ?>

</body>
</html>