/**
 * Created by phelippe on 21/10/18.
 */

$( function() {
    var discipline = {id:'{discipline_discipline}', quantity: '{discipline_theory_quantity}'};
    
    
    $('body').on('click', '.time:not(.error)', function() {
        var divGroup = groupOfTime($(this));
        var divTime = $(this);

        requestChangeTimeOfGroup(divGroup, divTime);
    });

    var classDraggable = {
        helper: "clone",
        snapMode: "inner",
        cursorAt: [20, 20]
    };

	$(".class").draggable(classDraggable);

    $("#classes").droppable({
        accept: ".class",
        drop: function( event, ui ) {
            var divClass = ui.draggable;

            requestRemoveClassFromGroup(divClass);
        }
    });

    var groupDroppable = {
        accept: ".class",
        classes: {
            "ui-droppable-hover": "ui-state-hover"
        },
        drop: function( event, ui ) {
            var divClass = getActiveDivClass(ui.draggable);
            var divGroup = $(this);

            requestAddClassToGroup(divClass, divGroup);
        }
    };

    $(".group:not(#add_group)").droppable(groupDroppable);

    $("#add_group").droppable({
        accept: ".class",
        classes: {
            "ui-droppable-hover": "ui-state-hover"
        },
        drop: function( event, ui ) {
            var divClass = getActiveDivClass(ui.draggable);

            requestCreateGroup(divClass);
        }
    });

    function requestCreateGroup(divClass) {
        var data = {id:divClass.data('id'), discipline: discipline.id, 'class':divClass.data('class')};
        $.ajax({
            url: '{url_magisterial_theory_groups}',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: "json",
            processData: true,
            success: function(response) {
                if (response.success) {
                    createGroup(divClass, response.data)
                } else {
                    alert(response.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    function createGroup(divClass, groupObj) {
        var divGroup = instantiateBasicGroup(groupObj.group);

        $("#add_group").before(divGroup);

        addClassToGroup(divClass, divGroup, groupObj);
    }

    function instantiateBasicGroup(group) {
        var divGroup = $('<div class="group"/>').attr('data-group', group);
        var content = $('<div class="group_content"/>');
        content.append($('<h2/>').text('Grupo ' + group));
        content.append($('<div class="schedule"/>'));
        var classesDiv = $('<div class="classes"/>')
            .append($('<div class="title"/>').append($('<div class="title_contend"/>').append($('<label/>').text('Turmas'))))
            .append($('<div class="clear"/>'));
        content.append(classesDiv);
        divGroup.append(content);
        divGroup.droppable(groupDroppable);

        return divGroup;
    }

    function updateTimeOfGroup(divGroup, groupObj) {
        var schedule = divGroup.find(".schedule");
        schedule.empty();

        if (groupObj.schedule.length > 0) {
            if (groupObj.selected.length < discipline.quantity) {
                var text = "Selecione mais " + (discipline.quantity - groupObj.selected.length);
                schedule.append($('<span class="error"/>').text(text));
            } else if (groupObj.selected.length > discipline.quantity) {
                var text = "Selecione menos " + (groupObj.selected.length - discipline.quantity);
                schedule.append($('<span class="error"/>').text(text));
            }
            for (var i in groupObj.schedule) {
                var time = groupObj.schedule[i];
                var span = $('<span class="time"/>').attr('data-time', time).text(time);
                if (groupObj.selected.indexOf(time+"") > -1) {
                    span.addClass('selected');
                }
                schedule.append(span);
            }
        } else {
            schedule.append($('<span class="error"/>').text('ERRO'));
        }
    }

    function requestAddClassToGroup(divClass, divGroup) {
        var data = {id:divClass.data('id'), group:divGroup.data('group'), discipline: discipline.id, 'class':divClass.data('class')};
        $.ajax({
            url: '{url_magisterial_theory_groups}',
            type: 'PUT',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: "json",
            processData: true,
            success: function(response) {
                if (response.success) {
                    addClassToGroup(divClass, divGroup, response.data);
                } else {
                    alert(response.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    function addClassToGroup(divClassOriginal, divGroup, groupObj) {
        var divClass = cloneDivClass(divClassOriginal);

        if (divGroup.find(".class").length > 0) {
            divGroup.find(".class").each(function (index) {
                if ($(this).data('class') > divClass.data('class')) {
                    $(this).before(divClass);
                    return false;
                }
                if (divGroup.find(".class").length - 1 == index) {
                    $(this).after(divClass);
                }
            });
        } else {
            divGroup.find(".classes").append(divClass);
        }

        removeClassFromGroup(divClassOriginal);

        updateGroupOfClass(divClass, divGroup);

        updateTimeOfGroup(divGroup, groupObj);
    }

    function cloneDivClass(divClassOriginal) {
        var divClass = divClassOriginal.clone();

        divClass.draggable(classDraggable);

        return divClass;
    }

    function requestRemoveClassFromGroup(divClass) {
        if (classHasGroup(divClass)) {
            var data = {id: divClass.data('id'), discipline: discipline.id};
            $.ajax({
                url: '{url_magisterial_theory_groups}',
                type: 'DELETE',
                data: JSON.stringify(data),
                contentType: 'application/json',
                dataType: "json",
                processData: true,
                success: function (response) {
                    if (response.success) {
                        removeClassFromGroup(divClass)
                    } else {
                        console.log(response);
                        alert(response.message);
                    }
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                }
            });
        }
    }

    function removeClassFromGroup(divClass) {
        if (classHasGroup(divClass)) {
            var divGroup = groupOfClass(divClass);

            divClass.remove();
            if (!groupHasClass(divGroup)) {
                divGroup.remove();
            } else {
                requestUpdateGroupTime(divGroup);
            }
            updateGroupOfClass(divClass, null);
        }
    }

    function requestUpdateGroupTime(divGroup) {
        var divClass = divGroup.find(".class").eq(0);

        var data = {id:divClass.data('id'), group:divGroup.data('group'), discipline: discipline.id, 'class':divClass.data('class')};
        $.ajax({
            url: '{url_magisterial_theory_groups}',
            type: 'PUT',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: "json",
            processData: true,
            success: function(response) {
                if (response.success) {
                    updateTimeOfGroup(divGroup, response.data);
                } else {
                    alert(response.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    function requestChangeTimeOfGroup(divGroup, divTime) {
        var data = {discipline: discipline.id, group:divGroup.data('group'), time:divTime.data('time')};
        $.ajax({
            url: '{url_magisterial_theory_groups}',
            type: 'PATCH',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: "json",
            processData: true,
            success: function(response) {
                if (response.success) {
                    updateTimeOfGroup(divGroup, response.data);
                } else {
                    alert(response.message);
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    function changeTimeOfGroup(divGroup, divTime) {
        removeSelectedTimeFromGroup(divGroup);
        selectTime(divTime);
        removeErrorFromGroup(divGroup);
    }

    function removeSelectedTimeFromGroup(divGroup) {
        divGroup.find(".time.selected").removeClass("selected");
    }

    function removeErrorFromGroup(divGroup) {
        divGroup.find(".schedule .error").remove();
    }

    function selectTime(divTime) {
        divTime.addClass("selected");
    }

    function groupOfTime(time) {
        return time.parents('.group');
    }

    function groupHasClass(divGroup) {
        return divGroup && divGroup.find(".class").length > 0;
    }

    function classHasGroup(divClass) {
        return divClass && divClass.parents(".group").length > 0;
    }

    function getActiveDivClass(originalDivClass) {
        var id = originalDivClass.data('id');
        var divClass = $(".group .class_"+id).first();

        if (divClass && divClass.length > 0) {
            return divClass;
        } else {
            return originalDivClass;
        }
    }

    function groupOfClass(divClass) {
        return divClass.parents('.group');
    }

    function updateGroupOfClass(divClass, divGroup) {
        var classId = divClass.data('id');
        if (!divGroup) {
            $(".class_"+classId).find(".class_group").text("");
        } else {
            $(".class_"+classId).find(".class_group").text(divGroup.data('group'));
        }
    }









	resizeContent();

	$(window).resize(function() {
		resizeContent();
	});

	function resizeContent() {
        var cw = $(window).height();
        $(".height").height(cw - 106);
	}

	function isNumber (o) {
		return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
	}
});
