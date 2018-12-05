@extends('layout')
@section('body')
    <!-- Bordered panel body table -->
    <div class="panel panel-flat" id="app" length-ids="{{count($products)}}">
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
                                    <input type="radio" @if($request->exported == null || $request->exported == "on_off") value="on_off" checked @endif name="exported">
                                    Chưa xuất và đã xuất
                                </label>
                                <label class="radio-inline">
                                    <input id="show_parent" type="checkbox" @if($request->has('show_parent')) checked @endif name="show_parent">
                                    Chỉ hiển thị sản phẩm cha
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
                        @csrf
                        <div class="text-right">
                            <span id="select_all_product" @if(!$request->has('show_parent')) style="display: none;" @endif > <input type="checkbox" @if($request->has('show_parent')) checked @endif  name="select_all_product"> Thêm cả sản phẩm con</span>

                            <button type="submit" class="btn btn-primary">Thêm các mục đã chọn vào template <i class="icon-arrow-right14 position-right"></i></button>
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
                                <th  style="width: 10px"><input type="checkbox" value="{{$product->id}}" name="id_selected[]"></th>
                                <th scope="row"  style="width: 10px">{{$product->id}}</th>
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
            $('#show_parent').change(function () {
                if($(this).prop("checked"))
                {
                    $("#select_all_product").show()
                }
                else{
                    $('#select_all_product input').prop('checked', false);
                    $("#select_all_product").hide()
                }
            })
        })
    </script>
@endsection
