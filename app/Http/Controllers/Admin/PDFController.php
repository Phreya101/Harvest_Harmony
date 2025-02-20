<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{

    public function generatePDF(Request $request)
    {
        // Validate form input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        // Convert dates to Carbon instances
        $fromDate = Carbon::parse($request->input('from'))->startOfDay();
        $toDate = Carbon::parse($request->input('to'))->endOfDay();

        $formattedFromDate = $fromDate->format('F d, Y');
        $formattedToDate = $toDate->format('F d, Y');

        // Fetch records from the 'events' table based on date range
        // Fetch records with joins
        $events = DB::table('events')
            ->join('equipments', 'events.equipment_id', '=', 'equipments.id')
            ->join('users', 'events.farmer_id', '=', 'users.id')
            ->select(
                'events.id',
                'events.start_date',
                'events.end_date',
                'equipments.name as equipment_name',
                'users.name as farmer_name'
            )
            ->whereBetween('events.created_at', [$fromDate, $toDate])
            ->get();

        // Include TCPDF
        require_once public_path('tcpdf-main/tcpdf.php');

        // Create PDF instance
        $pdf = new \TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Laravel App');
        $pdf->SetTitle('Harvest');
        $pdf->SetHeaderData('', 0, 'Scheduled Equipments Report', '');

        // Add a page
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Build the HTML table
        $html = "
   <style>
        body {
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .date-range {
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>

    <p class='date-range'><strong>From:</strong> $formattedFromDate &nbsp;&nbsp;&nbsp; <strong>To:</strong> $formattedToDate</p>
    <br>
    <table>
        <tr>
            <th>Farmer Name</th>
            <th>Equipment</th>
            <th>From</th>
            <th>To</th>
        </tr>
";

        // Loop through events and add rows
        foreach ($events as $event) {
            $from = Carbon::parse($event->start_date)
                ->setTimezone('Asia/Manila')
                ->format('F d, Y h:i A');

            $to = Carbon::parse($event->end_date)
                ->setTimezone('Asia/Manila')
                ->format('F d, Y h:i A');

            $html .= "
        <tr>
            <td>{$event->farmer_name}</td>
            <td>{$event->equipment_name}</td>
            <td>{$from}</td>
            <td>{$to}</td>
        </tr>
    ";
        }

        $html .= "</table>";

        // Write the HTML to PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Download the PDF
        $pdf->Output('event_report.pdf', 'D'); // 'D' = Download
    }
}
