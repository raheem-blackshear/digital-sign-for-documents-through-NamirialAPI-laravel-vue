<!-- Age Field -->

<div class="form-group col-sm-6">
        {!! Form::label('seller_id', 'Vendite ID:') !!}
        {!! Form::number('seller_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('age', 'Età:') !!}
    {!! Form::number('age', null, ['class' => 'form-control']) !!}
</div>

<!-- Packagetype Field -->
<!--
<div class="form-group col-sm-6">
    {!! Form::label('packageType', 'Tipo di pacchetto:') !!}
    {!! Form::number('packageType', null, ['class' => 'form-control']) !!}
</div>
-->

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Prezzo:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractortype Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorType', 'Contraente Genere:') !!}
    {!! Form::text('contractorType', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractorfirstname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorFirstName', 'Contraente Nome:') !!}
    {!! Form::text('contractorFirstName', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractorlastname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorLastName', 'Contraente Cognome:') !!}
    {!! Form::text('contractorLastName', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractoraddress Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorAddress', 'Contraente Indirizzo:') !!}
    {!! Form::text('contractorAddress', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractortaxcode Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorTaxCode', 'Contraente Luogo:') !!}
    {!! Form::text('contractorTaxCode', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractorbirthday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorBirthday', 'Contraente Compleanno:') !!}
    {!! Form::text('contractorBirthday', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractorbirthplace Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorBirthPlace', 'Contraente luogo di nascita:') !!}
    {!! Form::text('contractorBirthPlace', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractoremail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorEmail', 'Contraente EMail:') !!}
    {!! Form::text('contractorEmail', null, ['class' => 'form-control']) !!}
</div>

<!-- Contractortelephone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contractorTelephone', 'Contraente Telefono:') !!}
    {!! Form::text('contractorTelephone', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredtype Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredType', 'Assicurato Genere:') !!}
    {!! Form::text('insuredType', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredfirstname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredFirstName', 'Assicurato Nome:') !!}
    {!! Form::text('insuredFirstName', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredlastname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredLastName', 'Assicurato Cognome:') !!}
    {!! Form::text('insuredLastName', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredaddress Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredAddress', 'Assicurato Indirizzo:') !!}
    {!! Form::text('insuredAddress', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredtaxcode Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredTaxCode', 'Assicurato Luogo:') !!}
    {!! Form::text('insuredTaxCode', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredbirthday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredBirthday', 'Assicurato Compleanno:') !!}
    {!! Form::text('insuredBirthday', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredbirthplace Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredBirthPlace', 'Assicurato luogo di nascita:') !!}
    {!! Form::text('insuredBirthPlace', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredemail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredEmail', 'Assicurato EMail:') !!}
    {!! Form::text('insuredEmail', null, ['class' => 'form-control']) !!}
</div>

<!-- Insuredtelephone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insuredTelephone', 'Assicurato Telefono:') !!}
    {!! Form::text('insuredTelephone', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbentype Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenType', 'Beneficiario Caso Morte Genere:') !!}
    {!! Form::text('deathBenType', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbenfirstname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenFirstName', 'Beneficiario Caso Morte Nome:') !!}
    {!! Form::text('deathBenFirstName', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbenlastname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenLastName', 'Beneficiario Caso Morte Cognome:') !!}
    {!! Form::text('deathBenLastName', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbenaddress Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenAddress', 'Beneficiario Caso Morte Indirizzo:') !!}
    {!! Form::text('deathBenAddress', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbentaxcode Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenTaxCode', 'Beneficiario Caso Morte Luogo:') !!}
    {!! Form::text('deathBenTaxCode', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbenbirthday Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenBirthday', 'Beneficiario Caso Morte Compleanno:') !!}
    {!! Form::text('deathBenBirthday', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbenbirthplace Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenBirthPlace', 'Beneficiario luogo di nascita:') !!}
    {!! Form::text('deathBenBirthPlace', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbenemail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenEmail', 'Beneficiario Caso Morte EMail:') !!}
    {!! Form::text('deathBenEmail', null, ['class' => 'form-control']) !!}
</div>

<!-- Deathbentelephone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deathBenTelephone', 'Beneficiario Caso Morte Telefono:') !!}
    {!! Form::text('deathBenTelephone', null, ['class' => 'form-control']) !!}
</div>

<!-- Receiveemail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receiveEmail', 'Ricevute EMail :') !!}
    {!! Form::text('receiveEmail', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Salvare', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('admin.sales.index') !!}" class="btn btn-default">Annulla</a>
</div>
