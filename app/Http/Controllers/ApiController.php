<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Image;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function service_list()
    {
        $services = Service::with('image')->get();

        return response()->json([
            'success' => true,
            'message' => 'All services fetched successfully.',
            'data' => $services,
        ], 200);
    }
}
