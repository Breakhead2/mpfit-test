@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Добавление заказа</h2>
        <form action="{{ route('orders.store') }}" method="POST" class="card p-4 shadow">
            @csrf
            <div class="mb-3">
                <label for="customer_name" class="form-label">ФИО покупателя</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Комментарий</label>
                <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="product_name" class="form-label">Наименование товара</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">Количество</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Цена за единицу</label>
                    <input type="number" name="price" id="price" class="form-control" value="0" min="0" step="0.01" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Добавить заказ</button>
        </form>
    </div>
@endsection
