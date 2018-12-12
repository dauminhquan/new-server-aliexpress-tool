@extends('layout')
@section('body')
    <!-- Bordered panel body table -->
    <div class="panel panel-flat" id="app" length-ids="{{count($products)}}">
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
                                <label class="control-label col-lg-2">Các cột hiển thị <span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="column_selected[]" style="width: 100%" class="select" multiple>
                                        @foreach($columns as $column)
                                            @if($column !="id")
                                                <option value="{{$column}}" @if(in_array($column,$column_selected)) selected @endif>{{$column}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Số sản phẩm mỗi trang</label>
                                <div class="col-lg-10">
                                    <input type="number" min="1" step="1" required name="limit" @if($request->limit != null) value="{{$request->limit}}" @else value="10" @endif class="form-control" placeholder="Điền số sản phẩm mỗi trang">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Tình trạng</label>
                                <div class="col-lg-10">
                                    <label class="radio-inline">
                                        <input type="radio" value="on" name="exported" @if($request->exported == "on") checked @endif required="required" aria-required="true">
                                        Đã xuất
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" value="off" @if($request->exported == "off") checked @endif name="exported">
                                        Chưa xuất
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" @if($request->exported == null || $request->exported == "on_off")  checked @endif value="on_off" name="exported">
                                        Chưa xuất và đã xuất
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" @if($request->show_parent)  checked @endif name="show_parent">
                                        Chỉ hiển thị các sản phẩm cha
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Tìm kiếm <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal form-validate-jquery" method="post">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">

                        <fieldset class="content-group">
                            <p>Đã chọn <span class="text-danger" id="length_product_selected">0</span> sản phẩm</p>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Chọn thao tác <span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select id="select_action" name="action" style="width: 100%" class="select">
                                        <option>Chọn 1 mục</option>
                                        <option value="export-excel">Xuất Excel các mục đã chọn</option>
                                        <option value="delete">Xóa các mục đã chọn</option>
                                        <option value="reset_export">Chuyển các mục đã xuất thành chưa xuất</option>
                                        <option value="add_product">Thêm sản phẩm vào template</option>
                                    </select>
                                    <div id="export_all" style="display: none">
                                        <input type="checkbox" name="export_all"> <span>Xuất tất cả</span>
                                    </div>
                                    <div id="delete_child" style="display: none">
                                        <input type="checkbox" name="delete_child"> <span>Xóa cả các biến thể</span>
                                    </div>
                                    <div id="reset_export_all" style="display: none">
                                        <input type="checkbox" name="reset_export_all"> <span>Chuyển cả các biến thể</span>
                                    </div>


                                </div>
                            </div>
                        </fieldset>
                        @csrf
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Thực hiện <i class="icon-arrow-right14 position-right"></i></button>
                        </div>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-framed">
                            <thead>
                            <tr style="background-color: rgba(79,232,174,0.24)">
                                <th style="width: 10px"><input id="select-all" type="checkbox" ></th>
                                @foreach($column_selected as $column)
                                    @if($column != "id")
                                        <th style="text-transform: uppercase;font-weight: bold">{{$column}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th  style="width: 10px"><input type="checkbox" value="{{$product->item_sku}}" name="id_selected[]"></th>
                                    @foreach($column_selected as $column)
                                        @if($column !="id")
                                            @if(strpos($column,'image_url'))
                                                <td style="max-width: 100px;max-height: 100px"><img src="{{$product->$column}}" alt="{{$product->$column}}" style="width: 100%"></td>
                                            @else
                                                <td>{{$product->$column}}</td>
                                            @endif
                                        @endif

                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;margin-top: 20px">
                            {{ $products->appends($request->all())->links() }}
                        </div>
                    </div>

                </div>
            </form>
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
                    $('#length_product_selected').text('0')
                    $('[name="id_selected[]"]').prop('checked', false);
                }else{
                    $('[name="id_selected[]"]').prop('checked', true);
                    $('#length_product_selected').text({{count($products)}})
                }
            })
            $('[name="id_selected[]"]').change(function () {
                let count = $('[name="id_selected[]"]:checked').length
                $('#length_product_selected').text(count)
                if( count !== {{count($products)}})
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

                if($(this).val() == "export-excel")
                {
                    $("#export_all").show()
                    // $("#export_all input").prop('checked',true)
                }
                else{
                    $("#export_all").hide()
                    $("#export_all input").prop('checked',false)
                }

                if($(this).val() == "reset_export")
                {
                    $("#reset_export_all").show()
                    $("#reset_export_all input").prop('checked',true)
                }
                else{
                    $("#reset_export_all").hide()
                    $("#reset_export_all input").prop('checked',false)
                }


            })
        })
    </script>
@endsection
