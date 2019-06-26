<html>
    <body>
        <div id = "mainWrapper">
            <div class = "logo">
                {{--<img src= "{{ public_path('assets/img/Assiqura_Logo.png')}}"/>--}}
                <img src= "assets/img/Assiqura_Logo.png"/>
            </div>

            <div class = "questionnaire-answers-wrapper">
                <h1>QUESTIONARIO IDD - RISPOSTE</h1>

                <div class = "one-question-pair one-question-pair-first">
                    <div class = "personal-info-sub-wrapper">
                        <div class="question">
                            <strong>Nome / Ragione sociale</strong>
                        </div>

                        <div class = "answer">
                            {{ $idd_first_name . ' ' . $idd_last_name }}
                        </div>
                    </div>
                    <div class = "personal-info-sub-wrapper">
                        <div class="question">
                            <strong>Codice fiscale / Partita IVA</strong>
                        </div>

                        <div class = "answer">
                            {{ $idd_tax_code }}
                        </div>
                    </div>
                    @if( $idd_type == 'private' )
                    <div class = "personal-info-sub-wrapper">
                        <div class="question">
                            <strong>Data di nascita</strong>
                        </div>

                        <div class = "answer">
                            {{ $idd_birthday }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Vuoi proteggere la tua persona o la tua sfera professionale?</strong>
                    </div>

                    <div class = "answer">
                        @if($idd_private_life == true)
                            <div>Vita privata</div>
                        @endif
                        @if($idd_professional_life == true)
                            <div>Sfera professionale</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Quali sono le esigenze assicurative?</strong>
                    </div>

                    <div class = "answer">
                        @if($idd_insurance_needs_professional_activity == true)
                            <div>Tutela attività professionale</div>
                        @endif
                        @if($idd_insurance_needs_employee_manager_life == true)
                            <div>Assicurare la vita dei tuoi dipendenti e dirigenti</div>
                        @endif
                        @if($idd_insurance_needs_employee_manager_retirement == true)
                            <div>Integrare la pensione dei tuoi dipendenti e dirigenti</div>
                        @endif
                        @if($idd_insurance_needs_company_assets == true)
                            <div>Gestire il patrimonio aziendale</div>
                        @endif
                        @if($idd_insurance_needs_business_credit == true)
                            <div>Proteggere il credito aziendale</div>
                        @endif
                        @if($idd_insurance_needs_vehicle == true)
                            <div>Assicurare i veicoli</div>
                        @endif
                        @if($idd_insurance_needs_injuries_illness == true)
                            <div>Assicurarsi in caso di infortuni e malattia</div>
                        @endif
                        @if($idd_insurance_needs_home_family == true)
                            <div>Assicurarsi in caso di infortuni e malattia,Proteggere casa e famiglia</div>
                        @endif
                        @if($idd_insurance_needs_family_members == true)
                            <div>Assicurare la tua vita o quella dei tuoi famigliari</div>
                        @endif
                        @if($idd_insurance_needs_pension == true)
                            <div>Integrare la tua pensione</div>
                        @endif
                        @if($idd_insurance_needs_annuity == true)
                            <div>Garantire una rendita</div>
                        @endif
                        @if($idd_insurance_needs_heirs_income == true)
                            <div>Tutelare il reddito agli eredi</div>
                        @endif
                        @if($idd_insurance_needs_investing_saving == true)
                            <div>Investire/ Risparmiare</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Parlando della tua attività, parlaci della tua professione </strong>
                    </div>
                    <div class = "answer">
                        {{ $idd_talking_business_profession }}
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Parlando della tua attività cosa proteggeresti?</strong>
                    </div>
                    <div class = "answer">
                        @if($idd_business_protect_danni_to_me == true)
                            <div>Danni a beni</div>
                        @endif
                        @if($idd_business_protect_damage_others == true)
                            <div>Danni provocati ad altri</div>
                        @endif
                        @if($idd_business_protect_legal_disputes == true)
                            <div>Da controversie legali</div>
                        @endif
                        @if($idd_business_protect_activity_interruption == true)
                            <div>Dall&rsquo;interruzione dell&rsquo;attività</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Parlando di infortuni e malattia, da quali eventi ti vuoi tutelare?</strong>
                    </div>
                    <div class = "answer">
                        @if($idd_accident_protect_disease == true)
                            <div>Malattia</div>
                        @endif
                        @if($idd_accident_protect_hospitalization == true)
                            <div>Ricovero ospedaliero</div>
                        @endif
                        @if($idd_accident_protect_accident == true)
                            <div>Infortuni</div>
                        @endif
                        @if($idd_accident_protect_traveling == true)
                            <div>Imprevisti in caso di viaggi all estero</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Parlando di casa e famiglia, cosa si vuole proteggere?</strong>
                    </div>
                    <div class = "answer">
                        @if($idd_home_family_protect_family == true)
                            <div>Famiglia</div>
                        @endif
                        @if($idd_home_family_protect_house == true)
                            <div>Casa, condominio</div>
                        @endif
                        @if($idd_home_family_protect_legal_dispute == true)
                            <div>Controversie legali</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Quali sono le aspettative rispetto al&rsquo;capitale versato?</strong>
                    </div>
                    <div class = "answer">
                        @if($idd_paid_up_condition_after_expiration == true)
                            <div>L&rsquo;investitore vuole che il capitale sia garantito alla scadenza del contratto</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Qual è il livello di tolleranza al rischio?</strong>
                    </div>
                    <div class = "answer">
                        <div>{{ $idd_risk_tolerance_media_sr13_sr14 }}</div>
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Qual è il livello di conoscenza delle dinamiche del mercato finanziario assicurativo?</strong>
                    </div>
                    <div class = "answer">
                        <div>{{ $idd_insurance_knowledge_level_base }}</div>
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Preferiresti un accantonamento</strong>
                    </div>
                    <div class = "answer">
                        @if($idd_subscription_type == 'annual')
                            <div>Annuale</div>
                        @elseif($idd_subscription_type == 'half-yearly')
                            <div>Semestrale</div>
                        @elseif($idd_subscription_type == 'half-yearly')
                            <div>Mensile</div>
                        @endif
                    </div>
                </div>

                <div class = "one-question-pair">
                    <div class="question">
                        <strong>Parlando della sua professione, qual è il fatturato dell&rsquo;ultimo anno?</strong>
                    </div>
                    <div class = "answer">
                        <div>{{ $idd_business_last_year_turnover }}</div>
                    </div>
                </div>

            </div>

            <div class = "questionnaire-answers-wrapper">
                <h1>QUESTIONARIO IDD - RISULTATO</h1>

                <div class = "one-question-pair one-question-pair-first result-container">
                    @if( ($idd_type == 'private' && $idd_insurance_needs_injuries_illness) || ($idd_type == 'agency' && $idd_insurance_needs_employee_manager_life ))
                    <div class="question">
                        <strong>Sussidio Mutualistico a rimborso spese diagnostiche e di ricovero con o senza intervento chirurgico - Coeprtura infortuni H24 - Copertura per non autosufficeinti</strong>
                    </div>
                    <div class="question">
                        <strong>Coeprtura infortuni H24</strong>
                    </div>
                    <div class="question">
                        <strong> Copertura per non autosufficeinti</strong>
                    </div>
                    @endif
                    @if( ($idd_type == 'private' && $idd_insurance_needs_investing_saving) || ($idd_type == 'agency' && $idd_insurance_needs_company_assets))
                    <div class="question">
                        <strong>Assicurazione a premio annuale con rivalutazione collegate al rendimento di gestioni interne separate</strong>
                    </div>
                    @endif
                    @if( ($idd_type == 'private' && $idd_insurance_needs_family_members) || ($idd_type == 'agency' && $idd_insurance_needs_injuries_illness) )
                    <div class="question">
                        <strong> Polizza temporanea caso morte </strong>
                    </div>
                    @endif
                </div>
        </div>

        <style>
            body{
                padding: 20px;
                margin: 0 auto;
                width: 726px;
                border-left: 50px solid rgb(12, 82, 157);
                background-color: white;
                padding-bottom: 0;
            }
            html{
                padding: 0;
                margin: 0;
                background-color: grey;
            }

            .logo{
                text-align: center;
            }
            .logo img{
                width: 50%;
            }
            .questionnaire-answers-wrapper{
                margin-top: 40px;
                padding: 20px;
            }
            .questionnaire-answers-wrapper h1{
                color: rgb(236, 143, 8);
                text-align: right;
                font-size: 28px;
                margin-bottom: 40px;
            }

            .questionnaire-answers-wrapper .question{
                color: rgb(60, 60, 60);
            }

            .questionnaire-answers-wrapper .answer{
                margin-top: 15px;
                margin-left: 15px;
                color: rgb(90, 90, 90);
            }
            .questionnaire-answers-wrapper .one-question-pair-first{
                margin-top: 0px;
            }
            .questionnaire-answers-wrapper .one-question-pair{
                margin-top: 30px;
            }
            .personal-info-sub-wrapper{
                width: 32%;
                display: inline-block;
                box-sizing: border-box;
            }
            .result-container .question{
                margin-bottom: 15px;
            }
        </style>
    </body>
</html>
