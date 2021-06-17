$().ready(function() {
	var table, dialog_edit, dialog_delete, form, matClass, request = false;

	form = $("#edit_insert_form");
	form.validate();

	table = $('#classes_table').DataTable({
		"order": [[0, "asc" ], [1, "asc" ]],
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false,
		"columnDefs": [
			{"orderable": false, "targets": [5, 6]}
		]
	});

//	console.log($('#line_818').prev().html());
//	$('#line_818').each(function() {
//
//		$('#line_818').addClass("deleted", 1000);
//
//		var line = $('#line_819');
//		var c = line.attr('class');
//		line.removeClass(c);
//		line.addClass("changed", 500);
//
//		var line = $('#line_819');
//		var c = line.attr('class');
//		line.removeClass(c);
//		line.addClass("changed", 500, function() {
//			setTimeout(function() {
//				line.addClass(c, 2000, function() {
//					line.removeClass("changed");
//				});
//			}, 1000 );
//		});
//	});

	$('#classes_table thead th:eq(0)').unbind('click').click(function(){
		var sor = table.order();

		if(sor[0][0] == 0) {
			if(sor[0][1] == 'desc'){
				table.order([[0, 'asc'], [1, sor[1][1]]]);
			}else{
				table.order([[0, 'desc'], [1, sor[1][1]]]);
			}
		} else {
			table.order([[0, 'asc'], [1, 'asc']]);
		}
		table.draw();
	});

	$('#classes_table thead th:eq(1)').unbind('click').click(function(){
		var sor = table.order();

		if(sor[0][0] == 0) {
			if(sor[1][1] == 'desc'){
				table.order([[0, sor[0][1]], [1, 'asc']]);
			}else{
				table.order([[0, sor[0][1]], [1, 'desc']]);
			}
		} else {
			table.order([[0, 'asc'], [1, 'asc']]);
		}
		table.draw();
	});

	$('body').on('click', '.edit_class', function() {
		var id = $(this).attr('id').substring(5);
		//console.log(id);
		matClass = classFromId(id);
		dialog_edit.dialog("open");

		startLineAnimation(id, "changed");
	});


	$('body').on('click', '.delete_class', function() {
		var id = $(this).attr('id').substring(7);
		//console.log(id);
		matClass = classFromId(id);

		var desc = "A turma "+matClass.discipline_name+" - "+matClass.class+" será removida permanentemente. Tem certeza disso?";
		$('#delete_confirmation_dialog_description').text(desc);

		dialog_delete.dialog("open");

		startLineAnimation(id, "deleted");
	});

	$('.new_class').click(function() {
		matClass = null;
		dialog_edit.dialog("open");

//		var obj = {id: "952", discipline_name: "ALGEBRA 1", class: "C", period: "Diurno", schedule: "308-508", discipline_id: "113107", classroom: "ICC 2345"};
//
//		table.row.add( [
//		                 'õ',
//		                 '.2',
//		                 '.3',
//		                 '.4',
//		                 '.5',
//		                 '<button id="edit_'+obj.id+'" class="edit_class">Editar</button>\n<input type="hidden" id="discipline_id_'+obj.id+'" value="113204">',
//		                 '<button id="delete_'+obj.id+'" class="delete_class">Excluir</button>'
//		             ] ).draw(false);
	});

	function startLineAnimationTime(id, type, time) {
		var line = $('#line_'+id);
		var c = line.attr('class');
		line.removeClass(c);
		line.addClass(type, time);
	}

	function endLineAnimationTime(id, type, delay, time) {
		var line = $('#line_'+id);
		var c = $('#line_'+id).prev().prev().attr('class');
		if (!c) {
			c = $('#line_'+id).next().next().attr('class');
		}
		setTimeout(function() {
			line.addClass(c, time, function() {
				line.removeClass(type);
			});
		}, delay );
	}

	function startLineAnimation(id, type) {
		startLineAnimationTime(id, type, 500);
	}

	function endLineAnimation(id, type) {
		endLineAnimationTime(id, type, 0, 500);
	}

	var dWidth = 410, dHeight = 227;
	dialog_edit = $('#edit_insert_dialog').dialog({
		autoOpen: false,
		width: dWidth,
		modal: true,
		create: createOpenDialog,
	    open: openDialog,
	    close: closeDialog,
		buttons: {
			"Salvar": addEditClass,
			"Cancelar": function() {
				dialog_edit.dialog("close");
			}
		}
	});

	form.submit(function( event ) {
		event.preventDefault();
		addEditClass();
	});

	function addEditClass() {
		if (form.valid()) {
			//Salva via ajax, se deu certo reflete da table

			var did = $('#dialog_edit_discipline').val();
			var cla = $('#dialog_edit_class').val();
			var per = $('#dialog_edit_period').val();
			var sch = $('#dialog_edit_schedule').val();
			var clr = $('#dialog_edit_classroom').val();

			var dataToBeSent;
			if (matClass) {
				dataToBeSent = {update: matClass.id, discipline_id: did, class: cla, period: per, schedule: sch, classroom: clr}
			} else {
				dataToBeSent = {insert: true, discipline_id: did, class: cla, period: per, schedule: sch, classroom: clr}
			}
			//console.log(dataToBeSent);
			request = true;
			$.post("{url_alter_class_temporary}", dataToBeSent)
				.done(function(data) {
					var resp = JSON.parse(data);
					if (resp.success) {
						if (dataToBeSent.update != undefined) {
							fillLineTable(resp.response[0]);
						} else {
							createLineTable(resp.response[0]);
						}
					} else {
						alert(resp.message);
					}

					request = false;
				});

			dialog_edit.dialog("close");
		} else {
			$("#effect").animate({
				backgroundColor: "#aa0000",
				color: "#fff",
				width: 500
			}, 1000);
		}
	}

	function openDialog(event, ui) {
		fillDialogClassData(matClass);

		createOpenDialog(event, ui)
	}

	function closeDialog(event, ui) {
		if(!request) {
			if (matClass) {
				endLineAnimation(matClass.id, "changed");
				matClass = null;
			}
		}
		dialog_edit.dialog("close");
	}

	function fillDialogClassData(clas) {
		var id = clas ? clas.discipline_id : "";
		var class_ = clas ? clas.class : "";
		var period = clas ? clas.period : "";
		var schedule = clas ? clas.schedule : "";
		var classroom = clas ? clas.classroom : "";

		$('#dialog_edit_discipline').val(id);
		$('#dialog_edit_class').val(class_);
		$('#dialog_edit_period').val(period);
		$('#dialog_edit_schedule').val(schedule);
		$('#dialog_edit_classroom').val(classroom);
	}

	function createOpenDialog(event, ui) {
        var dW = dWidth + 7, dH = dHeight + 0.8;
        var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],wW=w.innerWidth||e.clientWidth||g.clientWidth,wH=w.innerHeight||e.clientHeight||g.clientHeight;
        var left = Math.round((wW - dW) / 2 * 100) / 100, top = Math.round((wH - dH) / 2 * 100) / 100;

        $(event.target).parent().css('position', 'fixed');
        $(event.target).parent().css('left', left+"px");
        $(event.target).parent().css('top', top+"px");
    }

	function classFromId(id) {
		var dis = $('#discipline_name_'+id).html();
		var cla = $('#class_'+id).html();
		var per = $('#period_'+id).html();
		var sch = $('#schedule_'+id).html();
		var did = $('#discipline_id_'+id).val();
		var clr = $('#classroom_'+id).html();

		return {id: id, discipline_name: dis, class: cla, period: per, schedule: sch, discipline_id: did, classroom: clr};
	}

	function fillLineTable(clas) {
		var id = clas.id;

		$('#discipline_name_'+id).text(clas.discipline_name);
		$('#class_'+id).text(clas.class);
		$('#period_'+id).text(clas.period);
		$('#schedule_'+id).text(clas.schedule);
		$('#discipline_id_'+id).val(clas.discipline_id);
		$('#classroom_'+id).text(clas.classroom);

		table.row('#line_'+clas.id).invalidate().draw(false);

		startLineAnimationTime(clas.id, "changed", 0);
		endLineAnimationTime(clas.id, "changed", 1000, 500);
	}

	function createLineTable(clas) {
		var classroom = clas.classroom ? clas.classroom : "";
		table.row.add($(
			'<tr id="line_'+clas.id+'">'+
				'<td id="discipline_name_'+clas.id+'">'+clas.discipline_name+'</td>'+
				'<td id="class_'+clas.id+'">'+clas.class+'</td>'+
				'<td id="period_'+clas.id+'">'+clas.period+'</td>'+
				'<td id="schedule_'+clas.id+'">'+clas.schedule+'</td>'+
				'<td id="classroom_'+clas.id+'">'+classroom+'</td>'+
				'<td>'+
					'<button id="edit_'+clas.id+'" class="edit_class">Editar</button>'+
					'<input type="hidden" id="discipline_id_'+clas.id+'" value="'+clas.discipline_id+'">'+
				'</td>'+
				'<td><button id="delete_'+clas.id+'" class="delete_class">Excluir</button></td>'+
			'</tr>'
		)).draw(false);

		var h = (window.innerHeight - 29) / 2;
		$('html, body').animate({
			scrollTop: ($('#line_'+clas.id).offset().top - h)
		}, 500);

		startLineAnimationTime(clas.id, "changed", 0);
		endLineAnimationTime(clas.id, "changed", 2500, 500);
	}

	dialog_delete = $('#delete_confirmation_dialog').dialog({
		autoOpen: false,
		width: dWidth,
		modal: true,
		create: createOpenDialog,
	    open: openDialog,
	    close: function(event, ui) {
			if(!request) {
				endLineAnimation(matClass.id, "deleted");
			}
			dialog_delete.dialog("close");
	    },
		buttons: {
			"Excluir": function() {
				request = true;
				$.post("{url_alter_class_temporary}", {remove: matClass.id})
					.done(function(data) {
						var resp = JSON.parse(data);
						if (resp.success) {
							$('#line_'+matClass.id)
						        .children('td')
						        .animate({padding: 0})
						        .wrapInner('<div />')
						        .children()
						        .slideUp(function(){
						        	table.row('#line_'+matClass.id).remove().draw(false);
						        });
							request = false;
						}
					});
				dialog_delete.dialog("close");
				endLineAnimation(matClass.id, "deleted", 5000, 500);
			},
			"Cancelar": function() {
				dialog_delete.dialog("close");
			}
		}
	});
});