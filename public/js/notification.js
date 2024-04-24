$(document).ready(function(){


   var table1 =$('#notification').DataTable({
       

    ajax:'notificationss',
    order: [[0, 'desc']],
    columns:[
        { data: 'id' },
        { data: 'user_id' },
        { data: 'user_name' },
        { data: 'page_affected' },
        { data: 'action' },
        { "data": null,
                    render: function(data, type, row) {
            return `<td  data-id="${row.id}" class="d-none" >${row.old_data}</td>`       
                    
                    }, 
                    createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                        $(cell).addClass('d-none');  // Assign a class to the cell element
                    }
      },
        { "data": null,
                    render: function(data, type, row) {
                        return `<td  data-id="${row.id}" class="d-none">${row.new_data}</td>`    
                        
      },
      createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
        $(cell).addClass('d-none');  // Assign a class to the cell element
    } 
    
    },
    { data: 'date' },
      { "data": null,
      render: function(data, type, row) {
          return ` <td>
          <button  data-id="${row.id}" type="button" id="mark" class="btn btn-warning rounded-circle ">
          Mark AS Read
          </button>
             </td>`    
          
} },

        { 
            "data": null,
                    render: function(data, type, row) {
                        return ` <td>
                      
                         
                        <button type="button" class="btn btn-primary editbtn">
                        <i class="fa-solid fa-eye"></i>
                        </button>
                    
                            <button type="button" class="btn btn-dark deletebtn">
                            <i class="far fa-trash-alt"></i>
                            </button>
    

   </td>
`;



            }
        }
    ],

   
       
      });
    
     





      $(document).on('click', '.editbtn', function(event) {
        event.preventDefault();


    

    $tr = $(this).closest('tr');

    var data1 = $tr.children("td").map(function() {
        return $(this).text();
    }).get();

    if(data1[3]=='general ledger'){
        $('#editmodal').modal('show');
        var data= JSON.parse(data1[5]);
        if(data1[6]=='null'){
    
            $('#second1').val('');
            $('#third1').val('');
            $('#fourth1').val('');
            $('#five1').val('');

        }else{
    
            var data2= JSON.parse(data1[6]);
        $('#second1').val(data2[0].category);
        $('#third1').val(data2[0].detail);
        $('#fourth1').val(data2[0].debit);
        $('#five1').val(data2[0].credit);
        }
      
    
    
        $('#first').val(data[0].date);
        $('#second').val(data[0].category);
        $('#third').val(data[0].detail);
        $('#fourth').val(data[0].debit);
        $('#five').val(data[0].credit);
    }
   

    
    if(data1[3]=='attendance'){
        $('#attendancemodal').modal('show');
        var data= JSON.parse(data1[5]);
        if(data1[6]=='null'){
    
            $('#first4').val('');
            $('#second4').val('');
            $('#third4').val('');
            $('#fourth4').val('');
        }
        else
        {
    
            var data2= JSON.parse(data1[6]);
            // console.log(data2[0].name);
            $('#first4').val(data2[0].name);
        $('#second4').val(data2[0].status);
        $('#third4').val(data2[0].reason);
        $('#fourth4').val(data2[0].work_sum);
        }
      
    
    console.log(data);
        $('#first3').val(data[0].name);
        $('#second3').val(data[0].status);
        $('#third3').val(data[0].reason);
        $('#fourth3').val(data[0].work_sum);
        $('#five3').val(data[0].date);
    }
    
    if(data1[3] =='employee'){
        $('#employeemodal').modal('show');
        console.log(data1);
        var data= JSON.parse(data1[5]);
        if(data1[6]=='null'){
    
            $('#first6').val('');
            $('#second6').val('');
            $('#third6').val('');
            $('#fourth6').val('');
            $('#five6').val('');
            $('#six6').val('');
            $('#seven6').val('');
            $('#eight6').val('');
            $('#nine6').val('');
        }

        else

        {
    
            var data2 = JSON.parse(data1[6]);
            $('#first6').val(data2[0].name);
            $('#second6').val(data2[0].email);
            $('#third6').val(data2[0].mobile_no);
            $('#fourth6').val(data2[0].contact_no);
            $('#five6').val(data2[0].address);
            $('#six6').val(data2[0].cnic);
            $('#seven6').val(data2[0].join);
            $('#eight6').val(data2[0].left);
            $('#nine6').val(data2[0].employee_id);

        }
      
        $('#first5').val(data[0].name);
        $('#second5').val(data[0].email);
        $('#third5').val(data[0].mobile_no);
        $('#fourth5').val(data[0].contact_no);
        $('#five5').val(data[0].address);
        $('#six5').val(data[0].cnic);
        $('#seven5').val(data[0].join);
        $('#eight5').val(data[0].left);
        $('#nine5').val(data[0].employee_id);
    
      
    }
});

/////////////for delete//////////
$(document).on('click', '.deletebtn', function(event) {
    event.preventDefault();

// $('#deletemodal').modal('show');

$tr = $(this).closest('tr');

var data = $tr.children("td").map(function () {
return $(this).text();
}).get();


var id=data[0];
// $('#delete_id').val(data[0]);
$.ajaxSetup({
    headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"deletenotification",
        type:"POST",
        data:{id:id},
        success:function(response){
            
                     table1.ajax.reload();     

        },
        error:function(response){ 
            alert("error!!!!");
        },
        async: false

    })



});




$(document).on('click', '#mark', function(event) {
    event.preventDefault();
    $tr = $(this).closest('tr');

var data = $tr.children("td").map(function () {
return $(this).text();
}).get();

console.log(data);
    var id = data[0];
   
   
$.ajaxSetup({
    headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"updatenotification",
        type:"POST",
        data:{id:id},
        success:function(response){
            
                     table1.ajax.reload();     

        },
        error:function(response){ 
            alert("error!!!!");
            console.log(response);
        },
        async: false

    })
})

}); 
