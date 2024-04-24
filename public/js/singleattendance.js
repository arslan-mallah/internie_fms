$(document).ready(function(){

  $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
    }
  });

  $('#editable').Tabledit({
    url:'attendancee.action',
    dataType:"json",
    columns:{
      identifier:[0, 'id'],
      editable:[[2, 'name'], [3, 'status', '{"absent":"absent", "present":"present","leave":"leave"}'],[4, 'reason'],[5,'summary']]
    },
    restoreButton:false,
    success:function(data, textStatus, jqXHR)
    {
      if (data.action == 'delete') {
        $('#' + data.id).remove();
      }
    }
  });

});  