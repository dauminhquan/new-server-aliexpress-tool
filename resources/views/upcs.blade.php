@extends('layout')
@section('body')

    <!-- Bordered panel body table -->
    <div class="panel panel-flat" id="app">
        <div class="panel-body">
            <p>Còn tất cả <span class="text-bold text-warning">{{\App\Upc::count()}}</span> mã UPC</p>
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
@endsection

@section('script')
    <script type="text/javascript" src="/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>
@endsection
