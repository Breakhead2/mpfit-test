@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Список товаров</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Добавить товар</a>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" target="_blank">{{ $product->name }}</a>
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }} ₽</td>
                    <td>{{ $product->description }}</td>
                    <td class="d-flex gap-2">

                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Удалить товар?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Товары отсутствуют</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
