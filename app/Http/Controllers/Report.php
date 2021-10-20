<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reports;
use Illuminate\Http\Response;


class Report extends Controller
{
    public function commission()
    {
        $com_rep = Reports::select(
            'orders.invoice_number',
            'users.first_name',
            'users.id as uid',
            'users.referred_by',
            'users.last_name',
            'categories.name',
            'orders.order_date',
            'orders.id as oid',
            DB::raw('referred_count(users.id) as referred_count'),
            DB::raw('percentage_commission(referred_count(users.id)) as percentages'),
            DB::raw('order_total_count(orders.id) as order_total'),
            DB::raw('(order_total_count(orders.id)*percentage_commission(referred_count(users.id))) as commission')
            )
            // DB::raw('(SELECT COUNT(*) FROM users vt WHERE vt.referred_by=users.id) as referred_count'))
            ->join('user_category','user_category.user_id','=','users.id')
            ->join('categories','categories.id','=','user_category.category_id')
            ->join('orders','orders.purchaser_id','=','users.id')
            ->where('categories.id','=',2)
            ->skip(0)
            ->take(100)
            ->get();
        return view('commission_report',['data'=>$com_rep]);
    }
    public function rank()
    {
        $data = Reports::select(
                'users.first_name',
                DB::raw('order_total_sales_count(users.id) as total_sales')
            )->join('user_category','user_category.user_id','=','users.id')
            ->where('user_category.category_id','=',1)
            ->orderBy('total_sales','DESC')
            ->take(100)
            ->get();
        return view('rank_report',['data'=>$data,'i'=>0]);
    }
    public function show(Request $request){
        $id = $request->input('ID');
        $data = DB::select('SELECT products.id,products.price,order_items.qantity,products.name,(order_items.qantity*products.price) AS total FROM orders JOIN order_items on order_items.order_id=orders.id left join products on products.id=order_items.product_id where orders.id=?',[$id]);
        return response()->json($data, 200);
        // select *,order_items.qantity*products.price as total from orders join order_items on order_items.order_id=orders.id left join products on products.id=order_items.product_id where orders.id=220242;
    }
}
