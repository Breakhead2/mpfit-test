<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->getProducts();

        return response()->view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getProducts(): LengthAwarePaginator
    {
        return Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $categories = Category::all();
        return response()->view('products.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            Product::create($request->all());
            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "Товар успешно добавлен.");
        } catch (Exception $exception) {
            DB::rollBack();

            Log::error("Ошибка при создании товара", [
                'error' => $exception->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->route('products.create')
                ->with('error', "Произошла ошибка при добавлении товара. Попробуйте снова.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return response()->view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product): Response
    {
        $categories = Category::all();

        return response()->view('products.create', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product->fill($request->all());
            $product->save();

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', "Товар {$product->name} успешно обновлен.");
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Ошибка обновления записи", [
                'error' => $exception->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->route('products.edit', $product)
                ->with('error', "Произошла ошибка при добавлении товара {$product->name}. Попробуйте снова.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $name = $product->name;
            $product->delete();
            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "Товар {$name} успешно удален.");
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Ошибка удаления товара", [
                'error' => $exception->getMessage()
            ]);

            return redirect()->route('products.index')
                ->with('error', "Товар {$name} не был удален.");
        }
    }
}
