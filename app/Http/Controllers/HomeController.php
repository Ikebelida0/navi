<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('invoice.invoice_search');
    }
}

















    // public function getInv(){

    //     $connect = odbc_connect('WSPHarma_Term2', 'super', 'fsasya1941');

    //     $table_query = "SELECT [Line No_] as line, [Sell-to Customer No_] as cust, [Type] as type FROM [PHARMA WHOLESALE TERM2\$Sales Invoice Line] WHERE [Document No_] = ?";
          
    //     $result = odbc_prepare($connect, $table_query);
    //     odbc_execute($result, array('PWS2-SPIN00000002'));
          
    //     $invoice = array();

    //     while ($row = odbc_fetch_array($result)) {
    //         $inv["line"] = $row["line"];
    //         $inv["cust"] = $row["cust"];
    //         $inv["type"] = $row["type"];
    //         $invoice[] = $inv;
    //     }

    //     odbc_free_result($result);
    //     odbc_close($connect);

    //     var_dump($invoice);

    // }

