<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Jobs\ImportInstallments;
use App\Models\Installment;
use App\Models\InstallmentLedger;
use App\Models\Location;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'rows'                      => ['required', 'array'],
                'rows.*.sales_order_no'     =>  ['required']
            ],
            [
                'rows.*.sales_order_no.required'    =>  'SO number is required for each accounts.PLease check the uploaded file'
            ]
        );

        foreach(array_chunk($request->rows, 500) as $chunk)
        {
            ImportInstallments::dispatch($chunk, Auth::user()->name);
        }

        return response()->json(
            [
                'message' => 'Installment generation completed successfully.'
            ]
            , 200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Installment $installment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installment $installment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Installment $installment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Installment $installment)
    {
        //
    }
}
