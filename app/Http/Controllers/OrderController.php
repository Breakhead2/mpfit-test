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
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        return response()->view('orders.show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function edit(Order $order): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate(
            [
                'status' => ['required', 'in:completed'],
            ],
            [
                'status.required' => 'Поле статус обязательно для заполнения.',
                'status.in' => 'Статус должен быть только "completed".',
            ]
        );

        $name = $order->full_name;
        $orderDate = $order->created_at->format('d.m.Y H:i');

        DB::beginTransaction();

        try {
            $order->status = $request->status;
            $order->save();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', "Статус заказа №{$order->id} на имя {$name} от {$orderDate} изменен на \"Выполнен\".");
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Ошибка обновления записи", [
                'error' => $exception->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->route('orders.show', $order)
                ->with('errpr', "Ошибка обновления записи №{$order->id}. Попробуйте позже.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $name = $order->full_name;
        $orderDate = $order->created_at->format('d.m.Y H:i');

        DB::beginTransaction();

        try {
            $order->delete();
            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', "Заказ №{$order->id} на имя {$name} от {$orderDate} успешно удален.");
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Ошибка удаления заказа", [
                'error' => $exception->getMessage()
            ]);

            return redirect()->route('orders.index')
                ->with('error', "Заказ №{$order->id} на имя {$name} от {$orderDate} не был удален.");
        }
    }

    private function calculateTotalPrice(Product $product, int $quantity): float
    {
        return $quantity * $product->price;
    }
}
