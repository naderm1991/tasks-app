<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\View;

class DevicesController extends Controller
{
    public function index()
    {
//        $devices = [
//            'iPhone 3 Pro Max',
//            'iPhone 11 Pro',
//        ];
//
//        sort($devices, SORT_NATURAL);
//        return $devices;

        $devices = Device::query()
            ->orderByRaw('natural_sort(name)')
            ->paginate(10)
        ;

//        $sortedResult = $devices->getCollection()
//            ->sortBy('name',SORT_NATURAL)
//            ->values()
//        ;
//        $devices->setCollection($sortedResult);

        return View::make('devices.index', [
            'devices' => $devices,
        ]);
    }
}
