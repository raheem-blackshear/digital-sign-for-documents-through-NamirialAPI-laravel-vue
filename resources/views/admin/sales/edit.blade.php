@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modifica informazioni di vendita
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sale, ['route' => ['admin.sales.update', $sale->id], 'method' => 'patch']) !!}

                        @include('admin.sales.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
