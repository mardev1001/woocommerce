(function() {
   tinymce.create('tinymce.plugins.recentposts', {
      init : function(ed, url) {
         ed.addButton('recentposts', {
            title : 'Recent posts',
            image : url+'/recentpostsbutton.png',
            onclick : function() {
               ed.execCommand('mceInsertContent', false, '[hm_recent_posts]');
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('recentposts', tinymce.plugins.recentposts);
   
   tinymce.create('tinymce.plugins.hmproducts', {
      init : function(ed, url) {
		  this._dt_url = url;
		  this._dt_ed = ed;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "hmproducts" :
					// Register example button
					var menuButton = cm.createMenuButton( "products", {
						title : "Hyunmoo Products",
						image : _this._dt_url + '/products.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Product Categories Slider',
							onclick : function() {
								_this._dt_ed.windowManager.open({file :  _this._dt_url + '/ui.php?page=productcatslider',width : 600 ,	height : 300 ,	inline : 1});
							}
						});

						m.add({
							title : 'Product Categories List',
							onclick : function() {
								_this._dt_ed.windowManager.open({file :  _this._dt_url + '/ui.php?page=productcatlist',width : 600 ,	height : 300 ,	inline : 1});
							}
						});
						
						m.add({
							title : 'Featured Products',
							onclick : function() {
							   _this._dt_ed.execCommand('mceInsertContent', false, '[hm_featured_products]');
							}
						});
						
						m.add({
							title : 'Recent Products',
							onclick : function() {
							   _this._dt_ed.execCommand('mceInsertContent', false, '[hm_recent_products]');
							}
						});

						m.add({
							title : 'Best Sellers',
							onclick : function() {
							   _this._dt_ed.execCommand('mceInsertContent', false, '[hm_bestsellers]');
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('hmproducts', tinymce.plugins.hmproducts);
   
   tinymce.create('tinymce.plugins.hmslider', {
      init : function(ed, url) {
         ed.addButton('hmslider', {
            title : 'Hyunmoo Slider',
            image : url+'/hmslider.png',
            onclick : function() {
			   var name = prompt("Slider Name", "");
			   if(name!=null && name!="")
	               ed.execCommand('mceInsertContent', false, '[hm_slider name="'+name+'"]');
			   else	
              	   ed.execCommand('mceInsertContent', false, '[hm_slider]');
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('hmslider', tinymce.plugins.hmslider);

   tinymce.create('tinymce.plugins.row', {
      init : function(ed, url) {
         ed.addButton('row', {
            title : 'Row',
            image : url+'/row.png',
            onclick : function() {
           	   ed.execCommand('mceInsertContent', false, '[row][/row]');
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('row', tinymce.plugins.row);

   tinymce.create('tinymce.plugins.button', {
      init : function(ed, url) {
         ed.addButton('button', {
            title : 'Button',
            image : url+'/button.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=button',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('button', tinymce.plugins.button);

   tinymce.create('tinymce.plugins.circle', {
      init : function(ed, url) {
         ed.addButton('circle', {
            title : 'Circle',
            image : url+'/circle.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=circle',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('circle', tinymce.plugins.circle);

   tinymce.create('tinymce.plugins.parallax', {
      init : function(ed, url) {
         ed.addButton('parallax', {
            title : 'Parallax',
            image : url+'/parallax.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=parallax',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('parallax', tinymce.plugins.parallax);

   tinymce.create('tinymce.plugins.accordion', {
      init : function(ed, url) {
		  this._dt_url = url;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "accordion" :
					// Register example button
					var menuButton = cm.createMenuButton( "accordion", {
						title : "Accordion",
						image : _this._dt_url + '/accordion.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'accordion',
							onclick : function() {
								
								/**********************************/
								// Edit shortcode here!
								/**********************************/
								var accordion = [
										'[toggle title="TITLE_1"]CONTENT_1[/toggle]',
										'[toggle title="TITLE_2"]CONTENT_2[/toggle]',
										'[toggle title="TITLE_3"]CONTENT_3[/toggle]'
									];

					            return_text = '[accordion]' + accordion.join('') + '[/accordion]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'item',
							onclick : function() {
								
								/**********************************/
								// Edit shortcode here!
								/**********************************/
								var attr = [
									'title="TITLE"'
								];

								var attr_str = attr.join(' ');

					            return_text = '[toggle ' + attr_str + ']CONTENT[/toggle]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);

   tinymce.create('tinymce.plugins.counterbox', {
      init : function(ed, url) {
		  this._dt_url = url;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "counterbox" :
					// Register example button
					var menuButton = cm.createMenuButton( "counterbox", {
						title : "Counter Box",
						image : _this._dt_url + '/counterbox.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Counter Boxes',
							onclick : function() {
								
								/**********************************/
								// Edit shortcode here!
								/**********************************/
								var accordion = [
										'[counter_box value="100"]CONTENT_1[/counter_box]',
										'[counter_box value="100"]CONTENT_2[/counter_box]',
									];

					            return_text = '[counter_boxes]' + accordion.join('') + '[/counter_boxes]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'Counter Box',
							onclick : function() {
								
								var value=prompt("Counter Value","100");

								return_text = '[counter_box value="' + value + '"]CONTENT[/counter_box]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('counterbox', tinymce.plugins.counterbox);

   tinymce.create('tinymce.plugins.columns', {
      init : function(ed, url) {
		  this._dt_url = url;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "columns" :
					// Register example button
					var menuButton = cm.createMenuButton( "columns", {
						title : "Columns",
						image : _this._dt_url + '/columns.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'one_half',
							onclick : function() {
								 var last = prompt("Input 'yes' or 'no' to select if this column is last", "no");
                                 return_text='[one_half last="'+last+'"][/one_half]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'one_third',
							onclick : function() {
								 var last = prompt("Input 'yes' or 'no' to select if this column is last", "no");
                                 return_text='[one_third last="'+last+'"][/one_third]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});
						
						m.add({
							title : 'one_fourth',
							onclick : function() {
								 var last = prompt("Input 'yes' or 'no' to select if this column is last", "no");
                                 return_text='[one_fourth last="'+last+'"][/one_fourth]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});
						
						m.add({
							title : 'two_third',
							onclick : function() {
								 var last = prompt("Input 'yes' or 'no' to select if this column is last", "no");
                                 return_text='[two_third last="'+last+'"][/two_third]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});
						
						m.add({
							title : 'three_fourth',
							onclick : function() {
								 var last = prompt("Input 'yes' or 'no' to select if this column is last", "no");
                                 return_text='[three_fourth last="'+last+'"][/three_fourth]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('columns', tinymce.plugins.columns);

   tinymce.create('tinymce.plugins.alert', {
      init : function(ed, url) {
         ed.addButton('alert', {
            title : 'Alert',
            image : url+'/alert.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=alert',width : 600 ,	height : 300 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('alert', tinymce.plugins.alert);

   tinymce.create('tinymce.plugins.docviewer', {
      init : function(ed, url) {
         ed.addButton('docviewer', {
            title : 'Docviewer',
            image : url+'/docviewer.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=docviewer',width : 600 ,	height : 350 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('docviewer', tinymce.plugins.docviewer);

   tinymce.create('tinymce.plugins.donate', {
      init : function(ed, url) {
         ed.addButton('donate', {
            title : 'Donate',
            image : url+'/donate.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=donate',width : 600 ,	height : 350 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('donate', tinymce.plugins.donate);
   
   tinymce.create('tinymce.plugins.hmblockquote', {
      init : function(ed, url) {
         ed.addButton('hmblockquote', {
            title : 'Blockquote',
            image : url+'/blockquote.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=blockquote',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('hmblockquote', tinymce.plugins.hmblockquote);

   tinymce.create('tinymce.plugins.heading', {
      init : function(ed, url) {
         ed.addButton('heading', {
            title : 'Heading',
            image : url+'/heading.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=heading',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('heading', tinymce.plugins.heading);

   tinymce.create('tinymce.plugins.highlight', {
      init : function(ed, url) {
         ed.addButton('highlight', {
            title : 'Highlight',
            image : url+'/highlight.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=highlight',width : 600 ,	height : 300 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('highlight', tinymce.plugins.highlight);

   tinymce.create('tinymce.plugins.list', {
      init : function(ed, url) {
         ed.addButton('list', {
            title : 'List',
            image : url+'/list.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=list',width : 600 ,	height : 300 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('list', tinymce.plugins.list);

   tinymce.create('tinymce.plugins.map', {
      init : function(ed, url) {
         ed.addButton('map', {
            title : 'Map',
            image : url+'/map.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=map',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('map', tinymce.plugins.map);

   tinymce.create('tinymce.plugins.paragraph', {
      init : function(ed, url) {
         ed.addButton('paragraph', {
            title : 'Paragraph',
            image : url+'/paragraph.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=paragraph',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('paragraph', tinymce.plugins.paragraph);

   tinymce.create('tinymce.plugins.pricingtable', {
      init : function(ed, url) {
		  this._dt_url = url;
		  this._dt_ed = ed;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "pricingtable" :
					// Register example button
					var menuButton = cm.createMenuButton( "pricingtable", {
						title : "Pricing Table",
						image : _this._dt_url + '/pricingtable.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Pricing Table',
							onclick : function() {
                                 return_text='[pricing_table][/pricing_table]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'Pricing Column',
							onclick : function() {
								 _this._dt_ed.windowManager.open({file : _this._dt_url + '/ui.php?page=pricingcolumn',width : 600 ,	height : 200 ,	inline : 1});
							}
						});
						
						m.add({
							title : 'Pricing Row',
							onclick : function() {
								 _this._dt_ed.windowManager.open({file : _this._dt_url + '/ui.php?page=pricingrow',width : 600 ,	height : 250 ,	inline : 1});
							}
						});
						
						m.add({
							title : 'Normal Row',
							onclick : function() {
								 var content = prompt("Content", "");
                                 return_text='[normal_row]'+content+'[/normal_row]';					
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});
						
						m.add({
							title : 'Pricing Footer',
							onclick : function() {
								 var content = prompt("Content", "");
                                 return_text='[pricing_footer]'+content+'[/pricing_footer]';				
					             tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('pricingtable', tinymce.plugins.pricingtable);
   
   tinymce.create('tinymce.plugins.socialicon', {
      init : function(ed, url) {
		  this._dt_url = url;
		  this._dt_ed = ed;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "socialicon" :
					// Register example button
					var menuButton = cm.createMenuButton( "socialicon", {
						title : "Social Icon",
						image : _this._dt_url + '/socialicons.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Social Icons',
							onclick : function() {
								
								/**********************************/
								// Edit shortcode here!
								/**********************************/

								return_text = '[social_icons][/social_icons]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'Social Icon',
							onclick : function() {
								 _this._dt_ed.windowManager.open({file : _this._dt_url + '/ui.php?page=socialicon',width : 600 , height : 300 ,	inline : 1});
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('socialicon', tinymce.plugins.socialicon);

   tinymce.create('tinymce.plugins.tab', {
      init : function(ed, url) {
		  this._dt_url = url;
		  this._dt_ed = ed;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "tab" :
					// Register example button
					var menuButton = cm.createMenuButton( "tab", {
						title : "Tab",
						image : _this._dt_url + '/tabs.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Tabs',
							onclick : function() {
								
								/**********************************/
								// Edit shortcode here!
								/**********************************/

								return_text = '[tabs][/tabs]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'Tab',
							onclick : function() {
								 _this._dt_ed.windowManager.open({file : _this._dt_url + '/ui.php?page=tab',width : 600 , height : 300 ,	inline : 1});
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('tab', tinymce.plugins.tab);
   
   tinymce.create('tinymce.plugins.testimonial', {
      init : function(ed, url) {
		  this._dt_url = url;
		  this._dt_ed = ed;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "testimonial" :
					// Register example button
					var menuButton = cm.createMenuButton( "testimonial", {
						title : "Testimonial",
						image : _this._dt_url + '/testimonial.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Testimonial Slider',
							onclick : function() {
								
								return_text = '[testimonial_slider][/testimonial_slider]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'Testimonial List',
							onclick : function() {
								
								return_text = '[testimonial_list][/testimonial_list]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});
						
						m.add({
							title : 'Testimonial',
							onclick : function() {
								 _this._dt_ed.windowManager.open({file : _this._dt_url + '/ui.php?page=testimonial',width : 600 , height : 400 ,	inline : 1});
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('testimonial', tinymce.plugins.testimonial);
   
   tinymce.create('tinymce.plugins.toggle', {
      init : function(ed, url) {
		  this._dt_url = url;
		  this._dt_ed = ed;
      },
      createControl : function(n, cm) {
			var _this = this;

			switch (n) {

				case "toggle" :
					// Register example button
					var menuButton = cm.createMenuButton( "toggle", {
						title : "Toggle",
						image : _this._dt_url + '/toggle.png',
						icons : false				
					});

					menuButton.onRenderMenu.add(function(c, m) {

						m.add({
							title : 'Toggles',
							onclick : function() {
								
								/**********************************/
								// Edit shortcode here!
								/**********************************/

								return_text = '[toggles][/toggles]';

					            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
							}
						});

						m.add({
							title : 'Toggle',
							onclick : function() {
								 _this._dt_ed.windowManager.open({file : _this._dt_url + '/ui.php?page=toggle',width : 600 , height : 300 ,	inline : 1});
							}
						});

					});
					return menuButton;
					break;
			}
			return null;

	  }
   });
   tinymce.PluginManager.add('toggle', tinymce.plugins.toggle);

   tinymce.create('tinymce.plugins.vimeo', {
      init : function(ed, url) {
         ed.addButton('vimeo', {
            title : 'Vimeo',
            image : url+'/vimeo.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=vimeo',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('vimeo', tinymce.plugins.vimeo);
   
   tinymce.create('tinymce.plugins.youtube', {
      init : function(ed, url) {
         ed.addButton('youtube', {
            title : 'Youtube',
            image : url+'/youtube.png',
            onclick : function() {
			 	ed.windowManager.open({file : url + '/ui.php?page=youtube',width : 600 ,	height : 450 ,	inline : 1});
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      }
   });
   tinymce.PluginManager.add('youtube', tinymce.plugins.youtube);

})();