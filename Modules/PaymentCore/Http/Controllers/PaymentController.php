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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function() use ($request){
            $response = $this->initializePayment->handle($request->all());
            return response()->json($response);
        });
    }
}
