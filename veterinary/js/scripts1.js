var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {
    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k];
            events.push({
                id: row.id,
                title: row.title,
                start: row.start_datetime,
                end: row.end_datetime,
                veterinaryId: row.veterinaryId, // Added veterinaryId
                medicalName: row.medicalName, // Added medicalName
                full_name: row.full_name // Added full_name
            });
        });
    }

    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();

    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        selectable: true,
        themeSystem: 'bootstrap',
        events: events,
        eventClick: function(info) {
            var _details = $('#event-details-modal');
            var id = info.event.id;
            if (!!scheds[id]) {
                _details.find('#title').text(scheds[id].title);
                _details.find('#description').text(scheds[id].description);
                _details.find('#start').text(scheds[id].start_datetime);
                _details.find('#end').text(scheds[id].end_datetime);
                _details.find('#veterinaryId').text(scheds[id].veterinaryId); // Added veterinaryId
                _details.find('#medicalName').text(scheds[id].medicalName); // Added medicalName
                _details.find('#full_name').text(scheds[id].full_name); // Added full_name
                _details.find('#edit,#delete').attr('data-id', id);
                _details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function(info) {
            // Do Something after events mounted
        },
        editable: true
    });

    calendar.render();

    // Form reset listener
    $('#schedule-form').on('reset', function() {
        $(this).find('input:hidden').val('');
        $(this).find('input:visible').first().focus();
    });

    // Edit Button
    $('#edit').click(function() {
        var id = $(this).attr('data-id');
        if (!!scheds[id]) {
            var _form = $('#schedule-form');
            _form.find('[name="id"]').val(id);
            _form.find('[name="title"]').val(scheds[id].title);
            _form.find('[name="description"]').val(scheds[id].description);
            _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"));
            _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"));
            _form.find('[name="veterinaryId"]').val(scheds[id].veterinaryId); // Added veterinaryId
            _form.find('[name="medicalName"]').val(scheds[id].medicalName); // Added medicalName
            _form.find('[name="full_name"]').val(scheds[id].full_name); // Added full_name
            $('#event-details-modal').modal('hide');
            _form.find('[name="title"]').focus();
        } else {
            alert("Event is undefined");
        }
    });
});
