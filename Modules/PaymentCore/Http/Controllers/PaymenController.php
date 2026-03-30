<?php

namespace Modules\PaymentCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PaymentCore\Actions\InitializePayment;

class PaymentController extends Controller
{
    public function __construct(
        protected InitializePayment $initializePayment
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('paymentcore::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function() use ($request){
            $response = $this->initializePayment->handle($request->all());
            return response()->json($response);
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('paymentcore::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('paymentcore::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
