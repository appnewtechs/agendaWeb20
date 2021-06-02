/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////         Funções Genéricas de cálculos e formatações        ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

window.setFocus = function(event, idInput) {
var x = event.keyCode;

	if (x == 13)  {
		$(idInput).focus(); 
		event.preventDefault();
		return false;
	};
}


window.tablesorter = function($field){
    $sort = $('#sort').val();
    $('#field').val($field);
    $('#sort').val( $sort=='asc'?'desc':'asc' );
    $('#search_btn').click();
}


window.resetForm = function(form){
	$(form)[0].reset();
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////         Funções de Manipulações de Dados para Controller         /////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

window.gravarRegistro = function (form){

    $('#crudModal #erros').css("color", 'green');
    $('#crudModal #erros').html("Salvando Registro!");

    $.ajax({
        url:  $(form).attr('action'),
        data: $(form).serialize(),
        type: 'POST',
        success: function(response){

            if(response.code=='200'){   
                $('#crudModal').modal('hide');
                location.reload();            
            } else {
                $.each(response.erros, function (index) {
                    $('#crudModal #erros').css("color", 'red');
                    $('#crudModal #erros').html(response.erros[index]);
                    return false;
                });
            }
        }
    });
}