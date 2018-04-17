jQuery(document).ready(function ($) {

  $('#tbodyOptional').on('click', '.deleteRow', function (e) {
    var row = e.currentTarget.closest('tr');
    var id = $(row).attr('data-id');

    var data = {
      'action': 'deleteRow',
      'ID': id
    };

    jQuery.post(ajaxurl, data, function (response) {
      $('#optional tr[data-id="' + id + '"]').remove();
    });
  });

  $('#clear-all').on('click', function () {
    console.log('all connected');
    var data = {
      'action': 'clearAll'
    };
    jQuery.post(ajaxurl, data, function (response) {
      $("#tbody").empty();
    });


  });

  $("#addAddress").on("submit", function (e) {
    var rowCount = $('#optional tbody tr').length;
    var IP = jQuery("#dname").val()
    e.preventDefault();
    var data = {
      'action': 'insertIP',
      'ROUTE': IP
    };

    jQuery.post(ajaxurl, data, function (response) {
      var obj = $.parseJSON(response);
      $('#optional').append("<tr data-id=" + obj.ID + ">" + "<td>" + (++rowCount) + "</td>" + "<td>" + obj.IP + "</td>" + "<td><button class='button-secondary deleteRow' type='button'>Delete</button></td>" + "</tr>");
    });
  });

  $(".checkIPs").on("change", "input:radio", function (e) {
    var which = $('input[name="logIP"]:checked').val();
    var data = {
      'action': 'whichIpToLog',
      'logIP': which
    };

    jQuery.post(ajaxurl, data, function (response) {
      $("#logThis").text("Currently logging" + response + " IP's");
    });
  });

});