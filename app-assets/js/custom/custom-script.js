$(document).ready(function() {

  $('#phone').formatter({
    'pattern': '+91 {{99999}} {{99999}}',
    'persistent': true
  });
    
  $("#addClient").validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      },
      email: {
        required: true,
        email:true
      },
      phone: {
        required: true,
        minlength: 10
      }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  $('#scroll-hor').DataTable({
    "scrollX": true
  });

  $.validator.addMethod("greaterThan", 
  function(value, element, params) {
      var temp = value.split("/");
      let s_date = temp[1]+'/'+temp[0]+'/'+temp[2];
      temp = $(params).val().split("/");
      let e_date = temp[1]+'/'+temp[0]+'/'+temp[2];
      if (!/Invalid|NaN/.test(new Date(s_date))) {
        return new Date(s_date) > new Date(e_date);
      }
      return isNaN(value) && isNaN($(params).val()) 
          || (Number(value) > Number($(params).val())); 
  },'Must be greater than start date.');


  
});


