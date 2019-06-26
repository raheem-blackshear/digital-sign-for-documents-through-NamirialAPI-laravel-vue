@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Update your information
        </h1>
   </section>
   <div class="content">
        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['admin.users.update_profile'], 'method' => 'patch']) !!}

                   <!-- Name Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('first_name', 'Nome : ') !!}
                        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-sm-6">
                            {!! Form::label('last_name', 'Cognome : ') !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                    </div>

                   <!-- Email Field -->
                    <div class="form-group col-md-6">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    </div>
                    <!-- Codice Intermediario -->
                    <div class="form-group col-sm-6">
                       {!! Form::label('codiceintermediario', ' Codice Intermediario:') !!}
                       {!! Form::text('codiceintermediario',null, ['class' => 'form-control']) !!}
                   </div>
                    <!-- Sotto-codice -->
                    <div class="form-group col-sm-6">
                       {!! Form::label('sotto_codice', 'Sotto-codice:') !!}
                       {!! Form::text('sotto_codice', null,['class' => 'form-control']) !!}
                   </div>  
                   <!-- Password Field -->
                   <div class="form-group col-sm-6">
                       {!! Form::label('password', 'Password:') !!}
                       {!! Form::password('password', ['class' => 'form-control']) !!}
                   </div>
                   <!-- Password Field -->
                   <div class="form-group col-sm-6">
                       {!! Form::label('password_confirmation', 'Password Conferma:') !!}
                       {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                   </div>


                   <!-- Submit Field -->
                   <div class="form-group col-sm-12">
                       {!! Form::submit('Salvare', ['class' => 'btn btn-primary']) !!}
                   </div>


                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
