$(document).ready(function (){
    $('#flatTable').DataTable({
       processing: true,
       serverSide: true,
       ajax: INDEX_EMPLOYEE_URL,
       columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'Sl. No.' },
           {data: 'flat_no', name: 'flat_no'},
           {data: 'flat_type', name: 'flat_type'},
           {data: 'furniture_type', name: 'furniture_type'},
           
           {data: 'action', name: 'action', orderable: false, searchable: false},
       ]
   });
});
