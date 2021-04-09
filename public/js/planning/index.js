
function allowDrop(ev) {
   ev.preventDefault();
 }
 
 function drag(ev) {
   ev.dataTransfer.setData("text", ev.target.id);
 }
 
 function drop(ev) {
   ev.preventDefault();
   var data = ev.dataTransfer.getData("text");
   ev.target.appendChild(document.getElementById(data));
 }

 var table = $('#plannings').DataTable( {
  "paging": true,
  "pageLength": 10,
  "lengthChange": true,
  "lengthMenu": [ 10, 20, 50, 75, 100 ],
  language: {
     url: '/assets/datatables/french.json'
  },
  //------------Stockage local (cache) du numéro de page précédent partout dans mon application-------------
  "bStateSave": true,
  "fnStateSave": function (oSettings, oData) {
      localStorage.setItem('offersDataTables', JSON.stringify(oData));
  },
  "fnStateLoad": function (oSettings) {
      return JSON.parse(localStorage.getItem('offersDataTables'));
  }
    //-------------------------
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