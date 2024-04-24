
$(document).ready(function(){

    var table = $('#employee_data').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#employee_data_wrapper .col-md-6:eq(0)' );
    
   





 
$('.editbtn').on('click', function() {

    $('#editmodal').modal('show');

    $tr = $(this).closest('tr');

    var data = $tr.children("td").map(function() {
        return $(this).text();
    }).get();

    $('#update_id').val(data[0]);
    $('#name').val(data[1]);
    $('#email').val(data[2]);
    $('#contact1').val(data[3]);
    $('#contact2').val(data[4]);
    $('#address').val(data[5]);
    $('#cnic').val(data[6]);
    $('#joining').val(data[7]);
    $('#left').val(data[8]);
    $('#emp_id').val(data[9]);
    if(data[10]="Male"){
        // document.getElementById("dot-1").checked = true;
        $("#dot-1").prop("checked", true);
    }
    

});

/////////////for delete//////////
$('.deletebtn').on('click', function () {

$('#deletemodal').modal('show');

$tr = $(this).closest('tr');

var data = $tr.children("td").map(function () {
return $(this).text();
}).get();


$('#delete_id').val(data[0]);

});






}); 
