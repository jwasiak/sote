<?php 

$issued = false;

function st_allegro_section_type($items)
{
	$type = strtolower($items[0]->type);

	if (isset($items[1]))
	{
		$type .= '-'.strtolower($items[1]->type);
	}
	
	return $type;
}
?>

<style type="text/css">
	#allegro-text {
		clear: left;	
	}

	#allegro-text-image-select .content {
		padding: 20px;
		text-align: center;
		min-width: 500px;
	}

	#allegro-text-image-select .flex,
	#allegro-text .flex {
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
		-webkit-flex-direction: row;
		-ms-flex-direction: row;
		flex-direction: row;
		-webkit-flex-wrap: nowrap;
		-ms-flex-wrap: nowrap;
		flex-wrap: nowrap;
		-webkit-justify-content: center;
		-ms-flex-pack: center;
		justify-content: center;
		-webkit-align-content: stretch;
		-ms-flex-line-pack: stretch;
		align-content: stretch;
		-webkit-align-items: flex-start;
		-ms-flex-align: start;
		align-items: flex-start;
	}

	#allegro-text .flex .image {
		text-align: center;
		width: 100%;
		max-width: 50%;
	}

	#allegro-text .flex .image img {
		max-width: 100%;
	}

	#allegro-text .flex .image a {
		display: inline-block;
		border: 1px dashed #ccc;
		padding: 10px;
		width: 100%;
		box-sizing: border-box;
	}

	#allegro-text .image > span, 
	#allegro-text .flex .image a span {
		display: inline-block;
		box-sizing: border-box;
		background: url('/jQueryTools/plupload/images/add.png?v2') center center no-repeat;
		width: 100%;
		height: 352px;
	}

	#allegro-text .flex .image a span[style|="background"] {
		background-position: center top;
		background-size: contain;
	}

	#allegro-text .flex .image a:hover {
		background-color: #eee;
	}

	#allegro-text .image > span {
		border: 1px dashed #ccc;
		background-color: #eee;
	}

	#allegro-text .flex > div {
		-webkit-order: 0;
		-ms-flex-order: 0;
		order: 0;
		-webkit-flex: 1 1 auto;
		-ms-flex: 1 1 auto;
		flex: 1 1 auto;
		-webkit-align-self: auto;
		-ms-flex-item-align: auto;
		align-self: center;	
		padding: 0 10px;		
	}

	#allegro-text .flex > div.text {
		min-width: 650px;		
	}

	#allegro-text .flex > div.text:empty:after {
		text-align: center;
		padding: 50px 0;
		content: 'Uzupełnij tekst';
		display: block;
		font-size: 18px;
		color: #C62929;
		background: #fff4f2;
	}

	#allegro-text > .section {
		padding: 10px;
		border: 1px dashed #ccc;
	}

	#allegro-text > .section + .section {
		margin-top: 10px;
	}

	#allegro-text .section-controls {
		background: #fff;
		text-align: left;
	}

	#allegro-text .section-controls .text {
		padding-top: 0px;
	}

	#allegro-text .section-controls .tabs {
		padding: 0 11px;
	}

	#allegro-text .section-controls .panes {
		padding-top: 10px;
	}

	#allegro-text .section-controls:not(:empty) {
		padding: 10px 0;
	}

	#allegro-text .header {
		display: none;
		padding-bottom: 10px;
	}

	#allegro-text .header .title {
		text-align: left;
		padding-left: 0;
	}

	#allegro-text .header .tools {
		text-align: right;
		padding-right: 0;
	}

	#allegro-text > .section.active .header {
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
	}

	#allegro-text > .section:not(.active) {
		padding: 10px 0;
	}

	<?php if (!$issued): ?>
		#allegro-text > .section:not(.active) {
			cursor: pointer;
		}

		#allegro-text > .section:hover, #allegro-text > .section.active {
			background: #eee;
		}
	<?php endif ?>

	#allegro-text > .section.active .section-content {
		display: none;
	}

	#allegro-text .section-content ul {
		display: block;
		list-style: disc;
		padding-left: 40px;
		margin-top: 15px;
		margin-bottom: 15px;
	}

	#allegro-text .section-content ol {
		display: block;
		list-style: decimal;
		padding-left: 40px;
		margin-top: 15px;
		margin-bottom: 15px;
	}

	#allegro-text .section-content h1,
	#allegro-text .section-content h2 {
		margin-bottom: 13px;
		margin-top: 13px;
		line-height: 1.1;
	}

	#allegro-text .section-content p {
		margin-bottom: 10px;
	}

	#allegro-text-image-select ul {
		width: 888px;
	}

	#allegro-text-image-select ul:after {
		content: "";
		display: table;
		clear: both;
	}
	
	#allegro-text-image-select li { 	
		padding: 0px;	
		float: left;
		margin-right: 10px;
		margin-bottom: 10px;
	}

	#allegro-text-image-select li > a {
		display: block;
		padding: 10px;
		height: 120px;
		width: 180px;
		text-align: center;
		border: 1px solid #ddd;
	}

	#allegro-text-image-select li > a:hover {
		background: #eee;
	}

	#allegro-text-image-select li > a > img {
		max-width: 100%;
		max-height: 100%;
	}

</style>
<script type="text/x-template" id="allegro-section-controls-tpl">
	<ul class="tabs">
		<li><a data-type="text" href="#"><?php echo __('Opis') ?></a></li>
		<li><a data-type="image" href="#"><?php echo __('Zdjęcie') ?></a></li>
		<li><a data-type="text-image" href="#"><?php echo __('Opis + Zdjęcie') ?></a></li>
		<li><a data-type="image-text" href="#"><?php echo __('Zdjęcie + Opis') ?></a></li>
		<li><a data-type="image-image" href="#"><?php echo __('Zdjęcie + Zdjęcie') ?></a></li>
	</ul>
	<div class="panes">
		<div class="flex">
			<div class="text"><textarea id="text-editor"></textarea></div>
		</div>
		<div class="flex">
			<div class="image"><a href="#"><span></span></a></div>
		</div>
		<div class="flex">
			<div class="text"><textarea id="text-image-editor"></textarea></div>
			<div class="image"><a href="#"><span></span></a></div>
		</div>
		<div class="flex">
			<div class="image"><a href="#"><span></span></a></div>
			<div class="text"><textarea id="image-text-editor"></textarea></div>
		</div>
		<div class="flex">
			<div class="image"><a href="#"><span></span></a></div>
			<div class="image"><a href="#"><span></span></a></div>
		</div>
	</div>		
</script>
<script type="text/x-template" id="allegro-text-image-select-tpl">
	<div id="allegro-text-image-select" class="popup_window">
		<div class="close"><img src="/images/backend/beta/gadgets/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></div>
		<h2><?php echo __('Wybierz zdjęcie') ?></h2>
		<div class="content"></div>
	</div>
</script>
<script type="text/x-template" id="allegro-section-text-tpl">
	<div class="section" data-type="text">
		<div class="header flex">
			<div class="title"><h3><?php echo __("Edycja sekcji") ?></h3></div>
			<div class="tools"><a class="remove" href="#"><img src="/images/backend/beta/gadgets/close.png"></a></div>
		</div>
		<div class="section-controls tinymce-container"></div>
		<div class="section-content flex">
			<div class="text"></div>
		</div>
	</div>	
</script>
<script type="text/x-template" id="allegro-section-image-tpl">
	<div class="section" data-type="text-image">
		<div class="header flex">
			<div class="title"><h3><?php echo __("Edycja sekcji") ?></h3></div>
			<div class="tools"><a class="remove" href="#"><img src="/images/backend/beta/gadgets/close.png"></a></div>
		</div>
		<div class="section-controls tinymce-container"></div>
		<div class="section-content flex">
			<div class="image"><img src="/jQueryTools/plupload/images/add.png?v2"></div>
		</div>
	</div>	
</script>
<script type="text/x-template" id="allegro-section-text-image-tpl">
	<div class="section" data-type="text-image">
		<div class="header flex">
			<div class="title"><h3><?php echo __("Edycja sekcji") ?></h3></div>
			<div class="tools"><a class="remove" href="#"><img src="/images/backend/beta/gadgets/close.png"></a></div>
		</div>
		<div class="section-controls tinymce-container"></div>
		<div class="section-content flex">
			<div class="text"></div>
			<div class="image"><img src="/jQueryTools/plupload/images/add.png?v2"></div>
		</div>
	</div>	
</script>
<script type="text/x-template" id="allegro-section-image-text-tpl">
	<div class="section" data-type="image-text">
		<div class="header flex">
			<div class="title"><h3><?php echo __("Edycja sekcji") ?></h3></div>
			<div class="tools"><a class="remove" href="#"><img src="/images/backend/beta/gadgets/close.png"></a></div>
		</div>
		<div class="section-controls tinymce-container"></div>
		<div class="section-content flex">
			<div class="image"><img src="/jQueryTools/plupload/images/add.png?v2"></div>
			<div class="text"></div>
		</div>
	</div>	
</script>
<script type="text/x-template" id="allegro-section-image-image-tpl">
	<div class="section" data-type="image-image">
		<div class="header flex">
			<div class="title"><h3><?php echo __("Edycja sekcji") ?></h3></div>
			<div class="tools"><a class="remove" href="#"><img src="/images/backend/beta/gadgets/close.png"></a></div>
		</div>
		<div class="section-controls tinymce-container"></div>
		<div class="section-content flex">
			<div class="image"><img src="/jQueryTools/plupload/images/add.png?v2"></div>
			<div class="image"><img src="/jQueryTools/plupload/images/add.png?v2"></div>
		</div>
	</div>	
</script>
<div class="row">
	<div id="allegro-text">
		<?php foreach ($value as $section): ?>
				<div class="section" data-type="<?php echo st_allegro_section_type($section->items) ?>">
					<div class="header flex">
						<div class="title"><h3><?php echo __("Edycja sekcji") ?></h3></div>
						<div class="tools"><a class="remove" href="#"><img src="/images/backend/beta/gadgets/close.png"></a></div>
					</div>
					<div class="section-controls tinymce-container"></div>
					<div class="section-content flex">
						<?php foreach ($section->items as $content): ?>
							<?php if ($content->type == 'TEXT'): ?>
								<div class="text"><?php echo $content->content ?></div>
							<?php endif ?>
							<?php if ($content->type == 'IMAGE'): ?>
								<div class="image" data-value="<?php echo $content->url ?>">
									<img src="<?php echo $content->url ?>">
								</div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
		<?php endforeach ?>
	</div>
	<?php echo input_hidden_tag($name, json_encode(stAllegroApi::objectToArray($value)), array('id' => 'allegro_auction_text')); ?>
	<?php if (!$issued): ?>
		<ul style="margin-top: 10px; float: right" class="admin_actions">
			<li class="action-add"><input type="button" name="add" id="allegro-text-add-section" value="<?php echo __('Dodaj sekcję') ?>" style="background-image: url(/images/backend/icons/add.png)"></li>
		</ul>
	<?php endif ?>
</div>

<?php if (!$issued): ?>
	<script type="text/javascript">
		jQuery(function($) {

			function cleanupHTML(html) {

				var dom = $('<div>'+html+'</div>');
				
				dom.find('*').each(function () {
					var tag = $(this);
					if (tag.parents(tag.prop('tagName')).length) {
						tag.contents().unwrap();
					}
				});

				html = dom.html();

				return html
					.replace(/<b>/g, '<strong>')
					.replace(/<\/b>/g, '</strong>')
			}
			

			var firstInit = true;

			var tinymceConfig = {
				version: "<?php echo sfRichTextEditorTinyMCE::VERSION ?>",
				language: "<?php echo strtolower(substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2)) ?>"
			};

			var container = $('#allegro-text');

			function resetActiveSection() {
				$.each(['text-editor', 'image-text-editor', 'text-image-editor'], function() {
					tinymce.remove('#'+this);
				});

				container.find('.section.active').removeClass('active').find('.section-controls').html("");					
			}

			container.on('click', '.section', function() {
				var section = $(this);

				if (section.hasClass('active')) {
					return true;
				}

				if (!section.data('allegro-init')) {
					section.data('allegro-init', true);
					section.find('.remove').click(function() {
						resetActiveSection();
						section.remove();
						return false;
					});
				}

				resetActiveSection();

				if (container.find('.section').length > 1) {
					section.find('.tools').show();
				} else {
					section.find('.tools').hide();
				}

				section.addClass('active');

				var sectionControls = section.find('.section-controls').html($('#allegro-section-controls-tpl').html());

				var sectionContent = section.find('.section-content');

				var contents = { text: undefined, image: { 0: undefined, 1: undefined } };

				sectionContent.children('div').each(function(index) {
					var elem = $(this);
					if (elem.hasClass('image')) {
						contents[elem.attr('class')][index] = elem.data('value');
					} else {
						contents[elem.attr('class')] = elem.html();
					}
				});

				var pane = null;
				var tab = null;

				var updateContents = function() {

					switch(tab.data('type'))
					{
						case 'text':
							sectionContent.html('<div class="text">'+contents['text']+'</div>');
						break;
						case 'image':
							sectionContent.html('<div class="image" data-value="'+contents['image'][0]+'"><img src="'+contents['image'][0]+'"></div>');
						break;
						case 'text-image':
							sectionContent.html('<div class="text">'+contents['text']+'</div><div class="image" data-value="'+contents['image'][1]+'"><img src="'+contents['image'][1]+'"></div>');
						break;
						case 'image-text':
							sectionContent.html('<div class="image" data-value="'+contents['image'][0]+'"><img src="'+contents['image'][0]+'"></div><div class="text">'+contents['text']+'</div>');
						break;
						case 'image-image':
							sectionContent.html('<div class="image" data-value="'+contents['image'][0]+'"><img src="'+contents['image'][0]+'"></div><div class="image" data-value="'+contents['image'][1]+'"><img src="'+contents['image'][1]+'"></div>');
						break;
					}
				}

				var tabInitialIndex = sectionControls.find('.tabs a[data-type="'+section.data('type')+'"]').closest('li').index();

				sectionControls.find('.panes').on('click', '.image > a', function() {
					var link = $(this);
					var index = link.parent().index();

					container.append($('#allegro-text-image-select-tpl').html());

					$('#allegro-text-image-select').overlay({
						closeOnClick: true,
						closeOnEsc: true,
						top: "5%", 
						speed: 'fast',
						oneInstance: true,
						load: true,
						mask: {
							color: '#444',
							loadSpeed: 'fast',
							opacity: 0.5,
							zIndex: 30000
						}, 

						onClose: function() {
							$('#allegro-text-image-select').remove();
						},

						onBeforeLoad: function() {
							var api = this;
							var content = this.getOverlay().children('.content');
							var images = $('#offer_images').val() ? JSON.parse($('#offer_images').val()) : [];
							
							content.on('click', 'a', function() {
								var value = $(this).data('value');
								contents['image'][index] = value;
								link.children('span').css({ 'background-image': 'url('+value+')' });
								updateContents();
								api.close();
								return false;
							});

							if (!$.isEmptyObject(images)) {
								var list = [];

								$.each(images, function() {
									list.push('<li><a href="#" data-value="'+this.url+'"><img src="'+this.url+'"></a><li>');
								});

								content.html('<ul>'+list.join('')+'</ul>');


							} else {
								content.html('Musisz wpierw wybrać zdjęcia do aukcji');
							}
						}     
					});

					return false;
				});

				sectionControls.find('.tabs').tabs('#allegro-text div.panes > div', {
					initialIndex: tabInitialIndex,
					onClick: function() {
						pane = this.getCurrentPane();
						tab = this.getCurrentTab();

						var init = pane.data('allegro-init');

						var tpl = $($('#allegro-section-'+section.data('type')+'-tpl'));

						if (!init) {
							pane.data('allegro-init', true);

							if (tab.data('type') != 'image-image') {
								var textarea = pane.find('.text textarea').get(0);	
								tinymce.init({
									target: textarea,
									skin: "custom",
									plugins: ["lists", "autoresize", "paste"],
									browser_spellcheck: true,
									menubar: false,
									convert_urls: false,
									toolbar: "undo redo | formatselect | bold | bullist numlist",
									valid_elements: "b,strong,p,h1,h2,ul,ol,li",
									valid_children: "h1[-],h2[-],li[strong|p|b],p[strong|b],ol[li],ul[li]",
									block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;',
									resize: true,
									force_p_newlines: true,
									language: tinymceConfig.language,
									width: "100%",
									autoresize_max_height: 300,
									autoresize_min_height: 300,
									cache_suffix: "?v="+tinymceConfig.version,
									entity_encoding: "raw",
									keep_styles: false,
									allow_conditional_comments: false,
									content_css: ["/css/backend/stTinyMCEContent.css"],
									setup: function(editor) {
										editor.on('keydown', function(e) {
											if (e.shiftKey && e.key == 'Enter') {
												e.preventDefault();
												return false;
											}
										}); 
									},
									init_instance_callback: function (editor) {

										// editor.shortcuts.remove('shift+enter');
										editor.focus();

										if (!contents['text']) {
											contents['text'] = '';
										}

										if (contents['text'].length) {
											contents['text'] = cleanupHTML(contents['text']);
										}

										editor.setContent(contents['text']);

										contents['text'] = editor.getContent();

										updateContents();

										var updated = true;
										
										editor.on('blur', function (e) {
											var content = editor.getContent();

											if (content.length) {
												content = cleanupHTML(content);
											}

											editor.setContent(content);
							
											contents['text'] = content;
											sectionContent.find('.text').html(content);
											updated = false;
										});

										editor.on('focus', function() {
											if (!updated) {
												editor.setContent(contents['text']);
												updated = true;
											}
										});

										if (firstInit) {
											firstInit = false;
											$('#allegro_auction_name').click().focus();
										}


									}
								}); 
							} 							
						} else {
							var editor = tinymce.get(tab.data('type')+'-editor');
							if (editor) {
								editor.focus();
							}

							updateContents();
						}

						if (tab.data('type') != 'text') {
				
							pane.find('.image').each(function() {
								var image = $(this);
								if (contents['image'][image.index()]) {
									image.find('a > span').css({ 'background-image': 'url('+contents['image'][image.index()]+')' });
								} else {
									image.removeAttr('style');
								}
							});
						}

						section.data('type', tab.data('type'));
						
					}
				});
			});

			container.find('.section').first().click();

			$('#allegro-text-add-section').click(function() {
				var section = $($('#allegro-section-text-tpl').html());

				container.append(section);

				section.click();
			});

			var form = $('#allegro_auction_text').closest('form');

			form.submit(function() {
				var sections = [];

				container.find('.section').each(function() {
					var section = $(this);

					var items = [];

					section.find('.section-content > div').each(function() {
						var item = $(this);
						if (item.hasClass('text')) {
							var content = $(this).html();
							content = content.replace(/<strong>/g, '<b>').replace(/<\/strong>/g, '</b>');
							items.push({
								'type': 'TEXT',
								'content': content,
							});
						} else {
							items.push({
								'type': 'IMAGE',
								'url': $(this).data('value'),
							});							
						}
					});
					sections.push({ 'items': items });
				});	

				// console.log(sections);

				// return false;

				$('#allegro_auction_text').val(JSON.stringify({ 'sections': sections }));
			});
		});
	</script>
<?php endif ?>