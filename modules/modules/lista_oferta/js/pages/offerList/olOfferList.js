/**
 * Created by phelippe on 24/01/17.
 */

$( function() {
	var selected = 0;

	$(".professor").draggable({
		helper: "clone",
		snap: ".container",
		snapMode: "inner",
		cursorAt: [50, 9]
	});

	$(".class").droppable({
		accept: ".professor",
		classes: {
			"ui-droppable-hover": "ui-state-hover"
		},
		drop: function( event, ui ) {
			var professor1 = ui.draggable;
			var class2 = $(this);
			var class1 = classOfProfessor(professor1);
			var professor2 = professorOfClass(class2);

			if (!professor2 || professor1.data('id') != professor2.data('id')) {
				removeClassProfessor(class1);
				removeClassProfessor(class2);
				setClassProfessor(class1, professor2);
				setClassProfessor(class2, professor1);
			}
		}
	});

	$("#professors").droppable({
		accept: ".professor",
		drop: function( event, ui ) {
			var professor = ui.draggable;

			removeClassProfessor(classOfProfessor(professor));
		}
	});

	//noinspection JSJQueryEfficiency
	$('#container').on('click', '.professor', function () {
		if (!isSelected($(this))) {
			removeSelection();

			selectProfessor($(this));
		} else {
			removeSelection();
		}

		return false;
	});

	//noinspection JSJQueryEfficiency
	$('#container').on('click', '.class', function () {
		if (!isSelected($(this))) {
			removeSelection();

			selectClass($(this));
		} else {
			removeSelection();
		}

		return false;
	});

	$("body").click(function() {
		removeSelection();
	});

	function setSelected(object) {
		object.addClass("selected");
	}

	function removeSelected(object) {
		object.removeClass("selected");
	}

	function setTimeConflict(object) {
		object.addClass("timeConflict");
	}

	function removeTimeConflict(object) {
		object.removeClass("timeConflict");
	}

	function setOwn(object) {
		object.addClass("own");
	}

	function removeOwn(object) {
		object.removeClass("own");
	}

	function setScheduleShock(object) {
		object.addClass("scheduleShock");
	}

	function removeScheduleShock(object) {
		object.removeClass("scheduleShock");
	}

	function setOption(object, number) {
		object.addClass("option" + number);
	}

	function removeOption(object, number) {
		object.removeClass("option" + number);
	}

	function setFree(object) {
		object.addClass("free");
	}

	function removeFree(object) {
		object.removeClass("free");
	}

	function setBusy(object) {
		object.addClass("busy");
	}

	function removeBusy(object) {
		object.removeClass("busy");
	}

	function isSelected(professor) {
		return professor.hasClass("selected");
	}

	function removeSelection() {
		var div = $("div");

		removeSelected(div);
		removeFree(div);
		removeBusy(div);
		removeOption(div, 1);
		removeOption(div, 2);
		removeOption(div, 3);
		removeOption(div, 4);
		removeOption(div, 5);
		removeOption(div, 6);

		hide(false, true);
		hide(false, false);

		selected = 0;
	}

	function allInstancesOfProfessor(professor) {
		return DOMWithData("professor", "id", professor.data('id'));
	}

	function mainProfessor(professor) {
		return $("#professors .professor[data-id='" + professor.data('id') + "']");
	}


	function setClassProfessor(divClass, professor) {
		if (divClass && professor) {
			var idProf = professor.data('id');
			var divProf = $("#professors .professor[data-id='" + idProf + "']").first().clone();
			removeSelected(divProf);
			divClass.find(".container").append(divProf);

			divProf.draggable({
				helper: "clone",
				snap: ".container",
				snapMode: "inner",
				cursorAt: [50, 9]
			});

			adjustScheduleOfProfessor(professor);
			adjustScheduleShockOfProfessor(professor);
			if (isSelected(mainProfessor(professor))) {
				removeSelection();
				selectProfessor(professor);
			}

			$.ajax({
				url: '{url_professor_class_temporary}?professor=' + idProf + '&class=' + divClass.data('id'),
				type: 'POST',
				success: function (response) {
					if (response.success) {
						$(".professor[data-id='" + response.professor + "'] .credits").text(response.credits);
					} else {
						divClass.find(".container").empty();
						alert(response.message);
					}
				},
				error: function (response) {
					divClass.find(".container").empty();
					alert(response.responseText);
					//alert("Error, contate o administrador do sistema.");
				},
				dataType: "json"
			});

			hide_classes_with_professor();
		}
	}

	function removeClassProfessor(divClass) {
		if (classHaveProfessor(divClass)) {
			var professor = professorOfClass(divClass);
			divClass.find(".container").empty();

			removeOwn(divClass);
			removeScheduleShock(divClass);

			adjustScheduleOfProfessor(professor);
			adjustScheduleShockOfProfessor(professor);
			if (isSelected(mainProfessor(professor))) {
				removeSelection();
				selectProfessor(professor);
			}

			$.ajax({
				url: '{url_professor_class_temporary}?class=' + divClass.data('id'),
				type: 'DELETE',
				success: function(response) {
					if (response.success) {
						$(".professor[data-id='" + response.professor + "'] .credits").text(response.credits);
					} else {
						alert(response.message);
					}
				},
				dataType: "json"
			});
		}
	}

	function classHaveProfessor(divClass) {
		return divClass && divClass.find(".professor").length > 0;
	}

	function professorHaveClass(professor) {
		return professor && professor.parents('.class').length > 0;
	}

	function classOfProfessor(professor) {
		if (professorHaveClass(professor)) {
			return professor.parents('.class');
		}
		return null;
	}

	function classesWithoutProfessor(professor) {
		return $(".class:not(:has(.professor[data-id='" + professor.data('id') + "']))");
	}

	function classesOfProfessor(professor) {
		return $(".class:has(.professor[data-id='" + professor.data('id') + "'])");
	}

	function classesWithAnyProfessor() {
		return $(".class:has(.professor)");
	}

	function professorOfClass(divClass) {
		if (classHaveProfessor(divClass)) {
			return divClass.find(".professor");
		}
		return null;
	}

	function DOMWithData(hClass, dataName, data) {
		return $("." + hClass + "[data-" + dataName + "='" + data + "']");
	}

	function scheduleOfElement(obj) {
		var schedule = obj.attr("class").split(' ');

		schedule = schedule.filter(function (item, index) {
			return isNumber(item);
		});

		return schedule;
	}

	function adjustScheduleShockOfProfessor(professor) {
		var classesRaw = classesOfProfessor(professor);
		var times = scheduleOfElement(professor);
		removeScheduleShock(classesRaw);

		for (var i in times) {
			var classes = classesRaw.filter('.' + times[i]);
			if (classes.length > 1) {
				setScheduleShock(classes);
			}
		}
	}

	function possiblesDisciplinesWithTimeConflictOfProfessor(professor) {
		professor = allInstancesOfProfessor(professor).first();
		removeTimeConflict($(".class"));

		var schedule = scheduleOfElement(professor);
		schedule = schedule.length > 0 ? '.'+schedule.join(',.') : '';

		return classesWithoutProfessor(professor).filter(schedule);
	}

	function adjustScheduleOfProfessor(professor) {
		var times = scheduleOfElement(professor);
		times = times.length > 0 ? times.join(' ') : '';

		allInstancesOfProfessor(professor).removeClass(times);

		times = new Array();
		classesOfProfessor(professor).each(function( index ) {
			var x = scheduleOfElement($(this));
			times = times.concat(x);
		});
		times = times.length > 0 ? times.join(' ') : '';
		allInstancesOfProfessor(professor).addClass(times);
	}

	function selectProfessor(professor) {
		adjustScheduleOfProfessor(professor);
		setBusy(possiblesDisciplinesWithTimeConflictOfProfessor(professor));

		setSelected($("#professors .professor[data-id='" + professor.data('id') + "']"));
		setSelected(classesOfProfessor(professor));

		setProfessorPreferred(professor);

		hide(true, false);

		selected = 1;
	}

	function setProfessorPreferred(professor) {
		var conflict = possiblesDisciplinesWithTimeConflictOfProfessor(professor);
		var _classesOfProfessor = classesWithAnyProfessor();
		var option = DOMWithData("class", "discipline", professor.data('option1'));
		setOption(option, 1);
		setFree(option.not(conflict).not(_classesOfProfessor));

		option = DOMWithData("class", "discipline", professor.data('option2'));
		setOption(option, 2);
		setFree(option.not(conflict).not(_classesOfProfessor));

		option = DOMWithData("class", "discipline", professor.data('option3'));
		setOption(option, 3);
		setFree(option.not(conflict).not(_classesOfProfessor));

		option = DOMWithData("class", "discipline", professor.data('option4'));
		setOption(option, 4);
		setFree(option.not(conflict).not(_classesOfProfessor));

		option = DOMWithData("class", "discipline", professor.data('option5'));
		setOption(option, 5);
		setFree(option.not(conflict).not(_classesOfProfessor));

		option = DOMWithData("class", "discipline", professor.data('option6'));
		setOption(option, 6);
		setFree(option.not(conflict).not(_classesOfProfessor));
	}

	function selectClass(divClass) {
		setBusy(busyProfessorsCauseOfClass(divClass));
		setSelected(divClass);
		showProfessorsOptionsOfClass(divClass);
		selectProfessorOfClass(divClass);

		hide(true, true);

		selected = 2;
	}

	function busyProfessorsCauseOfClass(divClass) {
		removeTimeConflict($(".professor"));

		var schedule = scheduleOfElement(divClass);
		schedule = schedule.length > 0 ? '.'+schedule.join(',.') : '';

		var professor = professorOfClass(divClass);

		var professors = $("#professors .professor");

		if (professor) {
			professors = professors.not(".professor[data-id='" + professor.data('id') + "']");
		}
		professors = professors.filter(schedule);

		return professors;
	}

	function selectProfessorOfClass(divClass) {
		var professor = professorOfClass(divClass);
		if (professor) {
			professor = $("#professors .professor[data-id='" + professor.data('id') + "']");
			removeBusy(professor);
			removeFree(professor);
			setSelected(professor);
		}
	}

	function showProfessorsOptionsOfClass(divClass) {
		var conflict = busyProfessorsCauseOfClass(divClass);

		var option = $("#professors .professor[data-option1='" + divClass.data("discipline") + "']");
		setOption(option, 1);
		setFree(option.not(conflict));

		var option = $("#professors .professor[data-option2='" + divClass.data("discipline") + "']");
		setOption(option, 2);
		setFree(option.not(conflict));

		var option = $("#professors .professor[data-option3='" + divClass.data("discipline") + "']");
		setOption(option, 3);
		setFree(option.not(conflict));

		var option = $("#professors .professor[data-option4='" + divClass.data("discipline") + "']");
		setOption(option, 4);
		setFree(option.not(conflict));

		var option = $("#professors .professor[data-option5='" + divClass.data("discipline") + "']");
		setOption(option, 5);
		setFree(option.not(conflict));

		var option = $("#professors .professor[data-option6='" + divClass.data("discipline") + "']");
		setOption(option, 6);
		setFree(option.not(conflict));
	}


	var currentForm;
	$("#dialog_confirm").dialog({
		resizable: false,
		modal: true,
		autoOpen: false,
		buttons: [
			{
				text: "Cancel",
				click: function() {
					$(this).dialog('close');
				}
			},
			{
				text: "Remover distribuições",
				"class": 'remove_distributions',
				click: function() {
					currentForm.submit();
				}
			}
		]
	});

	$('#clean_form').submit(function(){
		currentForm = this;
		$('#dialog_confirm').dialog('open');
		return false;
	});




	var hidden = false;
	$("#hide_unselected_professors").click(function(event) {
		if (hidden) {
			$(this).html("Esconder não escolhidos");
		} else {
			$(this).html("Mostrar não escolhidos");
		}
		hidden = !hidden;

		if (selected == 1) {
			hide(true, false);
		} else if (selected == 2) {
			hide(true, true);
		}

		event.stopPropagation();
	});

	function hide(push, professors) {
		if (professors) {
			$('#professors .professor').removeClass('hide');
			if (push && hidden) {
				$("#professors .professor:not(.option1,.option2,.option3,.option4,.option5,.option6,.selected)").addClass('hide');
			}
		} else {
			$('#classes .class').removeClass('hide');
			if (push && hidden) {
				$("#classes .class:not(.option1,.option2,.option3,.option4,.option5,.option6,.selected)").addClass('hide');
			}
		}
	}

	var hidden_classes = false;
	$("#hide_classes_with_professor").click(function(event) {
		hidden_classes = !hidden_classes;

		if (hidden_classes) {
			$(this).html("Mostrar classes com professores");
		} else {
			$(this).html("Esconder classes com professores");
		}

		hide_classes_with_professor();

		event.stopPropagation();
	});

	function hide_classes_with_professor() {
		if (hidden_classes) {
			$(".class:has(.professor)").addClass('hide_class');
		} else {
			$('.class').removeClass('hide_class');
		}
	}




	resizeContent();

	$(window).resize(function() {
		resizeContent();
	});

	function resizeContent() {
		var cw = $('.big').height();
		$(".height").height(cw - 96);
	}

	function isNumber (o) {
		return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
	}
});
