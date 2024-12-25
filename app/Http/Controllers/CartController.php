<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF; // Ensure this line is present
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $totalCart = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        return view('cart.index', compact('cartItems', 'totalCart'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity + 1 > $product->quantity) {
                return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ.');
            }
            $cartItem->increment('quantity');
        } else {
            if ($product->quantity < 1) {
                return redirect()->back()->with('error', 'Sản phẩm đã hết hàng.');
            }
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function remove($productId)
    {
        Cart::where('user_id', auth()->id())->where('product_id', $productId)->delete();

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function updateAll(Request $request)
    {
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $productId => $quantity) {
            $cartItem = Cart::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $product = Product::find($productId);
                if ($product && $quantity <= $product->quantity) {
                    $cartItem->update(['quantity' => $quantity]);
                } else {
                    return redirect()->route('cart.index')->with('error', 'Số lượng sản phẩm ' . $product->name . ' không đủ.');
                }
            }
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    public function checkout(Order $order, Request $request)
    {
        $cartItems = $order->orderDetails;
        $totalPrice = $order->total_price;
        $orderTime = $order->created_at;
        $buyerName = $request->query('buyer_name');
        $phone = $request->query('phone');
        $address = $request->query('address');

        return view('cart.checkout', compact('cartItems', 'totalPrice', 'orderTime', 'order', 'buyerName', 'phone', 'address'));
    }

    public function printInvoice(Request $request)
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $buyerName = $request->input('buyer_name');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $orderTime = now()->setTimezone('Asia/Bangkok');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cart.invoice', compact('cartItems', 'buyerName', 'phone', 'address', 'orderTime'));
        return $pdf->download('invoice.pdf');
    }

    public function process(Request $request)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $validatedData = $request->validate([
                'buyer_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'payment_method' => 'required|in:cod,bank_transfer,vnpay',
            ]);

            // Lấy giỏ hàng hiện tại
            $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
            }

            // Tính tổng giá trị đơn hàng
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => auth()->id(),
                'buyer_name' => $validatedData['buyer_name'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'total_price' => $totalPrice,
                'status' => "delivered",
                'payment_method' => $validatedData['payment_method'],
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Xóa giỏ hàng sau khi tạo đơn hàng thành công
            Cart::where('user_id', auth()->id())->delete();

            return redirect()->route('cart.index')->with('success', 'Đơn hàng đã được tạo thành công.');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra khi tạo đơn hàng: ' . $e->getMessage());
        }
    }
}
