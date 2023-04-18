@extends('layouts.home')
@section('title', 'Pembelian')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('rating/css/star-rating.css') }}">
<style type="text/css">
    .select2-selection__choice {
        background-color: #3b4a6b !important;
        color: white !important;
    }
</style>
@endpush
@section('content')

<div class="row">
    <div class="col-sm-3">
        <div class="pl-5 pr-0 pb-2">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="card">
                        <div class="card-body">
                            @if(auth()->user()->foto)
                            <img src="{{ asset(auth()->user()->foto) }}" class="image-cropper mb-2" width="70px" height="70px">
                            @else
                            <img src="{{ asset('default.png') }}" class="image-cropper mb-2" id="preview-foto" width="70px">
                            @endif
                            <br>
                            <small><strong>{{ auth()->user()->nama }}</strong></small>
                            <br>
                            <small>{{ auth()->user()->nohp }}</small>
                            <br>
                            <div class="text-center mt-4">
                                <small>Total Transaksi</small>
                                <br>
                                <small>Rp</small><b>{{ number_format($total_transaksi, 0,'.','.') }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="pl-0 pr-5 pb-2">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('pembelian.riwayat') }}?status=all" class="badge {{ $status == 'all' ? 'btn-info' : 'btn-secondary' }}">
                                Semua <br>
                                <small>(<b>{{ $semua_count }}</b>)</small>
                            </a>
                            ||
                            <a href="{{ route('pembelian.riwayat') }}?status=menunggu" class="badge {{ $status == 'menunggu' ? 'btn-info' : 'btn-secondary' }}">
                                Menunggu Pembayaran <br>
                                <small>(<b>{{ $menunggu_count }}</b>)</small>
                            </a>
                            ||
                            <a href="{{ route('pembelian.riwayat') }}?status=menunggu-konfirmasi" class="badge {{ $status == 'menunggu-konfirmasi' ? 'btn-info' : 'btn-secondary' }}">Menunggu 
                                Konfirmasi <br>
                                <small>(<b>{{ $menunggu_konfirmasi_count }}</b>)</small>
                            </a>
                            ||
                            <a href="{{ route('pembelian.riwayat') }}?status=diproses" class="badge {{ $status == 'diproses' ? 'btn-info' : 'btn-secondary' }}">
                                Diproses <br>
                                <small>(<b>{{ $diproses_count }}</b>)</small>
                            </a>
                            ||
                            <a href="{{ route('pembelian.riwayat') }}?status=dikirim" class="badge {{ $status == 'dikirim' ? 'btn-info' : 'btn-secondary' }}">
                                Dikirim <br>
                                <small>(<b>{{ $dikirim_count }}</b>)</small>
                            </a>
                            ||
                            <a href="{{ route('pembelian.riwayat') }}?status=sampai" class="badge {{ $status == 'sampai' ? 'btn-info' : 'btn-secondary' }}">
                                Sampai <br>
                                <small>(<b>{{ $sampai_count }}</b>)</small>
                            </a>
                            ||
                            <a href="{{ route('pembelian.riwayat') }}?status=selesai-order" class="badge {{ $status == 'selesai-order' ? 'btn-info' : 'btn-secondary' }}">
                                Selesai <br>
                                <small>(<b>{{ $selesai_order_count }}</b>)</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pl-0 pr-5 pb-5">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            @if( session('msg') )
                            <?php $msg = session('msg'); ?>
                            <div class="alert alert-{{ $msg['type'] }} alert-remove">
                                {!! $msg['text'] !!}
                            </div>
                            @endif
                            @foreach($records as $row)
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <div class="card" style="box-shadow: 0 .2rem 0.5rem rgba(0, 0, 0, .11)!important;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="float-left">
                                                        <div class="row">
                                                            <div class="col-sm-2 text-center">
                                                                <img src="{{ asset('icon-belanja.png') }}" width="40px">
                                                            </div>
                                                            <div class="col-sm-10 text-left pl-4">
                                                                #{{ tanggalIndo($row->tanggal) }}
                                                                <small class="d-block">{{ differentTime($row->tanggal) }}</small>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="accordion" id="accordionExample">
                                                            <strong class="btn text-muted" type="button" data-toggle="collapse" data-target="#collapseOne{{ $row->id }}" aria-expanded="true" aria-controls="collapseOne{{ $row->id }}">
                                                                <i class="ml-3 fa fa-eye" aria-hidden="true"></i><small> Ringkasan Belanja</small>
                                                            </strong>
                                                            <div id="collapseOne{{ $row->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            @foreach($row->OrderDetail as $detail)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="row ml-3">
                                                                                        <div class="col-sm-3">
                                                                                            @if($detail->Produk->foto)
                                                                                            <img src="{{ asset($detail->Produk->foto) }}" width="100px">
                                                                                            @else
                                                                                            <img src="{{ asset('no-foto.png') }}" width="100px">
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="col-sm-9 pl-5" style="font-size: 12px;">
                                                                                            {{ $detail->Produk->nama }}<br>
                                                                                            <strong>
                                                                                                {{ 'Rp'.number_format($detail->Produk->harga, 0,'.','.') }}
                                                                                            </strong><br>
                                                                                            {{ $detail->jumlah }} Barang
                                                                                        </div>
                                                                                        <div class="col-sm-12">
                                                                                            <div class="float-left">
                                                                                                <small>Catatan : {{ $detail->keterangan }}</small>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12">
                                                                                            @if($row->status == statusOrder('selesai-order') || $row->status == statusOrder('sampai'))
                                                                                            @if($detail->Testimoni()->count() > 0)
                                                                                            <span class="badge badge-info">Penilaian terkirim</span>
                                                                                            @else
                                                                                            <button type="button" class="btn btn-sm btn-success btn-nilai" data-id="{{ $detail->id }}"><i class="fa fa-pencil" aria-hidden="true"></i> Nilai</button>
                                                                                            @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="float-right text-right">
                                                        <b style="color: orange;">{{ 'Rp'.number_format($row->total_tagihan, 0,'.','.') }}</b>
                                                        <br>
                                                        <a href="{{ route('pembelian.index') }}?order={{ base64_encode($row->id) }}">
                                                            @if($row->bukti_pembayaran == NULL && $row->status == statusOrder('baru'))
                                                            {{ 'Menunggu Pembayaran' }}
                                                            @else
                                                            {{ 'Pembayaran Terkirim' }}
                                                            @endif
                                                        </a>
                                                        <br>
                                                        @if($row->status == statusOrder('dikirim'))
                                                        <button class="mt-1 btn btn-success btn-sm btn-sampai" data-id="{{ $row->id }}"><i class="fa fa-check" aria-hidden="true"></i> Diterima & Sampai</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Berikan Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('testimoni.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_detail_id" id="order_detail_id">
                <input type="hidden" name="jumlah_bintang" id="jumlah_bintang">
                <div class="modal-body" id="modal-body">
                    <div class="form-group">
                        <input id="rating-input" type="text" title="" name="rate"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Berikan Penilaian</label>
                        <textarea class="form-control" name="keterangan" placeholder="Tuliskan penilaian disini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Upload Gambar</label> <br>
                        <img src="" class="img-fluid mb-2" id="preview-gambar" width="200px">
                        <input type="file" name="gambar" class="form-control" required accept="image/*" onchange="loadImage(event, 'preview-gambar')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="btn-store">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim
                    </button>&nbsp;
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('rating/js/star-rating.js') }}"></script>
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        var $inp = $('#rating-input');
        
        //$inp.attr('value','4');
            
        $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'sm',
                showClear: false
            });
        $inp.on('rating.change', function () {
            
        });
    });
    var loadImage = function(e, targetPreview) {
        var output = document.getElementById(targetPreview);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    function pushStar() {
        console.log('data', $('#star1').val());
    }

    $(document).on('click','.btn-nilai', function() {
        let id = $(this).data('id');
        let html = $(this).html();

        $(this).html(`<div class="spinner-border spinner-border-sm text-light" role="status"></div>`);

        $.get("{{ route('testimoni.get.order.detail') }}",
        {
            id : id,
        },
        function(res){
            $('#order_detail_id').val(res.id);

            document.getElementById('title').innerHTML = res.produk;

            $('#modal-edit').modal('toggle');
            $('.btn-nilai').html(html);
        },'json');

    });

    $(document).on('click','.btn-sampai', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        Swal.fire({
            title: 'Pesanan Sampai?',
            text: "apakah anda yakin barangnya sudah diterima?",
            icon: 'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Selesai',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Kembali',
            preConfirm: () => {
                $.get("{{ route('pembelian.sampai') }}",
                {
                    id : id,
                },
                function(res){

                },'json');
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then(function(result) {
            if (result.value) {
                Swal.fire({
                    title: 'Pesanan Sampai!',
                    text: 'Data Pesanan telah diterima.',
                    icon: 'success',
                    onClose: function() {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endpush