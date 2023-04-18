@extends('layouts.admin')
@section('title', 'Edit Warna')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
@endpush
@section('content')
<div class="row">
    <div class="col-5">
        <div class="card card-outline card-blue">
            <div class="card-header">
                <h3 class="card-title" id="card-title">Warna Baru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.warna') }}" class="btn btn-default"><i class="fas fa-reply"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                @if( session('msg') )
                <?php $msg = session('msg'); ?>
                <div class="alert alert-{{ $msg['type'] }} alert-remove">
                    {!! $msg['text'] !!}
                </div>
                @endif
                <form method="POST" action="{{ route('admin.warna.update', $records->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nama Warna<strong class="text-danger">*</strong></label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Warna" required value="{{ $records->nama }}">
                            </div>
                            <div id="cp2" class="input-group colorpicker-component"> 
                                <input type="text" value="{{ $records->value }}" class="form-control" name="value"/>
                                <span class="input-group-addon mt-2">
                                    &nbsp;&nbsp;&nbsp;<i></i>
                                </span>
                            </div>
                            <div class="text-right pt-3">
                                <button type="reset" class="btn btn-danger">Reset</button>&nbsp;
                                <button type="submit" class="btn btn-primary" id="btn-store">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript">
    $('#cp2').colorpicker();
</script>
@endpush
