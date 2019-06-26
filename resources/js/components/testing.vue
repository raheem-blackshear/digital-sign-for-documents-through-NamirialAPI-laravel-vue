<template>
    <div>
        <loading :active.sync="isLoading"
            :is-full-page="fullPage">
        </loading>
        <Questionnaire v-if = "showQuestionnaire == true" @questionnaireFinishedHandler = "onQuestionnaireFinished" ></Questionnaire>
        <form-wizard v-if = "showWizard == true" ref="formWizard" @on-complete="onComplete" shape = "circle" color="#e67e22" title = "" subtitle = "">
            <h2 slot="title">
                <img class = "register_step_logo" src = "assets/img/Assiqura_Logo.png"/>
            </h2>
            
            <!-- <tab-content title="Informazione" icon="ti-info">
                <PersonalInfoStep ref="personalInfoStep"></PersonalInfoStep>
            </tab-content> -->
            
            <tab-content title="l'età " icon="ti-user" :before-change="ageStepValidate">
                <div class="container justify-content-center align-items-center align-content-center align-self-center" id="app-head" style="background-image:url(&quot;assets/img/team-motivation-teamwork-together-53958.jpeg&quot;);background-position:center;background-size:cover;background-repeat:no-repeat;">
                    <h4 class="text-center text-head" style="font-family:Montserrat, sans-serif;font-style:normal;font-weight:bold;font-size:15px;padding-top:21px;color:rgb(230,230,230);">Ognuno di noi ha tante cose a cui tiene,<br></h4>
                    <div class="row text-center">
                        <img src="assets/img/LogoneBlalloNice.png" id="center-img-head" style="width:50px;margin:0 auto;">
                    </div>
                    <h4 class="text-center text-head" style="font-weight:bold;font-family:Montserrat, sans-serif;font-size:16px;color:rgb(255,255,255);padding-top:-36px;">proteggile tutte con un unica soluzione.<br></h4>
                </div>
                <div class="container">
                    <p class="para-data" style="color:rgba(33,37,41,0.84);">Scegli il prodotto più completo che garantisca Tutela e Risparmio.&nbsp;</p>
                    <p class="para-data data-calco">Inserisci l'età e ottieni la tua soluzione</p>
                    <div class = "age-wrapper">
                        <NumberInputSpinner :min="-1" :max="100" v-model="form.age" />
                    </div>
                </div>
            </tab-content>
            <tab-content title="protezioni" icon="ti-hand-point-right">
                <explanation-step></explanation-step>
            </tab-content>
            <tab-content title="Pacchetto" icon="ti-money">
                <SelectPackageStep ref="selectPackageStep" @selectPackageHandler = "onSelectPackage" ></SelectPackageStep>
            </tab-content>
            <!-- <tab-content title="Informazione" icon="ti-info">
                <PersonalInfoStep ref="personalInfoStep"></PersonalInfoStep>
            </tab-content> -->

            <template slot="footer" slot-scope="props">
                <div class=wizard-footer-left>
                    <wizard-button  v-if="props.activeTabIndex > 0 && !props.isLastStep" @click.native="props.prevTab()" :style="props.fillButtonStyle">Indietro</wizard-button>
                    </div>
                    <div class="wizard-footer-right">
                    <wizard-button v-if="!props.isLastStep && props.activeTabIndex != 2" @click.native="props.nextTab()" class="wizard-footer-right" :style="props.fillButtonStyle">Avanti</wizard-button>
                    <wizard-button v-else-if="props.isLastStep" class="wizard-footer-right finish-button" @click.native="finishSteps" :style="props.fillButtonStyle">Inviare</wizard-button>
                </div>
            </template>
        </form-wizard>
    </div>
</template>

<script>
    import {FormWizard, TabContent} from 'vue-form-wizard';
    import NumberInputSpinner from 'vue-number-input-spinner';

    //Loading
    import Loading  from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    import ExplanationStep from './ExplanationStep.vue';
    import SelectPackageStep from './SelectPackageStep.vue';
    import PersonalInfoStep from './PersonalInfoStep.vue';
    import Questionnaire from './Questionnaire.vue';

    import VueRouter from 'vue-router'
    Vue.use(require('vue-cookies'));
    Vue.use(VueRouter);

    import 'v-slim-dialog/dist/v-slim-dialog.css'
    import SlimDialog from 'v-slim-dialog'
    Vue.use(SlimDialog)

    export default {
        props: ['logged_in'],
        components: {
            Questionnaire,
            ExplanationStep,
            SelectPackageStep,
            PersonalInfoStep,
            NumberInputSpinner,
            FormWizard,
            TabContent,
            SlimDialog,
            Loading
        },
        data: ()=>{
            return {
            isLoading: false,
            fullPage: true,
            // showWizard: false,
            showWizard: true,
            showQuestionnaire: false,
            form :{
                age: 18,
                price: 0,
                personalInfo: {},
                questionnaire_data: {},
                packageType: 0
            },
          }
        },
        beforeMount(){
            /*
            if(this.check_logged_in())
            {
                var register_data = this.$cookies.get('register_data', this.form);
                if(register_data != "null")
                {
                    this.send_register_request(register_data, (response) => {
                        if(response.success)
                            location.href = "/regSuccessfull";
                        else
                            this.showQuestionnaire = true;
                    });
                }
                else
                    this.showQuestionnaire = true;
            }
            else*/
            this.showQuestionnaire = true;
        },
        methods: {
            onComplete: function(){
                if(this.check_logged_in())
                {
                    this.isLoading = true;
                    this.send_register_request(this.form, (response)=>{
                        if(response.success)
                        {
                            location.href = response.redirect;
                        }
                        this.isLoading = false;
                    });
                }
                else
                {
                    this.$cookies.set('register_data', this.form);
                    location.href = "/login";
                }
            },
            check_logged_in: function(){
                return this.logged_in == 1;
            },







            // send_register_request: function(form_values, callback){
            //     axios.post('/register_sale', form_values).then((response)=>{
            //         callback(response.data);
            //     });
            //     this.$cookies.set('register_data', null);
            // }

            /* register_sale_test */
            send_register_request: function(form_values, callback){
                axios.post('/register_sale_test', form_values).then((response)=>{
                    callback(response.data);
                });
                // this.$cookies.set('register_data', null);
            },









            ageStepValidate: function(){
                //let the slect package step know the age price
                this.$refs.selectPackageStep.agePrice = this.priceFromAge(this.form.age);

                return this.form.age >= 18 && this.form.age <= 59;
            },
            onSelectPackage: function(price, packageType){
                this.form.price = price;
                this.form.packageType = packageType;
                this.$refs.formWizard.nextTab();
            },
            finishSteps: function(){
                if(this.$refs.personalInfoStep.validateUser())
                {
                    this.form.personalInfo = this.$refs.personalInfoStep.form;
                    this.$refs.formWizard.$emit('on-complete');
                }
            },

            onQuestionnaireFinished: function(data){
                this.form.questionnaire_data = data;
                this.showQuestionnaire = false;
                this.showWizard = true;
                console.log(this.form.questionnaire_data);
            },

            priceFromAge: function(number){
                if (number == 18){
                    return "300.000";
                }
                if (number == 19){
                    return "286.807";
                }
                if (number == 20){
                    return "273.390";
                }
                if (number == 21){
                    return "259.665";
                }
                if (number == 22){
                    return "245.633";
                }
                if (number == 23){
                    return "231.839";
                }
                if (number == 24){
                    return "217.707";
                }
                if (number == 25){
                    return "203.343";
                }
                if (number == 26){
                    return "189.314";
                }
                if (number == 27){
                    return "175.918";
                }
                if (number == 28){
                    return "162.748";
                }
                if (number == 29){
                    return "150.653";
                }
                if (number == 30){
                    return "139.104";
                }
                if (number == 31){
                    return "128.388";
                }
                if (number == 32){
                    return "118.389";
                }
                if (number == 33){
                    return "109.223";
                }
                if (number == 34){
                    return "100.604";
                }
                if (number == 35){
                    return "92.688";
                }
                if (number == 36){
                    return "85.389";
                }
                if (number == 37){
                    return "78.644";
                }
                if (number == 38){
                    return "72.464";
                }
                if (number == 39){
                    return "66.725";
                }
                if (number == 40){
                    return "61.459";
                }
                if (number == 41){
                    return "56.597";
                }
                if (number == 42){
                    return "52.120";
                }
                if (number == 43){
                    return "47.974";
                }
                if (number == 44){
                    return "44.126";
                }
                if (number == 45){
                    return "40.584";
                }
                if (number == 46){
                    return "37.313";
                }
                if (number == 47){
                    return "34.816";
                }
                if (number == 48){
                    return "32.439";
                }
                if (number == 49){
                    return "30.187";
                }
                if (number == 50){
                    return "28.048";
                }
                if (number == 51){
                    return "26.020";
                }
                if (number == 52){
                    return "24.114";
                }
                if (number == 53){
                    return "22.323";
                }
                if (number == 54){
                    return "20.648";
                }
                if (number == 55){
                    return "19.080";
                }
                if (number == 56){
                    return "17.620";
                }
                if (number == 57){
                    return "16.255";
                }
                if (number == 58){
                    return "14.985";
                }
                if (number == 59){
                    return "13.801";
                }
            }
    }
  }
</script>
