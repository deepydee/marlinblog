@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить категорию
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
        @csrf
        @method('PUT')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем категорию</h3>
        </div>
        <div class="box-body">
          @include('admin.errors')
          <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Название</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$category->title}}" name="title">
            </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
          <button type="submit" class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->
      </div>
    </form>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
@endsection
