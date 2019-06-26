<style>
.form_container br {
  height: 0px;
}
.form_container {
  width: 80%;
  margin: 0px auto 0px;
  padding-top: 50px;
}
.form_container h1 {
  color: #3c8dbc;
  font-weight: bold;
  font-size: 20px;
  padding: 0px;
  line-height: 30px;
  margin: 30px 0px;
}
.form_container p {
  font-size: 16px;
  color: #000;
  font-weight: bold;
  margin: 0px;
  padding: 0px;
  text-align: center;
  text-transform: uppercase;
}
.form_container p span {
  display: block;
  line-height: 11px;
  font-size: 10px;
  margin-bottom: 35px;
}
.form_container span.birthday_label {
  margin-right: 10px;
  font-size: 16px;
  color: #777;
  font-weight: 500;
}
.form_container .md-checkbox .md-checkbox-label {
  height: auto;
}
</style>
<template>
  <div class="form_container">
       <loading :active.sync="isLoading"
        :is-full-page="fullPage"></loading>
    <!-- first form start -->
    <div class="row justify-content-center mt-4">
      <md-card class="md-layout-item md-size-100 md-small-size-100">
        <md-card-header>
          <div class="md-title text-center">
            <h1>Familiari da garantire</h1>
          </div>
        </md-card-header>
        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-100 md-small-size-100">
              <p>
                Preso atto dell’Informativa di cui sopra, relativamente al trattamento e alla comunicazione a terzi dei dati personali, che è stata fornita ai sensi ai sensi del Regolamento UE 2016/679 relativo
                alla protezione delle persone fisiche con riguardo ai dati personali a opera di ASSYTECH S.R.L., per i soggetti indicati nella predetta informativa e nei limiti del Regolamento stesso,
              </p>
            </div>
          </div>
        </md-card-content>
        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-25 md-small-size-100">
              <md-checkbox value="do" class="md-primary" v-model="form.contractordiamoilconsenso" >do/diamo il consenso</md-checkbox>
            </div>
            <div class="md-layout-item md-size-25 md-small-size-100">
              <md-checkbox value="nego" class="md-primary" v-model="form.contractorneghiamoilconsenso">nego/neghiamo il consenso</md-checkbox>
            </div>
          </div>
        </md-card-content>
        <md-card-content>
          <div class="md-title text-left">
            <p>Resta fermo il fatto che il consenso, se dato, è condizionato al rispetto delle Condizioni della vigente normativa.</p>
          </div>
          <div class="md-layout-item md-size-100 md-small-size-100">
             <md-field>
              <label for="firstName">(Cognome e nome / Denominazione)</label>
              <md-input type="text" v-model="form.contractordenominazione" md-dense/>
              <span class="md-error">The Partita IVA is required</span>
              </md-field>
          </div>
        </md-card-content>

        <md-card-content>
          <div class="md-title text-left">
            <p>Dati anagrafici del contraente</p>
          </div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-50 md-small-size-100">
               <md-field>
                <label for="firstName">Comune di Nascita</label>
                <md-input type="text" v-model="form.contractorComunediNascita" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
                </md-field>
            </div>
            <div class="md-layout-item md-size-50 md-small-size-100">
              <md-field>
                <label for="firstName">Provincia di Nascita</label>
                <md-input type="text" v-model="form.contractorProvinciadiNascita" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
              </md-field>
            </div>
          </div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-50 md-small-size-100">
              <md-field>
                <label for="firstName">Codice Fiscale</label>
                <md-input type="text" v-model="form.contractorCodiceFiscale" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
              </md-field>
            </div>
            <div class="md-layout-item md-size-50 md-small-size-100">
              <md-field>
                <label for="firstName">Partita Iva</label>
                <md-input type="text" v-model="form.contractorPartitaIva" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
              </md-field>
            </div>
          </div>
        </md-card-content>
        <md-card-content>
          <div class="md-title text-left">
            <p>Residenza o Sede Legale</p>
          </div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-100 md-small-size-100">
              <md-field>
                <label>Indirizzo</label>
                <md-textarea v-model="form.contractorIndirizzo"></md-textarea>
              </md-field>
            </div>

            <div class="md-layout-item md-size-50 md-small-size-100">
              <md-field>
                <label for="firstName">CAP</label>
                <md-input type="text" v-model="form.contractorCAP" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
              </md-field>
            </div>
            <div class="md-layout-item md-size-50 md-small-size-100">
              <md-field>
                <label for="firstName">Città</label>
                <md-input type="text" v-model="form.contractorCitta" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
              </md-field>
            </div>
          </div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-100 md-small-size-100">
              <md-field>
                <label for="firstName">Provincia</label>
                <md-input type="text" v-model="form.contractorProvincia" md-dense/>
                <span class="md-error">The Partita IVA is required</span>
              </md-field>
            </div>
          </div>
            <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-100 md-small-size-100">
           <div class = "ml-4 mt-4">
              <md-button class="md-dense md-raised md-primary pull-right" @click="onFinishFirstForm(form)">procedere</md-button>
              </div>
             </div>
          </div> 
        </md-card-content>
      </md-card>
    </div>
    <!-- last form end  -->
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import Loading  from 'vue-loading-overlay';
import {
  required,
  email,
  minLength,
  maxLength
} from "vuelidate/lib/validators";

export default {
  name: "FormValidation",
  mixins: [validationMixin],
    components: {
        Loading
    },
  data: () => ({
    isLoading: false,
    fullPage: true,
    form: {
      contractordiamoilconsenso: null,
      contractorneghiamoilconsenso: null,
      contractordenominazione: null,
      contractorComunediNascita: null,
      contractorProvinciadiNascita: null,
      contractorCodiceFiscale: null,
      contractorPartitaIva: null,
      contractorIndirizzo: null,
      contractorCAP: null,
      contractorCitta: null,
      contractorProvincia: null,
    }
  }),
  methods: {
   onFinishFirstForm:function(){
            this.isLoading = true;
            this.send_register_request(this.form, (response)=>{
                if(response.success)
                {
                    
                    $.each(response.redirect, function(k, url){
                        // location.href = response.redirect;
                      window.open(url, '_self');
                    });
                }
                this.isLoading = false;
            });
    },
    check_logged_in: function(){
        return this.logged_in == 1;
    },
   send_register_request: function(form, callback){
        axios.post('/register_first_salesform', form).then((response)=>{
          console.log(response);
            callback(response.data);
        });
    }
  }
};
</script>