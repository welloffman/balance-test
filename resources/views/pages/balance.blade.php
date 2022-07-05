@extends('layouts.default')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col mt-5">
            <h3>Баланс: <span class="js-balance">{{ $balance->amount }}</span></h3>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Кол-во</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Дата</th>
                    </tr>
                </thead>
                <tbody class="js-operations">
                    @foreach($operations as $operation)
                        <tr>
                            <td>{{$operation->amount}}</td>
                            <td>{{$operation->type}}</td>
                            <td>{{$operation->description}}</td>
                            <td>{{$operation->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col mt-2">
            <a href="/history">История операций</a>
        </div>
    </div>

    <script src="/js/balance.js"></script>
@stop