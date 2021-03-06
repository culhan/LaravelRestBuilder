<!-- Page Heading -->
@if( !isset($data['tambah_dokumentasi']) )
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>            
    @if( isset($data['simpan_api']) )
        <button type="button" class="btn btn-success float-right col-sm-1 btn-sm" onclick="simpanKeApi()"><i class="fas fa-save fa-sm text-white-50"></i> Simpan</button>
    @elseif( isset($data['simpan_email']) )
        @if( !empty(Arr::get($data, 'id', 0)) )
            <div class="row col-md-3">
                <a href="{{url('/')}}/preview/{{ Arr::get($data, 'id', 0) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm col-sm-5"><i class="fas fa-eye fa-sm text-white-50"></i> preview</a>
                <div class="col-md-1"></div>
                <button type="button" class="btn btn-success float-right col-sm-5 btn-sm" onclick="simpanKeApi()"><i class="fas fa-save fa-sm text-white-50"></i> Simpan</button>
            </div>
        @else
            <button type="button" class="btn btn-success float-right col-sm-1 btn-sm" onclick="simpanKeApi()"><i class="fas fa-save fa-sm text-white-50"></i> Simpan</button>
        @endif
    @elseif( isset($data['simpan_event']) )
        <button type="button" class="btn btn-success float-right col-sm-1 btn-sm" onclick="simpanKeApi()"><i class="fas fa-save fa-sm text-white-50"></i> Simpan</button>
    @elseif( isset($data['simpan_user']) )
        <button type="button" class="btn btn-success float-right col-sm-1 btn-sm" onclick="simpanKeApiUser()"><i class="fas fa-save fa-sm text-white-50"></i> Simpan</button>
    @elseif( isset($data['tambah_modul']) )
        <a href="{{url('/')}}/create" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> tambah modul</a>
    @elseif( isset($data['tambah_tabel']) )
        <a href="{{url('/')}}/createTable" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> tambah tabel</a>
    @elseif( isset($data['tambah_project']) )
        <a href="{{url('/')}}/createProject" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> tambah project</a>
    @elseif( isset($data['tambah_user']) )
        <a href="{{url('/')}}/createUser" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> tambah user</a>
    @endif
</div>
@endif