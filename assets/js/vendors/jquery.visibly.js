/**
 * Visibly jQuery Plugin v1.1
 *
 * @version 1.1 (20/08/2013)
 * @author Daniel Rivers <me@danielrivers.com>
 * @see https://github.com/DanielRivers/jQuery-Visibly/
 *
 * Dual licensed under the MIT and GPLv3 Licenses
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl-3.0.html
 *
 */
//rVal gets rounds issue with hidden items in drop down being selected
(function($) {
	$.fn.rVal = function(content) {
		var result;
		if ($(this).is("select")) {
			$(this).find('option:selected').each(function() {
				if ($(this).parent().is("select")) result = $(this).val();
			});
		} else result = $(this).val();
		return result;
	};
})(jQuery);

;
(function($) {
	$.fn.Visibly = function(o) {
		//settings and defaults		 
		var s = $.extend({
			clearOnHide: false, //Clear the value from the elements on hide
			attr: 'visibly', //attr attribute to use for the visibly attr
			vdelim: ',', //Delimiter used to split the values a control can hold
			edelim: ':', //Equal delimiter between the field ID and the values
			nedelim: '!', //Not Equal delimiter between the field ID and the values
			regularExpression: false, //Use Regular expression for the test
			fdelim: ';', //Delimiter between the fields
			rdelim: '%' //Delimiter between rules
		}, o);
		var runitems = [];

		return this.each(function() {
			var c = $(this);
			var split = RegExp(s.edelim + "|" + s.nedelim);
			//loop through all controls related to the field to create events
			$.each($(this).attr(s.attr).split(s.fdelim), function(k, v2) {
				//Bind keyup and change events, keyup is used because if the next tab item is made visible it would not be tabbed to using change or blur
				var vis = $('#' + v2.split(split)[0]);

				if (vis.length == 0) vis = $('INPUT[name="' + v2.split(split)[0] + '"]');
				vis.bind("keyup change click", function() {
						//Parent field has changed! Check if should be made visible
						var visible = true;
						$.each(c.attr(s.attr).split(s.rdelim), function(k, rv) {
							visible = true;
							//loop through the controls related to the rules
							$.each(rv.split(s.fdelim), function(k, v) {
								//Cache the element
								var elem = $('#' + v.split(split)[0]);
								if (elem.length == 0) elem = $("INPUT[name='" + v.split(split)[0] + "']:checked");
								//Does the element exist?
								if (elem.val() != undefined) {
									//Cache the value, plus workaround for issue with .val on select boxes with hidden items
									var val = '';
									if (elem.is('select')) {
										elem.find('option:selected').each(function() {
											if ($(this).parent().is("select")) val = $(this).rVal();
										});
									} else val = elem.val();
									//If the rule doesn't match, hide control
									if (v.split(s.edelim)[1] != null)
									//work around for .val not working correctly 
										var grep = $.grep(v.split(s.edelim)[1].split(s.vdelim), function(n, i) {
										if ($.inArray(val, v.split(s.edelim)[1].split(s.vdelim)) != -1)
											return true;
										//didnt match above, test if its a regular expression match
										return (s.regularExpression) ? (val.match(n)) : false;
									});
									if (v.split(s.nedelim)[1] != null)
										var grep = $.grep(v.split(s.nedelim)[1].split(s.vdelim), function(n, i) {
											if ($.inArray(val, v.split(s.nedelim)[1].split(s.vdelim)) != -1)
												return false;
											//didnt match above, test if its a regular expression match
											return (s.regularExpression) ? (!val.match(n)) : true;
										});
									if (grep.length == 0) visible = false;
								} else visible = false
							});
							return !visible;
						});
						//Set visibilty
						//setting individual items on drop down doesn't work cross browser, check to see if option and wrap in hidden span
						if (visible) {
							if (c.is("option")) {
								if (c.parent('span.hide').length) c.unwrap();
							} else c.show()
						} else {
							if (c.is("option")) {
								if (c.parent('span.hide').length == 0) {
									if (c.val() == c.closest('select').val())
										c.closest('select').rVal('');
									c.trigger('change');
									c.wrap('<span class="hide" style="display: none;" />');
								};
							} else c.hide()
						};
						//Clear the element and child elements if ClearOnHide is set
						if ((!visible) && (s.clearOnHide)) {
							c.val('');
							c.find('input').val('');
							c.selectedIndex = 0;
						}
					})
					//Add event items to collection for initialisation
				if ($.inArray(v2.split(split)[0], runitems) == -1) runitems.push(v2.split(split)[0]);
			});
		}).promise().done(function() {
			//First load, set visibility on all fields based on rules
			for (var i = 0; i < runitems.length; i++) {
				$('INPUT[name="' + runitems[i] + '"]').trigger('change');
				$('#' + runitems[i]).trigger('change');
			}
		});
	};
})(jQuery);