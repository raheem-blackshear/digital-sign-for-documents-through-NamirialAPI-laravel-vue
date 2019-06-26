<div class = "container-fluid">
    <div class = "row">
        <div class = "col-md-3">
            <div class="form-group">
                    {!! Form::label('id', 'ID:') !!}
                    <p>{!! $sale->id !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('seller_id', 'Vendite ID:') !!}
                <p>{!! $sale->seller_id !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('age', 'Età:') !!}
                <p>{!! $sale->age !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('price', 'Prezzo:') !!}
                <p>{!! $sale->price !!}</p>
            </div>
        </div>
    </div>
    <div class = "row" style = "margin-top:20px">
        <div class = "col-md-3">
                <!-- Contractortype Field -->
                <div class="form-group">
                    {!! Form::label('contractorType', 'Contraente Genere:') !!}
                    <p>{!! $sale->contractorType !!}</p>
                </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-3">
            <!-- Contractorfirstname Field -->
            <div class="form-group">
                {!! Form::label('contractorFirstName', 'Contraente Nome:') !!}
                <p>{!! $sale->contractorFirstName !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Contractorlastname Field -->
            <div class="form-group">
                {!! Form::label('contractorLastName', 'Contraente Cognome:') !!}
                <p>{!! $sale->contractorLastName !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Contractoraddress Field -->
            <div class="form-group">
                {!! Form::label('contractorAddress', 'Contraente Indirizzo:') !!}
                <p>{!! $sale->contractorAddress !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Contractortaxcode Field -->
            <div class="form-group">
                {!! Form::label('contractorTaxCode', 'Contraente Luogo:') !!}
                <p>{!! $sale->contractorTaxCode !!}</p>
            </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-3">
            <!-- Contractorbirthday Field -->
            <div class="form-group">
                {!! Form::label('contractorBirthday', 'Contraente Compleanno:') !!}
                <p>{!! $sale->contractorBirthday !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Contractorbirthplace Field -->
            <div class="form-group">
                {!! Form::label('contractorBirthPlace', 'Contraente luogo di nascita:') !!}
                <p>{!! $sale->contractorBirthPlace !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Contractoremail Field -->
            <div class="form-group">
                {!! Form::label('contractorEmail', 'Contraente EMail:') !!}
                <p>{!! $sale->contractorEmail !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Contractortelephone Field -->
            <div class="form-group">
                {!! Form::label('contractorTelephone', 'Contraente Telefono:') !!}
                <p>{!! $sale->contractorTelephone !!}</p>
            </div>
        </div>
    </div>
    <div class = "row" style = "margin-top:50px">
        <div class = "col-md-3">
            <!-- Insuredtype Field -->
            <div class="form-group">
                {!! Form::label('insuredType', 'Assicurato Genere:') !!}
                <p>{!! $sale->insuredType !!}</p>
            </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-3">
                <!-- Insuredfirstname Field -->
                <div class="form-group">
                    {!! Form::label('insuredFirstName', 'Assicurato Nome:') !!}
                    <p>{!! $sale->insuredFirstName !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Insuredlastname Field -->
                <div class="form-group">
                    {!! Form::label('insuredLastName', 'Assicurato Cognome:') !!}
                    <p>{!! $sale->insuredLastName !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Insuredaddress Field -->
                <div class="form-group">
                    {!! Form::label('insuredAddress', 'Assicurato Indirizzo:') !!}
                    <p>{!! $sale->insuredAddress !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Insuredtaxcode Field -->
                <div class="form-group">
                    {!! Form::label('insuredTaxCode', 'Assicurato Luogo:') !!}
                    <p>{!! $sale->insuredTaxCode !!}</p>
                </div>
        </div>
    </div>
    <div class = "row">
            <div class = "col-md-3">
                <!-- Insuredbirthday Field -->
                <div class="form-group">
                    {!! Form::label('insuredBirthday', 'Assicurato Compleanno:') !!}
                    <p>{!! $sale->insuredBirthday !!}</p>
                </div>
            </div>
            <div class = "col-md-3">
                <!-- Insuredbirthplace Field -->
                <div class="form-group">
                    {!! Form::label('insuredBirthPlace', 'Assicurato luogo di nascita:') !!}
                    <p>{!! $sale->insuredBirthPlace !!}</p>
                </div>
            </div>
            <div class = "col-md-3">
                <!-- Insuredemail Field -->
                <div class="form-group">
                    {!! Form::label('insuredEmail', 'Assicurato EMail:') !!}
                    <p>{!! $sale->insuredEmail !!}</p>
                </div>
            </div>
            <div class = "col-md-3">
                <!-- Insuredtelephone Field -->
                <div class="form-group">
                    {!! Form::label('insuredTelephone', 'Assicurato Telefono:') !!}
                    <p>{!! $sale->insuredTelephone !!}</p>
                </div>
            </div>
    </div>
    <div class = "row" style = "margin-top:50px">
        <div class = "col-md-3">
            <!-- Deathbentype Field -->
            <div class="form-group">
                {!! Form::label('deathBenType', 'Beneficiario Caso Morte Genere:') !!}
                <p>{!! $sale->deathBenType !!}</p>
            </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-3">
                <!-- Deathbenfirstname Field -->
                <div class="form-group">
                    {!! Form::label('deathBenFirstName', 'Beneficiario Caso Morte Nome:') !!}
                    <p>{!! $sale->deathBenFirstName !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Deathbenlastname Field -->
                <div class="form-group">
                    {!! Form::label('deathBenLastName', 'Beneficiario Caso Morte Cognome:') !!}
                    <p>{!! $sale->deathBenLastName !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Deathbenaddress Field -->
                <div class="form-group">
                    {!! Form::label('deathBenAddress', 'Beneficiario Caso Morte Indirizzo:') !!}
                    <p>{!! $sale->deathBenAddress !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Deathbentaxcode Field -->
                <div class="form-group">
                    {!! Form::label('deathBenTaxCode', 'Beneficiario Caso Morte Luogo:') !!}
                    <p>{!! $sale->deathBenTaxCode !!}</p>
                </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-3">
                <!-- Deathbenbirthday Field -->
                <div class="form-group">
                    {!! Form::label('deathBenBirthday', 'Beneficiario Caso Morte Compleanno:') !!}
                    <p>{!! $sale->deathBenBirthday !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Deathbenbirthplace Field -->
                <div class="form-group">
                    {!! Form::label('deathBenBirthPlace', 'Beneficiario luogo di nascita:') !!}
                    <p>{!! $sale->deathBenBirthPlace !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Deathbenemail Field -->
                <div class="form-group">
                    {!! Form::label('deathBenEmail', 'Beneficiario Caso Morte EMail:') !!}
                    <p>{!! $sale->deathBenEmail !!}</p>
                </div>
        </div>
        <div class = "col-md-3">
                <!-- Deathbentelephone Field -->
                <div class="form-group">
                    {!! Form::label('deathBenTelephone', 'Beneficiario Caso Morte Telefono:') !!}
                    <p>{!! $sale->deathBenTelephone !!}</p>
                </div>
        </div>
    </div>

    <div class = "row" style = "margin-top:40px">
        <div class = "col-md-3">
            <!-- Receiveemail Field -->
            <div class="form-group">
                {!! Form::label('receiveEmail', 'Ricevte EMail:') !!}
                <p>{!! $sale->receiveEmail !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Created At Field -->
            <div class="form-group">
                {!! Form::label('created_at', 'Created At:') !!}
                <p>{!! $sale->created_at !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <!-- Updated At Field -->
            <div class="form-group">
                {!! Form::label('updated_at', 'Updated At:') !!}
                <p>{!! $sale->updated_at !!}</p>
            </div>
        </div>
    </div>

    {{--           Question Values          --}}
    <hr/>
    <div class = "row question_answers_container">
        <h5 class = "field_question">Dati personali del contraente</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Type:') !!}
                <p>{!! $sale->idd_type !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Email:') !!}
                <p>{!! $sale->idd_email !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Nome / Ragione sociale:') !!}
                <p>{!! $sale->idd_first_name !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Cognome:') !!}
                <p>{!! $sale->idd_last_name !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Codice fiscale / Partita IVA:') !!}
                <p>{!! $sale->idd_tax_code !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Data di nascita:') !!}
                <p>{!! $sale->idd_birthday !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Vuoi proteggere la tua persona o la tua sfera professionale?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Vita privata:') !!}
                <p>{!! $sale->idd_private_life ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Sfera professionale:') !!}
                <p>{!! $sale->idd_professional_life ? 'yes' : 'no' !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Quali sono le esigenze assicurative?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Tutela attività professionale:') !!}
                <p>{!! $sale->idd_insurance_needs_professional_activity ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Assicurare la vita dei tuoi dipendenti e dirigenti:') !!}
                <p>{!! $sale->idd_insurance_needs_employee_manager_life ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Integrare la pensione dei tuoi dipendenti e dirigenti:') !!}
                <p>{!! $sale->idd_insurance_needs_employee_manager_retirement ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Gestire il patrimonio aziendale:') !!}
                <p>{!! $sale->idd_insurance_needs_company_assets ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Proteggere il credito aziendale:') !!}
                <p>{!! $sale->idd_insurance_needs_business_credit ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Assicurare i veicoli:') !!}
                <p>{!! $sale->idd_insurance_needs_vehicle ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Assicurarsi in caso di infortuni e malattia:') !!}
                <p>{!! $sale->idd_insurance_needs_injuries_illness ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Proteggere casa e famiglia:') !!}
                <p>{!! $sale->idd_insurance_needs_home_family ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Assicurare la tua vita o quella dei tuoi famigliari:') !!}
                <p>{!! $sale->idd_insurance_needs_family_members ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Integrare la tua pensione:') !!}
                <p>{!! $sale->idd_insurance_needs_pension ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Garantire una rendita:') !!}
                <p>{!! $sale->idd_insurance_needs_annuity ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Tutelare il reddito agli eredi:') !!}
                <p>{!! $sale->idd_insurance_needs_heirs_income ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Investire/ Risparmiare:') !!}
                <p>{!! $sale->idd_insurance_needs_investing_saving ? 'yes' : 'no' !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Parlando della tua attività, parlaci della tua professione </h5>
        <div class = "col-md-12">
            <div class="form-group">
                <p>{!! $sale->idd_talking_business_profession !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Parlando della tua attività cosa proteggeresti?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Danni a beni:') !!}
                <p>{!! $sale->idd_business_protect_danni_to_me ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Danni provocati ad altri:') !!}
                <p>{!! $sale->idd_business_protect_damage_others ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Da controversie legali:') !!}
                <p>{!! $sale->idd_business_protect_legal_disputes ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Dall\'interruzione dell\'attività:') !!}
                <p>{!! $sale->idd_business_protect_activity_interruption ? 'yes' : 'no' !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Parlando di infortuni e malattia, da quali eventi ti vuoi tutelare?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Malattia:') !!}
                <p>{!! $sale->idd_accident_protect_disease ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Ricovero ospedaliero:') !!}
                <p>{!! $sale->idd_accident_protect_hospitalization ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Infortuni:') !!}
                <p>{!! $sale->idd_accident_protect_accident ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Imprevisti in caso di viaggi all\'estero:') !!}
                <p>{!! $sale->idd_accident_protect_traveling ? 'yes' : 'no' !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Parlando di casa e famiglia, cosa si vuole proteggere?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Famiglia:') !!}
                <p>{!! $sale->idd_home_family_protect_family ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Casa, condominio:') !!}
                <p>{!! $sale->idd_home_family_protect_house ? 'yes' : 'no' !!}</p>
            </div>
        </div>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Controversie legali:') !!}
                <p>{!! $sale->idd_home_family_protect_legal_dispute ? 'yes' : 'no' !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Quali sono le aspettative rispetto al capitale versato?</h5>
        <div class = "col-md-6">
            <div class="form-group">
                <p>{!! $sale->idd_paid_up_condition_after_expiration ? 'L\'investitore vuole che il capitale sia garantito alla scadenza del contratto' : '' !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Qual è il livello di tolleranza al rischio?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                {!! Form::label('', 'Media (SR13 - SR14):') !!}
                <p>{!! $sale->idd_risk_tolerance_media_sr13_sr14 !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Qual è il livello di conoscenza delle dinamiche del mercato finanziario assicurativo?</h5>
        <div class = "col-md-3">
            <div class="form-group">
                <p>{!! $sale->idd_insurance_knowledge_level_base !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Preferiresti un accantonamento </h5>
        <div class = "col-md-3">
            <div class="form-group">
                <p>{!! $sale->idd_subscription_type == 'annual' ? 'Annuale' : ($sale->idd_subscription_type == 'half-yearly' ? 'Semestrale' : 'Mensile') !!}</p>
            </div>
        </div>
    </div>

    <div class = "row question_answers_container">
        <h5 class = "field_question">Parlando della sua professione, qual è il fatturato dell&rsquo;ultimo anno? </h5>
        <div class = "col-md-6">
            <div class="form-group">
                <p>{!! $sale->idd_business_last_year_turnover !!}</p>
            </div>
        </div>
    </div>
</div>
