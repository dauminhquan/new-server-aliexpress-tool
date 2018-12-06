@extends('layout')
@section('body')
    <div id="modal_form_vertical" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h5 class="modal-title">Thêm server</h5>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên server</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Root url</label>
                            <input type="text" name="root_url" required class="form-control">
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
    <div id="modal_theme_danger" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h6 class="modal-title"><span class="icon-warning22"></span> Lưu ý</h6>
                </div>

                <div class="modal-body">
                    <p>Sau khi xóa toàn bộ dữ liệu có trong bảng excel này sẽ bị xóa hết!</p>
                </div>

                <div class="modal-footer">
                    <form id="delete-form" method="post">
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
    <div class="panel panel-flat" id="app" length-ids="{{count($servers)}}">
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
                            <label class="control-label col-lg-2">Số server hiển thị mỗi trang</label>
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
        <form class="form-horizontal form-validate-jquery" method="post">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                        </ul>
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_form_vertical">
                            Thêm mới <i class="icon-add position-right"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-framed">
                        <thead>
                        <tr style="background-color: rgba(79,232,174,0.24)">
                            <th style="width: 10px"><input id="select-all" type="checkbox" ></th>
                            <th  style="width: 10px">ID</th>
                            <th>Tên server</th>
                            <th>Root Url</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($servers as $server)
                            <tr>
                                <td  style="width: 10px"><input type="checkbox" value="{{$server->id}}" name="id_selected[]"></td>
                                <td scope="row"  style="width: 10px">{{$server->id}}</td>
                                <td>{{$server->name}}</td>
                                <td><a href="{{$server->root_url}}">{{$server->root_url}}</a></td>
                                <td>
                                    <ul class="icons-list">
                                        <li><a href="#" class="btn btn-link"  data-toggle="modal" onclick="deleteId({{$server->id}})" data-target="#modal_theme_danger"   title="Xóa" data-original-title="Remove"><i class="icon-trash"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="float: right;margin-top: 20px">
                        {{ $servers->appends($request->all())->links() }}
                    </div>
                </div>

            </div>
        </form>
    </div>
    <!-- /bordered panel body table -->
@endsection

@section('script')
    <script type="text/javascript" src="/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>
    <script>
        $(document).ready(function () {
            $('#select-all').click(function () {
                if(!$('#select-all').is(':checked'))
                {
                    $('#length_server_selected').text('0')
                    $('[name="id_selected[]"]').prop('checked', false);
                }else{
                    $('[name="id_selected[]"]').prop('checked', true);
                    $('#length_server_selected').text({{count($servers)}})
                }
            })
            $('[name="id_selected[]"]').change(function () {
                let count = $('[name="id_selected[]"]:checked').length
                $('#length_server_selected').text(count)
                if( count !== {{count($servers)}})
                {
                    $('#select-all').prop('checked',false)
                }
                else{
                    $('#select-all').prop('checked',true)
                }
            })
            $("#select_action").change(function(){
                if($(this).val() == "delete")
                {
                    $("#delete_child").show()
                    $("#delete_child input").prop('checked',true)
                }
                else{
                    $("#delete_child").hide()
                    $("#delete_child input").prop('checked',false)
                }
            })
        })
        function deleteId(id) {
            $("#delete-form").attr('action',"{{route('servers.index')}}/"+id)
        }
        function searchId(id) {
            $("#search-form").attr('action',"{{route('servers.index')}}/"+id)
        }
    </script>
@endsection
