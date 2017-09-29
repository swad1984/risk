//print.js
function opf(t,n) {
var opf_text;
if ( (t == 'S') && (n == 0) ) {
		opf_text = 'ИП';
	} 
else if ( (t == 'C') && (n==1) ) {
		opf_text = 'ООО';
	} 
else if ( (t == 'L') && (n == 0) ){
		opf_text = 'ООО';
	}
else opf_text = '&nbsp;';
return opf_text;
}


function credhistory(reqf) {
	x=[];
	$.ajax({
			type: "GET",
			url: "../in_db/print/default.aspx?"+reqf+"&printtype=credhistory",
			datatype: "json",
			success: function(html) { 
			$('#ptest').text(html);
			x = JSON.parse(html);
			var group = $('#group').html();
			if (x["PERSON"].length > 0 ) {
				$('#pf_table').show();
				$('button#bot').show();
				z = {};
				var rz = '<tr><td><div id=anim>Результаты оценки</div></td>';
				var rd = '<tr><td><div id=anim>Совокупная кредитная история</div></td>';
				if (group == 1) {
					var sb = '<tr><td><div id=anim>Внутренняя кредитная история</div></td>';
					var cb = '<tr><td><div id=anim>Внешняя кредитная история</div></td>';
					var bl = '<tr><td><div id=anim>Риск благонадежности</div></td>'; 
				}
				cl_t = x["APPL"][0]["CT"];

				for (i=0; i < x["PERSON"].length; i++) {
					if (x["PERSON"][i]["NUM"] == 0 ) {
						$('#mrow').append( $('<tr><td width="200pt">Заемщик</td><td width="30pt" id=opf>'+ opf(cl_t, i) +'</td><td width="300pt">'+ x["PERSON"][i]["FIO"]+'</td><td width="100pt" align="center">'+x["PERSON"][i]["PAS"]+'<br>'+x["PERSON"][i]["PD"]+'</td></tr>') );
						rz = rz + '<td><div id=anim>Заемщик</div></td>';
						rd = rd + '<td><div id=anim>'+ x["APPL"][0]["AP_CR"] + '</div></td>';
						if (group == 1) {
							sb = sb + '<td><div id=anim>'+ x["APPL"][0]["AP_SB"] + '</div></td>';
							cb = cb + '<td><div id=anim>'+ x["APPL"][0]["AP_CB"] + '</div></td>';
							bl = bl + '<td><div id=anim>'+ x["APPL"][0]["AP_BL"] + '</div></td>';
						}
					} else if (x["PERSON"][i]["NUM"] == 1 ) {
    					$('#mrow').append( $('<tr><td width="200pt">Поручитель</td><td width="30pt" id=opf>'+ opf(cl_t, i)+'</td><td width="300pt">'+ x["PERSON"][i]["FIO"]+'</td><td width="100pt" align="center">'+x["PERSON"][i]["PAS"]+'<br>'+x["PERSON"][i]["PD"]+'</td></tr>') );
    					rz = rz + '<td><div id=anim>Поручитель</div></td>';
						rd = rd + '<td><div id=anim>'+ x["APPL"][0]["GR_CR"] + '</div></td>';
						if (group == 1) {
							sb = sb + '<td><div id=anim>'+ x["APPL"][0]["GR_SB"] + '</div></td>';
							cb = cb + '<td><div id=anim>'+ x["APPL"][0]["GR_CB"] + '</div></td>';
							bl = bl + '<td><div id=anim>'+ x["APPL"][0]["GR_BL"] + '</div></td>';
						}
					} else if (x["PERSON"][i]["NUM"] == 2 ) {
    					$('#mrow').append( $('<tr><td width="200pt">Доп. Поручитель</td><td width="30pt" id=opf>'+ opf(cl_t, i)+'</td><td width="300pt">'+ x["PERSON"][i]["FIO"]+'</td><td width="100pt" align="center">'+x["PERSON"][i]["PAS"]+'<br>'+x["PERSON"][i]["PD"]+'</td></tr>') );
    					rz = rz + '<td><div id=anim>Доп.Поручитель</div></td>';
						rd = rd + '<td><div id=anim>'+ x["APPL"][0]["DGR_CR"] + '</div></td>';
						if (group == 1) {
							sb = sb + '<td><div id=anim>'+ x["APPL"][0]["DGR_SB"] + '</div></td>';
							cb = cb + '<td><div id=anim>'+ x["APPL"][0]["DGR_CB"] + '</div></td>';
							bl = bl + '<td><div id=anim>'+ x["APPL"][0]["DGR_BL"] + '</div></td>';
						}
					} else if (x["PERSON"][i]["NUM"] == 3 ) {
    					$('#mrow').append( $('<tr><td width="200pt">Созаемщик</td><td width="30pt" id=opf>'+ opf(cl_t, i)+'</td><td width="300pt">'+ x["PERSON"][i]["FIO"]+'</td><td width="100pt" align="center">'+x["PERSON"][i]["PAS"]+'<br>'+x["PERSON"][i]["PD"]+'</td></tr>') );
    					rz = rz + '<td><div id=anim>Созаемщик</div></td>';
						rd = rd + '<td><div id=anim>'+ x["APPL"][0]["CGR_CR"] + '</div></td>';
						if (group == 1) {
							sb = sb + '<td><div id=anim>'+ x["APPL"][0]["CGR_SB"] + '</div></td>';
							cb = cb + '<td><div id=anim>'+ x["APPL"][0]["CGR_CB"] + '</div></td>';
							bl = bl + '<td><div id=anim>'+ x["APPL"][0]["CGR_BL"] + '</div></td>';
						}
					}
				}

				rz = rz + '</tr>';
				rd = rd + '</tr>';
				if (group == 1) {
					sb = sb + '</tr>';
					cb = cb + '</tr>';
					bl = bl + '</tr>';
				}

				$('#drow').append($(rz));
				$('#drow').append($(rd));
				if (group == 1) {
					$('#drow').append($(sb));
					$('#drow').append($(cb));
					$('#drow').append($(bl));
				}

				if (x["APPL"][0]["LOYAL"] == 1) {
					$('#dloyal').text('Да');
				} else {
					$('#dloyal').text('Нет');
				}
				$('div#anim').hide();
			} else {
				alert('Заявка: \r\n' + $('#appno').html() + '\r\n не найдена');
				closew();
			}

			},
			error: function(html) {
				alert('Заявка: \r\n' + $('#appno').html() + '\r\n не найдена');
				closew();
			}
		});
setTimeout(function() {
$('div#anim').show();
$('#dloyal').addClass('fadeIn animated');
$('#drow').addClass('fadeRight animated');
$('#mrow').addClass('RotateInUpLeft animated');
$('div#anim').addClass('fadeIn animated');
}, 1000);


}

function printp() {
	window.print();
}

function closew() {
//tst();
window.close();
}

function tst() {
$('#pf_table').removeClass('slideInDown animated');
$('button#bot').removeClass();
$('#pf_table').addClass('fadeOutUp animated');
$('button#bot').addClass('rollOut animated');	
}