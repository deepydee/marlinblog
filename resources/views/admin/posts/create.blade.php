@extends('admin.layout')

@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Добавить статью
    <small>приятные слова..</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <form enctype="multipart/form-data" action="{{route('admin.posts.store')}}" method="POST">
        @csrf
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Добавляем статью</h3>
    </div>
    <div class="box-body">
        @include('admin.errors')
        <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{old('title')}}" name="title">
        </div>

        <div class="form-group">
            <label for="exampleInputFile">Лицевая картинка</label>
            <input type="file" id="exampleInputFile" name="image">

            <p class="help-block">Какое-нибудь уведомление о форматах..</p>
        </div>
        <div class="form-group">
            <label>Категория</label>

            <select class="form-control select2" data-placeholder="Выберите категорию" style="width: 100%;" name="category_id">
            @forelse ($categories as $category)
                <option value="{{$category->id}}">
                    {{$category->title}}
                </option>
            @empty
                Нет категорий
            @endforelse
            </select>

        </div>
        <div class="form-group">
            <label>Теги</label>
            <select class="form-control select2" multiple="multiple" data-placeholder="Выберите теги" style="width: 100%;" name="tags[]">
            @forelse ($tags as $tag)
                <option value="{{$tag->id}}">
                    {{$tag->title}}
                </option>
            @empty
                Нет тегов
            @endforelse
            </select>
        </div>
        <!-- Date -->
        <div class="form-group">
            <label>Дата:</label>

            <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker" value="{{old('date')}}" name="date">
            </div>
            <!-- /.input group -->
        </div>

        <!-- checkbox -->
        <div class="form-group">
            <label>
            <input type="checkbox" class="minimal" name="is_featured">
            </label>
            <label>
            Рекомендовать
            </label>
        </div>

        <!-- checkbox -->
        <div class="form-group">
            <label>
            <input type="checkbox" class="minimal" name="is_published">
            </label>
            <label>
            Опубликовано
            </label>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Полный текст</label>
            <textarea cols="30" rows="10" class="form-control" name="content" value="{{old('content')}}"></textarea>
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
