<?php
session_start();
require_once('tcpdf/tcpdf.php');
include 'include/config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM reports INNER JOIN stalls ON reports.billing_stall = stalls.stall_id INNER JOIN tenant ON tenant.stall_id = stalls.stall_id INNER JOIN users ON tenant.user = users.user_id WHERE id = '$id'";
$result = $conn->query($sql);

$stall = '';

while ($row = mysqli_fetch_array($result)) {
    $date_pay = date('F d, Y', strtotime($row['date_pay']));
    $date_pay2 = date('F Y', strtotime($row['date_pay']));
    $prevBillingSQL = "SELECT * FROM reports WHERE billing_stall = '{$row['billing_stall']}' AND id < '$id' ORDER BY date_pay DESC LIMIT 1";
    $prevBillingResult = $conn->query($prevBillingSQL);
    $prevBillingRow = mysqli_fetch_array($prevBillingResult);
    $stall = $row['billing_stall'];

    $prevRemainingAmount = ($prevBillingRow) ? ($prevBillingRow['amount'] - $prevBillingRow['amount_paid']) : 0;

    // Adjust the remaining amount by subtracting any excess payment from the current billing
    $excessPayment = max(0, $row['amount_paid'] - $row['amount']);

    // If remaining amount is negative, set it to 0 (fully paid)
//    $remainingAmount = max(0, $remainingAmount);

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);

    $pdf->SetCreator('TCPDF');
    $pdf->SetAuthor('' . $_SESSION['first_name'] . $_SESSION['middle'] . $_SESSION['last_name']);
    $pdf->SetTitle('Bill Report of ' . $row['stall_name']);








    $pdf->AddPage();








    $imagePath = 'images/evsu_logo.png';
    $pdf->Image($imagePath, 25, 10, 15, 0, '', '', '', false, 300, '', false, false, 0);

    $pdf->Cell(0, 5, '                            Republic of the Philippines', 0, 1);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 5, '                            EASTERN VISAYAS STATE UNIVERSITY - Tanauan Campus', 0, 1);
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 5, '                            San Miguel, Tanauan Leyte', 0, 1);
    $pdf->SetFont('helvetica', 12);

    $pdf->Ln(10);
    $pdf->Cell(0, 5, '        TO            :          ' . $row['stall_name'] .' /' . $row['first_name'] .' '. $row['middle'] .'. '. $row['last_name'] . '', 0, 1);
    $pdf->Cell(0, 5, '        DATE       :          ' . $date_pay, 0, 1);
    $pdf->Cell(0, 5, '        FROM      :          Office of the Income Generated Project', 0, 1);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 5, '        RE            :          BILLING STATEMENT AS OF  ' . $date_pay2, 0, 1);
    $pdf->Ln(5);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    $pdf->Ln(5);
    $pdf->Cell(0, 5, '        MONTHLY BILL', 0, 1);
    $pdf->SetFont('helvetica', 12);
    $pdf->Ln(3);
    $pdf->Cell(0, 5, '        Monthly Rental                                                                                      ' . number_format($row['rent_bal'], 2), 0, 1);
    $pdf->Cell(0, 5, '        Electricity Bill                                                                                         ' . number_format($row['electricity_bal'], 2), 0, 1);
    $pdf->Cell(0, 5, '        Water Bill                                                                                               ' . number_format($row['water_bal'], 2), 0, 1);
    $pdf->Cell(0, 5, '        Other Bill                                                                                                ' . number_format($row['other_bal'], 2), 0, 1);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 5, '        Total Current Monthly Bill                                                                   ' . number_format($row['amount'], 2), 0, 1);
    if ($excessPayment > 0) {
        $pdf->Cell(0, 5, '        EXCESS PAYMENT FROM CURRENT BILLING                                                                   ' . number_format($excessPayment, 2), 0, 1);
    }

    $pdf->Ln(5);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    $pdf->Ln(5);
    $totalRemainingAmount = 0;
    $billingsResult = $conn->query("SELECT * FROM reports WHERE billing_stall = '$stall' AND date_approved < '{$row['date_approved']}'");

    while ($billing = mysqli_fetch_array($billingsResult)) {
        $remainingAmount = $billing['amount'] - $billing   ['amount_paid'];
        $totalRemainingAmount += $remainingAmount;

        $pdf->SetFont('helvetica', 12);
        $pdf->Cell(0, 5, '        Remaining Balance of (' . date('F d, Y', strtotime($billing['date_approved'])) . ')                                                  ' . number_format($remainingAmount, 2), 0, 1);
    }

    $totalRemaining = $totalRemainingAmount + $row['amount'];

    $pdf->Ln(5);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    if ($totalRemaining == 0) {
        $pdf->Cell(0, 5, '        BALANCE                                                                                                 Fully Paid', 0, 1);
    } else {
        $pdf->Cell(0, 5, '        Total Outstanding Balance as of (' . date('F d, Y') . ')                             ' . number_format($totalRemaining, 2), 0, 1);
    }

    $pdf->SetFont('helvetica', 12);
}

$pdf->Output('sample.pdf', 'I');
