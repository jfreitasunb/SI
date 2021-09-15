$().ready(function() {
	var table = $('#disciplines_table').DataTable({
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false,
		"columnDefs": [
			{"orderable": false, "targets": [3, 4, 5]}
		]
	});
	
	var form = $("#edit_insert_form");
	form.validate({
		rules: {
			discipline: {
				required: true
			},
			theory: {
				required: true,
				digits: true
			},
			exercice: {
				required: true,
				digits: true
			}
		}
	});

	$("#dialog_edit_discipline").change(function() {
		var credits = $(this).find(':selected').data('credits');

		$(".credits_input").each(function( index ) {
			$(this).rules("remove", "sum");
			$(this).rules("add", { sum: [credits, $(".credits_input")] });
		});
	});

	$('body').on('click', '.new_discipline', function() {
		dialog_edit
			.data('discipline', null)
			.dialog("open");
	});

	$('body').on('click', '.edit_magisterial_discipline', function() {
		var id = $(this).attr('id').substring(5);
		// console.log(id);
		var magisterial_discipline = disciplineFromLine(id);

		dialog_edit
			.data('discipline', magisterial_discipline)
			.dialog("open");
	});

	$('body').on('click', '.delete_magisterial_discipline', function() {
		var id = $(this).attr('id').substring(7);
		var mClass = disciplineFromLine(id);
		var name = mClass.discipline_name.split(" (")[0];

		var desc = "A disciplina "+name+" não será mais magistral.<br>Tem certeza disso?";
		$('#delete_confirmation_dialog_description').html(desc);

		startLineAnimation(id, "deleted");

		dialog_delete
			.data('magisterial_discipline', id)
			.dialog("open");
	});
	
	var dWidth = 410, dHeight = 227;
	var dialog_edit = $('#edit_insert_dialog').dialog({
		autoOpen: false,
		width: dWidth,
		modal: true,
		create: createOpenDialog,
	    open: openEditDialog,
	    close: closeDialog,
		buttons: {
			"Salvar": addEditMagisterialDiscipline,
			"Cancelar": function() {
				dialog_edit.dialog("close");
			}
		}
	});

	var dialog_delete = $('#delete_confirmation_dialog').dialog({
		autoOpen: false,
		width: dWidth,
		modal: true,
		create: createOpenDialog,
	    open: createOpenDialog,
	    close: function(event, ui) {
			endLineAnimation($(this).data('magisterial_discipline'), "deleted");
	    },
		buttons: {
			"Excluir": deleteMagisterialDiscipline,
			"Cancelar": function() {
				dialog_delete.dialog("close");
			}
		}
	});
	
	function createOpenDialog(event, ui) {
        var dW = dWidth + 7, dH = dHeight + 0.8;
        var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],wW=w.innerWidth||e.clientWidth||g.clientWidth,wH=w.innerHeight||e.clientHeight||g.clientHeight;
        var left = Math.round((wW - dW) / 2 * 100) / 100, top = Math.round((wH - dH) / 2 * 100) / 100;

        $(event.target).parent().css('position', 'fixed');
        $(event.target).parent().css('left', left + "px");
        $(event.target).parent().css('top', top + "px");
    }

	function openEditDialog(event, ui) {
		createOpenDialog(event, ui);

		var magisterial_discipline = $(this).data('discipline');
		fillFormWithDiscipline(magisterial_discipline);

		var id = magisterial_discipline ? magisterial_discipline.id : null;
		startLineAnimation(id, "changed");
	}

	function closeDialog(event, ui) {
		var magisterial_discipline = $(this).data('discipline');
		var id = magisterial_discipline ? magisterial_discipline.id : null;

		form.validate().resetForm();

		endLineAnimation(id, "changed");
	}
	
	function addEditMagisterialDiscipline() {
		if (form.valid()) {
			//Salva via ajax, se deu certo reflete da table

			var data = disciplineFromForm();

            var method = null;
			if (data.id) {
                method = 'PUT';
			} else {
                method = 'POST';
			}
            console.log(data);
            console.log(method);

            $.ajax({
                url: '{url_magisterial_discipline}',
                type: method,
                data: JSON.stringify(data),
                contentType: 'application/json',
                dataType: "json",
                processData: true,
                success: function (response) {
                    if (response.success) {
                        if (data.id) {
                            fillTableWithDiscipline(response.data);
                        } else {
                            console.log(response.data);
                            createLineTable(response.data);
                        }
                    } else {
                        console.log(response);
                        alert(response.message);
                    }
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                }
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

	function deleteMagisterialDiscipline() {
		var id = $(this).data('magisterial_discipline');
		var data = {id: id};
        
        $.ajax({
            url: '{url_magisterial_discipline}',
            type: 'DELETE',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: "json",
            processData: true,
            success: function (response) {
                if (response.success) {
                    $('#line_'+id)
                        .children('td')
                        .animate({padding: 0})
                        .wrapInner('<div />')
                        .children()
                        .slideUp(function(){
                            table.row('#line_'+id).remove().draw(false);
                        });
                } else {
                    console.log(response);
                    alert(response.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
		dialog_delete.dialog("close");
		endLineAnimation(id, "deleted", 5000, 500);
	}

	function disciplineFromLine(id) {
		var dis = $('#discipline_name_'+id).html();
		var thq = $('#theory_quantity_'+id).html();
		var exq = $('#exercises_quantity_'+id).html();
		var did = $('#discipline_name_'+id).data('discipline');

		return {id: id, discipline_name: dis, theory_quantity: thq, exercises_quantity: exq, discipline: did};		
	}

	function fillTableWithDiscipline(magisterial_discipline) {
		$('#discipline_name_'+magisterial_discipline.id).text(magisterial_discipline.discipline_name);
		$('#theory_quantity_'+magisterial_discipline.id).text(magisterial_discipline.theory_quantity);
		$('#exercises_quantity_'+magisterial_discipline.id).text(magisterial_discipline.exercises_quantity);
		$('#discipline_name_'+magisterial_discipline.id).data('discipline', magisterial_discipline.discipline);

		table.row('#line_'+magisterial_discipline.id).invalidate().draw(false);
	}

	function createLineTable(magisterial_discipline) {
		table.row.add($(
			'<tr id="line_'+magisterial_discipline.id+'">'+
				'<td id="discipline_name_'+magisterial_discipline.id+'" data-discipline="'+magisterial_discipline.discipline+'">'+magisterial_discipline.name+' ('+magisterial_discipline.credits+')</td>'+
				'<td id="theory_quantity_'+magisterial_discipline.id+'">'+magisterial_discipline.theory_quantity+'</td>'+
				'<td id="exercises_quantity_'+magisterial_discipline.id+'">'+magisterial_discipline.exercises_quantity+'</td>'+
				'<td><button id="edit_'+magisterial_discipline.id+'" class="edit_magisterial_discipline">Editar</button></td>'+
				'<td><button id="delete_'+magisterial_discipline.id+'" class="delete_magisterial_discipline">Excluir</button></td>'+
                '<td><a href="?discipline='+magisterial_discipline.discipline+'"><button>Grupos Teoria</button></a></td>'+
			'</tr>'
		)).draw(false);

		var h = (window.innerHeight - 29) / 2;
		$('html, body').animate({
			scrollTop: ($('#line_'+magisterial_discipline.id).offset().top - h)
		}, 500);

		startLineAnimationTime(magisterial_discipline.id, "changed", 0);
		endLineAnimationTime(magisterial_discipline.id, "changed", 2500, 500);
	}

	function disciplineFromForm() {
		var magisterial_discipline = dialog_edit.data('discipline');
		var id = magisterial_discipline ? magisterial_discipline.id : null;

		var thq = $('#dialog_edit_theory').val();
		var exq = $('#dialog_edit_exercice').val();
		var did = $('#dialog_edit_discipline').val();

		return {id: id, theory_quantity: thq, exercises_quantity: exq, discipline: did};
	}

	function fillFormWithDiscipline(magisterial_discipline) {
		var discipline = magisterial_discipline ? magisterial_discipline.discipline : "";
		var theory_quantity = magisterial_discipline ? magisterial_discipline.theory_quantity : "";
		var exercises_quantity = magisterial_discipline ? magisterial_discipline.exercises_quantity : "";

		$('#dialog_edit_discipline').val(discipline);
		$('#dialog_edit_theory').val(theory_quantity);
		$('#dialog_edit_exercice').val(exercises_quantity);
		
		$("#dialog_edit_discipline").change();
	}

	function startLineAnimationTime(id, type, time) {
		var line = $('#line_'+id);
		var c = line.attr('class');
		line.data('class', c);
		line.removeClass(c);
		line.addClass(type, time);
	}

	function endLineAnimationTime(id, type, delay, time) {
		var line = $('#line_'+id);
		var c = line.data('class');

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
		endLineAnimationTime(id, type, 500, 500);
	}
});