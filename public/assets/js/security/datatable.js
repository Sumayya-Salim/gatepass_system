$(document).ready(function (){
    $('#SecurityTable').DataTable({
       processing: true,
       serverSide: true,
       ajax: INDEX_SECURITY_URL,
       columns: [
           {data: 'id', name: 'id'},
           {data: 'name', name: 'name'},
           {data: 'email', name: 'email'},
           {data: 'phoneno', name: 'phoneno'},
           {data: 'action', name: 'action', orderable: false, searchable: false},
       ]
   });
});
