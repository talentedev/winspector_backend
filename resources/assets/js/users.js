$(function () {

    // Datatable initialize
    $('#users_table').DataTable({
        order: [0, 'asc'],
        columnDefs: [
            { targets: [0, 4, 7], orderable: false}
        ],
        paging: true,
        info: true
    });

    // Show edit modal
    $('.edit-user').click(function () {

        $('#user_modal').modal('show');
        initUserModal();

        let userInfo = $(this).data('user');

        $('#user_id').val(userInfo.id);
        $('#user_name').val(userInfo.name);
        $('#user_email').val(userInfo.email);
        $('#phone_number').val(userInfo.phone);
        $('#address').val(userInfo.address);
        $('#id_number').val(userInfo.id_number);
        $('#office_name').val(userInfo.office_name);
    });

    function initUserModal() {
        $('#user_id').val('');
        $('#user_name').val('');
        $('#user_email').val('');
        $('#phone_number').val('');
        $('#address').val('');
        $('#id_number').val('');
        $('#office_name').val('');
    }

    // Update user info
    $('#user_form').validator();

    $('#user_form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            console.log('form is not valid');
        } else {
            e.preventDefault();
            saveUserInfo();
        }
    });
    
    function saveUserInfo() {
        let id = $('#user_id').val();
        let url = 'users/' + id;
        let userData = {
            name: $('#user_name').val(),
            email: $('#user_email').val(),
            phone: $('#phone_number').val(),
            address: $('#address').val(),
            id_number: $('#id_number').val(),
            office_name: $('#office_name').val()
        };

        axios.put(url, userData, id)
            .then(function (response) {
                console.log(response.data);
                if (response.data.status == true) {
                    location.reload();
                } else {
                    console.log('Failed to update user info.');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    // Delete selected user
    var deleteUserId;
    $('.delete-user').click(function () {

        deleteUserId = $(this).data('id');

        $('#delete_confirm_modal').modal('show');
    });

    var modalDeleteConfirm = function(callback){

        $("#btn_delete_user").on("click", function(){
            callback(true, deleteUserId);
            $("#delete_confirm_modal").modal('hide');
            waitingDialog.show('Deleting user...');
        });
    };

    modalDeleteConfirm(function(confirm, id){
        if(confirm){
            var url = 'users/' + id;
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

    // Settings 
    $('#setting_form').validator();

    $('#setting_form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            console.log('form is not valid');
        } else {
            e.preventDefault();
            submit();
        }
    });

    function submit() {
        var data = {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val()
        }

        var url = 'change-setting';
        axios.post(url, data)
            .then(function (response) {
                if (response.data.status == true) {
                    location.reload();
                } else {
                    console.log('Failed to change the account info.')
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

})