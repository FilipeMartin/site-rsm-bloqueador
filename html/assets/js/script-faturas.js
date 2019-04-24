$(document).ready(function() {

if(window.location.href.match(/area_cliente\/faturas/)){  

    // Carregar Tabela
    loadingTable(); 
    //---------------- 

	var dataTable = $('#listar-faturas').DataTable({
		"dom": '<"listtable"fit>pl',
        "responsive": true,
        //"ordering": false,
        //"searching": false,
        //"paging": false,
        /*
        "columnDefs": [
                    {
                    	"targets": 0,
                        "searchable": false,
                        "visible": false
                    }
        ],
        */
		"oLanguage":{
                    "sEmptyTable":     "Nenhum Registro Encontrado",
                    "sInfo":           "Mostrando _START_ para _END_ de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando 0 para 0 de 0 registros",
                    "sInfoFiltered":   "(Filtrou de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ",",
                    "sLengthMenu":     "Mostrar _MENU_ entradas",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing":     "Processando...",
                    "sSearch":         "",
                    "sZeroRecords":    "Nenhum Registro Encontrado",
                     "oPaginate": {
                                "sFirst":    "Primeiro",
                                "sLast":     "Ultímo",
                                "sNext":     "Próximo",
                                "sPrevious": "Anterior"
                    }
        },
        "pageLength": 10, 
        "order": [
        			[ 0, "asc" ]
        		 ],  
        "lengthMenu": [
                    	[10, 25, 50, -1],
                    	[10, 25, 50, "Todos"]
                      ],
        "stateSave": true 
	});

	jQuery(".dataTables_filter input").attr("placeholder", "Pesquisar...");
 
    $('#listar-faturas tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        } else{
            dataTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
         
    $('#button').click( function () {
        dataTable.row('.selected').remove().draw( false );
    } );

    function loadingTable(){
        $('#listar-faturas').css({'display':'block'});
        $('#loading_table').css({'display':'none'});
    }
}
});