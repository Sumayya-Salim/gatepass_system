$(document).ready(function () {
  $('#flatOwnerTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: INDEX_FLATOWNER_URL,
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'Sl. No.' },
      { data: 'owner_name', name: 'owner_name' },
      { data: 'flat_no', name: 'flat_no' },
      { data: 'members', name: 'members' },
      { data: 'park_slott', name: 'park_slott' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
  });
});
