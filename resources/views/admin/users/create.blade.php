@extends('admin.layout')

@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Добавить пользователя
    <small>приятные слова..</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <form enctype="multipart/form-data" action="{{route('admin.users.store')}}" method="POST">
        @csrf
    <!-- Default box -->
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Добавляем пользователя</h3>
    </div>
    <div class="box-body">
        @include('admin.errors')
        <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInputEmail1">Имя</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{ old('name') }}" name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">E-mail</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="" name="email">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Пароль</label>
            <input type="password" class="form-control" id="exampleInputEmail1" placeholder="" value="{{ old('email') }}" name="password">
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Аватар</label>
            <input type="file" id="exampleInputFile" name="avatar">

            <p class="help-block">Какое-нибудь уведомление о форматах..</p>
        </div>
    </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button class="btn btn-default">Назад</button>
        <button type="submit" class="btn btn-success pull-right">Добавить</button>
    </div>
    <!-- /.box-footer-->
    </div>
    </form>
    <!-- /.box -->

</section>
<!-- /.content -->
</div>
@endsection
