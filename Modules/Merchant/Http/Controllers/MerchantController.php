<?php

namespace Modules\Merchant\Http\Controllers;

use App\Action\GetAccessToken;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Modules\Merchant\Actions\CreateMerchant;
use Modules\Merchant\DTOs\MerchantData;
use Modules\Merchant\Enums\Enum\GrantType;
use Symfony\Component\HttpFoundation\Response;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('merchant::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateMerchant $createMerchant)
    {
        return DB::transaction(function () use ($request, $createMerchant) {
            $merchant = $createMerchant->handle($request->all());

            $tokens = app(GetAccessToken::class)->handle(['email' => $request->email, 'password' => $request->password, 'grant_type' => GrantType::PASSWORD->value]);

            $userData = MerchantData::from($merchant)->additional(['access_token' => $tokens['access_token'], 'refresh_token' => $tokens['refresh_token'], 'expires_in' => $tokens['expires_in']]);

            return successResponse('Merchant created successfully', $userData->toArray(), Response::HTTP_CREATED);
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('merchant::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('merchant::edit');
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
