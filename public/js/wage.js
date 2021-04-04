$(document).ready(function () {
    $("#btn-add").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'admin/wage',
            data: {
                email: $("#frmAddTask input[name=email]").val(),
                month: $("#frmAddTask input[name=month]").val(),
                year: $("#frmAddTask input[name=year]").val(),
                bonus: $("#frmAddTask input[name=bonus]").val(),
                deduction: $("#frmAddTask input[name=deduction]").val(),
                note: $("#frmAddTask input[name=note]").val(),
            },
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



    // $("#btn-edit").click(function () {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         type: 'PUT',
    //         url: 'admin/wage' + $("#frmEditTask input[name=task_id]").val(),
    //         data: {
    //             task: $("#frmEditTask input[name=task]").val(),
    //             soluong: $("#frmEditTask input[name=soluong]").val(),
    //         },
    //         dataType: 'json',
    //         success: function (data) {
    //             console.log(data);
    //             $('#frmEditTask').trigger("reset");
    //             $("#frmEditTask .close").click();
    //             window.location.reload();
    //         },
    //         error: function (data) {
    //             var errors = $.parseJSON(data.responseText);
    //             $('#edit-task-errors').html('');
    //             $.each(errors.messages, function (key, value) {
    //                 $('#edit-task-errors').append('<li>' + value + '</li>');
    //             });
    //             $("#edit-error-bag").show();
    //         }
    //     });
    // });

    $("#btn-delete").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: 'admin/wage/' + $("#frmDeleteTask input[name=id]").val(),
            dataType: 'json',
            success: function (data) {
                $("#frmDeleteTask .close").click();
                window.location.reload();
            },
            error: function (data) {
                console.log(data);
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

// function editTaskForm(task_id) {
//     $.ajax({
//         type: 'GET',
//         url: 'admin/wage/get/' + task_id,
//         success: function (data) {
//             $("#edit-error-bag").hide();
//             $("#frmEditTask input[name=task]").val(data.namefood);
//             $("#frmEditTask input[name=soluong]").val(data.task.qty);
//             $("#frmEditTask input[name=task_id]").val(data.task.detailID);
//             $('#editTaskModal').modal('show');
//         },
//         error: function (data) {
//             console.log(data);
//         }
//     });
// }

function deleteTaskForm(task_id) {
    $.ajax({
        type: 'GET',
        url: 'admin/wage/get/' + task_id,
        success: function (data) {
            $("#frmDeleteTask #delete-title").html("Delete this ?");
            $("#frmDeleteTask input[name=id]").val(task_id);
            $('#deleteTaskModal').modal('show');
        },
        error: function (data) {
            console.log(data);
            console.log('OK');
        }
    });
}
