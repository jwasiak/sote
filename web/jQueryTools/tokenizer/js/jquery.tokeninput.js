/*
 * jQuery Plugin: Tokenizing Autocomplete Text Entry
 * Version 1.6.0
 *
 * Copyright (c) 2009 James Smith (http://loopj.com)
 * Licensed jointly under the GPL and MIT licenses,
 * choose which one suits your project best!
 *
 */

(function ($) {
// Default settings
var DEFAULT_SETTINGS = {
   // Search settings
    method: "GET",
    contentType: "json",
    queryParam: "q",
    duplicatesParam: "d",
    searchDelay: 300,
    minChars: 1,
    propertyToSearch: "name",
    jsonContainer: null,
    searchAlgorithm: 'global',

   // Display settings
    hintText: "Type in a search term",
    noResultsText: "No results",
    searchingText: "Searching...",
    addNewIcon: "/images/backend/beta/icons/22x22/add.png",
    addNewText: "dodaj",
    createNew: false,
    deleteText: "&times;",
    animateDropdown: true,

   // Tokenization settings
    tokenLimit: null,
    tokenDelimiter: ",",
    propertyNew: "new",
    preventDuplicates: false,

   // Output settings
    tokenValue: "id",

   // Prepopulation settings
    prePopulate: null,
    processPrePopulate: false,
    additionalDataFields: [],

   // Manipulation settings
    idPrefix: "token-input-",

   // Formatters
    newResultsFormatter: function(item){ return "<li><img src=\""+this.addNewIcon+"\" style=\"vertical-align: middle; margin-right: 2px\" /> <span style=\"vertical-align: middle\">"+this.addNewText+": <b>"+item[this.propertyToSearch]+"</b></span></li>" },
    newTokenFormatter: function(item){ return "<li><p>" + item[this.propertyToSearch] + "</p></li>" },
    resultsFormatter: function(item){ return "<li>" + item[this.propertyToSearch]+ "</li>" },
    tokenFormatter: function(item) { return "<li><p>" + item[this.propertyToSearch] + "</p></li>" },

    savedTokens: {},

   // Callbacks
    onResult: null,
    onAdd: null,
    onDelete: null,
    onReady: null,
    onBeforeAdd: null
};

// Default classes to use when theming
var DEFAULT_CLASSES = {
    tokenList: "token-input-list",
    token: "token-input-token",
    tokenDelete: "token-input-delete-token",
    selectedToken: "token-input-selected-token",
    highlightedToken: "token-input-highlighted-token",
    dropdown: "token-input-dropdown",
    dropdownItem: "token-input-dropdown-item",
    dropdownItem2: "token-input-dropdown-item2",
    selectedDropdownItem: "token-input-selected-dropdown-item",
    inputToken: "token-input-input-token"
};

// Input box position "enum"
var POSITION = {
    BEFORE: 0,
    AFTER: 1,
    END: 2
};

// Keys "enum"
var KEY = {
    BACKSPACE: 8,
    TAB: 9,
    ENTER: 13,
    ESCAPE: 27,
    SPACE: 32,
    PAGE_UP: 33,
    PAGE_DOWN: 34,
    END: 35,
    HOME: 36,
    LEFT: 37,
    UP: 38,
    RIGHT: 39,
    DOWN: 40,
    NUMPAD_ENTER: 108,
    COMMA: 188
};

// Additional public (exposed) methods
var methods = {
    init: function(url_or_data_or_function, options) {
        var settings = $.extend({}, DEFAULT_SETTINGS, options || {});

        return this.each(function () {
            $(this).data("tokenInputObject", new $.TokenList(this, url_or_data_or_function, settings));
        });
    },
    clear: function() {
        this.data("tokenInputObject").clear();
        return this;
    },
    add: function(item) {
        this.data("tokenInputObject").add(item);
        return this;
    },
    updateTokens: function() {
        this.data("tokenInputObject").updateTokens();
        return this;
    },    
    remove: function(item) {
        this.data("tokenInputObject").remove(item);
        return this;
    },
    get: function() {
      return this.data("tokenInputObject").getTokens();
    }, 
    highlightTerm: function(value, term) {
      return this.data("tokenInputObject").highlightTerm(value, term);
    }
}

// Expose the .tokenInput function to jQuery as a plugin
$.fn.tokenInput = function (method) {
    // Method calling and initialization logic
    if(methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else {
        return methods.init.apply(this, arguments);
    }
};

// TokenList class for each input
$.TokenList = function (input, url_or_data, settings) {
    //
    // Initialization
    //

    // Configure the data source
    if(typeof(url_or_data) === "string" || typeof(url_or_data) === "function") {
        // Set the url to query against
        settings.url = url_or_data;

        // If the URL is a function, evaluate it here to do our initalization work
        var url = computeURL();

        // Make a smart guess about cross-domain if it wasn't explicitly specified
        if(settings.crossDomain === undefined) {
            if(url.indexOf("://") === -1) {
                settings.crossDomain = false;
            } else {
                settings.crossDomain = (location.href.split(/\/+/g)[1] !== url.split(/\/+/g)[1]);
            }
        }
    } else if(typeof(url_or_data) === "object") {
        // Set the local data to search through
        settings.local_data = url_or_data;
    }

    // Build class names
    if(settings.classes) {
        // Use custom class names
        settings.classes = $.extend({}, DEFAULT_CLASSES, settings.classes);
    } else if(settings.theme) {
        // Use theme-suffixed default class names
        settings.classes = {};
        $.each(DEFAULT_CLASSES, function(key, value) {
            settings.classes[key] = value + "-" + settings.theme;
        });
    } else {
        settings.classes = DEFAULT_CLASSES;
    }

    var token_input = this;


    // Save the tokens
    var saved_tokens = [];

    // Keep track of the number of tokens in the list
    var token_count = 0;

    // Basic cache to save on db hits
    var cache = new $.TokenList.Cache();

    // Keep track of the timeout, old vals
    var timeout;
    var input_val;

    // Create a new text input an attach keyup events
    var input_box = $("<input type=\"text\"  autocomplete=\"off\">")
    
    if (settings.prePopulate && settings.prePopulate.length > 0) {
        input_box.css({display: 'none'});
    }

    input_box.css({
            outline: "none",
        })
        .attr("id", settings.idPrefix + input.id)
        .focus(function (event) {
            if (settings.tokenLimit === null || settings.tokenLimit !== token_count) {
               $(this).show();
            }
            event.stopPropagation();
        })
        .blur(function () {
            hide_dropdown();
            input_box.val("");
            // if (saved_tokens.length > 0) {
            //    input_box.hide();
            // }
        })
        .bind("keyup keydown blur update", resize_input)
        .keydown(function (event) {
            var previous_token;
            var next_token;

            switch(event.keyCode) {
                case KEY.UP:
                case KEY.DOWN:
                    if(!$(this).val()) {
                        previous_token = input_token.prev();
                        next_token = input_token.next();

                        if((previous_token.length && previous_token.get(0) === selected_token) || (next_token.length && next_token.get(0) === selected_token)) {
                            // Check if there is a previous/next token and it is selected
                            if(event.keyCode === KEY.LEFT || event.keyCode === KEY.UP) {
                                deselect_token($(selected_token), POSITION.BEFORE);
                            } else {
                                deselect_token($(selected_token), POSITION.AFTER);
                            }
                        } else if((event.keyCode === KEY.LEFT || event.keyCode === KEY.UP) && previous_token.length) {
                            // We are moving left, select the previous token if it exists
                            select_token($(previous_token.get(0)));
                        } else if((event.keyCode === KEY.RIGHT || event.keyCode === KEY.DOWN) && next_token.length) {
                            // We are moving right, select the next token if it exists
                            select_token($(next_token.get(0)));
                        }
                    } else {
                        var dropdown_item = null;

                        if(event.keyCode === KEY.DOWN || event.keyCode === KEY.RIGHT) {
                            dropdown_item = $(selected_dropdown_item).next();
                        } else {
                            dropdown_item = $(selected_dropdown_item).prev();
                        }

                        if(dropdown_item.length) {
                            select_dropdown_item(dropdown_item);
                        }
                        return false;
                    }
                    break;

                case KEY.BACKSPACE:
                    previous_token = input_token.prev();

                    if(!$(this).val().length) {
                        if(selected_token) {
                            delete_token($(selected_token));
                            hidden_input.change();
                        } else if(previous_token.length) {
                            select_token($(previous_token.get(0)));
                        }

                        return false;
                    } else if($(this).val().length === 1) {
                        hide_dropdown();
                    } else {
                        // set a timeout just long enough to let this function finish.
                        setTimeout(function(){do_search();}, 5);
                    }
                    break;

                case KEY.TAB:
                case KEY.ENTER:
                case KEY.NUMPAD_ENTER:
                  if(selected_dropdown_item) {
                    add_token($(selected_dropdown_item).data("tokeninput"));
                    hidden_input.change();
                    return false;
                  }
                  break;

                case KEY.ESCAPE:
                  hide_dropdown();
                  return true;

                default:
                    if(String.fromCharCode(event.which)) {
                        // set a timeout just long enough to let this function finish.
                        if (selected_token) {
                           deselect_token($(selected_token), POSITION.END);
                           input_box.focus();
                        }
                        setTimeout(function(){do_search();}, 5);
                    }
                    break;
            }
        });

    // Keep a reference to the original input box
    var hidden_input = $(input)
                           .hide()
                           .val("")
                           .focus(function () {
                               input_box.focus();
                           })
                           .blur(function () {
                               input_box.blur();
                           });

    // Keep a reference to the selected token and dropdown item
    var selected_token = null;
    var selected_token_index = 0;
    var selected_dropdown_item = null;

    // The list to store the token items in
    var token_list = $("<ul />")
        .addClass(settings.classes.tokenList)
        .click(function (event) {
          // Deselect selected token
          if(selected_token) {
              deselect_token($(selected_token), POSITION.END);
          }

          if (!settings.local_data && (settings.tokenLimit === null || settings.tokenLimit !== token_count)) {
            show_dropdown_hint();
          }
          else if (settings.local_data && (settings.tokenLimit === null || settings.tokenLimit !== token_count)) {
            run_search(null);
          }

          // Focus input box
          input_box.focus();

        })
        .mouseover(function (event) {
            var li = $(event.target).closest("li");
            if(li && selected_token !== this) {
                li.addClass(settings.classes.highlightedToken);
            }
        })
        .mouseout(function (event) {
            var li = $(event.target).closest("li");
            if(li && selected_token !== this) {
                li.removeClass(settings.classes.highlightedToken);
            }
        })
        .keypress(function(event) {
            if (event.ctrlKey && event.which == 99)
            {
            }
        })
        .insertBefore(hidden_input);

    // The token holding the input box
    var input_token = $("<li />")
        .addClass(settings.classes.inputToken)
        .appendTo(token_list)
        .append(input_box);

    // The list to store the dropdown items in
    var dropdown = $("<div>")
        .addClass(settings.classes.dropdown)
        .appendTo("body")
        .hide();

    // Magic element to help us resize the text input
    var input_resizer = $("<tester/>")
        .insertAfter(input_box)
        .css({
            position: "absolute",
            top: -9999,
            left: -9999,
            width: "auto",
            fontSize: input_box.css("fontSize"),
            fontFamily: input_box.css("fontFamily"),
            fontWeight: input_box.css("fontWeight"),
            letterSpacing: input_box.css("letterSpacing"),
            whiteSpace: "nowrap"
        });

    // Pre-populate list if items exist
    hidden_input.val("");
    var li_data = settings.prePopulate || hidden_input.data("pre");
    if(settings.processPrePopulate && $.isFunction(settings.onResult)) {
        li_data = settings.onResult.call(hidden_input, li_data);
    }
    if(li_data && li_data.length) {
        $.each(li_data, function (index, value) {
            insert_token(value);
            checkTokenLimit();
        });
    }

    // Initialization is done
    if($.isFunction(settings.onReady)) {
        settings.onReady.call();
    }

    //
    // Public functions
    //

    this.clear = function() {
        token_list.children("li").each(function() {
            if (!$(this).hasClass(settings.classes.inputToken)) {
                delete_token($(this));
            }
        });
        //input_box.focus();
        saved_tokens = [];
        token_count = 0;
        selected_token_index = 0;
    }

    this.add = function(item) {
        add_token(item);
    }

    this.updateTokens = function() {
        saved_tokens = [];
        token_list.children().each(function() {
            var data = $(this).data('tokeninput');

            if (data) {
                var token = { id: data.id };
                token[settings.propertyToSearch] = data[settings.propertyToSearch];

                $.each(settings.additionalDataFields, function(index, value) {
                   token[value] = data[value];
                });

                if (data[settings.propertyNew])
                {
                   token_data[settings.propertyNew] = true;
                }

                saved_tokens.push(token);
            }
        });
        update_hidden_input(saved_tokens, hidden_input);
    }

    this.remove = function(item) {
        token_list.children("li."+settings.classes.token).each(function() {
            var currToken = $(this).data("tokeninput");
            var match = true;
            for (var prop in item) {
               if (item[prop] != currToken[prop]) {
                  match = false;
                  break;
               }
            }
            if (match) {
              delete_token($(this));
            }
        });
    }
    
    this.getTokens = function() {
         return saved_tokens;
      }

   this.highlightTerm = function(value, term) {
      return highlight_term(value, term);
   }

    //
    // Private functions
    //

    function checkTokenLimit() {
        if(settings.tokenLimit !== null && token_count >= settings.tokenLimit) {
            input_box.hide();
            hide_dropdown();
            return;
        }
    }

    function resize_input() {
        if(input_val === (input_val = input_box.val())) {return;}

        // Enter new content into resizer and resize input accordingly
        var escaped = input_val.replace(/&/g, '&amp;').replace(/\s/g,' ').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        input_resizer.html(escaped);
        input_box.width(input_resizer.width() + 30);
    }

    function is_printable_character(keycode) {
        return ((keycode >= 48 && keycode <= 90) ||     // 0-1a-z
                (keycode >= 96 && keycode <= 111) ||    // numpad 0-9 + - / * .
                (keycode >= 186 && keycode <= 192) ||   // ; = , - . / ^
                (keycode >= 219 && keycode <= 222));    // ( \ ) '
    }

    // Inner function to a token to the list
    function insert_token(item) {

        if (item.id == undefined) {
            item[settings.propertyToSearch] = input_box.val();
            
            item[settings.tokenValue] = item[settings.propertyToSearch];

            item[settings.propertyNew] = true;
        }

        var this_token = item[settings.propertyNew] ? settings.newTokenFormatter(item) : settings.tokenFormatter(item);

        this_token = $(this_token)
          .addClass(settings.classes.token)
          .insertBefore(input_token);

        // The 'delete token' button
        $("<span>" + settings.deleteText + "</span>")
            .addClass(settings.classes.tokenDelete)
            .appendTo(this_token)
            .click(function (event) {
                delete_token($(this).parent());
                hidden_input.change();
                input_box.focus();
                event.preventDefault();
                event.stopPropagation();
            });

        // Store data on the token
        var token_data = {};
        token_data[settings.tokenValue] = item[settings.tokenValue];
        token_data[settings.propertyToSearch] = item[settings.propertyToSearch];

        $.each(settings.additionalDataFields, function(index, value) {
           token_data[value] = item[value];
        });

        if (item.new !== undefined)
        {
           token_data[settings.propertyNew] = true;
        }
        $.data(this_token.get(0), "tokeninput", item);

        // Save this token for duplicate checking
        saved_tokens = saved_tokens.slice(0,selected_token_index).concat([token_data]).concat(saved_tokens.slice(selected_token_index));
        selected_token_index++;

        // Update the hidden input
        update_hidden_input(saved_tokens, hidden_input);

        token_count += 1;

        // Check the token limit
        if(settings.tokenLimit !== null && token_count >= settings.tokenLimit) {
            input_box.hide();
            hide_dropdown();
        }

        return this_token;
    }

    // Add a token to the token list based on user input
    function add_token (item) {
        cache.flush();

        var callback = settings.onBeforeAdd;

        if($.isFunction(callback)) {
            callback.call(input, item);
        }

        // See if the token already exists and select it if we don't want duplicates
        if(token_count > 0 && settings.preventDuplicates) {
            var found_existing_token = null;
            token_list.children().each(function () {
                var existing_token = $(this);
                var existing_data = $.data(existing_token.get(0), "tokeninput");
                if(existing_data && existing_data.id === item.id) {
                    found_existing_token = existing_token;
                    return false;
                }
            });

            if(found_existing_token) {
                select_token(found_existing_token);
                input_token.insertAfter(found_existing_token);
                input_box.focus();
                return;
            }
        }

        // Insert the new tokens
        if(settings.tokenLimit == null || token_count < settings.tokenLimit) {
            insert_token(item);
            checkTokenLimit();
        }

        // Clear input box
        input_box.val("");

        // Don't show the help dropdown, they've got the idea
        hide_dropdown();

        // Execute the onAdd callback if defined
        var callback = settings.onAdd;

        if($.isFunction(callback)) {
            callback.call(hidden_input,item);
        }
    }

    // Select a token in the token list
    function select_token (token) {
        token.addClass(settings.classes.selectedToken);
        selected_token = token.get(0);

        // Hide input box
        input_box.val("");

        // Hide dropdown if it is visible (eg if we clicked to select token)
        hide_dropdown();
    }

    // Deselect a token in the token list
    function deselect_token (token, position) {
        token.removeClass(settings.classes.selectedToken);
        selected_token = null;

        if(position === POSITION.BEFORE) {
            input_token.insertBefore(token);
            selected_token_index--;
        } else if(position === POSITION.AFTER) {
            input_token.insertAfter(token);
            selected_token_index++;
        } else {
            input_token.appendTo(token_list);
            selected_token_index = token_count;
        }
    }

    // Toggle selection of a token in the token list
    function toggle_select_token(token) {
        var previous_selected_token = selected_token;

        if(selected_token) {
            deselect_token($(selected_token), POSITION.END);
        }

        if(previous_selected_token === token.get(0)) {
            deselect_token(token, POSITION.END);
        } else {
            select_token(token);
        }
    }

    // Delete a token from the token list
    function delete_token (token) {
        cache.flush();
        // Remove the id from the saved list
        var token_data = $.data(token.get(0), "tokeninput");
        var callback = settings.onDelete;

        var index = token.prevAll().length;
        if(index > selected_token_index) index--;

        // Delete the token
        token.remove();
        selected_token = null;

        // Remove this token from the saved list
        saved_tokens = saved_tokens.slice(0,index).concat(saved_tokens.slice(index+1));
        if(index < selected_token_index) selected_token_index--;

        // Update the hidden input
        update_hidden_input(saved_tokens, hidden_input);

        token_count -= 1;

        if(settings.tokenLimit !== null || token_count <= 0) {
            input_box
                .show()
                .val("");
        }

        // Execute the onDelete callback if defined
        if($.isFunction(callback)) {
            callback.call(hidden_input,token_data);
        }
    }

    // Update the hidden input box value
    function update_hidden_input(saved_tokens, hidden_input) {

        settings.savedTokens = {};

        $.each(saved_tokens, function (index, el) {
            settings.savedTokens[el[settings.tokenValue]] = true;
        });

        hidden_input.val(JSON.stringify(saved_tokens));
    }

    // Hide and clear the results dropdown
    function hide_dropdown () {
        dropdown.hide().empty();
        selected_dropdown_item = null;
    }

    function show_dropdown() {
      setTimeout(function(){
        dropdown
            .css({
                position: "absolute",
                top: $(token_list).offset().top + $(token_list).outerHeight(),
                left: $(token_list).offset().left,
                zindex: 999
            })
            .show();
      }, 1);
    }

    function show_dropdown_searching () {
        if(settings.searchingText) {
            dropdown.html("<p>"+settings.searchingText+"</p>");
            show_dropdown();
        }
    }

    function show_dropdown_hint () {
        if(settings.hintText) {
            dropdown.html("<p>"+settings.hintText+"</p>");
            show_dropdown();
        }
    }

    // Highlight the query part of the search term
    function highlight_term(value, term) {

        if (term) {
           term = term.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
        }

        if (settings.searchAlgorithm == 'global')
        {
            return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<b>$1</b>");
        }
        else if (settings.searchAlgorithm == 'first')
        {
            return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(^" + term + ")(?![^<>]*>)(?![^&;]+;)", "i"), "<b>$1</b>");
        }
    }
    
    function find_value_and_highlight_term(template, value, term) {
        var regex_value = value.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
        return template.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + regex_value + ")(?![^<>]*>)(?![^&;]+;)", "g"), highlight_term(value, term));
    }

    // Populate the results dropdown with some results
    function populate_dropdown (query, results) {
      var new_item = true;

        if (settings.createNew && query) {
          $.each(results, function(index, value) {
             if (value[settings.propertyToSearch].toLowerCase() == query.toLowerCase())
             {
                new_item = false;
             }
          });

          if (new_item) {
             var item = {};
             item[settings.propertyNew] = true;
             item[settings.propertyToSearch] = query;
             results = [item].concat(results);
          }
        }  

        if(results && results.length) {
            dropdown.empty();
            var dropdown_ul = $("<ul>")
                .appendTo(dropdown)
                .mouseover(function (event) {
                    select_dropdown_item($(event.target).closest("li"));
                })
                .mousedown(function (event) {
                    add_token($(event.target).closest("li").data("tokeninput"));
                    hidden_input.change();
                    return false;
                })
                .hide();
            
            $.each(results, function(index, value) {
                var this_li = value[settings.propertyNew] && index == 0 ? settings.newResultsFormatter(value, token_input, query) : settings.resultsFormatter(value, token_input, query);
                
                this_li = find_value_and_highlight_term(this_li ,value[settings.propertyToSearch], query);            
                
                this_li = $(this_li).appendTo(dropdown_ul);
                
                if(index % 2) {
                    this_li.addClass(settings.classes.dropdownItem);
                } else {
                    this_li.addClass(settings.classes.dropdownItem2);
                }

                if(index === 0) {
                    select_dropdown_item(this_li);
                }

                $.data(this_li.get(0), "tokeninput", value);
            });

            show_dropdown();

            if(settings.animateDropdown) {
                dropdown_ul.slideDown("fast");
            } else {
                dropdown_ul.show();
            }
        } else {
            if(settings.noResultsText) {
                dropdown.html("<p>"+settings.noResultsText+"</p>");
                show_dropdown();
            }
        }
    }

    // Highlight an item in the results dropdown
    function select_dropdown_item (item) {
        if(item) {
            if(selected_dropdown_item) {
                deselect_dropdown_item($(selected_dropdown_item));
            }

            item.addClass(settings.classes.selectedDropdownItem);
            selected_dropdown_item = item.get(0);
            var token_data = item.data("tokeninput");

            if (token_data && (token_data[settings.tokenValue] != undefined || token_data[settings.propertyNew] != undefined))
            {
                input_box.val(token_data[settings.propertyToSearch]);
            }   

        }
    }

    // Remove highlighting from an item in the results dropdown
    function deselect_dropdown_item (item) {
        item.removeClass(settings.classes.selectedDropdownItem);
        selected_dropdown_item = null;
    }

    // Do a search and show the "searching" dropdown if the input is longer
    // than settings.minChars
    function do_search() {
        var query = input_box.val().toLowerCase().trim();

        if(query && query.length) {
            if(selected_token) {
                deselect_token($(selected_token), POSITION.AFTER);
            }

            if(query.length >= settings.minChars) {
               if (settings.url) {
                show_dropdown_searching();
                clearTimeout(timeout);

                timeout = setTimeout(function(){
                  run_search(query);
                }, settings.searchDelay);
               } else {
                  run_search(query);
               }


            } else {
                hide_dropdown();
            }
        }
    }

    // Do the actual search
    function run_search(query) {

        var cache_key = query + computeURL();
        var cached_results = cache.get(cache_key);
        if(cached_results) {
            populate_dropdown(query, cached_results);
        } else {
            // Are we doing an ajax search or local data search?
            if(settings.url) {
                var url = computeURL();
                // Extract exisiting get params
                var ajax_params = {};
                ajax_params.data = {};
                if(url.indexOf("?") > -1) {
                    var parts = url.split("?");
                    ajax_params.url = parts[0];

                    var param_array = parts[1].split("&");
                    $.each(param_array, function (index, value) {
                        var kv = value.split("=");
                        ajax_params.data[kv[0]] = kv[1];
                    });
                } else {
                    ajax_params.url = url;
                }

                // Prepare the request
                ajax_params.data[settings.queryParam] = query;
                if (settings.preventDuplicates && hidden_input.val()) {
                  var tokens = $.parseJSON(hidden_input.val());

                  var duplicates = []
                  $.each(tokens, function() {
                     if (!this[settings.propertyNew]) {
                        duplicates.push(this[settings.tokenValue]);
                     }
                  });

                  ajax_params.data[settings.duplicatesParam] = duplicates.join();
                }
                ajax_params.type = settings.method;
                ajax_params.dataType = settings.contentType;
                if(settings.crossDomain) {
                    ajax_params.dataType = "jsonp";
                }

                // Attach the success callback
                ajax_params.success = function(results) {
                  if (settings.jsonContainer) {
                      results = results[settings.jsonContainer];
                  }

                  if($.isFunction(settings.onResult)) {
                      results = settings.onResult.call(hidden_input, results);
                  }

                  cache.add(cache_key, results);

                  // only populate the dropdown if the results are associated with the active search query
                  if(input_box.val().toLowerCase() === query) {
                      populate_dropdown(query, results);
                  }
                };

                // Make the request
                $.ajax(ajax_params);
            } else if(settings.local_data) {
                // Do the search through local data

                var results = $.grep(settings.local_data, function (row) {    

                    if (settings.savedTokens[row[settings.tokenValue]])
                    {
                        return false;
                    }

                    if (query === null) {
                        return true;
                    }

                    var value = row[settings.propertyToSearch].toLowerCase();

                    if (settings.searchAlgorithm == 'global')
                    {
                        return value.indexOf(query.toLowerCase()) > -1;  
                    }
                    else if (settings.searchAlgorithm == 'first')
                    {
                        return value.indexOf(query.toLowerCase()) == 0;
                    }
                });

                if($.isFunction(settings.onResult)) {
                    results = settings.onResult.call(hidden_input, results);
                }

                cache.add(cache_key, results);
                populate_dropdown(query, results);
            }
        }
    }

    // compute the dynamic URL
    function computeURL() {
        var url = settings.url;
        if(typeof settings.url == 'function') {
            url = settings.url.call();
        }
        return url;
    }
};

// Really basic cache for the results
$.TokenList.Cache = function (options) {
    var settings = $.extend({
        max_size: 500
    }, options);

    var data = {};
    var size = 0;

    this.flush = function () {
        data = {};
        size = 0;
    };

    this.add = function (query, results) {
        if(size > settings.max_size) {
            flush();
        }

        if(!data[query]) {
            size += 1;
        }

        data[query] = results;
    };

    this.get = function (query) {
        return data[query];
    };
};
}(jQuery));
