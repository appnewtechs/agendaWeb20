/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////         Funções Genéricas de cálculos e formatações        ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function formatMoney(n, c, d, t){
	var c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


function carregaAnos() {
    var now = new Date;
    for( var i=2017; i <= now.getFullYear(); i++) {
        var option = "<option value='"+i+"'>"+i+"</option>"; 
        $("ano").append(option); 
    }
}

function setFocus(event, idInput) {
var x = event.keyCode;

	if (x == 13)  {
		$(idInput).focus(); 
		event.preventDefault();
		return false;
	};
}

function padDigits(number, digits) {
return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
}


function tablesorter( $field ){

	$sort = $('#sort').val();
	$('#field').val($field);
	$('#sort').val( $sort=='asc'?'desc':'asc' );
	$('#search_btn').click();
}

