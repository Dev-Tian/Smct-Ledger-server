<?php

namespace App\Http\Controllers;

use App\Jobs\ImportPayments;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'rows.*.document_number'    => ['required'],
                'rows.*.or_number'          => ['required'],
            ],
            [
                'rows.*.document_number.required'       =>  'Document number is required for each accounts.PLease check the uploaded file',
                'rows.*.or_number.required'             =>  'OR number is required for each accounts.PLease check the uploaded file',
            ]
        );

        $file_name = $request->file_name;

        $chunks = array_chunk($request->rows, 500);

        foreach ($chunks as $index => $chunk) {
            $batchNumber = $index + 1;

            $startRow = ($index * 500) + 1;
            $endRow = $startRow + count($chunk) - 1;

            $batch = "{$batchNumber} [{$startRow}-{$endRow}]";

            ImportPayments::dispatch(
                $batch,
                $chunk,
                Auth::user(),
                $file_name
            );
        }

        return response()->json(
            [
                'message' => 'Payment import is in progress. Please check the logs to monitor the upload status.'
            ]
            ,200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
