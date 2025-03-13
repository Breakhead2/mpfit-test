@extends('layouts.app')
<?php $products = [];?>
@section('content')
    <div class="container">
        <h1 class="mb-4">Список товаров</h1>
{{--        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Добавить товар</a>--}}
        <a href="#" class="btn btn-primary mb-3">Добавить товар</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Категория</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }} ₽</td>
                    <td>{{ $product->category }}</td>
                    <td>
{{--                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Просмотр</a>--}}
                        <a href="#" class="btn btn-info btn-sm">Просмотр</a>
{{--                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Редактировать</a>--}}
                        <a href="#" class="btn btn-warning btn-sm">Редактировать</a>
{{--                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">--}}
                        <form action="#" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить товар?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
