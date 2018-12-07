@extends('layout')
@section('body')
    <div id="modal_form_vertical" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h5 class="modal-title">Thêm tài khoản bằng file xlsx</h5>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>File Excel(.xlsx)</label>
                            <input type="file" name="file" required accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control">
                            <p>Vị trí trong file excel lân lượt phải là: <span class="text-warning">Tên nhân viên - Email - Mật khẩu - Loại tài khoản</span> ( 1 - Quản trị viên, 2 - Nhân viên tìm kiếm, 3 - Nhân viên Xuất Excel )</p>
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
    <div id="modal_form_add" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h5 class="modal-title">Thêm tài khoản</h5>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Loại tài khoản</label>
                            <select name="type" class="select" id="">
                                <option value="1">Admin</option>
                                <option value="2">Nhân viên xuất Excel</option>
                                <option value="3">Nhân viên tìm sản phẩm</option>

                            </select>
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
    <div class="panel panel-flat" id="app" length-ids="{{count($users)}}">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
                <div>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_form_vertical">
                        Thêm mới bằng Excel <i class="icon-file-excel position-right"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_form_add">
                        Thêm mới <i class="icon-plus3 position-right"></i>
                    </button>
                </div>
            </div>

        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-framed">
                    <thead>
                    <tr style="background-color: rgba(79,232,174,0.24)">
                        <th  style="width: 10px">ID</th>
                        <th>Email</th>
                        <th>Tên người dùng</th>
                        <th>Quyền</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td scope="row"  style="width: 10px">{{$user->id}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->name}}</td>
                            <td>@switch($user->type)
                                    @case(1)
                                    <span class="bg-white text-highlight">Admin</span>
                                    @break
                                    @case(3)
                                    <span class="bg-success text-highlight">Nhân viên tìm sản phẩm</span>
                                    @break
                                    @case(2)
                                    <span class="bg-danger text-highlight">Nhân viên xuất Excel</span>
                                    @break
                                @endswitch</td>
                            <td>
                                <ul class="icons-list">
                                    <li><a href="#" class="btn btn-link"  data-toggle="modal" onclick="deleteId({{$user->id}})" data-target="#modal_theme_danger"   title="Xóa" data-original-title="Remove"><i class="icon-trash"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
        function deleteId(id) {
            $("#delete-form").attr('action',"{{route('users.index')}}/"+id)
        }
    </script>
@endsection
