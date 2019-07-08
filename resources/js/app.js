let taskToggleCompletion = function(id, completed) {
    let taskSelector = $('#task' + id);
    let updateTaskCompletion = completed === 0 ? 0 : 1;

    let data = {
        'action': 'update',
        'id': id,
        'task': $('#task' + id + '_text').text(),
        'createdAt': taskSelector.data('createdAt'),
        'isCompleted': updateTaskCompletion,
        'csrf': $('#csrftoken').val()
    };

    $.ajax({
        type: 'POST',
        url: 'index.php',
        data: data,
        success: function(){
            toggleCompletion(taskSelector, updateTaskCompletion);
        }
    });
};

let taskDelete = function(id) {
    let confirmation = confirm('¿Estás seguro de querer borrar esta tarea?');

    if(confirmation) {
        let data = {
            'action': 'delete',
            'id': id,
            'csrf': $('#csrftoken').val()
        };

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: data,
            success: function () {
                window.location.href = './';
            }
        });
    }
};

let toggleCompletion = function(taskSelector, updateTaskCompletion) {
    if(updateTaskCompletion === 1) {
        taskSelector.removeClass('list-group-item-warning').addClass('list-group-item-success');
        taskSelector.find('button').removeClass('btn-warning').addClass('btn-success');
        taskSelector.find('#check').prop('disabled', true);
        taskSelector.find('#uncheck').prop('disabled', false);

    } else {
        taskSelector.removeClass('list-group-item-success').addClass('list-group-item-warning');
        taskSelector.find('button').removeClass('btn-success').addClass('btn-warning');
        taskSelector.find('#check').prop('disabled', false);
        taskSelector.find('#uncheck').prop('disabled', true);
    }
};
