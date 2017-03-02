jQuery(document).ready(function($) {

  $('#tbodyOptional').on('click','.deleteRow',function(e) {
    var tr = $(event.currentTarget).children().data('id');
    var data = {
              'action': 'deleteRow',
              'ID': tr
              };

    jQuery.post(ajaxurl, data, function(response) {
      $('#optional tr[data-id="'+tr+'"]').remove();
    });
  });

  $("#addAddress").on("submit", function(e) {
    var rowCount = $('#optional tbody tr').length;
    var IP = jQuery("#dname").val()
    e.preventDefault();
    var data = {
                'action': 'insertIP',
                'ROUTE': IP
               };

    jQuery.post(ajaxurl, data, function(response) {
      var obj=$.parseJSON(response);
      $('#optional').append("<tr data-id="+obj.ID+">" + "<td>" + (++rowCount) + "</td>" + "<td>" + obj.IP + "</td>" +  "<td><button class='button-secondary deleteRow' type='button'>Delete</button></td>" + "</tr>");
    });
  });

  $(".checkIPs").on("change", "input:radio", function(e){
    var which = $('input[name="logIP"]:checked').val();
    var data = {
                'action': 'whichIpToLog',
                'logIP': which
               };

    jQuery.post(ajaxurl, data, function(response) {
      $("#logThis").text("Currently logging" + response+ " IP's");
    });
  });

});