<?php

use App\Enum\ResponseStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

function successResponse(string $message, ?array $data = [], Response|int $response_code = Response::HTTP_OK, ResponseStatusEnum $status = ResponseStatusEnum::OK): JsonResponse
{
    return response()->json(
        [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],
        $response_code
    );
}

function failureResponse(string $message, array|string|null $error = null, Response|int $response_code = Response::HTTP_BAD_REQUEST, ResponseStatusEnum $status = ResponseStatusEnum::error): JsonResponse
{
    return response()->json(
        [
            'status' => $status,
            'message' => $message,
            'error' => $error
        ],
        $response_code
    );
}
function paginatedResponse(string $message, array|Collection $data, Response|int $response_code = Response::HTTP_OK, ResponseStatusEnum $status = ResponseStatusEnum::OK): JsonResponse
{
    return response()->json(
        [
            'status' => $status,
            'message' => $message,
            ...$data
        ],
        $response_code
    );
}
