
$(document).ready(function(){


    
    
   



/////////////for delete//////////
$('.deletebtn').on('click', function () {
$('#deletemodal').modal('show');

$tr = $(this).closest('tr');

var data = $tr.children("td").map(function () {
return $(this).text();
}).get();


$('#delete_id').val(data[0]);

});



////////////create category
$('.create-btn').on('click', function() {

    $('#createmodal').modal('show');


    

});



}); 
