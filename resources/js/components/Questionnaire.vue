  <template>  
    <div class = "container questionnaire-container">

        <loading :active.sync="isLoading"
        :is-full-page="fullPage"></loading>

        <div class = "row mt-4">
            <div class = "col-md-4">
                <md-toolbar>
                    <span class="md-title">Sei un privato o una azienda?</span>
                </md-toolbar>
                <md-content>
                    <md-radio v-model="question_form.idd_type" value="private">Privato</md-radio>
                    <md-radio v-model="question_form.idd_type" value="agency" class="md-primary">Azienda</md-radio>
                </md-content>
            </div>
            <div class = "col-md-8">
                <md-toolbar>
                    <span class="md-title">Dati personali del contraente</span>
                </md-toolbar>
                <md-content>
                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field>
                                <label for="firstName">Nome / Ragione sociale</label>
                                <md-input v-model = 'question_form.idd_first_name' type="text"  md-dense/>
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100">
                            <md-field>
                                <label>Cognome</label>
                                <md-input v-model = 'question_form.idd_last_name' type="text" />
                            </md-field>
                        </div>
                    </div>
                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field>
                                <label>Codice fiscale / Partita IVA</label>
                                <md-input v-model = 'question_form.idd_tax_code' type="text" />
                            </md-field>
                        </div>
                        <div class="md-layout-item md-small-size-100" v-show = 'question_form.idd_type == "private"'>
                            <md-field class = "birthday_container">
                                <span class = "birthday_label">Data di nascita</span>
                                <md-input v-model = 'question_form.idd_birthday' type="date" value = "01/01/2018"/>
                            </md-field>
                        </div>
                    </div>
                </md-content>
            </div>
        </div>

        <div class = "row mt-4">
            <div class = "col-md-12">
                <md-toolbar>
                    <span class="md-title">Customer Speaking</span>
                </md-toolbar>
                <md-content>

                    <md-subheader class = "mt-4">Vuoi proteggere la tua persona o la tua sfera professionale?</md-subheader>

                    <div class = 'ml-4'>
                        <md-checkbox v-model="question_form.idd_private_life" class="md-primary">Vita privata</md-checkbox>
                        <md-checkbox v-model="question_form.idd_professional_life" class="md-primary">Sfera professionale</md-checkbox>
                    </div>

                    <!--Insurance Need-->
                    <md-subheader>Quali sono le esigenze assicurative?</md-subheader>
                    <div class = 'ml-4 insurance-needs-checkboxes-container'>
                        <div class = "row">
                            <div class = "col-md-6">
                                <md-checkbox v-model="question_form.idd_insurance_needs_professional_activity" class="md-primary">Tutela attività professionale</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_employee_manager_life" class="md-primary" v-bind:class="{ 'mandatory-field': question_form.idd_type == 'agency' }">Assicurare la vita dei tuoi dipendenti e dirigenti</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_employee_manager_retirement" class="md-primary">Integrare la pensione dei tuoi dipendenti e dirigenti</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_company_assets" class="md-primary" v-bind:class="{ 'mandatory-field': question_form.idd_type == 'agency' }">Gestire il patrimonio aziendale</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_business_credit" class="md-primary">Proteggere il credito aziendale</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_vehicle" class="md-primary">Assicurare i veicoli</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_injuries_illness" class="mandatory-field">Assicurarsi in caso di infortuni e malattia</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_home_family" class="md-primary">Proteggere casa e famiglia</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_family_members" v-bind:class="{ 'mandatory-field': question_form.idd_type == 'private' }" >Assicurare la tua vita o quella dei tuoi famigliari</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_pension" class="md-primary">Integrare la tua pensione</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_annuity" class="md-primary">Garantire una rendita</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_heirs_income" class="md-primary">Tutelare il reddito agli eredi</md-checkbox>
                                <md-checkbox v-model="question_form.idd_insurance_needs_investing_saving" v-bind:class="{ 'mandatory-field': question_form.idd_type == 'private' }">Investire/ Risparmiare</md-checkbox>
                            </div>
                            <div class = "col-md-6 output_container">
                                <p v-if="(question_form.idd_type == 'private' && question_form.idd_insurance_needs_injuries_illness) || (question_form.idd_type == 'agency' && question_form.idd_insurance_needs_employee_manager_life)">-Sussidio Mutualistico a rimborso spese diagnostiche e di ricovero con o senza intervento chirurgico<br>-Coeprtura infortuni H24<br>-Copertura per non autosufficeinti</p>
                                <p v-if="(question_form.idd_type == 'private' && question_form.idd_insurance_needs_investing_saving) || (question_form.idd_type == 'agency' && question_form.idd_insurance_needs_company_assets)">-Assicurazione a premio annuale con rivalutazione collegate al rendimento di gestioni interne separate</p>
                                <p v-if="(question_form.idd_type == 'private' && question_form.idd_insurance_needs_family_members) || (question_form.idd_type == 'agency' && question_form.idd_insurance_needs_injuries_illness)">-Polizza temporanea caso morte</p>
                            </div>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Parlando della tua attività, parlaci della tua professione</md-subheader>
                    <div class = 'ml-4'>
                        <md-field>
                            <label>Campo testuale libero</label>
                            <md-textarea v-model = "question_form.idd_talking_business_profession" ></md-textarea>
                        </md-field>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Parlando della tua attività cosa proteggeresti?</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_business_protect_danni_to_me" class="md-primary">Danni a beni</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_business_protect_damage_others" class="md-primary">Danni provocati ad altri</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_business_protect_legal_disputes" class="md-primary">Da controversie legali</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_business_protect_activity_interruption" class="md-primary">Dall'interruzione dell'attività</md-checkbox>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Parlando di infortuni e malattia, da quali eventi ti vuoi tutelare?</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_accident_protect_disease" class="mandatory-field">Malattia</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_accident_protect_hospitalization" class="mandatory-field">Ricovero ospedaliero</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_accident_protect_accident" class="mandatory-field">Infortuni</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_accident_protect_traveling" class="md-primary">Imprevisti in caso di viaggi all'estero</md-checkbox>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Parlando di casa e famiglia, cosa si vuole proteggere?</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_home_family_protect_family" class="md-primary">Famiglia</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_home_family_protect_house" class="md-primary">Casa, condominio</md-checkbox>
                        </div>
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_home_family_protect_legal_dispute" class="md-primary">Controversie legali</md-checkbox>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Quali sono le aspettative rispetto al capitale versato?</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-checkbox v-model="question_form.idd_paid_up_condition_after_expiration" class="md-primary">Garanzia del capitale alla scadenza del contratto</md-checkbox>
                        </div>
                    </div>

                     <!---------------------------->
                    <md-subheader class = "mt-4">Qual è il livello di tolleranza al rischio?</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_risk_tolerance_media_sr13_sr14" value="Bassa">Bassa</md-radio>
                        </div>
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_risk_tolerance_media_sr13_sr14" value="Media">Media</md-radio>
                        </div>
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_risk_tolerance_media_sr13_sr14" value="Alta">Alta</md-radio>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Qual è il livello di conoscenza delle dinamiche del mercato finanziario assicurativo?</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_insurance_knowledge_level_base" value="Bassa">Bassa</md-radio>
                        </div>
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_insurance_knowledge_level_base" value="Media">Media</md-radio>
                        </div>
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_insurance_knowledge_level_base" value="Alta">Alta</md-radio>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Preferiresti un accantonamento</md-subheader>
                    <div class="md-layout md-gutter ml-4">
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_subscription_type" value="annual">Annuale</md-radio>
                        </div>
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_subscription_type" value="half-yearly">Semestrale</md-radio>
                        </div>
                        <div class="md-layout-item">
                            <md-radio v-model = "question_form.idd_subscription_type" value="monthly">Mensile</md-radio>
                        </div>
                    </div>

                    <!---------------------------->
                    <md-subheader class = "mt-4">Parlando della sua professione, qual è il fatturato dell'ultimo anno?</md-subheader>
                    <div class="md-layout ml-4">
                        <div class="md-layout-item">
                            <md-field>
                                <md-input v-model = 'question_form.idd_business_last_year_turnover' type="text"  md-dense/>
                            </md-field>
                        </div>
                    </div>

                    <!---------------------------->
                    <div class = "ml-4 mt-4">
                        <md-button class="md-dense md-raised md-primary pull-right" @click="onFinishQuestionnaire">Invia</md-button>
                    </div>
                </md-content>
            </div>
        </div>

        <md-dialog-prompt
            :md-active.sync="showEmailModal"
            v-model="question_form.idd_email"
            md-title="Qual è il tuo indirizzo e-mail?"
            md-input-maxlength="30"
            md-input-placeholder="Type your Email..."
            md-confirm-text="Invia"
            md-cancel-text="Annulla"
            @md-confirm = "onSubmitQuestionnaire"/>
        <md-dialog-alert
            :md-active.sync="showValidationModal"
            md-title="Warning!"
            :md-content="validationErrorMsg" />
    </div>
</template>
<script>
    // Import component
    import Loading  from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {   
    components: {
        Loading
    },
    data: ()=>{
        return {
            isLoading: false,
            fullPage: true,
            showEmailModal: false,
            showValidationModal: false,
            validationErrorMsg: '',
            question_form:{
                idd_type                : 'private',
                idd_email               : '',
                idd_first_name          : '',
                idd_last_name           : '',
                idd_tax_code            : '',
                idd_birthday             : '',
                idd_private_life        : false,
                idd_professional_life   : false,

                //Quali sono le esigenze assicurative?
                idd_insurance_needs_professional_activity       : false,
                idd_insurance_needs_employee_manager_life       : false,    //Mandatory Field For Agency
                idd_insurance_needs_employee_manager_retirement : false,
                idd_insurance_needs_company_assets              : false,    //Mandatory Field For Agency
                idd_insurance_needs_business_credit             : false,
                idd_insurance_needs_vehicle                     : false,
                idd_insurance_needs_injuries_illness            : false,    //Mandatory Field For Private, Agency
                idd_insurance_needs_home_family                 : false,
                idd_insurance_needs_family_members              : false,    //Mandatory Field For Private
                idd_insurance_needs_pension                     : false,
                idd_insurance_needs_annuity                     : false,
                idd_insurance_needs_heirs_income                      : false,
                idd_insurance_needs_investing_saving                  : false,    //Mandatory Field For Private

                //Parlando della tua attività, parlaci della tua professione
                idd_talking_business_profession     : '',

                //Parlando della tua attività cosa proteggeresti?
                idd_business_protect_danni_to_me            : false,
                idd_business_protect_damage_others          : false,
                idd_business_protect_legal_disputes         : false,
                idd_business_protect_activity_interruption  : false,

                //Parlando di infortuni e malattia, da quali eventi ti vuoi tutelare?
                idd_accident_protect_disease            : false,        //Mandatory
                idd_accident_protect_hospitalization    : false,        //Mandatory
                idd_accident_protect_accident           : false,        //Mandatory
                idd_accident_protect_traveling          : false,

                //Parlando di casa e famiglia, cosa si vuole proteggere?
                idd_home_family_protect_family          : false,
                idd_home_family_protect_house           : false,
                idd_home_family_protect_legal_dispute   : false,

                //Quali sono le aspettative rispetto al capitale versato?
                idd_paid_up_condition_after_expiration  : false,

                //Qual è il livello di tolleranza al rischio?
                idd_risk_tolerance_media_sr13_sr14      : 'Bassa',

                //Qual è il livello di conoscenza delle dinamiche del mercato finanziario assicurativo?
                idd_insurance_knowledge_level_base      : 'Bassa',

                //Preferiresti un accantonamento
                idd_subscription_type                   : 'annual',

                //Parlando della sua professione, qual è il fatturato dell'ultimo anno?
                idd_business_last_year_turnover         : '',

            }
        }
    },
    methods: {
        onFinishQuestionnaire(){
            if( this.validateFormData() )
                this.showEmailModal = true; 
        },
        onSubmitQuestionnaire(){
            if(this.question_form.idd_email == ''){
                this.validationErrorMsg = "Please fill out Dati personali del   contraente.";
                this.showValidationModal = true;
                return false;
            }
            this.isLoading = true;
            this.send_questionnaire( this.question_form, (response) => {
                this.isLoading = false;
                if(response.success == true)
                {
                    this.$emit('questionnaireFinishedHandler', this.question_form);
                }
            } );
        },

        send_questionnaire: function(form_values, callback){
            axios.post('/register_questionnaire', form_values).then((response)=>{
                if(response.data.success)
                    callback({success:true});
                else
                    callback({success:false});
            });
        },

        validateFormData: function(){
            let _data = this.question_form;
            if(_data.idd_first_name == '' || _data.idd_last_name == '' || _data.idd_tax_code == '')
            {
                this.validationErrorMsg = "Please fill out Dati personali del contraente.";
                this.showValidationModal = true;
                return false;
            }
            if(_data.idd_type == 'private' && !_data.idd_insurance_needs_injuries_illness && !_data.idd_insurance_needs_family_members && !_data.idd_insurance_needs_investing_saving)
            {
                this.validationErrorMsg = "Per favore, compilare almeno un campo obbligatorio fra quelli presenti evidenziati in rosso.";
                this.showValidationModal = true;
                return false;
            }

            if(_data.idd_type == 'agency' && !_data.idd_insurance_needs_employee_manager_life && !_data.idd_insurance_needs_company_assets && !_data.idd_insurance_needs_injuries_illness)
            {
                this.validationErrorMsg = "Per favore, compilare almeno un campo obbligatorio fra quelli presenti evidenziati in rosso.";
                this.showValidationModal = true;
                return false;
            }

            if(!_data.idd_accident_protect_disease && !_data.idd_accident_protect_hospitalization && !_data.idd_accident_protect_accident)
            {
                this.validationErrorMsg = "Per favore, compilare almeno un campo obbligatorio fra quelli presenti evidenziati in rosso.";
                this.showValidationModal = true;
                return false;
            }

            return true;
        }
    }
    }
</script>

<style lang = 'css' scoped>

.questionnaire-container {
    padding-top: 4rem;
}

.md-radio {
    display: flex;
    margin-top: 15px;
}

.md-content{
    padding: 20px;
    padding-bottom: 60px;
}
.md-subheader{
    font-size: 16px;
    margin-top: 5px;
}

.md-toolbar {
    min-height: 45px;
}

.md-title{
    font-size: 18px;
}

.mt-2{
    margin-top: 10px;
}

.mt-4{
    margin-top: 20px;
}

.ml-4{
    margin-left: 20px;
}

.insurance-needs-checkboxes-container .md-checkbox{
    display: flex;
}
.birthday_label{
    margin-right: 20px;
}
.birthday_container{
    color: rgba(0,0,0,0.54);
    font-size: 16px;
    font-weight: 900;
}
.mandatory-field{
    color: rgb(130, 60, 60)
}
.output_container{
    font-size: 17px;
    line-height: 30px;
    padding-top: 50px;
    padding-right: 60px;
    font-weight: 500;
}
</style>
