@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Список заказов</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Создать заказ</a>
        </div>

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
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->full_name }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'new' ? 'warning' : 'success' }}">
                                {{ $order->status == 'new' ? 'Новый' : 'Выполнен' }}
                            </span>
                        </td>
                        <td>{{ number_format($order->total_price, 2, '.', ' ')}} ₽</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">
                                Просмотр
                            </a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Удалить заказ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center"> отсутствуют</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
