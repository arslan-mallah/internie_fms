$(document).ready(function() {
    var table = $('#employee_data').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'csv', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#employee_data_wrapper .col-md-6:eq(0)' );


    $('.my_table tbody').on('click', '.deletebtn', function() {

        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        $('#delete_id').val(data[0]);

    });


});


   
 

