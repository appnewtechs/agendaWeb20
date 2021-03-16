$(document).ready(function(){
    
    $('#telefone').mask('(00) 00000-0000');

    $('#crud').on('shown.bs.modal', function(e) {
    $('#crud #nome').focus();
    });    

    $('#delete').on('show.bs.modal', function(e) {
        var codigo   = $(e.relatedTarget).data("codigo");
        var descricao= $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Usuário: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_usuario_"+codigo+"').submit()");
    });   
});


function insertUsuario(){

    var $id = null;
    $('#frmUsuario')[0].reset();
    $('#empresas tbody tr').remove();

    $('#crud #idUsuario').val('');
    $('#crud #modal-title').text("Inserir Usuário");
    $('#crud #erros').html('');

    carregaEmpresas($id);
    $('#crud').modal('show');
}

function updateUsuario(usuario){

    $id = usuario.id_usuario;
    $('#frmUsuario')[0].reset();
    $('#empresas tbody tr').remove();
    $('#crud #modal-title').html("Alterar Usuário: "+$id+" - "+usuario.nome);
    $('#crud #erros').html('');


    $('#crud #id_usuario').val($id);
    $('#crud #nome').val(usuario.nome);
    $('#crud #email').val(usuario.email);
    $('#crud #status').val(usuario.status);
    $('#crud #id_empresa').val(usuario.id_empresa);
    $('#crud #login').val(usuario.login);
    $('#crud #telefone').val(usuario.telefone);
    $('#crud #id_perfil').val(usuario.id_perfil);
    $('#crud #data_nascimento').val(usuario.data_nascimento);
    $('#crud #id_linha_produto').val(usuario.id_linha_produto);
    $('#crud #especialidade').val(usuario.especialidade);
    $('#crud #notificacao_agenda').val(usuario.notificacao_agenda);
    
    carregaEmpresas($id);
    $('#crud').modal('show');
}

function carregaEmpresas(userId){

    $.ajax({
        url: 'usuario/empresas/'+userId,
        type: 'get',
        dataType: 'json',
        success: function(response){
    
            for(var i=0; i<response.length; i++){
            
                var email = response[i].email!=null ? response[i].email : "";
                var selectedSim = response[i].status=="0" ? 'selected' : '';
                var selectedNao = response[i].status=="1" ? 'selected' : '';
    
                newRow =  '<tr>';
                newRow += '<td>'+response[i].razao_social+'</td>';
                newRow += '<td><input  name="arr_email[]"   id="arr_email'+response[i].id_empresa+'"   value="'+email+'" type="email"  class="form-control inputrow"></input>';
                newRow += '<td><select name="arr_status[]"  id="arr_status'+response[i].id_empresa+'"  value="'+response[i].status+'"  class="form-control selectrow"><option value="0" '+selectedSim+'>Sim</option><option value="1" '+selectedNao+'>Não</option></select>';
                newRow += '    <input  name="arr_empresa[]" id="arr_empresa'+response[i].id_empresa+'" value="'+response[i].id_empresa+'" type="hidden"></input>';
                newRow += '</td></tr>';
                $('#empresas tbody').append(newRow);    
            }
        },
    
        error: function(error) {
        window.location.href = '/';
        },
    });
        
}

function salvarUsuario(){

    $.ajax({
        url: "usuario/store",
        type: 'POST',
        dataType:'json',            
        data: $('#frmUsuario').serialize(),
        
        success: function(response){
            if(response.code=='200'){   
                $('#crud').modal('hide');
                location.reload();
            } else {
                $.each(response.erros, function (index) {
                    $('#crud #erros').html(response.erros[index]);
                    return false;
                });
            }
        },

        error: function() {
        window.location.href = '/';
        },
    });

}

function preencherEmail($modo) {

    if($modo=="update"){
        $("input[name='u_arr_empresa[]']").each(function(){
            i=$(this).val();
            codEmpresa = $("#u_arr_empresa"+i).val();
            if( codEmpresa==$('#u_id_empresa').val() ){
                $("#u_arr_email"+i).val( $('#u_email').val() );
            }
        });
    } else {
        $("input[name='i_arr_empresa[]']").each(function(){
            i=$(this).val();
            codEmpresa = $("#i_arr_empresa"+i).val();
            if( codEmpresa==$('#i_id_empresa').val() ){
                $("#i_arr_email"+i).val( $('#i_email').val() );
            }
        });
    }
}
