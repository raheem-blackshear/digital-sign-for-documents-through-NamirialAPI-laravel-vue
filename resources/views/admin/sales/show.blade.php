@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Vendite
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.sales.show_fields')
                    <a href="{!! route('admin.sales.index') !!}" class="btn btn-default">Indietro</a>
                </div>
            </div>
        </div>
    </div>
@endsection
