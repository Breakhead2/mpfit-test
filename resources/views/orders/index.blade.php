@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Список заказов</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Дата создания</th>
                    <th>ФИО покупателя</th>
                    <th>Статус</th>
                    <th>Итоговая цена</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'new' ? 'warning' : 'success' }}">
                                {{ $order->status == 'new' ? 'Новый' : 'Выполнен' }}
                            </span>
                        </td>
                        <td>{{ number_format($order->total_price, 2) }} ₽</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                Просмотр
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
