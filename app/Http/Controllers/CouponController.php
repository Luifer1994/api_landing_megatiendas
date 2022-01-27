<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function cuoponForDay()
    {
        $query = Coupon::select('id', 'created_at')
            ->orderBy('created_at', 'ASC')
            ->get()

            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });
        return $query;
    }

    public function cuoponForCity()
    {
        $client  =  Coupon::query()
            ->join('clients', 'clients.id', '=', 'coupons.client_id')
            ->selectRaw('count(coupons.id) as count, clients.city')
            ->groupBy('clients.city')
            ->get();

        return $client;
    }

    public function topClientNumberCoupon()
    {
        $return = Client::select('document', 'name', 'last_name')
            ->withCount('coupon')->orderBy('coupon_count', 'desc')->take(10)->get();
        return $return;
    }

    public function export()
    {
        $coupon = Coupon::select(
            'coupons.coupon',
            'coupons.serie',
            DB::raw("DATE_FORMAT(coupons.created_at,'%Y-%m-%d') as date"),
            'clients.document',
            'clients.name',
            'clients.last_name',
            'clients.phone',
            'clients.email',
            'clients.city'
        )->join('clients', 'clients.id', 'coupons.client_id')->orderBy('clients.document')->get();
        return $coupon;
    }
}