<?php

namespace Modules\PaymentCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\PaymentCore\Actions\InitializePayment;
use Modules\PaymentCore\Http\Concerns\ResolvesApiContext;

class PaymentController extends Controller
{
    use ResolvesApiContext;
    public function __construct(
        protected InitializePayment $initializePayment
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request): JsonResponse {
            $response = $this->initializePayment->handle($this->getApiKey(), $request->all());

            return successResponse("Payment link", $response);
        });
    }
}
