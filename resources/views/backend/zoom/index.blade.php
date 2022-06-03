@extends('backend.layouts.app')

@section('title', 'اعدادات الاجتماع المرئي')

@section('zoom', 'active')

@section('content')
    <div class="row g-5 g-xl-8">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-video fa-fw mx-2"></i>اعدادات الاجتماع المرئي</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control" readonly id="basic-url" placeholder="لم يتم الربط مع Zoom بعد" aria-describedby="basic-addon3"/>
                            <a href="#" class="input-group-text btn btn-primary" id="basic-addon3">الربط مع Zoom</a>
                        </div>
                        <small class="text-warning">يتوجب ان يكون لديك حساب <a href="https://zoom.us/" target="_blank">Zoom</a> لتتمكن من الانضمام الى الاجتماعات المرئية</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
