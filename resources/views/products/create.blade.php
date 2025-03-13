@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">
            {{ isset($product) ? 'Редактировать ' . $product->name : 'Добавить товар' }}
        </h1>

        <form
            method="POST"
            action="{{ isset($product) ? route('products.update', $product) :route('products.store') }}"
            class="card p-4 shadow-sm"
        >
            @csrf

            @if(isset($product))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" id="name" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Введите название товара"
                       value="{{ old('name', $product->name ?? '') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Категория</label>
                <select id="category_id" name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="" disabled selected>Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена</label>
                <input type="number" id="price" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       placeholder="Введите цену товара"
                       value="{{ old('price', $product->price ?? '') }}"
                       min="0" step="0.01" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea id="description" name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Введите описание товара" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-link">Назад</a>

                <button type="submit" class="btn btn-primary">
                    {{ isset($product) ? 'Обновить' : 'Сохранить' }}
                </button>
            </div>
        </form>
    </div>
@endsection
