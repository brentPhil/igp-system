$(document).ready(function() {
    // Function to fetch and update projects
    function fetchProjects() {
      // Perform AJAX request to fetch projects
      $.ajax({
        url: 'fetch_projects.php', // The PHP file to handle the request
        type: 'GET',
        success: function (response) {
          $('#projects tbody').html(response); // Update the table body with new data
        }
      });
    }

    // Initial fetch of projects when the page loads
    fetchProjects();

    // Function to handle row count select change
    $('#rowCountSelect').change(function () {
      var rowCount = parseInt($(this).val());

      // Show the selected number of rows
      $('#projects tbody tr').hide();
      $('#projects tbody tr:lt(' + rowCount + ')').show();
    });

    // Function to handle adding a new project
    $('#addProjectButton').click(function() {
      $('#addProjectModal').modal('show'); // Show the modal to add a new project
    });

    // On form submission (adding a project), handle AJAX request
    $('#addprojectForm').submit(function(event) {
      event.preventDefault(); // Prevent the default form submission

      $.ajax({
          url: $(this).attr('action'), // The form's action URL
          type: $(this).attr('method'), // The form's method (POST)
          data: $(this).serialize(), // Form data
          success: function(response) {
            if (response.trim() === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your project has been added successfully.',
                    timer: 1000,
                    showConfirmButton: false
                }).then(function() {
                    $('#addProjectModal').modal('hide'); // Hide the modal after successful submission
                    fetchProjects();
                    $('#addprojectForm')[0].reset();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to add the project. Please try again.'
                });
            }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'There was an error while adding the project. Please try again.'
              });
          }
      });
    });

    // Function to handle delete button click
    $(document).on("click", ".deleteBtn", function() {
      var projectId = $(this).data("id");

      Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this project!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // AJAX request to delete the project
          $.ajax({
            url: 'include/delete_project.php', // Create delete_project.php to handle deletion
            type: 'GET',
            data: { id: projectId },
            success: function(response) {
              Swal.fire({
                title: 'Deleted!',
                text: 'Your project has been deleted.',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000
              }).then(function() {
                fetchProjects(); // Refresh the projects table
              });
            }
          });
        }
      });
    });

    // Function to handle view button click
    $(document).on("click", ".viewBtn", function() {
      var projectId = $(this).data("id");

      // AJAX request to fetch item table for the selected project ID
      $.ajax({
        url: 'fetch_items.php', // PHP file to handle fetching items
        type: 'POST',
        data: { projectId: projectId }, // Send the project ID
        success: function(response) {
          $('#itemTableContainer').html(response); // Display the item table in the container
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });

    setInterval(fetchProjects, 1000);
});