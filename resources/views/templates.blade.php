@extends('layout')
@section('body')
    <div id="modal_theme_danger" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h6 class="modal-title"><span class="icon-warning22"></span> Lưu ý</h6>
                </div>

                <div class="modal-body">
                    <h6 class="text-semibold"> Lưu ý</h6>
                    <p>Sau khi xóa toàn bộ sản phẩm có trong bảng excel này sẽ bị xóa hết!</p>


                </div>

                <div class="modal-footer">
                    <form id="id-template" method="post">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        @method("delete")
                        @csrf
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Bordered panel body table -->
    <div class="panel panel-flat" id="app" length-ids="{{count($templates)}}">
        <div class="panel-body">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal form-validate-jquery" action="#">
                        <fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Tìm kiếm </label>
                                <div class="col-lg-10">
                                    <input type="text" name="search" value="{{$request->search}}" class="form-control" placeholder="Tìm kiếm tất cả mọi thứ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Số template mỗi trang</label>
                                <div class="col-lg-10">
                                    <input type="number" min="1" step="1" required name="limit" @if($request->limit != null) value="{{$request->limit}}" @else value="10" @endif class="form-control" placeholder="Điền số sản phẩm mỗi trang">
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Tìm kiếm <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_form_vertical">
                    Thêm mới <i class="icon-add position-right"></i>
                </button>
            </div>
            <div id="modal_form_vertical" class="modal fade" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h5 class="modal-title">Thêm mới template</h5>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Tên template</label>
                                            <input type="text" required placeholder="Tên template" name="name" class="form-control">
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Tên bảng</label>
                                            <input type="text" required placeholder="Tên bảng" name="table_name" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>File Excel(.xlsx)</label>
                                    <input type="file" name="file" required accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control">
                                </div>

                            </div>
                            @csrf
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-framed">
                    <thead>
                    <tr style="background-color: rgba(79,232,174,0.24)">
                        <th  style="width: 10px">ID</th>
                        <th  style="width: 10px">Tên template</th>
                        <th  style="width: 10px">Các thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($templates as $template)
                        <tr>
                            <th scope="row"  style="width: 10px">{{$template->id}}</th>
                            <th scope="row"  style="width: 10px">{{$template->name}}</th>
                            <td>
                                <ul class="icons-list">
                                    <li><a href="#" title="Sửa" data-original-title="Edit"><i class="icon-pencil7"></i></a></li>
                                    <li><a href="#" data-toggle="modal" onclick="updateId({{$template->id}})" data-target="#modal_theme_danger"   title="Xóa" data-original-title="Remove"><i class="icon-trash"></i></a></li>
                                    <li><a href="{{route('template-products.index',["id" => $template->id])}}" title="Thêm sản phẩm và xuất Excel"  ><i class="icon-file-excel"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="float: right;margin-top: 20px">
                    {{ $templates->appends($request->all())->links() }}
                </div>
            </div>

        </div>
    </div>
    <!-- /bordered panel body table -->
@endsection

@section('script')
    <script type="text/javascript" src="/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>
    @if($errors->any())
        <script type="text/javascript">
            alert("{{$errors->first()}}")
        </script>
    @endif
    <script>
        function updateId(id) {
            $("#id-template").attr('action',"{{route('templates.index')}}"+'/'+id)
        }
    </script>
@endsection
