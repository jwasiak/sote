/*
 * Treeview 1.4 - jQuery plugin to hide and show branches of a tree
 * 
 * http://bassistance.de/jquery-plugins/jquery-plugin-treeview/
 * http://docs.jquery.com/Plugins/Treeview
 *
 * Copyright (c) 2007 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id: jquery.treeview.js 4684 2008-02-07 19:08:06Z joern.zaefferer $
 *
 */

;(function($) {

   $.extend($.fn, {
      swapClass: function(c1, c2) {
         var c1Elements = this.filter('.' + c1);
         this.filter('.' + c2).removeClass(c2).addClass(c1);
         c1Elements.removeClass(c1).addClass(c2);
         return this;
      },
      replaceClass: function(c1, c2) {
         return this.filter('.' + c1).removeClass(c1).addClass(c2).end();
      },
      hoverClass: function(className) {
         className = className || "hover";
         return this.hover(function() {
            $(this).addClass(className);
         }, function() {
            $(this).removeClass(className);
         });
      },
      heightToggle: function(animated, callback) {
         animated ?
            this.animate({ height: "toggle" }, animated, callback) :
            this.each(function(){
               jQuery(this)[ jQuery(this).is(":hidden") ? "show" : "hide" ]();
               if(callback)
                  callback.apply(this, arguments);
            });
      },
      heightHide: function(animated, callback) {
         if (animated) {
            this.animate({ height: "hide" }, animated, callback);
         } else {
            this.hide();
            if (callback)
               this.each(callback);          
         }
      },
      prepareBranches: function(settings) {
         if (!settings.prerendered) {
            // mark last tree items
            this.filter(":last-child:not(ul)").addClass(CLASSES.last);
            // collapse whole tree, or only those marked as closed, anyway except those marked as open
            this.filter((settings.collapsed ? "" : "." + CLASSES.closed) + ":not(." + CLASSES.open + ")").find(">ul").hide();
         }
         // return all items with sublists
         return this.filter(":has(> div img."+CLASSES.hitarea+")");
      },
      applyClasses: function(settings, toggler, loader) {
//       this.filter(":has(>ul):not(:has(>a))").find(">span").click(function(event) {
//          toggler.apply($(this).next());
//       }).add( $("a", this) ).hoverClass();
         
         if (!settings.prerendered) {
            // handle closed ones first
            this.filter(":has(>ul:hidden)")
                  .addClass(CLASSES.expandable)
                  .replaceClass(CLASSES.last, CLASSES.lastExpandable);
                  
            // handle open ones
            this.not(":has(>ul:hidden)")
                  .addClass(CLASSES.collapsable)
                  .replaceClass(CLASSES.last, CLASSES.lastCollapsable);
                  
               // create hitarea
            this.prepend("<div class=\"" + CLASSES.hitarea + "\"/>").find("div." + CLASSES.hitarea).each(function() {
               var classes = "";
               $.each($(this).parent().attr("class").split(" "), function() {
                  classes += this + "-hitarea ";
               });
               $(this).addClass( classes );
            });
         }
         
         // apply event to hitarea
                        if (settings.url)
                        {
                           $(this).not(':has(>ul)').find("." + CLASSES.hitarea).click(loader);
                           $(this).filter(':has(>ul)').find("." + CLASSES.hitarea).click(toggler);
                        }
                        else
                        {
                           $(this).find("." + CLASSES.hitarea).click(toggler);
                        }
      },
      treeview: function(settings) {
         
         settings = $.extend({
            cookieId: "treeview"
         }, settings);
         
         if (settings.add) {
            return this.trigger("add", [settings.add]);
         }
         
         if ( settings.toggle ) {
            var callback = settings.toggle;
            settings.toggle = function() {
               return callback.apply($(this).parent()[0], arguments);
            };
         }
      
         // factory for treecontroller
         function treeController(tree, control) {
            // factory for click handlers
            function handler(filter) {
               return function() {
                  // reuse toggle event handler, applying the elements to toggle
                  // start searching for all hitareas
                  toggler.apply( $("." + CLASSES.hitarea, tree).filter(function() {
                     // for plain toggle, no filter is provided, otherwise we need to check the parent element
                     return filter ? $(this).parent("." + filter).length : true;
                  }) );
                  return false;
               };
            }
            // click on first element to collapse tree
            $("a:eq(0)", control).click( handler(CLASSES.collapsable) );
            // click on second to expand tree
            $("a:eq(1)", control).click( handler(CLASSES.expandable) );
            // click on third to toggle tree
            $("a:eq(2)", control).click( handler() ); 
         }

                        function loader(event)
                        {

                           if (settings.url)
                           {
                              var hitarea = $(this);
                              hitarea.unbind(event);
                              hitarea.click(toggler);
                              hitarea.trigger('click');
                              hitarea.addClass('preload');
                  
                              $.get(settings.url, {id: Number(hitarea.attr('id').match(/[0-9]+$/))}, function(data) {
                                 var parent = hitarea.parent().parent();
                                 parent.append(data);

                                 hitarea.removeClass('preload');
                              });
                           }

                           event.stopPropagation();
                           event.stopImmediatePropagation();
                        }
      
         // handle toggle event
         function toggler(event) {
                          if (!event.isImmediatePropagationStopped())
                          {
                                 target = $(this);
                            

            target
               .parent()
               // swap classes for hitarea
               .find(">." + CLASSES.hitarea)
                  .swapClass( CLASSES.collapsableHitarea, CLASSES.expandableHitarea )
                  .swapClass( CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea )
               .end()
               // swap classes for parent li
               .swapClass( CLASSES.collapsable, CLASSES.expandable )
               .swapClass( CLASSES.lastCollapsable, CLASSES.lastExpandable )
               // find child lists
                    .parent()
               .find( ">ul" )
               // toggle them
               .heightToggle( settings.animated, settings.toggle );
            if ( settings.unique ) {
               target.parent()
                  .siblings()
                  // swap classes for hitarea
                  .find(">." + CLASSES.hitarea)
                     .replaceClass( CLASSES.collapsableHitarea, CLASSES.expandableHitarea )
                     .replaceClass( CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea )
                  .end()
                  .replaceClass( CLASSES.collapsable, CLASSES.expandable )
                  .replaceClass( CLASSES.lastCollapsable, CLASSES.lastExpandable )
                  .find( ">ul" )
                  .heightHide( settings.animated, settings.toggle );
            }
                                event.stopImmediatePropagation();
                          }

         }
         
         function serialize() {
            function binary(arg) {
               return arg ? 1 : 0;
            }
            var data = [];
            branches.each(function(i, e) {
               data[i] = $(e).is(":has(>ul:visible)") ? 1 : 0;
            });
            $.cookie(settings.cookieId, data.join("") );
         }
         
         function deserialize() {
            var stored = $.cookie(settings.cookieId);
            if ( stored ) {
               var data = stored.split("");
               branches.each(function(i, e) {
                  $(e).find(">ul")[ parseInt(data[i]) ? "show" : "hide" ]();
               });
            }
         }
         
         // add treeview class to activate styles
         this.addClass("treeview");
         
         // prepare branches and find all tree items with child lists
         var branches = this.find("li").prepareBranches(settings);
         
         switch(settings.persist) {
         case "cookie":
            var toggleCallback = settings.toggle;
            settings.toggle = function() {
               serialize();
               if (toggleCallback) {
                  toggleCallback.apply(this, arguments);
               }
            };
            deserialize();
            break;
         case "location":
            var current = this.find("a").filter(function() { return this.href.toLowerCase() == location.href.toLowerCase(); });
            if ( current.length ) {
               current.addClass(CLASSES.selected).parents("ul, li").add( current.next() ).show();
            }
            break;
         }
         
         branches.applyClasses(settings, toggler, loader);
            
         // if control option is set, create the treecontroller and show it
         if ( settings.control ) {
            treeController(this, settings.control);
            $(settings.control).show();
         }
         
         return this.bind("add", function(event, branches) {
            $(branches).prev()
               .removeClass(CLASSES.last)
               .removeClass(CLASSES.lastCollapsable)
               .removeClass(CLASSES.lastExpandable)
            .find(">." + CLASSES.hitarea)
               .removeClass(CLASSES.lastCollapsableHitarea)
               .removeClass(CLASSES.lastExpandableHitarea);
            $(branches).find("li").andSelf().prepareBranches(settings).applyClasses(settings, toggler, loader);
         });
      }
   });
   
   // classes used by the plugin
   // need to be styled via external stylesheet, see first example
   var CLASSES = $.fn.treeview.classes = {
      open: "open",
      closed: "closed",
      expandable: "x-tree-node-expanded",
      expandableHitarea: "x-tree-elbow-plus",
      lastExpandableHitarea: "x-tree-elbow-end-plus",
      collapsable: "x-tree-node-collapsed",
      collapsableHitarea: "x-tree-elbow-minus",
      lastCollapsableHitarea: "x-tree-elbow-end-minus",
      lastCollapsable: "lastCollapsable",
      lastExpandable: "lastExpandable",
      last: "last",
      hitarea: "x-tree-hitarea",
        selected: 'x-tree-node-anchor-selected'
   };
   
   // provide backwards compability
   $.fn.Treeview = $.fn.treeview;
   
})(jQuery);