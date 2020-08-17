/**
* Drzewo kategorii integrujące Ext.tree.TreePanel z modułem stCategoryTree
*
* @package stCategoryTreePlugin
* @author Marcin Butlak <marcin.butlak@sote.pl>
* @copyright SOTE
* @license SOTE
* @version $Id$
*/
jQuery(document).ajaxError(function() {
   Ext.MessageBox.hide();
});

function showError(message)
{
    Ext.Msg.alert('<?php echo __('Błąd'); ?>', message);
}

stCategoryTree = function() {
    return {
        showCategoryCreateWindow: function(tree, module_name, ui_provider)
        {
            var sn = tree.getSelectionModel().getSelectedNode();

            if (!sn)
            {
                sn = tree.getRootNode();
            }

            Ext.MessageBox.show({
                title: '<?php echo __('Dodaj kategorię'); ?>',
                msg: '<?php echo __('Nazwa kategorii:'); ?>',
                width:300,
                buttons: {
                    ok:'<?php echo __('Dodaj') ?>',
                    cancel:'<?php echo __('Anuluj') ?>'
                },
                prompt: true,
                fn: function (btn, text)
                {
                    text = Ext.util.Format.stripTags(text);

                    text = text.trim();

                    if (btn == 'ok' && text != '')
                    {
                        Ext.MessageBox.show({
                            msg: '<?php echo __('Dodawanie kategorii, prosze czekać...'); ?>',
                            progressText: '<?php echo __('Operacja w toku...'); ?>',
                            width:325,
                            wait:true,
                            waitConfig: {
                                interval:200
                            },
                            icon:'ext-mb-download'
                        });

                        jQuery.post(
                            Ext.SF_SCRIPT_NAME + '/' + module_name + '/appendCategory',
                            {
                                parent_id: sn.id,
                                name: text
                            },
                            function(json_data)
                            {
                                if (json_data)
                                {
                                    var parent = tree.getNodeById(json_data.parent_id);

                                    parent.appendChild(new Ext.tree.AsyncTreeNode({
                                        text: json_data.name,
                                        id: json_data.id,
                                        allowDrag: true,
                                        uiProvider: ui_provider,
                                        qtip: '<?php echo __('Kliknij dwukrotnie aby zmienić nazwę kategorii. Kliknij, przytrzymaj i przeciągnij aby zmienić jej położenie'); ?>'
                                    }));

                                    Ext.MessageBox.hide();

                                    parent.expand(false, true);


                                }
                            },
                            'json'
                        );
                    }
                    else if (btn != 'cancel')
                    {
                        stCategoryTree.showCategoryCreateWindow(tree, module_name, ui_provider);
                    }
                },
                animEl: sn.id
            });
        },
        create : function(root_name, root_id, module_name, editable, ui_provider, params, container_scroll, animated, show_hints, root_href)
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
                    trackMouse: true
                });
            }

            var tb = new Ext.Toolbar(
            {
                items:
                [

                {
                    text: '<?php echo __('Dodaj'); ?>',
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/add.png',
                    disabled: true,
                    tooltip: '<?php echo __('Wybierz kategorię z drzewa do której chcesz dodać nową podkategorię i ponownie wciśnij ten przycisk'); ?>',
                    handler: function () { stCategoryTree.showCategoryCreateWindow(tree, module_name, ui_provider) }
                },
                {
                    text: '<?php echo __('Edytuj'); ?>',
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/edit.png',
                    disabled: true,
                    tooltip: '<?php echo __('Wybierz kategorię z drzewa, którą chcesz edytować a następnie wciśnij ten przycisk.'); ?>',
                    handler: function()
                    {
                        var sn = tree.getSelectionModel().getSelectedNode();

                        if (sn)
                        {
                            window.location = Ext.SF_SCRIPT_NAME  + '/category/edit/id/' + sn.id;
                        }


                    }
                },
                {
                    text: '<?php echo __('Usuń'); ?>',
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/delete.png',
                    disabled: true,
                    tooltip: '<?php echo __('Wybierz kategorię z drzewa którą chcesz usunać a następnie wciśnij ten przycisk.'); ?>',
                    handler: function()
                    {
                        Ext.MessageBox.buttonText.yes = "<?php echo __('Tak') ?>";
                        Ext.MessageBox.buttonText.no = "<?php echo __('Nie') ?>";
                        Ext.Msg.confirm("<?php echo __('Usunąć kategorię?') ?>", '<?php echo __('Zamierzasz usunąć kategorię z drzewa. Jesteś pewien że chcesz kontynuować?') ?>',
                            function (btn)
                            {
                                if (btn == "yes")
                                {
                                    Ext.MessageBox.show({
                                        msg: '<?php echo __('Usuwanie kategorii, prosze czekać...'); ?>',
                                        progressText: '<?php echo __('Operacja w toku...'); ?>',
                                        width:325,
                                        wait:true,
                                        waitConfig: {
                                            interval:200
                                        },
                                        icon:'ext-mb-download', //custom class in msg-box.html
                                        animEl: 'mb7'
                                    });

                                    var sn = tree.getSelectionModel().getSelectedNode();

                                    if (sn)
                                    {

                                        jQuery.post(
                                            Ext.SF_SCRIPT_NAME + '/' + module_name + '/removeCategory',
                                            {
                                                id: sn.id
                                            },
                                            function(json_data)
                                            {
                                                if (json_data.error)
                                                {
                                                    Ext.MessageBox.hide();
                                                    showError(json_data.error);
                                                }
                                                else
                                                {
                                                    var node = tree.getNodeById(json_data.id);

                                                    if (node)
                                                    {
                                                        if (node.isRoot)
                                                        {
                                                            tree.destroy()
                                                        }
                                                        else
                                                        {
                                                            node.remove();
                                                        }
                                                    }

                                                    Ext.MessageBox.hide();
                                                }
                                            },
                                            'json'
                                        );
                                    }
                                }
                            });

                    }
                },
                {
                    text: '<?php echo __('Usuń drzewo'); ?>',
                    cls: 'st_ext_button-icon',
                    icon: '/images/backend/icons/delete.png',
                    tooltip: '<?php echo __('Usuwa całe drzewo kategorii'); ?>',
                    handler: function()
                    {
                        Ext.MessageBox.buttonText.yes = "<?php echo __('Tak') ?>";
                        Ext.MessageBox.buttonText.no = "<?php echo __('Nie') ?>";
                        Ext.Msg.confirm("<?php echo __('Usunąć drzewo?') ?>", '<?php echo __('Zamierzasz usunąć całe drzewo kategorii. Jesteś pewien że chcesz kontynuować?') ?>',
                            function (btn)
                            {
                                if (btn == "yes")
                                {
                                    Ext.MessageBox.show({
                                        msg: '<?php echo __('Usuwanie drzewa kategorii, prosze czekać...'); ?>',
                                        progressText: '<?php echo __('Operacja w toku...'); ?>',
                                        width:325,
                                        wait:true,
                                        waitConfig: {
                                            interval:200
                                        },
                                        icon:'ext-mb-download', //custom class in msg-box.html
                                        animEl: 'mb7'
                                    });

                                    var root = tree.getRootNode();

                                    jQuery.post(
                                        Ext.SF_SCRIPT_NAME + '/' + module_name + '/removeCategory',
                                        {
                                            id: root.id
                                        },
                                        function(json_data)
                                        {
                                            if (json_data.error)
                                            {
                                                Ext.MessageBox.hide();
                                                showError(json_data.error);
                                            }
                                            else
                                            {
                                                var node = tree.getNodeById(json_data.id);

                                                if (node)
                                                {
                                                    tree.destroy();
                                                }
                                                Ext.MessageBox.hide();
                                            }
                                        },
                                        'json'
                                    );
                                }
                            });


                    }
                },
                {
                    text: '&nbsp;&nbsp;',
                    icon: '/images/backend/beta/icons/16x16/go_prev_arrow.png',
                    tooltip: '<?php echo __('Przenieś drzewo do góry'); ?>',
                    handler: function () { 
                       Ext.MessageBox.show({
                                        msg: '<?php echo __('Przenoszenie drzewa kategorii...'); ?>',
                                        progressText: '<?php echo __('Operacja w toku...'); ?>',
                                        width:325,
                                        wait:true,
                                        waitConfig: {
                                            interval:200
                                        },
                                        icon:'ext-mb-download', //custom class in msg-box.html
                                        animEl: 'mb7'
                       });
                       window.location = Ext.SF_SCRIPT_NAME  + '/category/setRootPosition/id/' + root_id + '/move/up';
                    }
                }, 
                {
                    text: '&nbsp;&nbsp;',       
                    tooltip: '<?php echo __('Przenieś drzewo w dół'); ?>',           
                    icon: '/images/backend/beta/icons/16x16/go_next_arrow.png',
                    handler: function () { 
                       Ext.MessageBox.show({
                                        msg: '<?php echo __('Przenoszenie drzewa kategorii...'); ?>',
                                        progressText: '<?php echo __('Operacja w toku...'); ?>',
                                        width:325,
                                        wait:true,
                                        waitConfig: {
                                            interval:200
                                        },
                                        icon:'ext-mb-download', //custom class in msg-box.html
                                        animEl: 'mb7'
                       });                    
                       window.location = Ext.SF_SCRIPT_NAME  + '/category/setRootPosition/id/' + root_id + '/move/down';
                    }
                }                   

                ]
            });

            var Tree = Ext.tree;

            var tree = new Tree.TreePanel(
            {
                el: 'st_category-tree-' + root_id,
                autoScroll: true,
                animate: animated,
                enableDD: editable,
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
                    dataUrl: Ext.SF_SCRIPT_NAME + '/' + module_name + '/fetchCategories?root_id=' + root_id,
                    baseParams: params,
                    baseAttrs: {
                        uiProvider: ui_provider
                    }
                })

            });
            
            
            tree.on('load', function(node) {
               jQuery('#'+tree.getEl().id).removeClass('loaded').addClass('loaded');
            });               

            // set the root node
            if (editable)
            {
                var root = new Tree.AsyncTreeNode(
                {
                    text: root_name,
                    cls: 'st_category-tree-root',
                    draggable: false,
                    qtip: '<?php echo __('Kliknij dwukrotnie aby zmienić nazwę drzewa kategorii'); ?>',
                    id: root_id,
                    href: root_href ? root_href : null,
                    uiProvider: ui_provider
                });
            } else
            {
                var root = new Tree.AsyncTreeNode(
                {
                    text: root_name,
                    cls: 'st_category-tree-root',
                    draggable: false,
                    id: root_id,
                    href: root_href ? root_href : null,
                    uiProvider: ui_provider
                });
            }

            tree.setRootNode(root);

            tree.on('textchange', function (node, value, old_value)
            {

                value = Ext.util.Format.stripTags(value);

                value = value.trim();

                tree.suspendEvents();
                node.setText(value);
                tree.resumeEvents();

                if (value != '' && value != old_value)
                {
                    jQuery.post(
                        Ext.SF_SCRIPT_NAME + '/' + module_name + '/changeCategoryName',
                        {
                            'value': value,
                            'id': node.id
                        },
                        'json'
                    );



                }
                else if (value == '')
                {
                    tree.suspendEvents();
                    node.setText(old_value);
                    tree.resumeEvents();
                }

            });

            if (editable)
            {
                tree.on('click', function (node, e)
                {
                    tb.items.item(0).setDisabled(false);

                    if (node.isRoot)
                    {
                        tb.items.item(1).setDisabled(false);
                        tb.items.item(2).setDisabled(true);
                    }
                    else
                    {
                        tb.items.item(1).setDisabled(false);
                        tb.items.item(2).setDisabled(false);
                    }
                });
            }

            tree.on('movenode', function (tree, node, old_parent, new_parent, index)
            {

                Ext.MessageBox.show({
                    msg: '<?php echo __('Przenoszenie kategorii, prosze czekać...'); ?>',
                    progressText: '<?php echo __('Operacja w toku...'); ?>',
                    width:325,
                    wait:true,
                    waitConfig: {
                        interval:200
                    },
                    icon:'ext-mb-download'
                });


                if (node.previousSibling)
                {
                    prev_sibling_id = node.previousSibling.id;
                }
                else
                {
                    prev_sibling_id = 0;
                }

                if (node.nextSibling)
                {
                    next_sibling_id = node.nextSibling.id;
                }
                else
                {
                    next_sibling_id = 0;
                }

                jQuery.post(
                    Ext.SF_SCRIPT_NAME + '/' + module_name + '/moveCategory',
                    {
                        'prev_sibling_id': prev_sibling_id,
                        'next_sibling_id': next_sibling_id,
                        'parent_id': new_parent.id,
                        'id': node.id
                    },
                    function()
                    {
                        Ext.MessageBox.hide();
                    }                    
                );
            });


            // render the tree
            tree.render();

            root.expand();

            if (typeof Ext.categoryTree == 'undefined')
            {
                Ext.categoryTree = [];
            }

            Ext.categoryTree[root.id] = tree;

            if (editable)
            {
                var ge = new Ext.tree.TreeEditor(tree,
                {
                    allowBlank: false,
                    blankText: '<?php echo __('Musisz podać nazwę kategorii'); ?>',
                    selectOnFocus:true,
                    cancelOnEsc: true
                });
            }
        }

    };
}();


Ext.tree.stTreeNodeUI = Ext.extend(Ext.tree.TreeNodeUI, {

    updateExpandIcon : function(){
        if(this.rendered){

            var n = this.node, c1, c2;
            var cls = n.isLast() ? "x-tree-elbow-end" : "x-tree-elbow";
            var hasChild = n.hasChildNodes();
            if(hasChild || n.attributes.expandable){
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

Ext.tree.stTreeNodeCheckbox = function(id, checked)
{ 
  if (!checked)
  {
     jQuery('#product_has_category_'+id).remove();
     
     if (jQuery('#product_default_category').val() == id)
     {
        jQuery('#product_default_category').remove();
     }
  }
  else
  {
     jQuery('#st_product_has_categories').append('<input type="hidden" value="'+id+'" name="product_has_category['+id+']" id="product_has_category_'+id+'" />');
          
     if (jQuery('#product_default_category').length == 0)
     {
        Ext.tree.stTreeNodeRadiobox(id);
        
        jQuery('#pdc_'+id).attr('checked', true);
     }
  }
  
  jQuery('#pdc_'+id).attr('disabled', !checked);
}

Ext.tree.stTreeNodeRadiobox = function(id)
{
   var input = jQuery('#product_default_category');
   
   if (input.length)
   {
      input.val(id);
   }
   else
   {
      jQuery('#st_product_has_categories').append('<input type="hidden" value="'+id+'" name="product_default_category" id="product_default_category" />');
   }
}

Ext.tree.stTreeNodeProductUI = Ext.extend(Ext.tree.stTreeNodeUI,{
    renderElements : function(n, a, targetNode, bulkRender){
        // add some indent caching, this helps performance when rendering a large tree
        this.indentMarkup = n.parentNode ? n.parentNode.ui.getChildIndent() : '';

        var root = n.ownerTree.getRootNode();
        if (!n.isRoot)
        {
            var cb = ['<input onchange="Ext.tree.stTreeNodeCheckbox(this.value, this.checked)" qtip="<?php echo __('Zaznacz aby dodać produkt do kategorii') ?>" name="pic[' + n.id + ']" value="' + n.id + '" class="x-tree-node-cb" type="checkbox" ' + (a.in_category ? 'checked="checked" />' : '/>') ,
            '<input onclick="Ext.tree.stTreeNodeRadiobox(this.value)" qtip="<?php echo __('Zaznacz aby ustawić główną kategorię dla produktu') ?>" name="pdc" id="pdc_'+n.id+'" value="' + n.id + '" type="radio" onmouseup="this.checked = true" ' + (!a.in_category ? 'disabled="disabled"' : '') + (a.default_category ? ' checked="checked" />' : '/>')].join('');
        }
        else
        {
            var cb = [];
        }

        var href = a.href ? a.href : Ext.isGecko ? "" : "#";
        var buf = ['<li class="x-tree-node"><div ext:tree-node-id="',n.id,'" class="x-tree-node-el x-tree-node-leaf ', a.cls,'">',

        '<span class="x-tree-node-indent">',this.indentMarkup,"</span>",
        '<img src="', this.emptyIcon, '" class="x-tree-ec-icon x-tree-elbow" />',
        '<img src="', a.icon || this.emptyIcon, '" class="x-tree-node-icon',(a.icon ? " x-tree-node-inline-icon" : ""),(a.iconCls ? " "+a.iconCls : ""),'" unselectable="on" />',
        cb,
        '<a hidefocus="on" class="x-tree-node-anchor" href="',href,'" tabIndex="1" ',
        a.hrefTarget ? ' target="'+a.hrefTarget+'"' : "", '><span unselectable="on">',n.text,"</span></a>",

        "</div>",

        '<ul class="x-tree-node-ct" style="clear: both;display:none;"></ul>',

        "</li>"].join('');

        var nel;
        if(bulkRender !== true && n.nextSibling && (nel = n.nextSibling.ui.getEl())){
            this.wrap = Ext.DomHelper.insertHtml("beforeBegin", nel, buf);
        }else{
            this.wrap = Ext.DomHelper.insertHtml("beforeEnd", targetNode, buf);
        }

        this.elNode = this.wrap.childNodes[0];
        this.ctNode = this.wrap.childNodes[1];
        var cs = this.elNode.childNodes;
        this.indentNode = cs[0];
        this.ecNode = cs[1];
        this.iconNode = cs[2];


        var index = n.isRoot ? 3 : 5;

        this.anchor = cs[index];
        this.textNode = cs[index].firstChild;
    },

    onCheckChange : function(){

    }

});

Ext.tree.stTreeNodeFrontendUI = Ext.extend(Ext.tree.stTreeNodeUI,{
    renderElements : function(n, a, targetNode, bulkRender){
        // add some indent caching, this helps performance when rendering a large tree
        this.indentMarkup = n.parentNode ? n.parentNode.ui.getChildIndent() : '';

        var href = a.href ? a.href : Ext.isGecko ? "" : "#";
        var buf = ['<li class="st_category-tree-element ',n.isLast ? 'st_category-tree-element-last' : '','"><div ext:tree-node-id="',n.id,'" class="x-tree-node-el ',a.cls,'">',

        //'<span class="x-tree-node-indent">',this.indentMarkup,"</span>",
        '<img src="', this.emptyIcon, '" class="x-tree-ec-icon x-tree-elbow" />',
        '<a class="x-tree-node-anchor" href="',href,'" tabIndex="1" ',
        a.hrefTarget ? ' target="'+a.hrefTarget+'"' : "", '><span unselectable="on">',n.text,"</span></a>",
        '<img src="', this.emptyIcon, '" class="x-tree-node-icon',(a.icon ? " x-tree-node-inline-icon" : ""),(a.iconCls ? " "+a.iconCls : ""),'" unselectable="on" />',
        "</div>",
        '<ul class="x-tree-node-ct" style="display:none;"></ul>',
        "</li>"].join('');

        var nel;
        if(bulkRender !== true && n.nextSibling && (nel = n.nextSibling.ui.getEl())){
            this.wrap = Ext.DomHelper.insertHtml("beforeBegin", nel, buf);
        }else{
            this.wrap = Ext.DomHelper.insertHtml("beforeEnd", targetNode, buf);
        }

        this.elNode = this.wrap.childNodes[0];
        this.ctNode = this.wrap.childNodes[1];
        var cs = this.elNode.childNodes;
        // this.indentNode = cs[0];
        this.ecNode = cs[0];
        this.iconNode = cs[2];


        var index = 1;

        this.anchor = cs[index];
        this.textNode = cs[index].firstChild;
    },

    onCheckChange : function(){

    }

});
