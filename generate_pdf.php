<?php
require_once('tcpdf/tcpdf.php'); // Include TCPDF library
$item_id = $_GET['getid'];
// Create a new TCPDF object
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Items Report');
$pdf->SetSubject('Items Report');
$pdf->SetKeywords('Items, Report');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Fetch items and create a table in the PDF
include 'include/config.php';

$result = mysqli_query($conn, "SELECT *, projects.name as itemname, items.date as idate FROM items INNER JOIN projects ON items.project_id = projects.id WHERE items.project_id = $item_id ORDER BY name ASC");

// Initialize the $itemName variable
$itemName = "";

$html = '';

if ($result->num_rows > 0) {
    // Fetch the first row to get the current item name
    $row = $result->fetch_assoc();
    $itemName = $row["itemname"];

    // Add spacing between rows using CSS
    $html .= '<style>
                table {
                    border-spacing: 0 5px; /* Change the second value (5px) for the desired spacing */
                }
                th, td {
                    padding: 5px; /* Adjust padding as needed */
                }
             </style>';

    // Modify the title to display the current item name
    $html .= '<h1>' . htmlentities("{$itemName} Item Report") . '</h1>';

    $html .= '<table>
                <tr>
                    <th>Date</th>
                    <th>Quantity Added</th>
                </tr>';

    do {
        $date = date('F j, Y', strtotime($row["idate"]));
        $quantityAdded = $row["qty_added"];

        $html .= '<tr>
                    <td>' . $date . '</td>
                    <td>' . $quantityAdded . '</td>
                  </tr>';
    } while ($row = $result->fetch_assoc());

    $html .= '</table>';
} else {
    $html .= '<p>No results</p>';
}

// Output the HTML content into PDF
$pdf->writeHTML($html, true, false, true, false, '');

header('Content-Type: application/pdf');
$pdf->Output();

mysqli_close($conn); // Close the database connection
?>
