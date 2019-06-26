<template>
<div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 id="rata-testo" style="font-size:25px;">Compila i campi sottostanti per proseguire</h1>
            </div>
        </div>
    </div>
    <div class="container" id="container-trat-dati">
        <div class="row">
            <div class="col">
                <p id="termine-titolo">Prima di fornirci i Suoi Dati personali attraverso il Form, La preghiamo di leggere la presente Informativa.<br></p>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col d-flex justify-content-center"><button class="btn btn-primary" type="button" style="font-style:italic;font-family:Montserrat, sans-serif;    font-size: 18px !important;margin-top:-11px;" data-toggle="modal" data-target="#trattamento-dati">Consulta</button></div>
        </div>
    </div>

    <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-60 md-small-size-100">
            <md-card-header>
                <div class="md-title text-center">Contraente</div>
            </md-card-header>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field :class="getValidationClass('contractorType')">
                            <label for="allin-radio-namecontraente">Contraente</label>
                            <md-select name="contractorType" id="contractorType" v-model="form.contractorType" md-dense>
                            <md-option value="Persona fisica">Persona fisica</md-option>
                            <md-option value="Società">Società</md-option>
                            </md-select>
                            <span class="md-error">The Contraente is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorFirstName')">
                            <label for="firstName">Nome</label>
                            <md-input type="text" v-model="form.contractorFirstName"  md-dense/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorLastName')">
                            <label for="lastName">Cognome</label>
                            <md-input type="text" v-model="form.contractorLastName"/>
                            <span class="md-error">The Cognome is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorAddress')">
                            <label for="address">Indirizzo</label>
                            <md-input type="text" v-model="form.contractorAddress"/>
                            <span class="md-error">The Indirizzo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorTaxCode')">
                            <label for="taxCode">Cod. Fiscale / P. Iva</label>
                            <md-input type="text" v-model="form.contractorTaxCode"/>
                            <span class="md-error">The Cod. Fiscale / P. Iva is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorBirthday')">
                            <md-input type="date" v-model="form.contractorBirthday" value = "01/01/2018"/>
                            <span class="md-error">The Compleanno is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorBirthPlace')">
                            <label for="birthPlace">Luogo di nascita</label>
                            <md-input type="text" v-model="form.contractorBirthPlace"/>
                            <span class="md-error">Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorEmail')">
                            <label for="email">E-Mail</label>
                            <md-input type="email" v-model="form.contractorEmail"/>
                            <span class="md-error" v-if="!$v.form.contractorEmail.required">The email is required</span>
                            <span class="md-error" v-else-if="!$v.form.contractorEmail.email">Invalid email</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('contractorTelephone')">
                            <label for="telephone">Telefono</label>
                            <md-input type="text" v-model="form.contractorTelephone"/>
                            <span class="md-error">Telefono is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>

    <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-60 md-small-size-100">
            <md-card-header>
                <div class="md-title text-center">Assicurato</div>
                <div style="float:right">
                    <md-button class="md-raised md-primary" v-on:click = "copyInformation()">Clona Informazioni</md-button>
                </div>
            </md-card-header>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field :class="getValidationClass('insuredType')">
                            <label for="allin-radio-nameinsured">Assicurato</label>
                            <md-select name="insuredType" id="insuredType" v-model="form.insuredType" md-dense>
                            <md-option value="Persona fisica">Persona fisica</md-option>
                            <md-option value="Società">Società</md-option>
                            </md-select>
                            <span class="md-error">The Assicurato is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredFirstName')">
                            <label for="firstName">Nome</label>
                            <md-input type="text" v-model="form.insuredFirstName"  md-dense/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredLastName')">
                            <label for="lastName">Cognome</label>
                            <md-input type="text" v-model="form.insuredLastName"/>
                            <span class="md-error">The Cognome is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredAddress')">
                            <label for="address">Indirizzo</label>
                            <md-input type="text" v-model="form.insuredAddress"/>
                            <span class="md-error">The Indirizzo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredTaxCode')">
                            <label for="taxCode">Cod. Fiscale / P. Iva</label>
                            <md-input type="text" v-model="form.insuredTaxCode"/>
                            <span class="md-error">The Cod. Fiscale / P. Iva is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredBirthday')">
                            <md-input type="date" v-model="form.insuredBirthday" value = "01/01/2018"/>
                            <span class="md-error">The Compleanno is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredBirthPlace')">
                            <label for="birthPlace">Luogo di nascita</label>
                            <md-input type="text" v-model="form.insuredBirthPlace"/>
                            <span class="md-error">Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredEmail')">
                            <label for="email">E-Mail</label>
                            <md-input type="email" v-model="form.insuredEmail"/>
                            <span class="md-error" v-if="!$v.form.insuredEmail.required">The email is required</span>
                            <span class="md-error" v-else-if="!$v.form.insuredEmail.email">Invalid email</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredTelephone')">
                            <label for="telephone">Telefono</label>
                            <md-input type="text" v-model="form.insuredTelephone"/>
                            <span class="md-error">Telefono is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>

    <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-60 md-small-size-100">
            <md-card-header>
                <div class="md-title text-center">Beneficiario Caso Morte</div>
            </md-card-header>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field :class="getValidationClass('deathBenType')">
                            <label for="allin-radio-namedeathBen">Beneficiario Caso Morte</label>
                            <md-select name="deathBenType" id="deathBenType" v-model="form.deathBenType" md-dense>
                            <md-option value="Contraente">Contraente</md-option>
                            <md-option value="Altri">Altri</md-option>
                            <md-option value="Eredi">Eredi legittimi dell'assicurato</md-option>
                            </md-select>
                            <span class="md-error">The Beneficiario Caso Morte is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenFirstName')">
                            <label for="firstName">Nome</label>
                            <md-input type="text" v-model="form.deathBenFirstName"  md-dense/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenLastName')">
                            <label for="lastName">Cognome</label>
                            <md-input type="text" v-model="form.deathBenLastName"/>
                            <span class="md-error">The Cognome is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenAddress')">
                            <label for="address">Indirizzo</label>
                            <md-input type="text" v-model="form.deathBenAddress"/>
                            <span class="md-error">The Indirizzo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenTaxCode')">
                            <label for="taxCode">Cod. Fiscale / P. Iva</label>
                            <md-input type="text" v-model="form.deathBenTaxCode"/>
                            <span class="md-error">The Cod. Fiscale / P. Iva is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenBirthday')">
                            <md-input type="date" v-model="form.deathBenBirthday" value = "01/01/2018"/>
                            <span class="md-error">The Compleanno is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenBirthPlace')">
                            <label for="birthPlace">Luogo di nascita</label>
                            <md-input type="text" v-model="form.deathBenBirthPlace"/>
                            <span class="md-error">Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('insuredEmail')">
                            <label for="email">E-Mail</label>
                            <md-input type="email" v-model="form.deathBenEmail"/>
                            <span class="md-error" v-if="!$v.form.deathBenEmail.required">The email is required</span>
                            <span class="md-error" v-else-if="!$v.form.deathBenEmail.email">Invalid email</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('deathBenTelephone')">
                            <label for="telephone">Telefono</label>
                            <md-input type="text" v-model="form.deathBenTelephone"/>
                            <span class="md-error">Telefono is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>

    <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-60 md-small-size-100">
            <md-card-header>
                <div class="md-title text-center">Inserisci la tua email</div>
            </md-card-header>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field :class="getValidationClass('receiveEmail')">
                            <label for="email">E-Mail</label>
                            <md-input type="email" v-model="form.receiveEmail"/>
                            <span class="md-error" v-if="!$v.form.receiveEmail.required">The email is required</span>
                            <span class="md-error" v-else-if="!$v.form.receiveEmail.email">Invalid email</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="trattamento-dati">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family:Montserrat, sans-serif;font-style:italic;">Trattamento dati personali</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p id="rata-termini" style="margin-bottom:0;padding-top:7px;padding-bottom:0;"><strong>Prima di fornirci i Suoi Dati personali attraverso il Form, La preghiamo di leggere la presente Informativa</strong>, segnalandoLe che per “Dati personali” si intendono ai sensi del DLgs 196/2003 (Codice privacy) e della presente
                        sia quelli che Le richiediamo con il presente modulo che quelli spontaneamente da Lei forniti nel testo del messaggio del Form.&nbsp;<br></p>
                    <p id="rata-termini" style="padding:0;padding-top:0;margin:0;"><strong>Tipologia dei dati trattati:&nbsp;</strong>Al fine di fornirle correttamente le informazioni da Lei richieste sono indispensabili tutti i dati richiesti nel Form, si tratta esclusivamente di dati comuni identificativi e di
                        contatto (nominativo e mail).<br>Finalità dei trattamenti<br>I Dati vengono da noi raccolti e trattati con la esclusiva finalità di fornirle le informazioni richieste.<br></p>
                    <p id="rata-termini" style="padding:0;padding-top:0;margin:0;"><strong>Modalità di trattamento:&nbsp;</strong>I Dati vengono da noi trattati a mezzo del nostro sistema informatico, con l’applicazione delle Misure di Sicurezza previste dal Codice Privacy, nonché con modalità cartacea e la documentazione
                        relativa verrà correttamente mantenuta e protetta per tutto il tempo necessario al trattamento.<br>I dati forniti saranno trattati da nostri Collaboratori, in qualità di Responsabili od Incaricati, non verranno diffusi, potranno
                        essere comunicati a terzi solo se strettamente indispensabile in relazione alle Sue richieste.<br></p>
                    <p id="rata-termini" style="padding:0;padding-top:0;margin:0;"><strong>Durata del trattamento</strong>I suoi dati verranno conservati nella nostra banca dati solo per il tempo strettamente necessario al trattamento, salvo Sua espressa indicazione contraria: qualora desideri che i dati vengano
                        cancellati subito dopo averle fornito le informazioni richieste la invitiamo a comunicarcelo nel campo “Messaggio” presente nel Form.&nbsp;<br></p>
                    <p id="rata-termini" style="padding:0;padding-top:0;margin:0;"><strong>Natura del conferimento dei dati:&nbsp;</strong>Il conferimento dei Suoi dati è assolutamente facoltativo, parimenti è facoltativo il consenso da parte Sua al trattamento dei dati forniti. Ci corre obbligo informarla che
                        il mancato conferimento dei dati di contatto non ci renderà possibile fornirle le informazioni richieste, parimenti il mancato consenso al trattamento potrebbe costringerci a cancellare i dati forniti.<br></p>
                    <p id="rata-termini"
                        style="padding:0;padding-top:0;margin:0;"><strong>Titolare del trattamento:&nbsp;</strong>Il Titolare del Trattamento è la scrivente Assiqura SAS di Maestripieri Filippo &amp; C. con sede in Via Brigata Bisagno 16129 Genova (GE), nella persona del legale rappresentante pro
                        tempore e che il Responsabile del Trattamento è il Responsabile dei Servizi Informatici, elettivamente domiciliato, per le disposizioni di cui al DLgs n° 196/2003, presso la sede della scrivente, ove è anche disponibile l’elenco
                        aggiornato degli Incaricati al trattamento, contattabile tramite email:&nbsp;<a href="mailto:info@hsambiente.it">i</a>nfo@assiqura.com<br></p>
                    <p id="rata-termini" style="padding:0;padding-top:0;margin:0;"><strong>Diritti dell’Interessato:&nbsp;</strong>La informiamo che, in qualità di Interessato, ha tutti i diritti previsti dall’art. 7 del DLgs n° 196/2003, tra i quali ottenere a cura del Titolare e senza ritardo la conferma o meno
                        dell’esistenza di Dati personali che La riguardano, l’aggiornamento, la rettifica, l’integrazione, la cancellazione, la trasformazione in forma anonima o il blocco dei Dati forniti.<br></p>
                    <p id="rata-termini" style="padding:0;padding-top:0;margin:0;"><strong>Consenso al Trattamento di Dati personali comuni e sensibili ai sensi del DLgs n° 196/2003&nbsp;</strong>Il sottoscritto/a, acquisite le informazioni sopra riportate in osservanza del disposto di cui all’art. 13 del DLgs n°
                        196/2003, manifesta il proprio libero e pieno consenso al trattamento dei dati personali forniti, mediante l’indicazione nella apposita casella in calce al Form.<br></p>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">chiudi</button></div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
  import { validationMixin } from 'vuelidate'
  import {
    required,
    email,
    minLength,
    maxLength
  } from 'vuelidate/lib/validators'

  export default {
    name: 'FormValidation',
    mixins: [validationMixin],
    data: () => ({
      form: {
        contractorType : null,
        contractorFirstName : null,
        contractorLastName : null,
        contractorAddress : null,
        contractorTaxCode : null,
        contractorBirthday : null,
        contractorBirthPlace : null,
        contractorEmail : null,
        contractorTelephone : null,

        insuredType : null,
        insuredFirstName : null,
        insuredLastName : null,
        insuredAddress : null,
        insuredTaxCode : null,
        insuredBirthday : null,
        insuredBirthPlace : null,
        insuredEmail : null,
        insuredTelephone : null,

        deathBenType : null,
        deathBenFirstName : null,
        deathBenLastName : null,
        deathBenAddress : null,
        deathBenTaxCode : null,
        deathBenBirthday : null,
        deathBenBirthPlace : null,
        deathBenEmail : null,
        deathBenTelephone : null,

        receiveEmail : null,
      }
    }),
    validations: {
      form: {
        contractorType : {
            required
        },
      }
    },
    methods: {
        
        copyInformation(){
            this.form.insuredType = this.form.contractorType;
            this.form.insuredFirstName = this.form.contractorFirstName;
            this.form.insuredLastName = this.form.contractorLastName;
            this.form.insuredAddress = this.form.contractorAddress;
            this.form.insuredTaxCode = this.form.contractorTaxCode;
            this.form.insuredBirthday = this.form.contractorBirthday;
            this.form.insuredBirthPlace = this.form.contractorBirthPlace;
            this.form.insuredEmail = this.form.contractorEmail;
            this.form.insuredTelephone = this.form.contractorTelephone;
        },
        getValidationClass (fieldName) {
            const field = this.$v.form[fieldName]
            if (field) {
                return {
                    'md-invalid': field.$invalid && field.$dirty
                }
            }
        },

        validateUser () {
            this.$v.$touch();
            return !this.$v.$invalid;
        }
    }
  }
</script>
