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
		jQuery(field).click(
			function() 
			{
				jQuery("label", field).show();
				jQuery(".publishnotes-editable", field).hide();
			}
		);
	};	
})();