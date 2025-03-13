@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $product->name }}</h1>

        <div class="card p-4 shadow-sm">
            <div class="mb-3">
                <h5 class="fw-bold">Категория:</h5>
                <p>{{ $product->category->name }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Цена:</h5>
                <p>{{ $product->price }} ₽</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Описание:</h5>
                <p>{{ $product->description ?: 'Описание отсутствует' }}</p>
            </div>

            @if($product->created_at)
                <div class="mb-3">
                    <h5 class="fw-bold">Дата создания:</h5>
                    <p>{{ $product->created_at->format('d.m.Y H:i') }}</p>
                </div>
            @endif

            @if($product->updated_at)
                <div class="mb-3">
                    <h5 class="fw-bold">Последнее обновление:</h5>
                    <p>{{ $product->updated_at->format('d.m.Y H:i') }}</p>
                </div>
            @endif

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('products.index') }}" class="btn btn btn-link">Назад</a>

                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning me-2">Редактировать</a>

                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Удалить этот товар?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
