function select_tb() {
	x = [];
	$.ajax({
		type: "POST",
		url: "in_db/search/select_tb.asp",
		datatype: "text",
		success: function(html) {
			z = html.split('||');
			for (q=0; z.length-1>q; q++) {
				x[q] = z[q].split('|');
			}
			$('#tb').empty();
			$('#tb').append($('<option value="0">Все ТБ</option>'));
			for (q=0; x.length-1>q; q++) {
				$('#tb').append($('<option value="'+x[q][0]+'">'+x[q][1]+" | "+x[q][2]+'</option>'));
			}
		//alert('2');
		}
		});	
}

function select_osb() {
	x=[];
	//alert('1');	
	tb = $('select[name=tb]').val();
	//alert(tb);
	if (tb != 0) {
		tb = '?tb=' + tb;
		$.ajax({
			type: "POST",
			url: "in_db/search/select_osb.asp"+tb,
			datatype: "text",
			success: function(html) {
				z = html.split('||');
				for (q=0; z.length-1>q; q++) {
					x[q] = z[q].split('|');
				}
				$('#osb').empty();
				$('#osb').append($('<option value="0">Все ОСБ</option>'));
				for (q=0; x.length-1>q; q++) {
					$('#osb').append($('<option value="'+x[q][0]+'">'+x[q][3]+'</option>'));
				}
			
			$('select[name=osb]').removeAttr('disabled');
			}

			});	
	}
	else {
		//alert('3');
		$('select[name=osb]').attr('disabled','disabled');
		$('#osb').empty();
		$('#osb').append($('<option value="0">Все ОСБ</option>'));
		$('select[name=do]').attr('disabled','disabled');
		$('#do').empty();
		$('#do').append($('<option value="0">Все ДО</option>'));
		
	}
	
}

function select_do() {
	x=[];
	//alert('1');	
	osb = $('select[name=osb]').val();
	//alert(tb);
	if (osb != 0) {
		osb = '?osb=' + osb;
		$.ajax({
			type: "POST",
			url: "in_db/search/select_do.asp"+osb,
			datatype: "text",
			success: function(html) {
				z = html.split('||');
				for (q=0; z.length-1>q; q++) {
					x[q] = z[q].split('|');
				}
				$('#do').empty();
				$('#do').append($('<option value="0">Все ДО</option>'));
				for (q=0; x.length-1>q; q++) {
					$('#do').append($('<option value="'+x[q][2]+'">'+x[q][2]+ ' - '+x[q][3]+'</option>'));
				}
			
			$('select[name=do]').removeAttr('disabled');
			}

			});	
	}
	else {
		//alert('3');
		$('select[name=do]').attr('disabled','disabled');
		$('#do').empty();
		$('#do').append($('<option value="0">Все ДО</option>'));
		
	}
	
}

function select_app_list(ser) {
	x=[];
	//alert('1');
	//alert(ser);
	$.ajax({
			type: "GET",
			url: "in_db/search/select_applist.aspx?"+ser,
			datatype: "json",
			success: function(html) {
				//alert(html);
				//$('#qwer').text(html);
				x = JSON.parse(html);
				//$('#qwer2').text(x);
				
				if (x.length > 0 ) {
					/* for (q=0; z.length-1>q; q++) {
						x[q] = z[q].split('|');
					} */
					
				//var x[];
				//x=z;

				//$('#do').empty();
				//$('#do').append($('<option value="0">Все ДО</option>'));
				//$('#app_list').append($('<table class="table table-hover"><thead><tr><td>Номер</td><td>Статус</td><td>ТБ</td><td>ОСБ</td><td>ДО</td></tr></thead><tbody>'));

				//$('#qwer3').text(x[]);

				for (q=0; x.length>q; q++) {
					$('#app_ltb').append($('<tr><td>'+x[q]["T_4450_APP_NO"]+'</td><td>'+x[q]["T_4453_APP_STATUS"]+'</td><td>'+x[q]["T_4454_BANK_CODE"]+'</td><td>'+x[q]["T_4455_BRANCH_CODE"]+'</td><td>'+x[q]["T_4456_SUBDIVISION_CODE"]+'</td><tr>'));

				}
				//$('#app_list').append($('</tbody></table>'));
				$('#app_list').show();
				$('#searchr').text('');
				}
				else {
					$('#searchr').text('Записей не найдено');
				}
			$('#plink').append($('<a href="print_ki.aspx?appno='+ x[0]["T_4450_APP_NO"] +'">Распечатать КИ</a>'))
			
			},
			error: function(html, html2, html3) { 
				//alert('Что то пошло не так:'+html+html2+html3);
				$('searchr').text('Произошла ошибка поиска заявки');
			}
			
			});	
}

function print_ki_j() {
	$('#print_ki_m').modal('show');
}

function PrintElem(elem)
    {
        Popup($(elem).html());
    }
 
function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600,menubar=yes,location=yes');
        mywindow.document.write('<html><head><title>my div</title>');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="css/bootstrap.css">');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="css/print.css">');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css"/>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        
        //mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        
        mywindow.print();
        //mywindow.close();
        
        return true;
    }

