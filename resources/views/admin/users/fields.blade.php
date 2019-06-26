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
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
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

<!--
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::select('role', \App\Models\User::ROLES, null, ['class' => 'form-control']) !!}
</div>
-->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvare', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.users.index') !!}" class="btn btn-default">Annulla</a>
</div>
