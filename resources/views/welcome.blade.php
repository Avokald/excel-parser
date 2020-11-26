@extends('layout.app')

@section('content')
    <section class="container container-fluid">
        <h1>Таблица</h1>
        <form method="post" action="{{ route('deleteAll') }}">
            @csrf
            <button class="delete-all">Очистить таблицу</button>
        </form>

        @foreach ($rowsGroupedByDay as $day => $rows)
            <h3 class="caption">День - {{ $day }}</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->date ? $row->date->format('d.m.Y') : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </section>
@endsection

