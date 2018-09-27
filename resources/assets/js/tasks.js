$(function () {

    // Datatable initialize
    $('#tasks_table').DataTable({
        order: [0, 'asc'],
        columnDefs: [
            { targets: [0, 9], orderable: false}
        ],
        paging: true,
        info: true
    });


    // Delete selected task
    var deleteTaskId;
    $('.delete-task').click(function () {

        deleteTaskId = $(this).data('id');

        $('#delete_confirm_modal').modal('show');
    });

    // Event when page is updated
    $('#tasks_table').on( 'draw.dt', function () {
        $('.delete-task').click(function () {
            deleteTaskId = $(this).data('id');
            $('#delete_confirm_modal').modal('show');
        });
    } );

    var modalDeleteConfirm = function(callback){

        $("#btn_delete_task").on("click", function(){
            callback(true, deleteTaskId);
            $("#delete_confirm_modal").modal('hide');
            waitingDialog.show('Deleting job...');
        });
    };

    modalDeleteConfirm(function(confirm, id){
        if(confirm){
            var url = 'tasks/' + id;
            axios.delete(url)
                .then(function (response) {
                    if (response.data.status == true) {
                        waitingDialog.hide();
                        location.reload();
                    } else {
                        waitingDialog.hide();
                    }
                })
                .catch(function (error) {
                    waitingDialog.hide();
                });
        }else{
            console.log('The operation to delete was canceled by user!')
        }
    });
})