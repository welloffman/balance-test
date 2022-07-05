@extends('layouts.default')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-4 mt-5">
            <form method="post" action="/login">
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Логин</label>
                    <input type="email" name="email" class="form-control" id="inputEmail">
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control" id="inputPassword">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                @if($errors->any())
                    <div class="mb-3 text-danger">{{$errors->first()}}</div>
                @endif

                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
@stop