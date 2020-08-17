/**
* 
* @package stProductOptionsTemplatePlugin
* @author Daniel Mendalka <daniel.mendalka@sote.pl>
* @copyright SOTE
* @license SOTE
* @version $Id$
*/
var tree;

stProductOptionsTree = function() {
    return {
        create : function(root_name, root_id, model, module_name, editable, ui_provider, params, container_scroll, animated, show_hints, root_href, culture)
        {
            if (typeof ui_provider == 'undefined')
            {
                ui_provider = Ext.tree.stTreeNodeUI;
            }
            
            if (typeof animated == 'undefined')
            {
                animated = true;
            }    
                    
            if (typeof show_hints == 'undefined')
            {
                show_hints = true;
            } 
                        
            if (typeof ui_provider == 'undefined')
            {
                container_scroll = true;
            }            
            
            if (typeof params == 'undefined')
            {
                params = {};
            }            

            if (show_hints)
            {
	            Ext.QuickTips.init();
	            Ext.apply(Ext.QuickTips.getQuickTip(), {
	                maxWidth: 200,
	                minWidth: 100,
	                showDelay: 50,
	                dismissDelay: 10000,
	                trackMouse: true,
	            });
            }

            var tb = new Ext.Toolbar(
            {
                items:
                [
                {
                    text: params['add_button_label'],
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/add.png',
                    tooltip: params['add_button_tooltip'],
                    handler: function dodaj()
                    {
                        var sn = tree.getSelectionModel().getSelectedNode();

                        if (!sn)
                        {
                            sn = root;
                        }
					
                        sn.expand(false, true, function ()
                        {						
                           jQuery.post(
                              Ext.SF_SCRIPT_NAME + '/' + module_name + '/appendProductOption',
                              { model: model, id: sn.id, name: sn.attributes.field ? params['new_field_value'] : params['new_option_value'], field: sn.attributes.field, parent_id: sn.parentNode ? sn.parentNode.id : null, product_id: params['product_id'] },
                              function(json_data) {
                                    if (json_data)
                                    {
                                        var parent = tree.getNodeById(json_data.parent_id);
                                        var node = parent.appendChild(new Ext.tree.AsyncTreeNode({
                                            text: json_data.name,
                                            id: json_data.id,
                                 cls: json_data.cls,
                                 field: json_data.field,
                                 qtip: json_data.qtip,
                                 
                                            allowDrag: true,
                                            uiProvider: ui_provider,
                                        }));

                              //node.fireEvent('click', node);
                                    }                                 
                              },
                              'json'
                           );
                        });

                    }
                },
                {
                    text: params['del_button_label'],
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/delete.png',
                    disabled: true,
                    tooltip: params['del_button_tooltip'],
                    handler: function()
                    {
                        var sn = tree.getSelectionModel().getSelectedNode();
                        if (sn)
                        {
                            jQuery(document).trigger('preloader', 'show');  

                            jQuery.post(
                              Ext.SF_SCRIPT_NAME + '/' + module_name + '/removeProductOption',
                              { model: model, id: sn.id, parent_id: sn.parentNode.id, field: sn.attributes.field, product_id: params['product_id'] },
                              function(json_data)
                              {
                                 var parentNode = sn.parentNode;

                                 if (sn)
                                 {
                                    sn.remove();
                                 }

                                 if (!tree.getSelectionModel().getSelectedNode() && parentNode) {
                                    parentNode.fireEvent('click', parentNode);
                                 }

                                 jQuery(document).trigger('preloader', 'close'); 
                              },
                              'json'
                           );
                        }
                    }
                },
                {
                    text: params['exp_button_label'],
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/filter.png',
                    tooltip: params['exp_button_tooltip'],
                    handler: function()
                    {
                        if(this.text==params['exp_button_label'])
                        {
                            tree.expandAll();
                            this.setText(params['fold_button_label']);
                        }
                        else
                        {
                            tree.collapseAll();
                            tree.getRootNode().fireEvent('click', tree.getRootNode());
                            this.setText(params['exp_button_label']);
                        }
                    }
                },
                /**
    		     * Przycisk wstaw szablon
    		     */
    		    {
    		    	text: params['tpl_button_label'],
    		    	cls: 'st_ext_button-icon',
    		    	icon: '/images/backend/icons/add_template.png',
    		    	tooltip: params['tpl_button_tooltip'],
    		    	handler: function() {
    		    		var selected = tree.getSelectionModel().getSelectedNode();
    		    	    var form = new Ext.form.FormPanel({
    		    	        baseCls: 'x-plain',
    		    	        labelWidth: 115,
    		    	        items: [{
    		    	        	width: 			200,
    		    	        	xtype:          'combo',
                                mode:           'local',
                                triggerAction:  'all',
                                forceSelection: true,
                                editable:       false,
                                fieldLabel:     params['tpl_window_label'],
                                name:           'combo',
                                hiddenName:     'combo',
                                displayField:   'name',
                                valueField:     'value',
                                value:          params.templates[0]['value'],
    		    	        	store:          new Ext.data.JsonStore({
                                    fields : ['name', 'value'],
                                    data   : params.templates
                                }),
    		    	        	editable: false
    		    	        }]
    		    	    });
    		    	    
		    	        var w = new Ext.Window({
    		    	        title: params['tpl_window_label'],
    		    	        collapsible: false,
    		    	        maximizable: false,
    		    	        width: 336,
    		    	        height: 95,
    		    	        layout: 'fit',
    		    	        hideBorders: true,
    		    	        plain: true,
    		    	        buttonAlign: 'right',
    		    	        items: form,
    		    	        buttons: [{
    		    	            text: params['tpl_window_label'],
    		    	            handler: function () {
    		    	        		var combo = document.getElementById('combo');
                                    w.close();
                                    
                                    jQuery(document).trigger('preloader', 'show');

    		    	        		Ext.Ajax.request( {
        		    					url: Ext.SF_SCRIPT_NAME + '/stProductOptionsBackend/useTemplate',
        		    					params: { optionId: selected.id, template: combo.value},
        		    					success: function(response) {
        		    						selected.attributes.expandable = true;
        		    						selected.attributes.isLeaf = false;
        		    						selected.reload();
                                            jQuery(document).trigger('preloader', 'close');
        		    					}
        		    				});
    		    	        		
    		    	            }
    		    	        },{
    		    	            text: params['tpl_cancel_label'],
    		    	            handler: function ()
    		    	            {
    		    	            	w.close();
    		    	            }
    		    	        }]
    		    	    });
    		    	    w.show();
                	}
    		    }
                
                ]
            });
                        
            var Tree = Ext.tree;

            tree = new Tree.TreePanel(
            {
                el: 'st_product_options-tree-' + root_id,
                autoScroll: true,
                animate: animated,
                enableDD: editable,
				rootVisible: true,
                containerScroll: container_scroll,
                autoScroll: container_scroll,
                autoHeight: !container_scroll,
                border: false,
                shadow: false,
                bodyBorder: false,
                useArrows: true,
                tbar: editable ? tb : null,
                nodeUiProvider: Ext.tree.stTreeNodeUI,
                loader: new Tree.TreeLoader(
                { 
                    dataUrl: Ext.SF_SCRIPT_NAME + '/' + module_name + '/fetchProductOptionValues?root_id=' + root_id,
					baseParams : {model: model, parent_id:null, field:null, language:culture, product_id: params['product_id']},
                    baseAttrs: {
                        uiProvider: ui_provider,
                    }
                }),
            });
			
            
            // set the root node
            var root = new Tree.AsyncTreeNode(
            {
                text: root_name,
                cls: 'st_product_options-tree-root',
                id: root_id,
            });   

            tree.setRootNode(root);

			// set additional parameters to POST while expanding tree
			tree.on('beforeload', function (node)
			{
				tree.loader.baseParams.parent_id = node.parentNode!=null ? node.parentNode.id : null;
				tree.loader.baseParams.field = node.attributes.field;
			});
			
			// expands first product_options after load
			tree.on('load', function (node)
			{
			   if(node == root)
			   {
			       // node.expandChildNodes();
			   } 
			});
			
			tree.on('beforecollapsenode', function (node, deep, anim)
			{
                node.fireEvent('click', node);
                return true;
			});
						
			// changes 3rd button text when any node expanded
			tree.on('beforeexpandnode', function (node, deep, anim)
			{
			    tb.items.item(2).setText(params['fold_button_label']);
			    
                node.fireEvent('click', node);
			    return true;
			});

            tree.on('textchange', function (node, value, old_value)
            {
                if (!node.eventsSuspended && value != old_value)
                {
                    jQuery.post(
                        Ext.SF_SCRIPT_NAME + '/' + module_name + '/changeProductOptionValue',
                        {model: model, value: value, id: node.id, field: node.attributes.field, firstEdit: node.attributes.backEdit, language: node.attributes.language, product_id: params['product_id'] }
                    );
                }
				node.attributes.backEdit = false;
				if($('product_option_value'))
				{
				    $('product_option_value').value = value;
				}
				if($('field_name'))
				{
				    $('field_name').value = value;
				}
            });
                        
            if (editable)
            {
                tree.on('click', function (node, e)
                {
                    if (node.isRoot)
                    {
                        tb.items.item(1).setDisabled(true);

                    }
                    else
                    {
                        tb.items.item(1).setDisabled(false);
                    }

                    jQuery('.save-ok').hide();

                    jQuery(document).trigger('preloader', 'show');        
                        
                    tb.items.item(3).setDisabled(node.getDepth()%2);
                    
                    // aktualizowanie formularza
                    if(node.isRoot)
                    {
                        jQuery.post(
                            Ext.SF_SCRIPT_NAME + '/stProductOptionsBackend/showRoot',
                            { model: model, product_option_id: node.id, language:culture, product_id: params['product_id'] },
                            function(html) {
                                jQuery('#st_product_options-tree_edit').html(html);
                                jQuery(document).trigger('preloader', 'close');
                                setTimeout(function() {
                                    jQuery(document).trigger('preloader', 'close');
                                }, 1); 
                            }
                        );
                    }
                    else if(!node.attributes.field)
                    {
                        jQuery.post(
                            Ext.SF_SCRIPT_NAME + '/stProductOptionsBackend/showOption',
                            { model: model, product_option_id: node.id, language:culture, product_id: params['product_id']},
                            function(html) {
                                jQuery('#st_product_options-tree_edit').html(html);
                                jQuery('#product_option_value').focus();
                            
                                jQuery(document).trigger('preloader', 'close');
                       
                            }
                        );                        
                    }
                    else
                    {
                        jQuery.post(
                            Ext.SF_SCRIPT_NAME + '/stProductOptionsBackend/showField',
                            { field_id: node.attributes.field, language:culture, model: model, product_id: params['product_id'] },
                            function(html) {
                                jQuery('#st_product_options-tree_edit').html(html);
                                jQuery('#field_name').focus();
                                jQuery(document).trigger('preloader', 'close');
                            }
                        );                         
                    }
                });
            }
                        
            tree.on('nodedragover', function(event) {
                return event.target.attributes.field === undefined && event.point == 'append' && event.dropNode.attributes.field !== undefined 
                    || event.point != 'append' && event.dropNode.parentNode == event.target.parentNode;

            });
            
            tree.on('movenode', function (tree, node, old_parent, new_parent, index)
            {
                jQuery('.save-ok').hide();
                
                jQuery(document).trigger('preloader', 'show');

                var parameters = {
                    model: model,
                    parent_id: new_parent.attributes.id,
                    parent_field: new_parent.attributes.field,
                    id: node.attributes.id,
                    field: node.attributes.field
                };

                if (node.previousSibling)
                {
                    parameters.prev_sibling_id = node.previousSibling.attributes.id;
                    parameters.prev_sibling_field = node.previousSibling.attributes.fied;
                }
                else
                {
                    parameters.prev_sibling_id = 0;
                    parameters.prev_sibling_field = 0;
                }

                if (node.nextSibling)
                {
                    parameters.next_sibling_id = node.nextSibling.attributes.id;
                    parameters.next_sibling_field = node.nextSibling.attributes.field;
                }
                else
                {
                    parameters.next_sibling_id = 0;
                    parameters.next_sibling_field = 0;
                }

                if (node.attributes.field)
                {
                    var fields = [];
                    for (var i = 0; i < new_parent.childNodes.length; i++) {
                        fields.push(new_parent.childNodes[i].attributes.field);
                    }
                    parameters.fields = fields;
                }

                parameters.product_id = params['product_id'];

                
                jQuery.post(
                    Ext.SF_SCRIPT_NAME + '/' + module_name + '/moveProductOption',
                    parameters,
                    function()
                    {
                        node.fireEvent('click', node);
                    }                    
                );  
            });

            // render the tree
            tree.render();
            root.expand();

            if (typeof Ext.attributesTree == 'undefined')
            {
               Ext.attributesTree = [];
            }

            Ext.attributesTree[root.id] = tree;

            if (model == 'ProductOptionsDefaultValue') {
            	tb.items.item(3).setVisible(false);
            }
          
            if (editable)
            {
                var ge = new Ext.tree.TreeEditor(tree,
                {
                    allowBlank: false,
                    blankText: 'Musisz podać wartość',
                    selectOnFocus:true,
                    cancelOnEsc: true,
                    editDelay: 500
                });
            }
        },
        
        // returning created tree
        get : function ()
        {
            return tree;
        },
        
        unselect : function()
        {
            tree.getRootNode().fireEvent('click', root);
        },
        
        // finds and expands node for given id
        showNode : function (node_id)
        {
            node = tree.getNodeById(node_id);
            if(node)
            {
                tree.expandPath(node.getPath());
                node.fireEvent('click', node);
            }
            else
            {
                tree.getRootNode().expand(true);
                tree.collapseAll();
                
                tree.on('beforeexpandnode', function (node, deep, anim)
    			{
    			    if(deep)
    			    {
                        node = tree.getNodeById(node_id);
                        if(node)
                        {
                            tree.collapseAll();
                            tree.expandPath(node.getPath());
                            node.fireEvent('click', node);
                            return false;
                        }
    		        }
    			});
            }
        }
    };
}();

Ext.tree.stTreeNodeUI = Ext.extend(Ext.tree.TreeNodeUI, {	
    updateExpandIcon : function()
	{
        if(this.rendered){
            var n = this.node, c1, c2;
            var cls = n.isLast() ? "x-tree-elbow-end" : "x-tree-elbow";
            var hasChild = n.hasChildNodes();
            if(hasChild || n.attributes.expandable)
			{
                if(n.expanded){
                    cls += "-minus";
                    c1 = "x-tree-node-collapsed";
                    c2 = "x-tree-node-expanded";
                }else{
                    cls += "-plus";
                    c1 = "x-tree-node-expanded";
                    c2 = "x-tree-node-collapsed";
                }
                if(this.wasLeaf){
                    this.removeClass("x-tree-node-leaf");
                    this.wasLeaf = false;
                }
                if(this.c1 != c1 || this.c2 != c2){
                    Ext.fly(this.elNode).replaceClass(c1, c2);
                    this.c1 = c1; this.c2 = c2;
                }
            }else{
                if(!this.wasLeaf){
                    Ext.fly(this.elNode).replaceClass("x-tree-node-expanded", "x-tree-node-collapsed");
                    //                    delete this.c1;
                    //                    delete this.c2;
                    this.wasLeaf = false;
                }
            }
            var ecc = "x-tree-ec-icon "+cls;
            if(this.ecc != ecc){
                this.ecNode.className = ecc;
                this.ecc = ecc;
            }
        }
    }
});

function postSubmitForm(request, json, tree, params)
{
    $('product_options_template-visible_button').style.backgroundImage = 'url(/images/backend/icons/save.png)';
    $('product_options_template-visible_button').firstChild.nodeValue = params['save_title'];
    $('product_options_template-visible_button_up').style.backgroundImage = 'url(/images/backend/icons/save.png)';
    $('product_options_template-visible_button_up').firstChild.nodeValue = params['save_title'];

    errors_to_clear.each(function(error)
        {
            error.parentNode.removeClassName('form-error');
            error.hide();
        });
    
    errors_to_clear.clear();
    
    if (!json)
    {
        //if you don't use the json tips then evaluate the renderedText instead
        json = eval('(' + request.responseText + ')');
    }

    var errors = json.errors;
	var values = json.values;
    errors.each(function(error)
        {
            if(error.msg)
            {
                errors_to_clear.push($(error.id));                
                $(error.id).parentNode.addClassName('form-error');
                $(error.id).show();
                $(error.id).innerHTML = '↓&nbsp;' + error.msg + '&nbsp;↓';
            }
            
            if(error.value)
            {
                $(error.id).setValue(error.value);
            }
        });

    values.each(function(value)
    		{
        		if ($(value.id)) $(value.id).setValue(value.value);
    		});

    if(errors.size() == 0)
    {       
        var node = tree.getSelectionModel().getSelectedNode(); 
        node.suspendEvents(false);
        if($('field_name')!=null)
        {
            node.setText($('field_name').value); 
    	}
    	else if($('product_option_value')!=null)
    	{
    	    node.setText($('product_option_value').value);
    	}
        node.resumeEvents();
    	
    	$('top_green').show();
    }
    
}
