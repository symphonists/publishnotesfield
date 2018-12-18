/*-------------------------------------------------------------------------
  Publish Notes Field JS
-------------------------------------------------------------------------*/

(function($) {
  $(document).ready(function()
  {
    jQuery(".field-publishnotes.editable").each(function(i) {
      edit_in_place(this);
    });
  });

  /**
  *    Edit in place function
  */
  var edit_in_place = function(field) {

    var label = $("label", field);
    var save = $(".control input", field);
    var cancel = $(".control a", field);
    var edit = $(".publishnotes-edit", field);
    var editable = $(".publishnotes-note", field);

    // Hover/open editable
    $(".publishnotes-edit", field)
      .bind(
        'click',
        function(e) {
          label.show();
          edit.hide();
          editable.hide();
          e.preventDefault();
        }
      )
      .hover(
        function() {
          editable.addClass("hover");
        },
        function() {
          editable.removeClass("hover");
        }
      );

    // Commit changes to textarea
    $(save)
      .bind(
        'click',
        function() {
          var value = $("textarea", field).val();
          editable.html(value);
          edit.show();
          editable.show();
          label.hide();
          return false;
        }
      );

    // Commit changes to textarea
    $(cancel)
      .bind(
        'click',
        function() {
          var value = editable.html();
          $("textarea", field).val(value);
          edit.show();
          editable.show();
          label.hide();
          return false;
        }
      );
  };
})(jQuery);
