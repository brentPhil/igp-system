$(document).ready(function() {
    // Function to fetch and update items
    function fetchItems() {
        var item_id = <?php echo json_encode($item_id); ?>; // Get the item_id from PHP

        // AJAX call to fetch items.php
        $.ajax({
          url: 'fetch_items.php',
          method: 'GET',
          data: { getid: item_id }, // Pass the item_id as a parameter
          success: function(response) {
            $('#items tbody').html(response); // Populate the table body with fetched data
          }
        });
    }

    // Initial fetch of items when the page loads
    fetchItems();

    // Function to handle row count select change
    $('#rowCountSelect').change(function () {
      var rowCount = parseInt($(this).val());

      // Show the selected number of rows
      $('#items tbody tr').hide();
      $('#items tbody tr:lt(' + rowCount + ')').show();
    });

    // Function to handle adding a new project
    $('#addItemButton').click(function() {
      $('#addItemModal').modal('show'); // Show the modal to add a new project
    });

    // On form submission (adding a project), handle AJAX request
    $('#additemForm').submit(function(event) {
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
                    text: 'The quantity has been added successfully.',
                    timer: 1000,
                    showConfirmButton: false
                }).then(function() {
                    $('#addItemModal').modal('hide'); // Hide the modal after successful submission
                    fetchItems();
                    $('#additemForm')[0].reset();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to add the quantity. Please try again.'
                });
            }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'There was an error while adding the quantity. Please try again.'
              });
          }
      });
    });

    setInterval(fetchItems, 1000);
});