
      var table= $('#employee_data').DataTable({
        ajax:'tabledata',
        order: [[0, 'desc']],
        columns:[
            { data: 'id' },
            { data: 'employee_id' },
            { data: 'name' },
            { data: 'status' },
            { "data": null,
                        render: function(data, type, row) {
                            // return `<td data-id="${row.id}" class="btn btn-info reasonbtn" id="reasonbtn" data-toggle="modal" data-target="#exampleModal" >${row.reason}</td>`;
                            return `<button type="button" class="btn reasonbtn" id="reasonbtn">${row.reason}</button>`;
                        
                        } 
          },
            { "data": null,
                        render: function(data, type, row) {
                            // return `<td data-id="${row.id}" class="btn btn-info sumbtn" id="sumbtn" data-toggle="modal" data-target="#exampleModal">${row.work_sum}</td>`;
                            return `<button type="button" class="btn sumbtn" id="sumbtn">${row.work_sum}</button>`;
                            
                        } },
            { "data": 'date' },

            { 
                "data": null,
                        render: function(data, type, row) {
                            return `<button type="button" class="btn btn-primary editbtn" id="edit"><i class="fas fa-pen"></i></button>`;
                }
            }
        ],
        
    });




///////////when click on edit popup modal open/////////////
$(document).on('click', '#edit', function(){

        $('#editmodal').modal('show');
    
        $tr = $(this).closest('tr');
    
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
    
    
        $('#update_id').val(data[0]);
        $('#emp_id').val(data[1]);
        $('#name').val(data[2]);
        $('#status').val(data[3]);
        $('#reason').val(data[4]);
        $('#summary').val(data[5]);
      
}); 


///////////////hen click on reason popup modal//////////
    $(document).on('click', '#reasonbtn', function(){
    
        $('#reasonmodal').modal('show');
    
        $tr = $(this).closest('tr');
    
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
    
    
        $('#update_id').val(data[0]);
        $('#reas').val(data[4]);
       
      
      
}); 


///////////////hen click on summary popup modal//////////

    $(document).on('click', '#sumbtn', function(){

    
        $('#summodal').modal('show');
    
        $tr = $(this).closest('tr');
    
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
    
    
        $('#update_id').val(data[0]);
        
        $('#sum').val(data[5])
      
      
}); 



//////////////////////when  click on update ,it updates the data and reload table via ajax//////

$('#update').on('click', function(){

    var id = $("#update_id").val();
    var e_id = $("#emp_id").val();
    var name = $("#name").val();
    var status = $("#status").val();
    var reason = $("#reason").val();
    var summary = $("#summary").val();
   
$.ajaxSetup({
    headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"updateattend",
        type:"POST",
        data:{
            id:id,
            e_id:e_id,
            name:name,
            status:status,
            reason:reason,
            summary:summary,
        },
        success:function(){
                   $('#updateForm')[0].reset();
                     $('#editmodal').modal('hide');
                     table1.ajax.reload();     

        },
        error:function(){ 
            alert("error!!!!");
        },
        async: false

    })
})


///////////when click on it then reason willupdate via ajax//////////
$('#reas_update').on('click', function(){

    var id = $("#update_id").val();
    var reason = $("#reas").val();
$.ajaxSetup({
    headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"updatereason",
        type:"POST",
        data:{
            id:id,
            reason:reason,
        },
        success:function(){

                   $('#reasonform')[0].reset();
                  
                     $('#reasonmodal').modal('hide');
                     table1.ajax.reload(null, false);
                  
        },
        error:function(){ 
            alert("error!!!!");
        },
        async: false

    })
})

///////////when click on it then summary willupdate via ajax//////////


$('#sum_update').on('click', function(){

    var id = $("#update_id").val();
    var summary = $("#sum").val();
$.ajaxSetup({
    headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"updatesum",
          type:"POST",
        data:{
            id:id,
            summary:summary
        },
        success:function(){

                   $('#sumform')[0].reset();
                     $('#summodal').modal('hide');
                     table1.ajax.reload(null, false);
                  

        },
        error:function(){ 
            alert("error!!!!");
        },

        async: false

    })
})




