@extends('layout')
@section('body')
    <!-- Bordered panel body table -->
    <div class="panel panel-flat" id="app">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal form-validate-jquery" method="get">
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Các cột sửa <span class="text-danger">*</span></label>
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
                        <input type="text" style="display: none" name="ids" value="{{$ids}}">
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Sửa <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <form class="form-horizontal form-validate-jquery" method="post">
            <div class="panel-body">
                <fieldset class="content-group">
                    <p>Đã chọn <span class="text-danger" id="length_product_selected">{{count(explode(",",$ids))}}</span> sản phẩm</p>
                    <input type="text" style="display: none" name="ids" value="{{$ids}}">
                    @foreach($column_selected as $column)
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{$column}}</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="{{$column}}">
                            </div>
                        </div>
                    @endforeach
                </fieldset>
                @csrf
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update thông tin <i class="icon-arrow-right14 position-right"></i></button>
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
@endsection
