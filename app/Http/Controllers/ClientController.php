<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function registerCopupon(Request $request)
    {
        $rules = array(
            'document'  => 'required',
            'coupon'    => 'required',
            'serie'     => 'required',
            'name'      => 'required',
            'last_name' => 'required',
            'phone'     => 'required',
            'email'     => 'required',
            'city'      => 'required',
            'direction' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $client = Client::where('document', $request->document)->first();

        $coupon = Coupon::where('coupon', $request->coupon)->first();
        if ($coupon) {
            return response()->json([
                'res' => false,
                'message' => 'Este cupón ya fue registrado'
            ], 200);
        } else {
            $newCoupon = new Coupon();
            if ($client) {
                $newCoupon->client_id = $client->id;
                $newCoupon->coupon = $request->coupon;
                $newCoupon->serie = $request->serie;
                if ($newCoupon->save()) {
                    return response()->json([
                        'res' => true,
                        'message' => 'Cupón registrado con éxito'
                    ], 200);
                } else {
                    return response()->json([
                        'res' => false,
                        'message' => 'Error al registrar el cupón'
                    ], 400);
                }
            } else {
                $newClient = new Client();
                $newClient->document    = $request->document;
                $newClient->name        = $request->name;
                $newClient->last_name   = $request->last_name;
                $newClient->phone       = $request->phone;
                $newClient->email       = $request->email;
                $newClient->city        = $request->city;
                $newClient->direction   = $request->direction;

                if ($newClient->save()) {
                    $client = Client::latest('id')->first();
                    $newCoupon->client_id = $client->id;
                    $newCoupon->coupon = $request->coupon;
                    $newCoupon->serie = $request->serie;
                    if ($newCoupon->save()) {
                        return response()->json([
                            'res' => true,
                            'message' => 'Cupón registrado con éxito'
                        ], 200);
                    } else {
                        return response()->json([
                            'res' => false,
                            'message' => 'Error al registrar el cupón'
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'res' => false,
                        'message' => 'Error al registrar el cupón'
                    ], 400);
                }
            }
        }
    }

    public function listClientsCoupon(Request $request)
    {
        $request["limit"] ? $limit = $request["limit"] : $limit = 10;
        $clients = Client::select('clients.*')
            ->where('clients.document', 'like', '%' . $request["search"] . '%')
            ->orwhere('clients.name', 'like', '%' . $request["search"] . '%')
            ->orwhere('clients.email', 'like', '%' . $request["search"] . '%')
            ->orwhere('clients.city', 'like', '%' . $request["search"] . '%')
            ->orwhere('clients.last_name', 'like', '%' . $request["search"] . '%')
            ->with('coupon')->paginate($limit);

        return response()->json([
            'res' => true,
            'data' => $clients,
        ]);
    }

    public function detailClientCoupon(Request $request)
    {

        $client = Client::where('id', $request["id"])->with('coupon')->first();

        return response()->json([
            'res' => true,
            'data' => $client,
        ]);
    }
}