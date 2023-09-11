$(function () {
   $('.multi-select, .single-select').select2();

   let parented = $('.select2');
   parented.each(function () {
      $(this).select2({
         width: '100%',
         dropdownParent: '#' + $(this).data('parent')
      });
   });
});