@extends('layouts.default')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Кол-во</th>
                        <th scope="col">Тип</th>
                        <th scope="col">
                            <input type="text" class="js-filter" placeholder="Фильтр"><br>
                            Описание
                        </th>
                        <th scope="col" class="js-sort" role="button">Дата</th>
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
            <a href="/">Назад</a>
        </div>
    </div>

    <script src="/js/history.js"></script>
@stop