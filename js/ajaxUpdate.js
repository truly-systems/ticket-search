$( "#search_button" ).click(function( event ) {
    $.get('index.php?action=search&id=' + $('#search_ticket').val(), function(data, textStatus, jqXHR) {
        $('#ticket_information').html(data);
        console.log("FOI");
        }
    
    );
  });