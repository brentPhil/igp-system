// Handle delete button click
$('.deleteBtnStall').on('click', function() {
    // Get the user ID from the data attribute
    var stallId = $(this).data('stall_id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this stall!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request to delete the stall
            $.ajax({
                url: 'include/delete_stall.php',
                type: 'POST',
                data: { stall_id: stallId },
                success: function(response) {
                    // Show success message with SweetAlert2
                    Swal.fire('Deleted!', 'Stall has been deleted.', 'success').then(function(){
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Failed to delete user.', 'error').then(function(){
                        location.reload();
                    });
                }
            });
        }
    });
});

// Handle delete button click
$('.deleteBtnTenant').on('click', function() {
    // Get the user ID from the data attribute
    var tenantId = $(this).data('tenant_id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this tenant!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request to delete the stall
            $.ajax({
                url: 'include/delete_tenant.php',
                type: 'POST',
                data: { tenant_id: tenantId },
                success: function(response) {
                    // Show success message with SweetAlert2
                    Swal.fire('Deleted!', 'A Tenant has been deleted.', 'success').then(function(){
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Failed to delete Tenant.', 'error').then(function(){
                        location.reload();
                    });
                }
            });
        }
    });
});

// Handle delete button click
$('.deleteBtnUser').on('click', function() {
    // Get the user ID from the data attribute
    var userId = $(this).data('user_id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request to delete the stall
            $.ajax({
                url: 'include/delete_profile.php',
                type: 'POST',
                data: { user_id: userId },
                success: function(response) {
                    // Show success message with SweetAlert2
                    Swal.fire('Deleted!', 'A User has been deleted.', 'success').then(function(){
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Failed to delete user.', 'error').then(function(){
                        location.reload();
                    });
                }
            });
        }
    });
});

// Handle delete button click
$('.deleteBtnBill').on('click', function() {
    // Get the user ID from the data attribute
    var billingId = $(this).data('billing_id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Bill!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request to delete the stall
            $.ajax({
                url: 'include/delete_bill.php',
                type: 'POST',
                data: { billing_id: billingId },
                success: function(response) {
                    // Show success message with SweetAlert2
                    Swal.fire('Deleted!', 'A Bill has been deleted.', 'success').then(function(){
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Failed to delete bill.', 'error').then(function(){
                        location.reload();
                    });
                }
            });
        }
    });
});

// Handle delete button click
$('.deleteBtnReport').on('click', function() {
    // Get the user ID from the data attribute
    var reportId = $(this).data('id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this report!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request to delete the stall
            $.ajax({
                url: 'include/delete_report.php',
                type: 'POST',
                data: { id: reportId },
                success: function(response) {
                    // Show success message with SweetAlert2
                    Swal.fire('Deleted!', 'A Report has been deleted.', 'success').then(function(){
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Failed to delete Report.', 'error').then(function(){
                        location.reload();
                    });
                }
            });
        }
    });
});
