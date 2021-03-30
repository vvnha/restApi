$(document).ready(function () {
    $("#btn-add").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var body = {
            type: $("#frmAddTask input[name=type]").val(),
            coeficient: $("#frmAddTask input[name=coeficient]").val(),
            hour: $("#frmAddTask input[name=hour]").val(),
            salary: $("#frmAddTask input[name=salary]").val(),
            note: $("#frmAddTask input[name=note]").val()
        };
        $.ajax({
            type: 'POST',
            url: 'admin/salary',
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
                $.each(errors.messages, function (key, value) {
                    console.log(value);
                    $('#add-task-errors').append('<li>' + value + '</li>');
                });
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
            type: $("#frmEditTask input[name=type]").val(),
            coeficient: $("#frmEditTask input[name=coeficient]").val(),
            hour: $("#frmEditTask input[name=hour]").val(),
            salary: $("#frmEditTask input[name=salary]").val(),
            note: $("#frmEditTask input[name=note]").val()
        };
        $.ajax({
            type: 'PUT',
            url: 'admin/salary/' + $("#frmEditTask input[name=id]").val(),
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
            url: 'admin/salary/' + $("#frmDeleteTask input[name=id]").val(),
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
        url: 'admin/salary/' + task_id,
        success: function (data) {
            $("#edit-error-bag").hide();
            $("#frmEditTask input[name=id]").val(task_id);
            $("#frmEditTask input[name=type]").val(data.data.type);
            $("#frmEditTask input[name=coeficient]").val(data.data.coeficient);
            $("#frmEditTask input[name=salary]").val(data.data.salary);
            $("#frmEditTask input[name=note]").val(data.data.note);
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
        url: 'admin/salary/' + task_id,
        success: function (data) {
            $("#frmDeleteTask #delete-title").html("Delete Salary (" + data.data.type + " ID: " + data.data.id + ")?");
            $("#frmDeleteTask input[name=id]").val(data.data.id);
            $('#deleteTaskModal').modal('show');
        },
        error: function (data) {
            console.log(data);
        }
    });
}
