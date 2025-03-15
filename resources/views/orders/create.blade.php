@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Создание заказа</h2>

        <form action="{{ route('orders.store') }}" method="POST" class="card p-4 shadow">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">ФИО покупателя</label>
                <input type="text" name="full_name" id="full_name"
                       class="form-control @error('full_name') is-invalid @enderror"
                       value="{{ old('full_name') }}" required>
                @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label">Товар</label>
                <select id="product_id" name="product_id"
                        class="form-select @error('product_id') is-invalid @enderror" required>
                    <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>Выберите товар</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id', $order->product_id ?? '') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Количество</label>
                <input type="number" name="quantity" id="quantity"
                       class="form-control @error('quantity') is-invalid @enderror"
                       value="{{ old('quantity', 1) }}" min="1" required>
                @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Комментарий к заказу</label>
                <textarea name="comment" id="comment"
                          class="form-control @error('comment') is-invalid @enderror" rows="3">{{ old('comment') }}</textarea>
                @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-link">Назад</a>
                <button type="submit" class="btn btn-primary">Создать заказ</button>
            </div>
        </form>
    </div>
@endsection
