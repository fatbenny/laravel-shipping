<?php

namespace PangPang\Shipping\Controllers;
use PangPang\Shipping\Facades\Shipping;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class FedExTestController extends Controller
{

    public function index()
    {
        return view("shipping::fedex.index");
    }

    public function createLabel(Request $request)
    {
        $data = $request->all();
        $result =  Shipping::driver('fedex')->createShipment([
            "shipper" => $data['shipper'],
            "recipient" => $data['recipient'],
            "requested" => $data["requested"],
            "packages" => $data['packages'],
            "labelResponseOptions" => $data["labelResponseOptions"],
            "signature" => $data["signature"],
        ]);
        return response()->json($result);
    }

}