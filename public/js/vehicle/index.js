var table = $('#vehicles').DataTable( {
   "paging": true,
   "pageLength": 10,
   "lengthChange": true,
   "lengthMenu": [ 10, 20, 50, 75, 100 ],
   language: {
      url: '/assets/datatables/french.json'
   },
   
} );

new $.fn.dataTable.Buttons( table, {
buttons: [
    {
    extend:    'copy',
    text:      '<i class="fa fa-files-o"></i> Copy',
    titleAttr: 'Copy',
    className: 'btn btn-default btn-sm'
    },
    {
    extend:    'csv',
    text:      '<i class="fa fa-files-o"></i> CSV',
    titleAttr: 'CSV',
    className: 'btn btn-default btn-sm',
    exportOptions: {
        columns: ':visible'
    }
    },
    {
    extend:    'excel',
    text:      '<i class="fa fa-files-o"></i> Excel',
    titleAttr: 'Excel',
    className: 'btn btn-default btn-sm',
    exportOptions: {
        columns: ':visible'
    }
    },             
    {
    extend:    'print',
    text:      '<i class="fa fa-print"></i> Print',
    titleAttr: 'Print',
    className: 'btn btn-default btn-sm',
    exportOptions: {
        columns: ':visible'
    }
    },  
]
} );
   table.buttons().container().appendTo('#extraButton');
