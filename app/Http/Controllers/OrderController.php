<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected ProductController $productController;

    public function __construct()
    {
        $this->productController = new ProductController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $orders = $this->getOrders('paginate');

        return response()->view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * @param string $method
     * @param int $perPage
     * @return mixed
     */
    public function getOrders(string $method = 'get', int $perPage = 10): mixed
    {
        $query = Order::orderBy('created_at', 'desc');

        return $method === 'paginate' ?
            $query->paginate($perPage):
            $query->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $products = $this->productController->getProducts();

        return response()->view('orders.create', [
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return RedirectResponse
     */
    public function store(OrderRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product = Product::find($request->product_id);

            Order::create([
                'full_name' => $request->full_name,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'comment' => $request->comment ?? null,
                'total_price' => $this->calculateTotalPrice($product, $request->quantity)
            ]);
            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', "Заказ успешно создан.");
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error("Ошибка при создании заказа", [
                'error' => $exception->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->route('orders.create')
                ->with('error', "Произошла ошибка при создании заказа. Попробуйте снова.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    private function calculateTotalPrice(Product $product, int $quantity): float
    {
        return $quantity * $product->price;
    }
}
