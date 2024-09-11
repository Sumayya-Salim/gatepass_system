$(document).ready(function(){
    $('#guestTable').DataTable({
       processing: true,
       serverSide: true,
       ajax: INDEX_EMPLOYEE_URL,
       columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'Sl. No.' },
           {data: 'visitor_name', name: 'visitor_name'},
           {data: 'visitor_email', name: 'visitor_email'},
           {data: 'visitor_phoneno', name: 'visitor_phoneno'},
           {data: 'purpose', name: 'purpose'},
           {data: 'entry_time', name: 'entry_time'},
           {data: 'exit_time', name: 'exit_time'},
           
           {data: 'action', name: 'action', orderable: false, searchable: false},
       ]
   });
});
