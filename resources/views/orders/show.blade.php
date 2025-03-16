@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Заказ #{{ $order->id }}</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ФИО покупателя:</strong> {{ $order->full_name }}</li>
                    <li class="list-group-item"><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</li>
                    <li class="list-group-item"><strong>Статус:</strong>
                        @if ($order->status === 'completed')
                            <span class="badge bg-success">Выполнен</span>
                        @else
                            <span class="badge bg-warning text-dark">Новый</span>
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Комментарий:</strong> {{ $order->comment ?? '—' }}</li>
                    <li class="list-group-item"><strong>Итоговая цена:</strong> {{ number_format($order->total_price, 2, '.', ' ') }} ₽</li>
                </ul>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('orders.index') }}" class="btn btn btn-link ms-2">Назад к списку</a>

                    @if ($order->status !== 'completed')
                        <form action="{{ route('orders.update', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success">
                                    Выполнить
                                </button>
                            @error('status')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </form>
                    @else
                        <p class="text-success mt-2">Этот заказ уже выполнен</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
