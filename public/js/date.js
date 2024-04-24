$(function() {
    $("#txtFrom").datepicker({
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 1,
        onSelect: function(selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#txtTo").datepicker("option", "minDate", dt);
        }
    });
    $("#txtTo").datepicker({
        dateFormat: 'yy-mm-dd',
        numberOfMonths: 1,
        onSelect: function(selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#txtFrom").datepicker("option", "maxDate", dt);
        }
    });

    $('#start').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [day == 0];
        }
    });
    $('#end').datepicker({
        dateFormat: 'yy-mm-dd',
    
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [day == 0];
        }
    })
});
