<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reports;
use Illuminate\Http\Response;


class Report extends Controller
{
    public function commission()
    {
        // Date Interval
        $min = date("2001-9-11");
        $max = date("Y-m-d");
        $data = Reports::getCommissionReport($min,$max);
        return view('commission_report',['data'=>$data,'min'=>$min,'max'=>$max]);
    }
    public function filter(Request $request)
    {
        $min = $request->input('min_date');
        $max = $request->input('max_date');
        $data = Reports::getCommissionReport($min,$max);
        return view('commission_report',['data'=>$data,'min'=>$min,'max'=>$max]);
    }
    public function rank()
    {
        $data = Reports::getRank();
        return view('rank_report',['data'=>$data,'i'=>0]);
    }
    public function show(Request $request){
        $id = $request->input('ID');
        $data = Reports::getOrderList($id);
        return response()->json($data, 200);
    }
}
