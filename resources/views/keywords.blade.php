@extends('layout')
@section('body')
    <div id="modal_form_vertical" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h5 class="modal-title">Thêm từ khóa</h5>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
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
    <div id="modal_form_vertical_1" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h5 class="modal-title">Thêm từ khóa</h5>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Điền từ khóa</label>
                            <input type="text" name="keyword" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Điền url (Nếu có)</label>
                            <input type="text" name="url" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Điền page (Mặc định là 1)</label>
                            <input type="number" min="1" step="1" name="page" value="1" required class="form-control">
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
                    <h6 class="text-semibold"> <input type="checkbox" name="delete_all"> <span class="text-warning">Xóa cả các sản phẩm được tìm từ từ khóa này</span></h6>
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
    <div id="modal_theme_search" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <form id="search-form" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h6 class="modal-title"><span class="icon-search4"></span> Điền đầy đủ các thông tin</h6>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Hãy chọn 1 server </label>
                            <select name="server_id" data-placeholder="Hãy chọn 1 server" class="select" required>
                            @foreach($servers as $server)
                                <option value="{{$server->id}}">{{$server->name}}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Mức giá *:</label>
                            <input type="text" name="multiplication" required min="1.5" id="multiplication" placeholder="Giá nhân sp" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            @method("put")
                        <input type="text" name="action" value="search" style="display: none">
                            @csrf
                            <button type="submit" class="btn btn-info">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Bordered panel body table -->
    <div class="panel panel-flat" id="app" length-ids="{{count($keywords)}}">
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
                            <label class="control-label col-lg-2">Số keyword hiển thị mỗi trang</label>
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
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                        </ul>
                    </div>
                    <div>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_form_vertical">
                            Thêm mới bằng file Excel <i class="icon-file-excel position-right"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_form_vertical_1">
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
                            <th>Từ khóa</th>
                            <th>Trang</th>
                            <th>Url</th>
                            <th>Server tìm kiếm</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($keywords as $keyword)
                            <tr>
                                <td  style="width: 10px"><input type="checkbox" value="{{$keyword->id}}" name="id_selected[]"></td>
                                <td scope="row"  style="width: 10px">{{$keyword->id}}</td>
                                <td>{{$keyword->keyword}}</td>
                                <td>{{$keyword->page}}</td>
                                <td><a href="{{$keyword->url}}">Url của keyword {{$keyword->keyword}}</a></td>
                                <td>@if($keyword->server_id != null) {{$keyword->server->name }}@endif</td>
                                <td>@switch($keyword->status)
                                        @case(0)
                                        <span class="bg-white text-highlight">Đang đợi</span>
                                        @break
                                        @case(1)
                                       <span class="bg-success text-highlight">Đang chạy</span>
                                        @break
                                        @case(2)
                                        <span class="bg-danger text-highlight">Đang dừng</span>

                                        @break
                                        @case(3)
                                        <span class="bg-brown-800 text-highlight">Đã xong tìm kiếm</span>
                                        @break


                                    @endswitch</td>
                                <td>
                                    <ul class="icons-list">
                                        <li><a href="#" class="btn btn-link"  data-toggle="modal" onclick="deleteId({{$keyword->id}})" data-target="#modal_theme_danger"   title="Xóa" data-original-title="Remove"><i class="icon-trash"></i></a></li>
                                        @if($keyword->status != 1)<li><a href="#" class="btn btn-link" data-toggle="modal" onclick="searchId({{$keyword->id}},{{$keyword->multiplication}})" data-target="#modal_theme_search"   title="Tìm kiếm sản phẩm" data-original-title="Tìm kiếm"><i class="icon-search4"></i></a></li> @endif
                                        @if($keyword->status == 1)

                                            <li>
                                                <form method="post" action="{{route('keywords.index').'/'.$keyword->id}}">
                                                    <input type="text" name="action" value="stop" style="display: none">
                                                    @method("put")
                                                    @csrf
                                                    <button type="submit" class="btn btn-link"><i class="icon-stop"></i></button>
                                                </form>
                                            </li>

                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="float: right;margin-top: 20px">
                        {{ $keywords->appends($request->all())->links() }}
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
    <script>
        $(document).ready(function () {
            $('#select-all').click(function () {
                if(!$('#select-all').is(':checked'))
                {
                    $('#length_keyword_selected').text('0')
                    $('[name="id_selected[]"]').prop('checked', false);
                }else{
                    $('[name="id_selected[]"]').prop('checked', true);
                    $('#length_keyword_selected').text({{count($keywords)}})
                }
            })
            $('[name="id_selected[]"]').change(function () {
                let count = $('[name="id_selected[]"]:checked').length
                $('#length_keyword_selected').text(count)
                if( count !== {{count($keywords)}})
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
            $("#delete-form").attr('action',"{{route('keywords.index')}}/"+id)
        }
        function searchId(id,multiplication) {
            $("#search-form").attr('action',"{{route('keywords.index')}}/"+id)
            $("#multiplication").val(multiplication)
        }
    </script>
@endsection
