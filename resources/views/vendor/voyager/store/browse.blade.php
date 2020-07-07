@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->display_name_plural)

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(isset($dataType->order_column) && isset($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @include('voyager::multilingual.language-selector')
    </div>
    <div class="container">
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif
    
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
@stop

@section('content')
<div>
    @foreach($store as $st) 
    {{$st->id}}
    @endforeach
    <div class="table-responsive">
        <table id="dataTable" class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên cửa hàng</th>
                    <th>Mã số đăng kí kinh doanh</th>
                    <th>Ngày đăng kí</th>
                    <th>Tỉnh, thành phố</th>
                    <th>Ngành hàng</th>
                    <th>Tên chủ cửa hàng</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>  @foreach($dataTypeContent as $data)
                <tr>
                  @if ($data->status == 0)
                  <td>{{$data->id}}</td>
                  <td>{{$data->name}}</td>
                  <td>{{$data->id_license}}</td>      
                  <td>{{$data->created_at}}</td>
                  <td>{{$data->location}}</td>
                  @inject('user', 'App\User')
                  @inject('category', 'App\Category')
                  <td>{{$category->where('id', $data->category)->first()->name}}</td>
                  <td>{{$user->where('id', $data->id_owner)->first()->name}}</td>
                  <td>{{$user->where('id', $data->id_owner)->first()->phone_number}}</td>
                  <td>{{$user->where('id', $data->id_owner)->first()->email}}</td>

                    <td class="no-sort no-click" id="bread-actions">
                        @can('delete', $data)
                            <a href="{{route('stores.cancel', $data->id)}}" title="{{ __('voyager.generic.delete') }}" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $data->{$data->getKeyName()} }}" id="delete-{{ $data->{$data->getKeyName()} }}">
                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Hủy</span>
                            </a>
                        @endcan
                        @can('edit', $data)
                            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $data->{$data->getKeyName()}) }}" title="{{ __('voyager.generic.edit') }}" class="btn btn-sm btn-primary pull-right edit">
                                <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Sửa</span>
                            </a>
                        @endcan
                        @can('read', $data)
                            <a href="{{route('stores.accept', $data->id)}}" title="Duyệt" class="btn btn-sm btn-warning pull-right">
                                <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Duyệt</span>
                            </a>
                        @endcan
                    </td>
                   @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [['targets' => -1, 'searchable' =>  false, 'orderable' => false]],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop