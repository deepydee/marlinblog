@extends('admin.layout')
@section('content')
<section class="content">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Blank page
            <small>it all starts here</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Листинг сущности</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Добавить</a>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Название</th>
                      <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                          <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title }}</td>
                            <td><a href="{{ route('admin.categories.edit', $category->id) }}" class="fa fa-pencil"></a>
                                <form action = "{{ route('admin.categories.destroy', $category->id) }}"method="POST">
                                    @csrf @method('DELETE')<button onclick="return confirm('Вы уверены?');" class="btn-del" type="submit"><i class="fa fa-remove"></i></button>
                                </form>
                            </td>
                          </tr>
                        @empty
                            No data
                        @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
          <!-- /.box -->

        </section>
        <!-- /.content -->
      </div>
@endsection
