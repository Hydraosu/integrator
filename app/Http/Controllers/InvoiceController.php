<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{

    public $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);

        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                      <i class="fa fa-lg fa-fw fa-trash"></i>
                  </button>';
        $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                       <i class="fa fa-lg fa-fw fa-eye"></i>
                   </button>';

        $config = [
            'data' => [
            ],
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];

        $invoices = DB::table('invoices')->get();

        foreach ($invoices as $invoice) {
            unset($invoice->id);

            $config['data'][] = $invoice;
        }

        $heads = [
            'Fullnumber',
            ['label' => 'Date', 'width' => 40],
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        return view('/invoices/index',
            [
                'config' => $config,
                'heads' => $heads
            ]
        );
    }

    public function importWfirma() {

        $response = Http::withBasicAuth('piotr.malinowski@wfirma.pl', 'qweasdzxc')->get('http://api2.wf.localhost/invoices/find?outputFormat=json', []);
        $xml = simplexml_load_string($response->body());
        $invoicesCounter = 0;

        foreach ($xml[0]->invoices->invoice as $invoice) {
            if (DB::table('invoices')->where('invoice_number', $invoice->fullnumber)->doesntExist()) {
                DB::table('invoices')
                    ->insert(
                        [
                            'invoice_number' => $invoice->fullnumber,
                            'date' => $invoice->date
                        ]
                    );

                $invoicesCounter += 1;
            }
        }



        return redirect()->action([InvoiceController::class, 'index'])->with(['response' => 'Zaimportowano faktur: ' . $invoicesCounter]);
    }
}
