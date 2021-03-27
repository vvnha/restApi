$(document).ready(function () {
    $("#btn-add").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var body = {
            userID: $("#frmAddTask input[name=userID]").val(),
            date: $("#frmAddTask input[name=date]").val(),
            timeAttend: $("#frmAddTask input[name=timeAttend]").val(),
        };
        $.ajax({
            type: 'POST',
            url: 'admin/attend',
            data: body,
            dataType: 'json',
            success: function (data) {
                $('#frmAddTask').trigger("reset");
                $("#frmAddTask .close").click();
                window.location.reload();
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $('#add-task-errors').html('');
                // $.each(errors.messages, function (key, value) {
                console.log(value);
                $('#add-task-errors').append('<li>' + errors.messages + '</li>');
                //});
                $("#add-error-bag").show();
            }
        });
    });



    $("#btn-edit").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var body = {
            userID: $("#frmEditTask input[name=userID]").val(),
            date: $("#frmEditTask input[name=date]").val()
        };
        $.ajax({
            type: 'PUT',
            url: 'admin/attend/' + $("#frmEditTask input[name=id]").val(),
            data: body,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#frmEditTask').trigger("reset");
                $("#frmEditTask .close").click();
                window.location.reload();
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $('#edit-task-errors').html('');
                $.each(errors.messages, function (key, value) {
                    $('#edit-task-errors').append('<li>' + value + '</li>');
                });
                $("#edit-error-bag").show();
            }
        });
    });

    $("#btn-delete").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: 'admin/attend/' + $("#frmDeleteTask input[name=id]").val(),
            dataType: 'json',
            success: function (data) {
                $("#frmDeleteTask .close").click();
                window.location.reload();
            },
            error: function (data) {
                console.log(url);
            }
        });
    });
});

function addTaskForm() {
    $(document).ready(function () {
        $("#add-error-bag").hide();
        $('#addTaskModal').modal('show');
    });
}

function editTaskForm(task_id) {
    $.ajax({
        type: 'GET',
        url: 'admin/attend/' + task_id,
        success: function (data) {
            $("#edit-error-bag").hide();
            $("#frmEditTask input[name=id]").val(task_id);
            $("#frmEditTask input[name=userID]").val(data.data.userID);
            $("#frmEditTask input[name=date]").val(data.data.date);
            $('#editTaskModal').modal('show');
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function deleteTaskForm(task_id) {
    $.ajax({
        type: 'GET',
        url: 'admin/attend/' + task_id,
        success: function (data) {
            $("#frmDeleteTask #delete-title").html("Delete Salary ( ID: " + data.data.id + ")?");
            $("#frmDeleteTask input[name=id]").val(data.data.id);
            $('#deleteTaskModal').modal('show');
        },
        error: function (data) {
            console.log(data);
        }
    });
}
