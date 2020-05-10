<?php

namespace App\Traits;

trait ApiResponse {
    public function response200($data)
    {
        return response($data, 200);
    }

    public function response422($data)
    {
        return response([
            'errors' => $data
        ], 422);
    }

    public function response401()
    {
        return response([
            'errors' => 'Unauthenticated.'
        ], 401);
    }

    public function response403()
    {
        return response([
            'errors' => 'Forbidden.'
        ], 403);
    }

    public function response404()
    {
        return response([
            'errors' => 'Not found.'
        ], 404);
    }
}
