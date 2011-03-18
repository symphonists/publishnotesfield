/*-------------------------------------------------------------------------
	Publish Notes Field JS
-------------------------------------------------------------------------*/

(function() {
	jQuery.noConflict();
	jQuery(document).ready(function()
	{
		jQuery(".field-publishnotes").each(function(i)
		{
			edit_in_place(this);
		});
	});
	
	/**
	*		Edit in place function 
	*		- 
	*/
	var edit_in_place = function(field) {
		
		var label = jQuery("label", field);
		var save = jQuery(".control input", field);
		var cancel = jQuery(".control a", field);
		var editable = jQuery(".publishnotes-editable", field);
		
		// Hover/open editable
		jQuery(".publishnotes-edit", field).click(
			function(e) 
			{
				label.show();
				editable.hide();
				e.preventDefault();
			}
		).hover(
			function() {
				editable.addClass("hover");
			},
			function() {
				editable.removeClass("hover");
			}
		);
		
		// Commit changes to textarea
		jQuery(save).click(
			function() {
				var value = jQuery("textarea", field).val();
				editable.html(value);
				editable.show();
				label.hide();
				return false;
			}
		);
		
		// Commit changes to textarea
		jQuery(cancel).click(
			function() {
				var value = editable.html();
				jQuery("textarea", field).val(value)
				editable.show();
				label.hide();
				return false;
			}
		);
		
	};	
})();