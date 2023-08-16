<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'PHARMA WHOLESALE TERM2$Sales Invoice Line';
    protected $connection = 'odbc';

    public function getInvoiceDetails($documentNumber)
    {
        $connect = odbc_connect('WSPHarma_Term2', 'super', 'fsasya1941');
        $table_query = "SELECT 
            LINE_INVOICE.[Quantity] as qty,
            LINE_INVOICE.[Unit of Measure] as uom,
            LINE_INVOICE.[No_] as No,
            LINE_INVOICE.[Description] as esc,
            -- LINE_INVOICE.[Lot No_] as lot_no,
            LINE_INVOICE.[Expiry Date] as exp_date,
            -- LINE_INVOICE.[Deal] as deal,
            LINE_INVOICE.[Line Discount %] as line_percent,
            LINE_INVOICE.[Unit Price] as price,
            LINE_INVOICE.[Net Price] as net_price,
            LINE_INVOICE.[Line Discount Amount] as lda,
            LINE_INVOICE.[Amount] as amount,
            LINE_INVOICE.[Amount Including VAT] as vat_amount,
            HEADER_INVOICE.[Bill-to Name] as b_name,
            HEADER_INVOICE.[Bill-to Address] as b_address,
            HEADER_INVOICE.[Payment Terms Code] as payment_code,
            HEADER_INVOICE.[Due Date] as due_date
        FROM 
            [PHARMA WHOLESALE TERM2\$Sales Invoice Line] AS LINE_INVOICE
        JOIN
            [PHARMA WHOLESALE TERM2\$Sales Invoice Header] AS HEADER_INVOICE
        ON 
            LINE_INVOICE.[Document No_] = HEADER_INVOICE.[No_]
        WHERE 
            LINE_INVOICE.[Document No_] = ?";


        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($documentNumber));
        
        $invoiceDetails = [];
        while ($row = odbc_fetch_array($result)) {
            $inv["b_name"] = $row["b_name"];
            $inv["b_address"] = $row["b_address"];
            $inv["payment_code"] = $row["payment_code"];
            $inv["due_date"] = Carbon::parse($row["due_date"])->format('m/d/Y');

            $inv["qty"] = rtrim(number_format($row["qty"]));
            $inv["uom"] = $row["uom"];
            $inv["No"] = $row["No"];
            $inv["esc"] = $row["esc"];
            // $inv["lot_no"] = $row["lot_no"];
            $inv["exp_date"] = Carbon::parse($row["exp_date"])->format('m/d/Y');
            // $inv["deal"] = $row["deal"];
            $inv["line_percent"] = number_format($row["line_percent"], 2);
            $inv["price"] = number_format($row["price"], 2);
            $inv["net_price"] = rtrim(number_format($row["net_price"], 0));
            $inv["lda"] = rtrim(number_format($row["lda"], 0));
            $inv["amount"] = rtrim(number_format($row["amount"], 2));
            $inv["vat_amount"] = rtrim(number_format($row["vat_amount"], 2));
           
            $invoiceDetails[] = $inv;
        }
        return $invoiceDetails;
    }
}














    // public function getInvoiceDetails($documentNumber)
    // {
    //     $connect = odbc_connect('WSPHarma_Term2', 'super', 'fsasya1941');

    //     $table_query = "SELECT 
    //         [Quantity] as qty,
    //         [Unit of Measure] as uom,
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
        
    //     $invoiceDetails = [];
    //     while ($row = odbc_fetch_array($result)) {
    //         $inv["qty"] =  rtrim(number_format($row["qty"]));
    //         $inv["uom"] = $row["uom"];
    //         $inv["No"] = $row["No"];
    //         $inv["esc"] = $row["esc"];
    //         $inv["lot_no"] = $row["lot_no"];
    //         $expDate = Carbon::parse($row["exp_date"])->format('m/d/Y');
    //         $inv["exp_date"] = $expDate;
    //         $inv["deal"] = $row["deal"];
    //         $inv["line_percent"] = number_format($row["line_percent"], 2);
    //         $inv["price"] = number_format($row["price"], 2);
    //         $inv["net_price"] =  rtrim(number_format($row["net_price"], 0));
    //         $inv["lda"] = rtrim(number_format($row["lda"], 0));
    //         $inv["amount"] = rtrim(number_format($row["amount"], 2));
    //         $invoiceDetails[] = $inv;
    //     }
    //     return $invoiceDetails;
    // }

