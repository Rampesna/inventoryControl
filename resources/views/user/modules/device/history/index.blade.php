@extends('user.layouts.master')
@section('title', 'Envanter Yönetimi / Cihaz Listesi / İşlem Geçmişi | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <a href="{{ route('user.web.inventory.device.index') }}" class="fas fa-lg fa-backward cursor-pointer me-5"></a>
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Envanter Yönetimi / Cihaz Listesi / İşlem Geçmişi</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="historyGrid"></div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.device.history.components.style')
@endsection

@section('customScripts')
    @include('user.modules.device.history.components.script')
@endsection
