<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Invoice;

class InvoiceController extends Controller
{

    public function getInvoiceDetails(Request $request)
    {
        $documentNumber = $request->input('documentNumber');
        $invoiceDetails = Invoice::getInvoiceDetails($documentNumber);

        // usort($invoiceDetails, function ($a, $b) {
        //     return $a['qty'] - $b['qty'];
        // });

        usort($invoiceDetails, function ($a, $b) {
            if (is_numeric($a['qty']) && is_numeric($b['qty'])) {
                return $a['qty'] - $b['qty'];
            } else {
                // Handle the case where one or both values are non-numeric
                // For example, you might want to place non-numeric values at the end
                return is_numeric($a['qty']) ? -1 : (is_numeric($b['qty']) ? 1 : 0);
            }
        });
        return response()->json(['invoiceDetails' => $invoiceDetails]);
    }
}



















    // public function getInvoiceDetails($documentNumber) 
    // {

    //     $documentNumber = $request->input('documentNumber');
    //     $connect = odbc_connect('WSPHarma_Term2', 'super', 'fsasya1941');

    //     $table_query = "SELECT 
    //         [Quantity] as qty,
    //         [Unit of Measure] as oum,
    //         [No_] as No,
    //         [Description] as esc,
    //         [Lot No_] as lot_no,
    //         [Expiry Date] as exp_date,
    //         [Deal] as deal,
    //         [Line Discount %] as line_percent,
    //         [Unit Price] as price,
    //         [Net Price] as net_price,
    //         [Line Discount Amount] as lda,
    //         [Line Amount] as amount FROM [PHARMA WHOLESALE TERM2\$Sales Invoice Line] WHERE [Document No_] = ?";

    //     $result = odbc_prepare($connect, $table_query);
    //     odbc_execute($result, array($documentNumber));
        
    //     $invoiceDetails = array();
    //     while ($row = odbc_fetch_array($result)) {
    //         $inv["qty"] =  rtrim(number_format($row["qty"]));
    //         $inv["oum"] = $row["oum"];
    //         $inv["No"] = $row["No"];
    //         $inv["esc"] = $row["esc"];
    //         $inv["lot_no"] = $row["lot_no"];
    //         $expDate = Carbon::parse($row["exp_date"])->format('m-d-Y');
    //         $inv["exp_date"] = $expDate;
    //         $inv["deal"] = $row["deal"];
    //         $inv["line_percent"] = number_format($row["line_percent"], 2);
    //         $inv["price"] = number_format($row["price"], 2);
    //         $inv["net_price"] =  rtrim(number_format($row["net_price"], 0));
    //         $inv["lda"] = rtrim(number_format($row["lda"], 0));
    //         $inv["amount"] = rtrim(number_format($row["amount"], 2));
    //         $invoiceDetails[] = $inv;
    //     }

    //     odbc_free_result($result);
    //     odbc_close($connect);

    //     return response()->json(['invoiceDetails' => $invoiceDetails]);
    // }


