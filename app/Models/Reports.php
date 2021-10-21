<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reports extends Model
{
    use HasFactory;
    
    protected $table = 'users';

    public function getCommissionReport($min,$max)
    {
        $result = Reports::select(
            'orders.invoice_number',
            'users.enrolled_date',
            'users.first_name',
            'users.id as uid',
            'users.last_name',
            'categories.name',
            'orders.order_date',
            'orders.id as oid',
            DB::raw('distributor_name(users.id) as dist_name'),
            DB::raw("referred_count_by_date(users.id,'$min','$max') as referred_count"),
            DB::raw('percentage_commission(referred_count(users.id)) as percentages'),
            DB::raw('order_total_count(orders.id) as order_total'),
            DB::raw('(order_total_count(orders.id)*percentage_commission(referred_count(users.id))) as commission')
        )
        // DB::raw('(SELECT COUNT(*) FROM users vt WHERE vt.referred_by=users.id) as referred_count'))
        ->join('user_category','user_category.user_id','=','users.id')
        ->join('categories','categories.id','=','user_category.category_id')
        ->join('orders','orders.purchaser_id','=','users.id')
        // ->where('categories.id','=',2)
        ->havingRaw('users.enrolled_date BETWEEN ? AND ?',[$min,$max])
        ->skip(0)
        ->take(100)
        ->get();
        return $result;
    }

    public function getRank()
    {
        $result = Reports::select(
            'users.first_name',
            DB::raw('order_total_sales_count(users.id) as total_sales')
        )->join('user_category','user_category.user_id','=','users.id')
        ->where('user_category.category_id','=',1)
        ->orderBy('total_sales','DESC')
        ->take(100)
        ->get();
        return $result;
    }

    public function getOrderList($id)
    {
        $result = DB::table('orders')
                    ->selectRaw('
                        products.id,
                        products.price,
                        order_items.qantity,
                        products.name,
                        (order_items.qantity*products.price) AS total'
                    )
                    ->join('order_items', 'order_items.order_id','=','orders.id')
                    ->leftJoin('products', 'products.id','=','order_items.product_id')
                    ->where('orders.id','=',$id)
                    ->get();
        return $result;
    }
}
