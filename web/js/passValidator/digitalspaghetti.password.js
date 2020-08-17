/* @projectDescription jQuery Password Strength Plugin - A jQuery plugin to provide accessibility functions
 * @author Tane Piper (digitalspaghetti@gmail.com)
 * @version 2.0
 * @website: http://digitalspaghetti.me.uk/digitalspaghetti
 * @license MIT License:  
 * 
 * === Changelog ===
 * Version 2.1 (18/05/2008)
 * Added a jQuery method to add a new rule: jQuery('input[@type=password]').pstrength.addRule(name, method, score, active)
 * Added a jQuery method to change a rule score: jQuery('input[@type=password]').pstrength.changeScore('one_number', 50);
 * Added a jQuery method to change a rules active state: jQuery('input[@type=password]').pstrength.ruleActive('one_number', false);
 * Hide the 'password to short' span if the password is more than the min chars
 * 
 * Version 2.0 (17/05/2008)
 * Completly re-wrote the plugin from scratch.  Plugin now features lamda functions for validation and
 * custom validation rules 
 * Plugin now exists in new digitalspaghetti. namespace to stop any conflits with other plugins.
 * Updated documentation
 * 
 * Version 1.4 (12/02/2008)
 * Added some improvments to i18n stuff from Raffael Luthiger.
 * Version 1.3 (02/01/2008)
 * Changing coding style to more OO
 * Added default messages object for i18n
 * Changed password length score to Math.pow (thanks to Keith Mashinter for this suggestion)
 * Version 1.2 (03/09/2007)
 * Added more options for colors and common words
 * Added common words checked to see if words like 'password' or 'qwerty' are being entered
 * Added minimum characters required for password
 * Re-worked scoring system to give better results
 * Version 1.1 (20/08/2007)
 * Changed code to be more jQuery-like
 * Version 1.0 (20/07/2007)
 * Initial version.
 */

// Create our namespaced object
/*global window */
/*global jQuery */
/*global digitalspaghetti*/
window.digitalspaghetti = window.digitalspaghetti || {};
digitalspaghetti.password = {	
	'defaults' : {
		'displayMinChar': true,
		'minChar': 6,
		'minCharText': 'Minimalnie 6 znaków',
		'colors': ["#ff5b5b", "#ffa46d", "#ffde6d", "#e4f78d", "#9cf78d"],
		'scores': [6, 30, 40, 50],
		'verdicts':	['bardzo słabe', 'słabe', 'normalne', 'mocne', 'bardzo mocne'],
		'raisePower': 1.4,
		'debug': false
	},
	'ruleScores' : {
		'length': 0,
		'lowercase': 0,
		'uppercase': 3,
		'one_number': 2,
		'three_numbers': 2,
		'one_special_char': 10,
		'two_special_char': 15,
		'upper_lower_combo': 5,
		'letter_number_combo': 15,
		'letter_number_char_combo': 40
	},
	'rules' : {
		'length': true,
		'lowercase': true,
		'uppercase': true,
		'one_number': true,
		'three_numbers': true,
		'one_special_char': true,
		'two_special_char': true,
		'upper_lower_combo': true,
		'letter_number_combo': true,
		'letter_number_char_combo': true
	},
	'validationRules': {
		'length': function (word, score) {
			digitalspaghetti.password.tooShort = false;
			
			
			var wordlen = word.length;
			var lenScore = Math.pow(wordlen, digitalspaghetti.password.options.raisePower);
			if (wordlen < digitalspaghetti.password.options.minChar && wordlen > 0) {
				lenScore = (lenScore - 100);
				digitalspaghetti.password.tooShort = true;
			}
			return lenScore;
		},
		'lowercase': function (word, score) {
			return word.match(/[a-z]/) && score;
		},
		'uppercase': function (word, score) {
			return word.match(/[A-Z]/) && score;
		},
		'one_number': function (word, score) {
			return word.match(/\d+/) && score;
		},
		'three_numbers': function (word, score) {
			return word.match(/(.*[0-9].*[0-9].*[0-9])/) && score;
		},
		'one_special_char': function (word, score) {
			return word.match(/.[!,@,#,$,%,\^,&,*,?,_,~]/) && score;
		},
		'two_special_char': function (word, score) {
			return word.match(/(.*[!,@,#,$,%,\^,&,*,?,_,~].*[!,@,#,$,%,\^,&,*,?,_,~])/) && score;
		},
		'upper_lower_combo': function (word, score) {
			return word.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/) && score;
		},
		'letter_number_combo': function (word, score) {
			return word.match(/([a-zA-Z])/) && word.match(/([0-9])/) && score;
		},
		'letter_number_char_combo' : function (word, score) {
			return word.match(/([a-zA-Z0-9].*[!,@,#,$,%,\^,&,*,?,_,~])|([!,@,#,$,%,\^,&,*,?,_,~].*[a-zA-Z0-9])/) && score;
		}
	},
	'attachWidget': function (element) {
		var output = ['<div id="password-strength">'];
		if (digitalspaghetti.password.options.displayMinChar && !digitalspaghetti.password.tooShort) {
			output.push('<span class="password-min-char">' + digitalspaghetti.password.options.minCharText.replace('%d', digitalspaghetti.password.options.minChar) + '</span>');
		}
		output.push('<span class="password-strength-bar"></span>');
		output.push('</div>');
		output = output.join('');
		jQuery(element).after(output);
	},
	'debugOutput': function (element) {
		if (typeof console.log === 'function') {
			console.log(digitalspaghetti.password);	
		} else {
			alert(digitalspaghetti.password);
		}
	},
	'addRule': function (name, method, score, active) {
		digitalspaghetti.password.rules[name] = active;
		digitalspaghetti.password.ruleScores[name] = score;
		digitalspaghetti.password.validationRules[name] = method;
		return true;
	},
	'init': function (element, options) {
		digitalspaghetti.password.options = jQuery.extend({}, digitalspaghetti.password.defaults, options);
		digitalspaghetti.password.attachWidget(element);
		jQuery(element).keyup(function () {
			digitalspaghetti.password.calculateScore(jQuery(this).val());
		});
		jQuery('.password-min-char').hide();
	},
	'calculateScore': function (word) {
		digitalspaghetti.password.totalscore = 0;
		digitalspaghetti.password.width = 0;
		for (var key in digitalspaghetti.password.rules) if (digitalspaghetti.password.rules.hasOwnProperty(key)) {
			if (digitalspaghetti.password.rules[key] === true) {
				var score = digitalspaghetti.password.ruleScores[key];
				var result = digitalspaghetti.password.validationRules[key](word, score);
				if (result) {
					digitalspaghetti.password.totalscore += result;
				}
			}
			if (digitalspaghetti.password.totalscore <= digitalspaghetti.password.options.scores[0]) {
				digitalspaghetti.password.strColor = digitalspaghetti.password.options.colors[0];
				digitalspaghetti.password.strText = digitalspaghetti.password.options.verdicts[0];
				digitalspaghetti.password.width =  "1";
				digitalspaghetti.password.alt = "1";

			} else if (digitalspaghetti.password.totalscore > digitalspaghetti.password.options.scores[0] && digitalspaghetti.password.totalscore <= digitalspaghetti.password.options.scores[1]) {
				digitalspaghetti.password.strColor = digitalspaghetti.password.options.colors[1];
				digitalspaghetti.password.strText = digitalspaghetti.password.options.verdicts[1];
				digitalspaghetti.password.width =  "25";
				digitalspaghetti.password.alt = "2";
			} else if (digitalspaghetti.password.totalscore > digitalspaghetti.password.options.scores[1] && digitalspaghetti.password.totalscore <= digitalspaghetti.password.options.scores[2]) {
				digitalspaghetti.password.strColor = digitalspaghetti.password.options.colors[2];
				digitalspaghetti.password.strText = digitalspaghetti.password.options.verdicts[2];
				digitalspaghetti.password.width =  "50";
				digitalspaghetti.password.alt = "3";
			} else if (digitalspaghetti.password.totalscore > digitalspaghetti.password.options.scores[2] && digitalspaghetti.password.totalscore <= digitalspaghetti.password.options.scores[3]) {
				digitalspaghetti.password.strColor = digitalspaghetti.password.options.colors[3];
				digitalspaghetti.password.strText = digitalspaghetti.password.options.verdicts[3];
				digitalspaghetti.password.width =  "75";
				digitalspaghetti.password.alt = "4";
			} else {
				digitalspaghetti.password.strColor = digitalspaghetti.password.options.colors[4];
				digitalspaghetti.password.strText = digitalspaghetti.password.options.verdicts[4];
				digitalspaghetti.password.width =  "99";
				digitalspaghetti.password.alt = "5";
			}
			jQuery('.password-strength-bar').stop();
			
			if (digitalspaghetti.password.options.displayMinChar && !digitalspaghetti.password.tooShort) {
				jQuery('.password-min-char').hide();
			} else {
				jQuery('.password-min-char').show();
			}
			
			var my_width = 167;
			
						
			if (word)
			{
    			jQuery('.password-strength-bar').animate({opacity: 0.5}, 'fast', 'linear', function () {
    				jQuery(this).attr('alt', digitalspaghetti.password.alt).css({'display': 'block', 'padding-left':'5px', 'color': '#000', 'background-color': digitalspaghetti.password.strColor, 'width': my_width + "px"}).text(digitalspaghetti.password.strText);	
    				jQuery(this).animate({opacity: 1}, 'fast', 'linear');
    			});
			}else{
	           jQuery('.password-strength-bar').animate({opacity: 0.5}, 'fast', 'linear', function () {
    				jQuery(this).attr('alt', digitalspaghetti.password.alt).css({'display': 'none', 'padding-left':'5px', 'color': '#000', 'background-color': digitalspaghetti.password.strColor, 'width': my_width + "px"}).text(digitalspaghetti.password.strText);	
    				jQuery(this).animate({opacity: 1}, 'fast', 'linear');
    			});
		    
  			}
			
		}
		
	}
	
};

jQuery.extend(jQuery.fn, {
	'pstrength': function (options) {
		return this.each(function () {
			digitalspaghetti.password.init(this, options);
		});
	}
});
jQuery.extend(jQuery.fn.pstrength, {
	'addRule': function (name, method, score, active) {
		digitalspaghetti.password.addRule(name, method, score, active);
		return true;
	},
	'changeScore': function (rule, score) {
		digitalspaghetti.password.ruleScores[rule] = score;
		return true;
	},
	'ruleActive': function (rule, active) {
		digitalspaghetti.password.rules[rule] = active;
		return true;
	}
});