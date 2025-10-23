<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::user()->id)->firstOrFail();
        if($order) {
        $orderItems = OrderItem::where('order_id', $order->id)->orderBy('id')->paginate(10);
        $transaction  = Transaction::where('order_id', $order->id)->first();
        return view('user.order-details', compact('order', 'orderItems', 'transaction'));
        }else{
            return redirect()->route('login')->with('error', 'Order not found.');
        }
        
    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 'Cancelled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return redirect()->back()->with('status', 'Order cancelled successfully.');
    }

}
