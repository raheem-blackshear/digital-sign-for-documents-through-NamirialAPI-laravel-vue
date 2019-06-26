<style scoped>
    .form_container br{height:0px;}
    .form_container{width: 80%;margin: 0px auto 0px;padding-top: 50px;}
    .form_container h1{color: #3c8dbc;font-weight: bold;font-size: 20px;padding: 0px;line-height: 30px;margin: 30px 0px;}
    .form_container p{font-size:16px;color: #000;font-weight: bold;margin:0px;padding:0px;text-align: center;text-transform:uppercase;}
    .form_container p span{display: block;line-height: 11px;font-size: 10px;margin-bottom: 35px;}
    .form_container span.birthday_label {margin-right: 10px;font-size: 16px;color: #777;font-weight: 500;}
    /* .form_container .md-checkbox value="x" .md-checkbox value="x"-label{height:auto;} */
</style>
<template>
<div class="form_container">
    <!-- first form start -->
    <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-100 md-small-size-100">
            <!-- page one -->
            <md-card-content>
               <div class="md-layout md-gutter text-center"> 
                <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-radio value="personafisica">Persona fisica</md-radio>
                 </div>
                 <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-radio v-model.lazy="form.pageOne.Tipodipersona" value="personalegale">Persona legale</md-radio>
                 </div>
                </div> 
            </md-card-content>    
            <md-card-content>
                <div class="md-layout md-gutter" style="display:none">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Codice Intermediario</label>
                            <md-input type="text" v-model.lazy="form.pageOne.CodiceIntermediario"  md-dense/>
                            <span class="md-error">The Codice Intermediario is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Sotto-codice</label>
                            <md-input type="text" v-model.lazy="form.pageOne.SottoCodice"  md-dense/>
                            <span class="md-error">The Sotto-codice is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <md-card-content>
                <div class="md-title text-left">
                    <p>Presenza fisica del Cliente</p>
                </div>
                <div class="md-layout md-gutter text-center">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-radio v-model.lazy="form.pageOne.PresenzafisicadelCliente" value="si">SI</md-radio>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-radio v-model.lazy="form.pageOne.PresenzafisicadelCliente" value="no">NO</md-radio>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100" v-if="form.pageOne.PresenzafisicadelCliente == 'no'">
                        <md-checkbox value=">" class="md-primary" v-model.lazy="form.pageOne.FirmaDigitale">Firma Digitale</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100" v-if="form.pageOne.PresenzafisicadelCliente == 'no'">
                        <md-checkbox value=">" class="md-primary" v-model.lazy="form.pageOne.CollegamentoAudio">Collegamento Audio/Video1</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
            <!-- section one -->
            <md-card-header>
                <div class="md-title text-center"><h1>SEZIONE A - DATI IDENTIFICATIVI DEL CONTRAENTE /ADERENTE</h1></div>
            </md-card-header>
               
            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="Cognomeenome1">Cognome e nome</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.Cognomeenome1"  md-dense/>
                            <span class="md-error">The Cognome e nome is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="Datadinascita1">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.pageOne.sectionA.Datadinascita1"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                         <label for="Nazionalità1">Nazionalità</label>
                            <select v-model.lazy="form.pageOne.sectionA.Nazionalità1">
                            <option v-for="country in formArr.pageOne.sectionA.countries" :key="country" :value="country">{{country}}</option>
                          </select>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                         <label for="Regione1">Regione</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.Regione" id="Regione1" @md-selected="onRegioneChange">
                            <md-option v-for="region in formArr.pageOne.sectionA.regions" :key="region" :value="region">{{region}}</md-option>
                          </md-select>
                          <span class="md-error">The Regione is required</span>
                       </md-field>
                    </div>
                      <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                         <label for="Provincia1">Provincia</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.Provincia" id="Provincia1" @md-selected="onProvinciaChange">
                            <md-option v-for="province in formArr.pageOne.sectionA.provinces" :key="province" :value="province">{{province}}</md-option>
                          </md-select>
                          <span class="md-error">The Provincia is required</span>
                       </md-field>
                    </div>
                      <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                         <label for="Luogodinascita1">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.Luogodinascita1" id="Luogodinascita1">
                            <md-option v-for="commune in formArr.pageOne.sectionA.communes" :key="commune" :value="commune">{{commune}}</md-option>
                          </md-select>
                          <span class="md-error">The Luogo di nascita is required</span>
                       </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFisc1 }">
                            <label for="formCodFisc1">Cod.Fisc.</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.formCodFisc1" v-on:blur="checkFiscalCode($event.target.value,'sec1Fisc')"/>
                            <span class="md-error">Invalid Cod.Fisc.</span>
                        </md-field>
                    </div>  
                </div>
            </md-card-content>
            <md-card-content>
               <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-size-100 md-small-size-100">
                                <p style="text-align:left;">Sesso:</p>
                            </div>
                            <div class="md-layout-item md-size-20 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionA.Sesso1" value="m">M</md-radio>
                            </div>
                            <div class="md-layout-item md-size-20 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionA.Sesso1" value="f">F</md-radio>
                            </div>
                        </div>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                         <label for="tipodidentità">Tipo d'identità</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.tipodidentità" id="tipodidentità">
                            <md-option v-for="doctype in formArr.pageOne.sectionA.doctypes" :key="doctype" :value="doctype">{{doctype}}</md-option>
                          </md-select>
                          <span class="md-error">The Regione is required</span>
                       </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="Tipodocdiidentita1"></label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.Tipodocdiidentita1"/>
                            <span class="md-error">The Tipo doc. di identità is required</span>
                        </md-field>   
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="N1">N.</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.N1"/>
                            <span class="md-error">The N. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="Rilasciatoil">Rilasciato il</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.Rilasciatoil1"/>
                            <span class="md-error">The Rilasciato il is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                         <label for="Da1">da</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.da1" id="Da1">
                            <md-option v-for="region in formArr.pageOne.sectionA.dacommunes" :key="region" :value="region">{{region}}</md-option>
                          </md-select>
                          <span class="md-error">The Regione is required</span>
                       </md-field>
                    </div>
                      <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                         <label for="localitadirilascio1">Località di rilascio</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.Localitadirilascio1" id="localitadirilascio1">
                            <md-option v-for="region in formArr.pageOne.sectionA.localcommunes" :key="region" :value="region">{{region}}</md-option>
                          </md-select>
                          <span class="md-error">The Località di rilascio is required</span>
                       </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="Datascadenzadocidentita1">Data scadenza doc. identità</span>
                            <md-input type="date" v-model.lazy="form.pageOne.sectionA.Datascadenzadocidentita1"  md-dense/>
                            <span class="md-error">The Data scadenza doc. identità is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field>
                            <label>Indirizzo di residenza</label>
                            <md-textarea v-model.lazy="form.pageOne.sectionA.Indirizzodiresidenza1" md-autogrow></md-textarea>
                        </md-field>
                     </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="CAP1">CAP</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.CAP1"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                         <label for="Prov1">Prov.</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.Prov1" id="Prov1" @md-selected="onProvinciaChange">
                            <md-option v-for="province in formArr.pageOne.sectionA.provinces1" :key="province" :value="province">{{province}}</md-option>
                          </md-select>
                         <span class="md-error">The Prov. is required</span>
                       </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="Stato21">Stato2</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.Stato21"  md-dense/>
                            <span class="md-error">The Stato2 is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="Telefono1">Telefono</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.Telefono1"  md-dense/>
                            <span class="md-error">The Telefono is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidEmailMail1 }">
                            <label for="Mail">Mail</label>
                            <md-input type="text" v-model.lazy="form.pageOne.sectionA.Mail1"  v-on:blur="checkEmail($event.target.value,'sec1email')" md-dense/>
                            <span class="md-error">Invalid Email</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-size-100 md-small-size-100">
                                <p style="text-align:left;">Person Exposed Politically</p>
                            </div>
                            <div class="md-layout-item md-size-20 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionA.PEP31" value="no">NO</md-radio>
                            </div>
                            <div class="md-layout-item md-size-40 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionA.PEP31" value="si">SI</md-radio>
                                <!-- <md-field v-if="form.PEP31 == 'si'">
                                    <label>in qualitadi</label>
                                    <md-input type="text" v-model.lazy="form.sectionA.inqualitadi1"/>
                                </md-field> -->
                            </div>
                        </div>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-size-100 md-small-size-100">
                                <p style="text-align:left;">Incarichi Pubblici</p>
                            </div>
                            <div class="md-layout-item md-size-20 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionA.IncarichiPubblici4" value="no">NO</md-radio>
                            </div>
                            <div class="md-layout-item md-size-40 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionA.IncarichiPubblici4" value="si">SI</md-radio>
                                <!-- <md-field v-if="form.pageOne.sectionA.IncarichiPubblici4 == 'si'">
                                    <label>in quanto</label>
                                    <md-input type="text" v-model.lazy="form.sectionA.inquanto1"/>
                                </md-field> -->
                            </div>
                        </div>
                    </div>
                </div>
              </md-card-content>
             <!-- page two -->
             <md-card-header>
                <div class="md-title text-center"><h1>SEZIONE B – ALTRI SOGGETTI</h1></div>
              </md-card-header>
             <!-- section B -->
             <md-card-content>
                 <div class="md-layout-item md-size-50 md-small-size-100">
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-size-100 md-small-size-100">
                                <p style="text-align:left;">Ci sono altri soggetti da identificare?</p>
                            </div>
                            <div class="md-layout-item md-size-20 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionB.identificare" value="no">NO</md-radio>
                            </div>
                            <div class="md-layout-item md-size-40 md-small-size-100">
                                <md-radio v-model.lazy="form.pageOne.sectionB.identificare" value="si">SI</md-radio>
                            </div>
                       </div>
                 </div> 
             </md-card-content>  
            
            <md-card-content>

    <div role="tablist" v-show = 'form.pageOne.sectionB.identificare == "si"'>
    <!-- <b-card no-body class="mb-1">
      <b-card-header header-tag="header" class="p-1" role="tab">
        <b-button block href="#" v-b-toggle.accordion-1 variant="info">IL BENEFICIARIO</b-button>
      </b-card-header>
      <b-collapse id="accordion-1" visible accordion="my-accordion" role="tab">
        <b-card-body>
        <md-card-content>
                <div class="md-title text-center">
                    <p>IL BENEFICIARIO</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cognome e nome</label>
                            <md-input type="text" v-model.lazy="form.pageTwo.sectionB.Cognomeenome4"  md-dense/>
                            <span class="md-error">The Cognome e nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-show = 'form.pageOne.sectionB.identificare == "si"'>
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFisc4 }">
                            <label for="formCodFisc1">Cod.Fisc.</label>
                            <md-input type="text" v-model.lazy="form.pageTwo.sectionB.CodFisc4" v-on:blur="checkFiscalCode($event.target.value,'CodFisc4')"/>
                            <span class="md-error">Invalid Cod.Fisc.</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.pageTwo.sectionB.Datadinascita4"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="Luogodinascita1">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.pageTwo.sectionB.Luogodinascita4" id="Luogodinascita1">
                            <md-option v-for="commune in form.pageTwo.sectionB.communes" :key="commune" :value="commune">{{commune}}</md-option>
                            </md-select>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <md-card-content>
                <div class="md-title text-left">
                    <p>Paese di Residenza:</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.Italia4" class="md-primary">Italia</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageOne.sectionB.UE4" class="md-primary">UE</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.PaesiTerzi1quale4" class="md-primary">Paesi Terzi, quale</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.appartiene4" class="md-primary">appartiene al nucleo familiare dell’Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.harapporti4" class="md-primary">ha rapporti professionali o d’affari con l’Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.noneri4" class="md-primary">non è riconducibile né all’ambito familiare né professionale1</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
            <md-card-content>
                <div class="md-title text-left"><p>Person Exposed Politically</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-radio v-model.lazy="form.pageTwo.sectionB.PEP35"  value="no">NO</md-radio>
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-radio v-model.lazy="form.pageTwo.sectionB.PEP35"  value="si">SI, in qualità di</md-radio>
                    </div>
                </div>
            </md-card-content>
        </b-card-body>
      </b-collapse>
    </b-card>     -->
    <b-card no-body class="mb-1">
      <b-card-header header-tag="header" class="p-1" role="tab">
        <b-button block href="#" v-b-toggle.accordion-2 variant="info">IL BENEFICIARIO</b-button>
      </b-card-header>
      <b-collapse id="accordion-2" visible accordion="my-accordion" role="tab">
        <b-card-body>
             <md-card-header>
                <div class="md-title text-center"><h1>IL BENEFICIARIO</h1></div>
            </md-card-header>
                      <div class="md-layout md-gutter">
                       <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cognome e nome</label>
                            <md-input type="text"  v-model.lazy="form.pageTwo.sectionB.Cognomeenome5"  md-dense/>
                            <span class="md-error">The Cognome e nome is required</span>
                        </md-field>
                      </div>
                      <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidFiscColl }">
                            <label for="firstName">Cod.Fisc.</label>
                            <md-input type="text"  v-model.lazy="form.pageTwo.sectionB.CodFisc5"  v-on:blur="checkFiscalCode($event.target.value,'collFisc')" md-dense/>
                            <span class="md-error">The Cod.Fisc. is required</span>
                        </md-field>
                     </div>
                      <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date"  v-model.lazy="form.pageTwo.sectionB.Datadinascita5"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                         <label for="Luogodinascita5">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.pageOne.sectionA.Luogodinascita5" id="Luogodinascita5">
                            <md-option v-for="commune in form.pageOne.sectionA.collcommunes" :key="commune" :value="commune">{{commune}}</md-option>
                          </md-select>
                          <span class="md-error">The Luogo di nascita is required</span>
                       </md-field>
                      </div>
                      <md-card-content>
                <div class="md-title text-left">
                    <p>Paese di Residenza:</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.Italia5" class="md-primary">Italia</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageOne.sectionB.UE5" class="md-primary">UE</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.PaesiTerzi1quale5" class="md-primary">Paesi Terzi1, quale</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.appartiene5" class="md-primary">appartiene al nucleo familiare dell’Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.harapporti5" class="md-primary">ha rapporti professionali o d’affari con l’Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.noneri5" class="md-primary">non è riconducibile né all’ambito familiare né professionale1</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
            <md-card-content>
                <div class="md-title text-left"><p>Person Exposed Politically</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-radio v-model.lazy="form.pageTwo.sectionB.PEP36"  value="no">NO</md-radio>
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-radio v-model.lazy="form.pageTwo.sectionB.PEP36"  value="si">SI, in qualità di</md-radio>
                    </div>
                </div>
            </md-card-content>
                     </div>
        </b-card-body>
      </b-collapse>
    </b-card>

    <b-card no-body class="mb-1">
      <b-card-header header-tag="header" class="p-1" role="tab">
        <b-button block href="#" v-b-toggle.accordion-3 variant="info">BENEFICIARIO IN CASO DI MORTE</b-button>
      </b-card-header>
      <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
        <b-card-body>
          <!-- ASSICURATO2 -->
 <md-card-header>
                <div class="md-title text-center"><h1>BENEFICIARIO IN CASO DI MORTE</h1></div>
            </md-card-header>
            <md-card-content>
                <div class="md-title text-left">
                    <p>Benefi ciario in caso di morte</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.Assicurato2.Altri" class="md-primary">Altri (specifi care nello spazio a seguire)</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-65 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.Assicurato2.Eredi" class="md-primary">Eredi testamentari, in mancanza eredi legittimi dell'Assicurato</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-if="form.formTwo.Assicurato2.Altri">
                <div class="md-title text-left"><p>Cognome, nome / Ragione Sociale</p></div>
                <div class="md-layout md-gutter" style="display:none;">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field  >
                            <label for="firstName" style="display:none">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Sig"  md-dense/>
                            <span class="md-error">The Sig. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field  >
                            <label for="firstName" style="display:none">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Sigra"  md-dense/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field  >
                            <label for="lastName" style="display:none">Soc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Soc"/>
                            <span class="md-error">The Soc. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome / Ragione Sociale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Cognome"/>
                            <span class="md-error">The Cognome / Ragione Sociale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Nome"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-if="form.formTwo.Assicurato2.Altri">
                <div class="md-title text-left"><p>Data e luogo di nascita</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Assicurato2.Datadinascita"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="AssLuogodinascita">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.formTwo.Assicurato2.Luogodinascita" id="AssLuogodinascita">
                            <md-option v-for="commune in form.formTwo.Assicurato2.communes" :key="commune" :value="commune">{{commune}}</md-option>
                            </md-select>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Provincia"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Stato di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Assicurato2.Statodinascita"  md-dense/>
                            <span class="md-error">The Stato di nascita is required</span>   
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-if="form.formTwo.Assicurato2.Altri">
                <div class="md-title text-left"><p>Percentuale / Relazione con il Contraente</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Percentuale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Percentuale"  md-dense/>
                            <span class="md-error">The Percentuale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Relazione con il Contraente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Relazione"  md-dense/>
                            <span class="md-error">The Relazione con il Contraente is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-if="form.formTwo.Assicurato2.Altri">
                <div class="md-title text-left">
                    <p>Codice fi scale / Partita IVA</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-49 md-small-size-100">
                        <!-- <md-field  >
                            <label for="firstName">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Codicefiscale"  md-dense/>
                            <span class="md-error">The Codice fi scale is required</span>
                        </md-field> -->
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFisc3 }">
                            <label for="formCodFisc1">Cod.Fisc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Codicefiscale" v-on:blur="checkFiscalCode($event.target.value,'coll3Fisc')"/>
                            <span class="md-error">Invalid Cod.Fisc.</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Partita IVA</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.PartitaIVA"  md-dense/>
                            <span class="md-error">The Partita IVA is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout-item md-size-100 md-small-size-100">
                    <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCollEmail }">
                            <label for="Mail">Mail</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.email"  v-on:blur="checkEmail($event.target.value,'collemail')" md-dense/>
                            <span class="md-error">Invalid Email</span>
                    </md-field>
                </div>
            </md-card-content>

            <md-card-content v-if="form.formTwo.Assicurato2.Altri">
                <div class="md-title text-center">
                    <p>Benefi ciario con disabilità grave <span> (come defi nito dall’art. 3, comma 3, della legge n.104/1992)</span></p>
                </div>
                <div class="md-layout-item md-size-100 md-small-size-100">
                    <md-checkbox value=">" v-model.lazy="form.formTwo.Assicurato2.IlBeneficiario" class="md-primary">Il Benefi ciario in caso di morte è persona con disabilità grave (barrare se affermativo)</md-checkbox value="x">
                </div>
            </md-card-content>
              
            <md-card-content v-show="form.formTwo.Assicurato2.Eredi !='<'">
                <div class="md-title text-left"><p>Referente terzo</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100" style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Sig2"  md-dense/>
                            <span class="md-error">The Sig is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100" style="display:none">
                        <md-field  >
                            <label for="lastName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Sigra2"/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Cognome2"/>
                            <span class="md-error">The Cognome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Nome2"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Assicurato2.Datadinascita2"/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="LuogodinascitaA2">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.formTwo.Assicurato2.Luogodinascita2" id="LuogodinascitaA2">
                            <md-option v-for="commune in form.formTwo.Assicurato2.communes" :key="commune" :value="commune">{{commune}}</md-option>
                            </md-select>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Telefono</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato2.Telefono2"/>
                            <span class="md-error">The Telefono is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-show="form.formTwo.Assicurato2.Eredi !='<'">
                <div class="md-title text-center">
                    <p>Comunicazioni al benefi ciario</p>
                </div>
                <div class="md-layout-item md-size-100 md-small-size-100">
                    <md-checkbox value=">" v-model.lazy="form.formTwo.Assicurato2.Comunicazioni2" class="md-primary"> Richiesta di escludere l’invio di comunicazioni al benefi ciario prima dell’evento (barrare in caso di selezione)</md-checkbox value="x">
                </div>
            </md-card-content>
 <!-- // assicurato2 -->            
        </b-card-body>
      </b-collapse>
    </b-card>

    <b-card no-body class="mb-1">
      <b-card-header header-tag="header" class="p-4" role="tab">
        <b-button block href="#" v-b-toggle.accordion-4 variant="info">BENEFICIARIO IN CASO DI VITA</b-button>
      </b-card-header>
      <b-collapse id="accordion-4" accordion="my-accordion" role="tabpanel">
        <b-card-body>
                    <!-- BENEFICIARIO IN CASO DI VITA -->
            <md-card-header>
                <div class="md-title text-center"><h1>BENEFICIARIO IN CASO DI VITA</h1></div>
            </md-card-header>
            <md-card-content>
                <div class="md-title text-left">
                    <p>Benefi ciario in caso di vita</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Contraente" class="md-primary">Contraente</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Assicurato" class="md-primary">Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Altri" class="md-primary">Altri (precisare nello spazio a seguire)</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Cognome, nome / Ragione Sociale</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Sig"  md-dense/>
                            <span class="md-error">The Sig. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Sigra"  md-dense/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="lastName">Soc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Soc"/>
                            <span class="md-error">The Soc. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome / Ragione Sociale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Cognome"/>
                            <span class="md-error">The Cognome / Ragione Sociale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Nome"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Data e luogo di nascita</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Datadinascita"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di nascita</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Luogodinascita"  md-dense/>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Provincia"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Stato di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Statodinascita"  md-dense/>
                            <span class="md-error">The Stato di nascita is required</span>   
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Percentuale / Relazionecon il Contraente</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Percentuale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Percentuale"  md-dense/>
                            <span class="md-error">The Percentuale is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Relazione con il Contraente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Relazione"  md-dense/>
                            <span class="md-error">The Relazione con il Contraente is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Codice fi scale / Partita IVA</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-49 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Codicefiscale"  md-dense/>
                            <span class="md-error">The Codice fi scale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Partita IVA</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.PartitaIVA"  md-dense/>
                            <span class="md-error">The Partita IVA is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-100 md-small-size-100">   
                        <md-field  >
                            <label for="email">E-Mail</label>
                            <md-input type="email" v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.email1"/>
                        </md-field>
                   </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Comunicazioni al benefi ciario</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-49 md-small-size-100">
                        <md-field>
                            <label>Richiesta di escludere l’invio di comunicazioni al benefi ciario prima dell’evento (barrare in caso di selezione)</label>
                            <md-textarea v-model.lazy="form.formTwo.pageTwo.Beneficiarioincasodivita.Richiestadiescludere"></md-textarea>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- //BENEFICIARIO IN CASO DI VITA -->
        </b-card-body>
      </b-collapse>
    </b-card>
  </div>
 </md-card-content>
            <md-card-content>
               <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <p style="text-align:left;">Il pagatore è diverso dal contraente/aderente?</p>
                    </div>
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-radio v-model.lazy="form.pageOne.sectionB.pagatore" value="no">NO</md-radio>
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-radio v-model.lazy="form.pageOne.sectionB.pagatore" value="si">SI</md-radio>
                    </div>
                </div> 
            </md-card-content> 
            <md-card-content v-show = 'form.pageOne.sectionB.pagatore == "si"'>
                <div class="md-title text-center">
                    <p>Il Pagatore (se diverso dal contraente/aderente):</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cognome e nome</label>
                            <md-input type="text"  v-model.lazy="form.pageTwo.sectionB.Cognomeenome6"  md-dense/>
                            <span class="md-error">The Cognome e nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-show = 'form.pageOne.sectionB.pagatore == "si"'>
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFisc6 }">
                            <label for="formCodFisc1">Cod.Fisc.</label>
                            <md-input type="text" v-model.lazy="form.pageTwo.sectionB.CodFisc6" v-on:blur="checkFiscalCode($event.target.value,'secBFisc')"/>
                            <span class="md-error">Invalid Cod.Fisc.</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date"  v-model.lazy="form.pageTwo.sectionB.Datadinascita6"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-show = 'form.pageOne.sectionB.pagatore == "si"'>
                        <md-field>
                            <label for="Luogodinascita6">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.pageTwo.sectionB.Luogodinascita6" id="Luogodinascita6">
                            <md-option v-for="commune in form.pageTwo.sectionB.communes" :key="commune" :value="commune">{{commune}}</md-option>
                            </md-select>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <md-card-content v-show = 'form.pageOne.sectionB.pagatore == "si"'>
                <div class="md-title text-left">
                        <p>Paese di Residenza:</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                         <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.Italia6" class="md-primary">Italia</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageOne.sectionB.UE6" class="md-primary">UE</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.PaesiTerzi1quale6" class="md-primary">Paesi Terzi, quale</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.appartiene6" class="md-primary">appartiene al nucleo familiare dell’Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.harapporti6" class="md-primary">ha rapporti professionali o d’affari con l’Assicurato</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageTwo.sectionB.noneri6" class="md-primary">non è riconducibile né all’ambito familiare né professionale1</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
            <md-card-content v-show = 'form.pageOne.sectionB.pagatore == "si"'>
                <div class="md-title text-left"><p>Person Exposed Politically</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-radio  v-model.lazy="form.pageTwo.sectionB.PEP37" value="no">NO</md-radio>
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-radio  v-model.lazy="form.pageTwo.sectionB.PEP37" value="si">SI</md-radio>
                   </div>
                </div>
            </md-card-content>    
            <!-- // section B -->
            <!-- section c -->
            <md-card-header>
                <div class="md-title text-center"><h1>SEZIONE C – ULTERIORI INFORMAZIONI</h1></div>
            </md-card-header>
            <md-card-content>
                <div class="md-title text-left"><p>Istituto di credito di provenienza/destinazione </p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-radio v-model.lazy="form.pageTwo.sectionC.Istitutodicredito" value="Italia">Italia</md-radio>
                        <md-radio v-model.lazy="form.pageTwo.sectionC.Istitutodicredito" value="StatoEstero">Stato Estero, specificare quale</md-radio>
                    </div>
                </div>
            </md-card-content>
            <md-card-content>
                <div class="md-title text-left"><p>Titolare Effettivo del Rapporto: </p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-radio v-model.lazy="form.pageTwo.sectionC.TitolareEffettivo" value="Unico">(1) Unico Titolare Effettivo</md-radio>
                        <md-radio v-model.lazy="form.pageTwo.sectionC.TitolareEffettivo" value="Titolare">(2) Titolare Effettivo unitamente a:</md-radio>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100" v-show = 'form.pageTwo.sectionC.TitolareEffettivo == "Titolare"'>
                        <md-field>
                            <label for="firstName">Cognome e nome</label>
                            <md-input v-model.lazy="form.pageTwo.sectionC.Cognomeenome" type="text" md-dense/>
                            <span class="md-error">The Cognome e nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100" v-show = 'form.pageTwo.sectionC.TitolareEffettivo == "Titolare"'>
                       <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFiscP2 }">
                            <label for="formCodFisc1">Cod.Fisc.</label>
                            <md-input type="text" v-model.lazy="form.pageTwo.sectionC.CodiceFiscale" v-on:blur="checkFiscalCode($event.target.value,'P2Fisc')"/>
                            <span class="md-error">Invalid Cod.Fisc.</span>
                      </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100" v-show = 'form.pageTwo.sectionC.TitolareEffettivo == "Titolare"'>
                        <md-field>
                            <label for="Nazionalità1">Residenza</label>
                            <md-select v-model.lazy="form.pageTwo.sectionC.Residenza">
                            <md-option v-for="country in formArr.pageTwo.sectionC.countries" :key="country" :value="country">{{country}}</md-option>
                            </md-select>
                            <span class="md-error">The Residenza is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-show = 'form.pageTwo.sectionC.TitolareEffettivo == "Titolare"'>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <div class="md-layout-item md-size-100 md-small-size-100">
                            <div class="md-title text-left">
                                <p style="text-align:left;">Person Exposed Politically</p>
                            </div>
                        </div>
                        <md-radio v-model.lazy="form.pageTwo.sectionC.PEP38" value="no">NO</md-radio>
                        <md-radio v-model.lazy="form.pageTwo.sectionC.PEP38" value="si">SI, in qualità di</md-radio>
                    </div>
                    <div class="md-layout-item md-size-60 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Luogo e data</span>
                            <md-input type="date" v-model.lazy="form.pageTwo.sectionC.Luogoedata"  md-dense/>
                            <span class="md-error">The Luogo e data is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- //section c -->
            <!-- //page 2 -->
            <!-- page 3 -->
            <!-- section D -->
        </md-card>
        </div>
        <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-100 md-small-size-100">  
            <md-card-header>
                <div class="md-title text-center">
                    <h1>Scheda di Adeguata Verifica a cura del Distributore – Sezione D (a cura del Distributore)</h1>
                </div>
            </md-card-header>
            <md-card-content>
                <div class="md-title text-left"><p>Comportamento tenuto dal cliente all’instaurazione del rapporto continuativo</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.pageThree.sectionD.Normale" class="md-primary mandatory-field" v-on:change="addPackageValues()">Normale</md-checkbox value="x"><br/>
                        <md-checkbox value=">" v-model.lazy="form.pageThree.sectionD.Riluttanza" class="md-primary">Riluttanza e/o reticenza nel fornire le informazioni richieste1</md-checkbox value="x"><br/>
                        <md-checkbox value=">" v-model.lazy="form.pageThree.sectionD.Interposizione" class="md-primary">Interposizione di soggetti terzi senza apparente giustificazione1</md-checkbox value="x"><br/>
                        <md-checkbox value=">" v-model.lazy="form.pageThree.sectionD.Ilcliente" class="md-primary">Il cliente mostra una inusuale familiarità con le norme antiriciclaggio1</md-checkbox value="x"><br/>
                        <md-checkbox value=">" v-model.lazy="form.pageThree.sectionD.Altreanomalie" class="md-primary">Altre anomalie comportamentali riscontrate1. Specificare</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p style="text-align:left;">Le informazioni ricevute dal cliente, sono da ritenersi attendibili?</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-radio v-model.lazy="form.pageThree.sectionD.Leinformazioni" value="si">Si</md-radio>
                        <md-radio v-model.lazy="form.pageThree.sectionD.Leinformazioni" value="no">No. Specificare il motivo</md-radio>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cognome</label>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Cognome"  md-dense/>
                            <span class="md-error">The Cognome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Nome</label>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Nome"  md-dense/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice soggetto incaricato al collocamento</label>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Codice"  md-dense/>
                            <span class="md-error">The Codice soggetto incaricato al collocamento is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Num. iscrizione RUI</label>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Numiscrizione"  md-dense/>
                            <span class="md-error">The Num. iscrizione RUI is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Regione di attività del soggetto incaricato del collocamento</label>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Regione"  md-dense/>
                            <span class="md-error">The Regione di attività del soggetto incaricato del collocamento is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Luogo e data</span>
                            <md-input type="date" v-model.lazy="form.pageThree.sectionD.Luogoedata"  md-dense/>
                            <span class="md-error">The Luogo e data is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Intermediario</label>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Intermediario"  md-dense/>
                            <span class="md-error">The Intermediario is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Luogo e data</span>
                            <md-input type="date" v-model.lazy="form.pageThree.sectionD.Luogoedata1"  md-dense/>
                            <span class="md-error">The Luogo e data is required</span>
                        </md-field>
                   </div>
                </div>
            </md-card-content>

            <md-card-content v-show='isShowHiddenFields == "true"'>
                <div class="md-title text-left"><p>Validazione percorso di Adeguata Verifica</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Intermediario</span>
                            <md-input type="text" v-model.lazy="form.pageThree.sectionD.Intermediario1"  md-dense/>
                            <span class="md-error">The Intermediario is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Timbro/Firma</span>
                            <md-input type="date" v-model.lazy="form.pageThree.sectionD.TimbroFirma"  md-dense/>
                            <span class="md-error">The Timbro/Firma is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-header v-show='form.pageThree.sectionD.WCL == "show"'>
                <div class="md-title text-center"><h1>Spazio riservato alla Compagnia</h1></div>
            </md-card-header>
            <md-card-content v-show='form.pageThree.sectionD.WCL == "show"'> 
                <div class="md-title text-left"><p>Tipo verifica sul nominativo:</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                         <md-field  >
                            <span class="birthday_label">WCL</span>
                            <md-input type="date" v-model.lazy="form.pageThree.sectionD.WCL"  md-dense/>
                            <span class="md-error">The WCL is required</span>
                         </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Altro esito delle verifiche</span>
                            <md-input type="date" v-model.lazy="form.pageThree.sectionD.Altro"  md-dense/>
                            <span class="md-error">The Altro esito delle verifiche is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- //section d-->
            <!-- //page 3 -->
        </md-card>
    </div>
    <!-- //first form end -->
    <!-- second form -->
    <!-- first row -->
    <div class = "row justify-content-center mt-4" v-show='form.pageThree.sectionD.WCL == "show"'>
        <md-card class="md-layout-item md-size-100 md-small-size-100">
            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-small-size-100">
                        <md-field  >
                            <label for="firstName">Proposta Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.PropostaNumero"  md-dense/>
                            <span class="md-error">The Proposta Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-small-size-100">
                        <md-field  >
                            <label for="lastName">Agenzia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Agenzia"/>
                            <span class="md-error">The Agenzia is required</span>
                        </md-field>
                    </div>
                      <div class="md-layout-item md-small-size-100">
                        <md-field  >
                            <label for="lastName">Codice agenzia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Codiceagenzia"/>
                            <span class="md-error">The Codice agenzia is required</span>
                        </md-field>
                    </div>
                      <div class="md-layout-item md-small-size-100">
                        <md-field  >
                            <label for="lastName">Codice intermediario</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Codiceintermediario"/>
                            <span class="md-error">The Codice intermediario is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
        </md-card>
    </div>
    <!-- //first row -->
    <!-- form two -->
    <div class = "row justify-content-center mt-4">
        <md-card class="md-layout-item md-size-100 md-small-size-100">
            <!-- contraente -->
            <md-card-header>
                <div class="md-title text-center"><h1>CONTRAENTE</h1></div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left" style="display:none"><p>Cognome, nome / Ragione Sociale</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field style="display:none">
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Sig"  md-dense/>
                            <span class="md-error">The Sig. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none"> 
                        <md-field  style="display:none">
                            <label for="firstName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Sigra"  md-dense/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field style="display:none">
                            <label for="lastName">Soc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Soc"/>
                            <span class="md-error">The Soc. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  v-show='isShowHiddenFields==true'>
                            <label for="lastName">Cognome / Ragione Sociale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Cognome"/>
                            <span class="md-error">The Cognome / Ragione Sociale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field v-show='isShowHiddenFields==true'>
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Nome"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-show='isShowHiddenFields==true'>
                <div class="md-title text-left"><p>Residenza / Sede legale</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Indirizzo</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Indirizzo"  md-dense/>
                            <span class="md-error">The Indirizzo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Numero"  md-dense/>
                            <span class="md-error">The Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.CAP"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Città</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Città"  md-dense/>
                            <span class="md-error">The Città is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Provincia"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-show='isShowHiddenFields==true'>
                <div class="md-title text-left"><p>Data e luogo di nascita</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Contraente.Datadinascita"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di nascita</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Luogodinascita"  md-dense/>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Provincia2"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Stato di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Contraente.Statodinascita"  md-dense/>
                            <span class="md-error">The Stato di nascita is required</span>   
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            
            <md-card-content>
                <div class="md-title text-left"><p>Nazionalità / Professione attuale e settore economico</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-radio v-model.lazy="form.formTwo.Contraente.Nazionalita" value="Italiana">Italiana</md-radio>
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-radio v-model.lazy="form.formTwo.Contraente.Nazionalita" value="Altranazionalita">Altra nazionalità</md-radio>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Professione</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Professione"  md-dense/>
                            <span class="md-error">The Professione is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">  
                      <md-field>
                         <label for="Settore">Settore economico</label>
                            <md-select v-model.lazy="form.formTwo.Contraente.Settoreeconomico">
                            <md-option v-for="ecocategory in formArr.formTwo.Contraente.ecocategories" :key="ecocategory.id" :value="ecocategory">{{ecocategory}}</md-option>
                          </md-select>
                          <span class="md-error">The Settore economico is required</span>
                       </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                        <p>Territorialità fi scale di appartenenza</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-radio v-model.lazy="form.formTwo.Contraente.Territorialita" value="Italia">Italia</md-radio>
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-radio v-model.lazy="form.formTwo.Contraente.Territorialita" value="USA">USA e / o</md-radio>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="Specifi">Specifi care la Nazione di cui il Contraente è contribuente fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Specificarela"  md-dense/>
                            <span class="md-error">The Specifi care is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="Identifi">Identifi cativo fi scale (TIN/NIF)</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Identificativo" md-dense/>
                            <span class="md-error">The Settore economico is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
                
            <md-card-content  v-show='isShowHiddenFields==true'>
                <div class="md-title text-left">
                    <p>Codice fi scale / Partita IVA</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-49 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Codicefiscale"  md-dense/>
                            <span class="md-error">The Codice fi scale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Partita IVA</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.PartitaIVA"  md-dense/>
                            <span class="md-error">The Partita IVA is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-show='isShowHiddenFields==true'>
                <div class="md-title text-left">
                    <p>Recapito di contatto<span>(se diverso dalla residenza / sede legale)</span></p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field>
                            <label>Indirizzo</label>
                            <md-textarea v-model.lazy="form.formTwo.Contraente.Indirizzo2" ></md-textarea>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Numero2"  md-dense/>
                            <span class="md-error">The Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.CAP2"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Città</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Citta2"  md-dense/>
                            <span class="md-error">The Città is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Provincia2"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-show='isShowHiddenFields==true'>
                <div class="md-title text-left">
                    <p>Ulteriori recapiti</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Telefono fi sso</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Telefonofisso2"  md-dense/>
                            <span class="md-error">The Telefono fi sso is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Telefono ufficio</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Telefonoufficio2"  md-dense/>
                            <span class="md-error">The Telefono ufficio is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cellulare</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.Cellulare2"  md-dense/>
                            <span class="md-error">The Cellulare is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="email">E-Mail</label>
                            <md-input type="email" v-model.lazy="form.formTwo.Contraente.email2"/>
                        </md-field>
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidEmailemail2 }">
                            <label for="Mail">E-Mail</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Contraente.email2"  v-on:blur="checkEmail($event.target.value,'f2e1')" md-dense/>
                            <span class="md-error">Invalid Email</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- // Contraente -->
            <!-- ASSICURATO -->
            <md-card-header>
                <div class="md-title text-center"><h1>ASSICURATO</h1></div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Assicurato</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.Assicurato.Contraente3"  class="md-primary">Contraente</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-80 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.Assicurato.Personadiversadal" class="md-primary">Persona diversa dal Contraente (si prega specifi care di seguito)</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-show='form.formTwo.Assicurato.Contraente3 != ">"'>
                <div class="md-title text-left"><p>Cognome, nome</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100" style="display:none">
                        <md-field >
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Sig"  md-dense/>
                            <span class="md-error">The Sig is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100" style="display:none">
                        <md-field style="display:none">
                            <label for="lastName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Sigra"/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Cognome"/>
                            <span class="md-error">The Cognome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Nome"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-show='form.formTwo.Assicurato.Contraente3 != ">"'>
                <div class="md-title text-left">
                    <p>Residenza</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field>
                            <label>Indirizzo</label>
                            <md-textarea v-model.lazy="form.formTwo.Assicurato.Indirizzo"></md-textarea>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Numero"  md-dense/>
                            <span class="md-error">The Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.CAP"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="Citta2">Città</label>
                               <md-select  v-model.lazy="form.formTwo.Assicurato.Citta" id="Citta2" @md-selected="onRegioneChange">
                               <md-option v-for="region in formArr.formTwo.Assicurato.regions" :key="region" :value="region">{{region}}</md-option>
                            </md-select>
                            <span class="md-error">The Regione is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                          <md-field>
                            <label for="Provincia2">Provincia</label>
                            <md-select  v-model.lazy="form.formTwo.Assicurato.Provincia" id="Provincia2">
                            <md-option v-for="province in formArr.formTwo.Assicurato.provinces" :key="province" :value="province">{{province}}</md-option>
                            </md-select>
                            <span class="md-error">The Provincia is required</span>
                         </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-show='form.formTwo.Assicurato.Contraente3 != ">"'>
                <div class="md-title text-left"><p>Data e luogo di nascita</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Assicurato.Datadinascita"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Stato di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.Assicurato.Statodinascita"  md-dense/>
                            <span class="md-error">The Stato di nascita is required</span>   
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="Provincia1">Provincia</label>
                            <md-select  v-model.lazy="form.formTwo.Assicurato.Provincia3" id="Provincia3" @md-selected="onProvinciaChange">
                            <md-option v-for="province in formArr.formTwo.Assicurato.provinces3" :key="province" :value="province">{{province}}</md-option>
                            </md-select>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="Luogodinascita2">Luogo di nascita</label>
                            <md-select  v-model.lazy="form.formTwo.Assicurato.Luogodinascita" id="Luogodinascita2">
                            <md-option v-for="commune in formArr.formTwo.Assicurato.communes" :key="commune" :value="commune">{{commune}}</md-option>
                            </md-select>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-show='form.formTwo.Assicurato.Contraente3 != ">"'>
                <div class="md-title text-left"><p>Nazionalità / Professione</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-radio v-model.lazy="form.formTwo.Assicurato.Nazionalita2" value="Italiana">Italiana</md-radio>
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-radio v-model.lazy="form.formTwo.Assicurato.Nazionalita2" value="Altra">Altra nazionalità</md-radio>
                    </div>
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Professione</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Professione4"  md-dense/>
                            <span class="md-error">The Professione is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-show='form.formTwo.Assicurato.Contraente3 != ">"'>
                <div class="md-title text-left"><p>Codice fi scale</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFiscAsc }">
                            <label for="formCodFisc1">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Codicefiscale" v-on:blur="checkFiscalCode($event.target.value,'ascFisc')"/>
                            <span class="md-error">The Codice fi scale is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-show='form.formTwo.Assicurato.Contraente3 != ">"'>
                <div class="md-title text-left">
                    <p>recapiti</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Telefono fi sso</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Telefonofisso4"  md-dense/>
                            <span class="md-error">The Telefono fi sso is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Telefono ufficio</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Telefonoufficio4"  md-dense/>
                            <span class="md-error">The Telefono ufficio is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cellulare</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.Cellulare4"  md-dense/>
                            <span class="md-error">The Cellulare is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                       <md-field v-bind:class="{ 'md-invalid': errors.isInvalidEmailMail5 }">
                            <label for="Mail">Mail</label>
                            <md-input type="text" v-model.lazy="form.formTwo.Assicurato.email5"  v-on:blur="checkEmail($event.target.value,'form2email')" md-dense/>
                            <span class="md-error">Invalid Email</span>
                        </md-field>   
                    </div>
                </div>
            </md-card-content>

            <!-- //ASSICURATO -->
            


 
            <!-- Identificazionedel -->
            <md-card-header>
                <div class="md-title text-center"><h1>IDENTIFICAZIONE DEL CONTRAENTE PERSONA FISICA / DEL RAPPRESENTANTE LEGALE PERSONA GIURIDICA</h1></div>
            </md-card-header>
            <md-card-content>
                <div class="md-title text-left">
                    <p>Identifi cazione Contraente / Legale rappresentante</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Cartadidentita" class="md-primary">Carta d’identità</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Patente" class="md-primary">Patente</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Passaporto" class="md-primary">Passaporto</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Relazione con il Contraente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Relazioneconil"  md-dense/>
                            <span class="md-error">The Relazione con il Contraente is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice fi scale del legale rappresentante</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Codicefiscaledel"  md-dense/>
                            <span class="md-error">The Codice fi scale del legale rappresentante il Contraente is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di emissione</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Datadiemissione"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di scadenza</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Datadiscadenza"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Autorità emittente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Autoritaemittente"  md-dense/>
                            <span class="md-error">The Autorità emittente is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di emissione</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Luogodiemissione"  md-dense/>
                            <span class="md-error">The Luogo di emissione is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
                    
            <md-card-content>
                <div class="md-title text-left">
                    <p>Titolare effettivo <span>Il Contraente è il titolare effettivo del rapporto?</span></p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.Si" class="md-primary">Si</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-90 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.No" class="md-primary">No</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
                
            <md-card-content v-show='isShowHiddenFields=="true"'>
                <div class="md-title text-left">
                    <p>Sottoscrizione dell’intermediario</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Nome, Cognome dell’intermediario</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Identificazionedel.NomeCognome"  md-dense/>
                            <span class="md-error">The Nome, Cognome dell’intermediario con il Contraente is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <label>Sign</label>
                    </div>
                </div>
            </md-card-content>
            <!-- //Identificazionedel -->

            <!-- CapacitaDiRisparmio -->
            <md-card-header>
                <div class="md-title text-center">
                    <h1>CAPACITÀ DI RISPARMIO DEL CONTRAENTE</h1>
                    <p><span>Per valutare l’adeguatezza dell’investimento assicurativo che sta sottoscrivendo le chiediamo di indicarci la sua capacità media annua di risparmio. La capacità di risparmio deve essere valutata tenendo conto della sua situazione patrimoniale, reddituale, familiare e degli impegni fi nanziari già assunti.</span></p>
                </div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Capacità di risparmio annua</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Finoa600" class="md-primary">Fino a 600,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Tra600e5000" class="md-primary mandatory-field">Tra 600,– € e 5.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Oltre5000" class="md-primary">Oltre 5.000,– €</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Reddito annuo</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Finoa20000" class="md-primary">Fino a 20.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Tra20000e35000" class="md-primary mandatory-field">Tra 20.000,– € e 35.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Tra35000e50000" class="md-primary">Tra 35.000,– € e 50.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Tra50000e65000" class="md-primary">Tra 50.000,– € e 65.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Oltre65000" class="md-primary">Oltre 65.000,– €   </md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                        <p>Tipologia di reddito annuo</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Redditofisso" class="md-primary mandatory-field">Reddito fi sso</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Redditovariabilenoncerto" class="md-primary">Reddito variabile non certo</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Impegni fi nanziari già assunti</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Nessuno" class="md-primary">Nessuno</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Finoa1000" class="md-primary mandatory-field">Fino a 1.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Tra1000e5000" class="md-primary">Tra 1.000,– € e 5.000,– €</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Superiorea5000" class="md-primary">Superiore a 5.000,– €</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Numero componenti del nucleo familiare</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Numero" class="md-primary">Numero</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.CapacitaDiRisparmio.Dicuiacarico" class="md-primary">Di cui a carico</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
            <!-- //CapacitaDiRisparmio -->
            <!-- DECORRENZA E DURATA DEL CONTRATTO -->
            <md-card-header>
                <div class="md-title text-center"><h1>DECORRENZA E DURATA DEL CONTRATTO</h1></div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Data di Decorrenza e Durata del Contratto</p>
                </div>
                <div class="md-layout md-gutter">              
                    <div class="md-layout-item md-size-70 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di Decorrenza</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageTwo.DecorrenzaEDurata.DatadiDecorrenza" md-dense/>
                            <span class="md-error">The Data di Decorrenza is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-30 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Durata del Contratto</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.DecorrenzaEDurata.DuratadelContratto"  md-dense/>
                            <span class="md-error">The Durata del Contratto is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- //DECORRENZA E DURATA DEL CONTRATTO -->

            <!-- PREMIO -->
            <md-card-header>
                <div class="md-title text-center"><h1>PREMIO</h1>
                </div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Importo annuale del Premio</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Premio annuo</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Premio.Premioannuo"  md-dense/>
                            <span class="md-error">The Premio annuo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-field  >
                            <label for="firstName">€</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Premio.money"  md-dense/>
                            <span class="md-error">The € is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-60 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.Premio.Opzionediincremento" class="md-primary">OPZIONE DI INCREMENTO AUTOMATICO DEL PREMIO (barrare in caso di selezione)</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Piano di frazionamento del Premio / Rata di Premio</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-15 md-small-size-100">
                        <md-radio value="m" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi" class="md-primary" v-on:change ="addPackagePrice('e1')">Mensile</md-radio>
                    </div>
                    <div class="md-layout-item md-size-15 md-small-size-100">
                        <md-radio value="t" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi" class="md-primary"  v-on:change ="addPackagePrice('e1')">Trimestrale</md-radio>
                    </div>
                    <div class="md-layout-item md-size-15 md-small-size-100">
                         <md-radio value="s" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi" class="md-primary"  v-on:change ="addPackagePrice('e1')">Semestrale</md-radio>
                    </div>
                    <div class="md-layout-item md-size-15 md-small-size-100">
                         <md-radio value="y" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi" class="md-primary"  v-on:change ="addPackagePrice('e1')">Annuale</md-radio>
                    </div>
                    <div class="md-layout-item md-size-30 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Importo Rata di Premio</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Premio.ImportoRatadiPremio"  md-dense/>
                            <span class="md-error">The Importo Rata di Premio is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100">
                          <md-field  >
                            <label for="firstName">€</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Premio.money2"  md-dense/>
                            <span class="md-error">The € is required</span>
                          </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Prima Rata / importo del primo Premio</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-15 md-small-size-100"></div>
                    <div class="md-layout-item md-size-15 md-small-size-100">
                        <md-radio value="t" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi1" class="md-primary" v-on:change ="addPackagePrice('e2')">Trimestrale</md-radio>
                    </div>
                    <div class="md-layout-item md-size-15 md-small-size-100">
                        <md-radio value="s" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi1" class="md-primary" v-on:change ="addPackagePrice('e2')">Semestrale</md-radio>
                    </div>
                    <div class="md-layout-item md-size-15 md-small-size-100">
                        <md-radio value="y" v-model.lazy="form.formTwo.pageTwo.Premio.PackageEmi1" class="md-primary" v-on:change ="addPackagePrice('e2')">Annuale</md-radio>
                    </div>
                    <div class="md-layout-item md-size-30 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Prima Rata / Primo Premio</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Premio.PrimaRata"  md-dense/>
                            <span class="md-error">The Prima Rata / Primo Premio is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field  >
                            <label for="firstName">€</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageTwo.Premio.money3"  md-dense/>
                            <span class="md-error">The € is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- premio -->

            <!-- ModalitaDiPagamento -->
            <md-card-header>
                <div class="md-title text-center"><h1>MODALITÀ DI PAGAMENTO</h1>
                </div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Primo premio / Premi successivi <span>(barrare la modalità scelta)</span></p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <p style="text-align:left">Primo premio</p>
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.ModalitaDiPagamento.Primopremio" class="md-primary">Addebito diretto SEPA a favore di FWU Life Insurance Lux S.A. (compilare la sezione per l’autorizzazione al pagamento tramite addebito diretto SEPA)</md-checkbox value="x">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.ModalitaDiPagamento.Primopremio2" class="md-primary">CBILL – Avviso di pagamento inviato da FWU Life Insurance Lux S.A. tramite Banca Nel caso di pagamenti a favore di soggetti diversi da “FWU Life Insurance Lux S.A.” ovvero di pagamenti effettuati con modalità diverse da quelle sopra indicate, la Società intenderà il pagamento come non effettuato. Avvertenza: tutte le forme di pagamento devono essere indirizzate a favore di conti intestati alla Società.</md-checkbox value="x">
                    </div>  
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <p style="text-align:left;margin-top: 35px;">Premi successivi</p>
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.ModalitaDiPagamento.Premisuccessivi" class="md-primary">Addebito diretto SEPA a favore di FWU Life Insurance Lux S.A. (compilare la sezione per l’autorizzazione al pagamento tramite addebito diretto SEPA)</md-checkbox value="x">

                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageTwo.ModalitaDiPagamento.Premisuccessivi2" class="md-primary">CBILL – Avviso di pagamento inviato da FWU Life Insurance Lux S.A. tramite Banca Nel caso di pagamenti a favore di soggetti diversi da “FWU Life Insurance Lux S.A.” ovvero di pagamenti effettuati con modalità diverse da quelle sopra indicate, la Società intenderà il pagamento come non effettuato. Avvertenza: tutte le forme di pagamento devono essere indirizzate a favore di conti intestati alla Società.</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>
            <!-- //ModalitaDiPagamento -->
            <!-- Autorizzazioneal -->
            <md-card-header>
                <div class="md-title text-center"><h1 style="margin-top:50px;">AUTORIZZAZIONE AL PAGAMENTO TRAMITE ADDEBITO DIRETTO SEPA</h1>
                </div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Codice identifi cativo del creditore</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100"  v-show='isShowHiddenFields=="true"'>
                        <span>IT500010000094093500216</span>
                    </div>
                    <div class="md-layout-item md-size-20 md-small-size-100"  v-show='isShowHiddenFields=="true"'>
                        <span>Identifi cativo del mandato:</span>
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-field  >
                            <label for="firstName">numero di polizza</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.numerodipolizza"  md-dense/>
                            <span class="md-error">The numero di polizza is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>IBAN Tipo pagamento</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field v-bind:class="{'md-invalid':errors.isInvalidIBAN}">
                            <label for="firstName">Pagamento ricorrente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Pagamentoricorrente" v-on:blur="checkIBAN($event.target.value,'IBANCK1')" md-dense/>
                            <span class="md-error">The Pagamento ricorrente is invalid</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Intestatario del conto</p></div>
                 <div class="md-layout-item md-size-100 md-small-size-100">
                  <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.iscontraente" v-on:change="isContraente()">Lo stesso della persona contraente</md-checkbox value="x">
                 </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Sig"  md-dense/>
                            <span class="md-error">The Sig. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Sigra"  md-dense/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100" style="display:none">
                        <md-field  >
                            <label for="lastName">Soc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Soc"/>
                            <span class="md-error">The Soc. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome / Ragione Sociale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Cognome"/>
                            <span class="md-error">The Cognome / Ragione Sociale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Nome"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout-item md-size-100 md-small-size-100">
                    <md-field>
                        <label>Indirizzo</label>
                        <md-textarea v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Indirizzo"></md-textarea>
                    </md-field>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Numero"  md-dense/>
                            <span class="md-error">The Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.CAP"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-if='form.formTwo.pageThree.iscontraente == ">"'>
                        <md-field  >
                            <label for="lastName">Città</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Citta"/>
                            <span class="md-error">The Città is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-if='form.formTwo.pageThree.iscontraente == ">"'>
                        <md-field >
                            <label for="lastName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Provincia"/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-if='form.formTwo.pageThree.iscontraente != ">"'>
                        <md-field>
                            <label for="Regione4">Città</label>
                            <md-select  v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Citta" id="Regione4" @md-selected="onRegioneChange">
                            <md-option v-for="region in formArr.formTwo.pageThree.Autorizzazioneal.regions" :key="region" :value="region">{{region}}</md-option>
                            </md-select>
                            <span class="md-error">The Regione is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100" v-if='form.formTwo.pageThree.iscontraente != ">"'>
                        <md-field>
                            <label for="Provincia4">Provincia</label>
                            <md-select  v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Provincia" id="Provincia4" @md-selected="onProvinciaChange">
                            <md-option v-for="province in formArr.formTwo.pageThree.Autorizzazioneal.provinces" :key="province" :value="province">{{province}}</md-option>
                            </md-select>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Codice fi scale / Partita IVA</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-49 md-small-size-100">
                        <md-field v-bind:class="{ 'md-invalid': errors.isInvalidCodFisc4 }">
                            <label for="formCodFisc1">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.Codicefiscale" v-on:blur="checkFiscalCode($event.target.value,'f2Fisc4')"/>
                            <span class="md-error">Invalid Cod.Fisc.</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Partita IVA</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Autorizzazioneal.PartitaIVA"  md-dense/>
                            <span class="md-error">The Partita IVA is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- //Autorizzazioneal -->
            <!-- Identificazionedel -->
            <md-card-header>
                <div class="md-title text-center"><h1 style="margin-top:50px;">IDENTIFICAZIONE DEL PAGATORE E DICHIARAZIONI IN OSSERVANZA ALLA NORMATIVA ANTIRICICLAGGIO E ANTITERRORISMO</h1>
                </div>
            </md-card-header>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Pagatore</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Contraente">Contraente</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-80 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Persona">Persona diversa dal Contraente (si prega specifi care di seguito)</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Cognome, nome / Ragione Sociale<span>(se diverso da Contraente)</span></p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Sig"  md-dense/>
                            <span class="md-error">The Sig. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none"> 
                        <md-field  >
                            <label for="firstName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Sigra"  md-dense/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="lastName">Soc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Soc"/>
                            <span class="md-error">The Soc. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome / Ragione Sociale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Cognome"/>
                            <span class="md-error">The Cognome / Ragione Sociale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Nome"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout-item md-size-100 md-small-size-100">
                    <div class="md-title text-left"><p>Residenza / Sede legale</span></p></div>
                </div>
                       
                <div class="md-layout-item md-size-100 md-small-size-100">
                     <md-field>
                        <label>Indirizzo</label>
                        <md-textarea v-model.lazy="form.formTwo.pageThree.Identificazionedel.Indirizzo"></md-textarea>
                    </md-field>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Numero"  md-dense/>
                            <span class="md-error">The Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.CAP"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Città</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Citta"/>
                            <span class="md-error">The Città is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Provincia"/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Data e luogo di nascita</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Datadinascita"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di nascita</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Luogodinascita"  md-dense/>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Provincia2"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Stato di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Statodinascita"  md-dense/>
                            <span class="md-error">The Stato di nascita is required</span>   
                        </md-field>
                    </div>
                </div>
            </md-card-content>
           
            <md-card-content>
                <div class="md-title text-left">
                    <p>Codice fi scale / Partita IVA</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-49 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Codicefiscale"  md-dense/>
                            <span class="md-error">The Codice fi scale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Partita IVA</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.PartitaIVA"  md-dense/>
                            <span class="md-error">The Partita IVA is required</span>
                        </md-field>
                    </div>

                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Relazione con il Contraente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Relazioneconil"  md-dense/>
                            <span class="md-error">The Relazione con il Contraente is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Professione</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Professione"  md-dense/>
                            <span class="md-error">The Professione is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Settore economico</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Settoreeconomico"  md-dense/>
                            <span class="md-error">The Settore economico is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Identifi cazione del pagatore</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Cartadidentita">Carta d’identità</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Patente">Patente</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Passaporto">Passaporto</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero del documento</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Numerodeldocumento"  md-dense/>
                            <span class="md-error">The Numero del documento is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di emissione</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Datadiemissione"  md-dense/>
                            <span class="md-error">The Data di emissione is required</span>
                        </md-field>
                    </div>
                         
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di scadenza</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Datadiscadenza"  md-dense/>
                            <span class="md-error">The Data di scadenza is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Autorità emittente</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Autoritaemittente"  md-dense/>
                            <span class="md-error">The Autorità emittente is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di emissione</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Luogodiemissione"  md-dense/>
                            <span class="md-error">The Luogo di emissione is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Identifi cazione del pagatore</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Ilversamento">Il versamento è effettuato in conto proprio</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Ilversamento2">Il versamento è effettuato per conto di terzi</md-checkbox value="x">
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Nome ed indirizzo della personaper conto della quale è effettuato il versamento</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Sig2"  md-dense/>
                            <span class="md-error">The Sig. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="firstName">Sig.ra</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Sigra2"  md-dense/>
                            <span class="md-error">The Sig.ra is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-10 md-small-size-100"  style="display:none">
                        <md-field  >
                            <label for="lastName">Soc.</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Soc2"/>
                            <span class="md-error">The Soc. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Cognome / Ragione Sociale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Cognome2"/>
                            <span class="md-error">The Cognome / Ragione Sociale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-100">
                        <md-field  >
                            <label for="lastName">Nome</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Nome2"/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Residenza / Sede legale</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Indirizzo</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Indirizzo2"  md-dense/>
                            <span class="md-error">The Indirizzo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Numero2"  md-dense/>
                            <span class="md-error">The Numero is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.CAP2"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Città</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Citta2"  md-dense/>
                            <span class="md-error">The Città is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Provincia3"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Data e luogo di nascita</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Datadinascita2"  md-dense/>
                            <span class="md-error">The Data di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di nascita</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Luogodinascita2"  md-dense/>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Provincia</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Provincia4"  md-dense/>
                            <span class="md-error">The Provincia is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Stato di nascita</span>
                            <md-input type="date" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Statodinascita2"  md-dense/>
                            <span class="md-error">The Stato di nascita is required</span>   
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Codice fi scale / Partita IVA</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice fi scale</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Codicefiscale2"  md-dense/>
                            <span class="md-error">The Codice fi scale is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Partita IVA</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.PartitaIVA2"  md-dense/>
                            <span class="md-error">The Partita IVA is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left">
                    <p>Il premio versato proviene da</p>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Redditoprofessionale">Reddito professionale</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Risparmio">Risparmio</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Eredita">Eredità</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-checkbox value=">" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Altro">Altro</md-checkbox value="x">
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Specifi care le altre origini del versamento</label>
                            <md-input type="text" v-model.lazy="form.formTwo.pageThree.Identificazionedel.Specificarele"  md-dense/>
                            <span class="md-error">The Specifi care le altre origini del versamento is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>
            <!-- //Identificazionedel -->
            <!-- // page three -->
            <!-- // formTwo -->

            <!-- remaining -->

            <!-- form Three -->
            <!-- page one -->
            <md-card-content v-if="form.pageOne.Tipodipersona == 'personafisica'">
                <div class="md-title text-left"><p>Domanda di adesione a</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-radio v-model.lazy="form.formThree.pageOne.SocioOrdinario" value="socio1">Socio Ordinario(Se il richiedente è persona fisica)</md-radio>
                        <md-radio v-model.lazy="form.formThree.pageOne.SocioOrdinario"  value="socio2">Socio Partecipante (Se il richiedente è persona giuridicae/o associazione)</md-radio>
                        <md-radio v-model.lazy="form.formThree.pageOne.SocioOrdinario" value="socio3">Socio</md-radio>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Domanda di adesione numero</label>
                            <md-input type="text" v-model.lazy="form.formThree.pageOne.Domandadiadesione" md-dense/>
                            <span class="md-error">The Domanda di adesione numero is required</span>
                        </md-field> 
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Convenzione</label>
                            <md-input type="text" v-model.lazy="form.formThree.pageOne.Convenzione" md-dense/>
                            <span class="md-error">The Convenzione is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cod. Informatore</label>
                            <md-input type="text" v-model.lazy="form.formThree.pageOne.CodInformatore" md-dense/>
                            <span class="md-error">The Cod. Informatore is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-title text-left"><p>Dati del Richiedente</p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cognome/Ragione Sociale</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.CognomeRagioneSociale"  md-dense/>
                            <span class="md-error">The Cognome/Ragione Sociale is required</span>
                        </md-field> 
                    </div>
                    <div class="md-layout-item md-size-55 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Nome (in caso di azienda inserire Nome e Cognome del legale rapp.)</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Nome"  md-dense/>
                            <span class="md-error">The Nome is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-20 md-small-size-100">
                        <p>Sesso</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Sesso" value="m">M</md-radio>
                            <md-radio  v-model.lazy="form.formThree.pageOne.Sesso" value="f">F</md-radio>
                        </div>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Luogo di nascita</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Luogodinascita"  md-dense/>
                            <span class="md-error">The Luogo di nascita is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Prov.</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Prov"  md-dense/>
                            <span class="md-error">The Prov. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field class = "birthday_container">
                            <span class = "birthday_label">Data di nascita</span>
                            <md-input  v-model.lazy="form.formThree.pageOne.Datadinascita" type="date" value = "2018-02-20"/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Nazionalità</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Nazionalita"  md-dense/>
                            <span class="md-error">The Nazionalità is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Codice Fiscale/Partita IVA</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.CodiceFiscale"  md-dense/>
                            <span class="md-error">The Codice Fiscale/Partita IVA is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <md-field>
                            <label>Indirizzo domicilio</label>
                            <md-textarea v-model.lazy="form.formThree.pageOne.Indirizzodomicilio"></md-textarea>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">CAP</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.CAP"  md-dense/>
                            <span class="md-error">The CAP is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                         <md-field  >
                            <label for="firstName">Località/Frazione</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.LocalitaFrazione"  md-dense/>
                            <span class="md-error">The Località/Frazione is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Prov.</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Prov"  md-dense/>
                            <span class="md-error">The Prov. is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Telefono</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Telefono"  md-dense/>
                            <span class="md-error">The Telefono is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Cellulare</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Cellulare"  md-dense/>
                            <span class="md-error">The Cellulare is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                      <md-field v-bind:class="{ 'md-invalid': errors.isInvalidEmailMail3 }">
                        <label for="Mail">Mail</label>
                        <md-input type="text" v-model.lazy="form.formThree.pageOne.email"  v-on:blur="checkEmail($event.target.value,'f3email')" md-dense/>
                        <span class="md-error">Invalid Email</span>
                     </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Professione</label>
                            <md-input type="text"  v-model.lazy="form.formThree.pageOne.Professione"  md-dense/>
                            <span class="md-error">The Professione is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <div class="md-title text-left"><p>Tipo documento</p></div>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Tipodocumento" value="ci">C.I.</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Tipodocumento" value="pat">PAT</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Tipodocumento" value="pass">PASS.</md-radio>
                        </div>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Numero documento</label>
                            <md-input type="text" v-model.lazy="form.formThree.pageOne.Numerodocumento"  md-dense/>
                            <span class="md-error">The Numero documento is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field  >
                            <label for="firstName">Ente di rilasci o e luogo</label>
                            <md-input type="text" v-model.lazy="form.formThree.pageOne.Entedirilasci"  md-dense/>
                            <span class="md-error">The Ente di rilasci o e luogo is required</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field class = "birthday_container">
                            <span class = "birthday_label">Data di rilascio</span>
                            <md-input v-model.lazy="form.formThree.pageOne.Datadirilascio" type="date" value = "2018-02-20"/>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field class = "birthday_container">
                            <span class = "birthday_label">Data di scadenza</span>
                            <md-input v-model.lazy="form.formThree.pageOne.Datadiscadenza" type="date" value = "2018-02-20"/>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <p>Sussidio prescelto</p>
                        <md-field>
                            <label for="firstName">A</label>
                            <md-input v-model.lazy="form.formThree.pageOne.SussidiopresceltoA" type="text"  md-dense/>
                        </md-field>
                        <md-field>
                            <label for="firstName">B</label>
                            <md-input v-model.lazy="form.formThree.pageOne.SussidiopresceltoB" type="text"  md-dense/>
                        </md-field>
                        <md-field>
                            <label for="firstName">C</label>
                            <md-input v-model.lazy="form.formThree.pageOne.SussidiopresceltoC" type="text"  md-dense/>
                        </md-field>
                    </div> 
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <p>Contributo annuo</p>
                        <md-field>
                            <label for="firstName">€</label>
                            <md-input v-model.lazy="form.formThree.pageOne.ContributoannuoA" type="text"  md-dense/>
                        </md-field>
                        <md-field>
                            <label for="firstName">€</label>
                            <md-input v-model.lazy="form.formThree.pageOne.ContributoannuoB" type="text"  md-dense/>
                        </md-field>
                        <md-field>
                            <label for="firstName">€</label>
                            <md-input v-model.lazy="form.formThree.pageOne.ContributoannuoC" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
            </md-card-content>

            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <p>Copertura scelta</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.CoperturasceltaA" value="s">Singolo</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.CoperturasceltaA" value="n">Nucleo</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.CoperturasceltaB" value="s" style="display:none;">Singolo</md-radio><br/>
                            <md-radio v-model.lazy="form.formThree.pageOne.CoperturasceltaB" value="n">Nucleo</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.CoperturasceltaC" value="s">Singolo</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.CoperturasceltaC" value="n">Nucleo</md-radio>
                        </div>
                    </div> 

                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <p>Frazionamento del pagamento</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Frazionamentodelpagamento" value="m">Mensile</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Frazionamentodelpagamento" value="t">Trimestrale</md-radio><br/>
                            <md-radio v-model.lazy="form.formThree.pageOne.Frazionamentodelpagamento" value="s">Semestrale</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Frazionamentodelpagamento" value="a">Annuale</md-radio>
                            <p><span>In caso di frazionamento è obbligatorio compilare il modellodi addebito SEPA.</span></p>
                        </div>
                    </div> 
                </div>
            </md-card-content>

            <md-card-header style="display:none">
                <div class="md-title text-center">
                    <h1>Riepilogo quote e contributi associativi per richiedente socio ordinario o fruitore</h1>
                </div>
            </md-card-header>

            <md-card-content style="display:none">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        Quota associativa di base annuale (non detraibile)
                    </div> 
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field>
                            <label for="firstName">€ 30,00</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Quotaassociativadi" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        Contributo associativo di base annuale
                    </div> 
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field>
                            <label for="firstName">€ 30,00</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Contributoassociativodi" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        Quota associativa socio fruitore
                    </div> 
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field>
                            <label for="firstName">€ 30,00</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Quotaassociativasocio" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        Contributo aggiuntivo del sussidio prescelto (A+B+C)
                    </div> 
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field>
                            <label for="firstName">€ 30,00</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Contributoaggiuntivodel" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                        Contributo volontario
                    </div> 
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field>
                            <label for="firstName">€ 30,00</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Contributovolontario" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-40 md-small-size-100">
                       <p>Totale quota da versare</p>
                    </div> 
                    <div class="md-layout-item md-size-10 md-small-size-100">
                        <md-field>
                            <label for="firstName">€ 30,00</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Totalequotada" type="text"  md-dense/>
                        </md-field>
                    </div> 
                </div>
            </md-card-content>

            <md-card-content style="display:none">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                       Addebito SEPA (compilare correttamente il modello allegato per pagamento Sepa
                    </div> 
                    <div class="md-layout-item md-size-33 md-small-size-100">
                       Bollettino di Conto Corrente Postale intestato a Aglea Salus - CC Numero 1027834157
                    </div> 
                    <div class="md-layout-item md-size-33 md-small-size-100">
                       Bonifico Bancario intestato a Aglea Salus - IBAN IT50J0878739220000000 0 40738
                    </div> 
                </div>
            </md-card-content>

            <md-card-content style="display:none">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <p>Assegno Circolare o Bancario non trasferibile n°     
                            <md-field>
                                <md-input v-model.lazy="form.formThree.pageOne.AssegnoCircolareo" type="text"  md-dense/>
                            </md-field> i
                            ntestato a Aglea Salus s.g.m.s.
                        </p>
                    </div> 
                    <div class="md-layout-item md-size-33 md-small-size-100">
                       Bonifico Postale intestato a Aglea Salus - IBAN IT95U0760103200001027 83 4157
                    </div> 
                </div> 
            </md-card-content>

            <md-card-content v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <p>N.B.: Non saranno ritenute valide altre modalità di pagamento al di fuori di quelle sopraelencate ed intestate solo ed esclusivamente ad Aglea Salus</p>
                    </div>
                </div>
            </md-card-content>

            <md-card-content v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-title text-left"><p>Il richiedente chiede diinserire nel sussidio prescelto: <span>Per la definizione di familiare si veda il regolamento applicativo.</span></p></div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-100 md-small-size-100">
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.richiedentechiede" value="se">Se stesso e i propri familiari</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.richiedentechiede" value="uno">Uno o più dei suoi familiari</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.richiedentechiede" value="solo">Solo se stesso</md-radio>
                        </div>
                    </div>
                </div>
            </md-card-content>

            <md-card-header v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-title text-center"><h1>Familiari da garantire</h1></div>
            </md-card-header>

            <md-card-content  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Familiare 1 - Nome e Cognome</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Familiare1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data e Luogo di nascita</span>
                            <md-input v-model.lazy="form.formThree.pageOne.DataeLuogodi1" type="date"  md-dense/>
                            <span class="md-error">The Data e Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Familiare 2 - Nome e Cognome</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Familiare2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data e Luogo di nascita</span>
                            <md-input v-model.lazy="form.formThree.pageOne.DataeLuogodi2" type="date" md-dense/>
                            <span class="md-error">The Data e Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Familiare 3 - Nome e Cognome</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Familiare3" type="text"  md-dense/>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data e Luogo di nascita</span>
                            <md-input v-model.lazy="form.formThree.pageOne.DataeLuogodi3" type="date"  md-dense/>
                            <span class="md-error">The Data e Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Familiare 4 - Nome e Cognome</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Familiare4" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data e Luogo di nascita</span>
                            <md-input v-model.lazy="form.formThree.pageOne.DataeLuogodi4" type="date"  md-dense/>
                            <span class="md-error">The Data e Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Familiare 5 - Nome e Cognome</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Familiare5" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field  >
                            <span class="birthday_label">Data e Luogo di nascita</span>
                            <md-input v-model.lazy="form.DataeLuogodi5" type="date" md-dense/>
                            <span class="md-error">The Data e Luogo di nascita is required</span>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-header  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-title text-center"><h1>Grado di parentela: 1 (Coniuge), 2 (Convivente), 3 (Figlio/a)</h1></div>
            </md-card-header>

            <md-card-content  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Grado di parentela</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Gradodiparentela1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Professione</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Professione1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">C.F.</label>
                            <md-input v-model.lazy="form.formThree.pageOne.CF1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <p>Sussidio scelto</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto1" value="a">A</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto1" value="b" style="display:none;">B</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto1" value="c" style="display:none;">C</md-radio>                           -->
                        </div>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Grado di parentela</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Gradodiparentela2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Professione</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Professione2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">C.F.</label>
                            <md-input v-model.lazy="form.formThree.pageOne.CF2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <p>Sussidio scelto</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto2" value="a">A</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto2" value="b" style="display:none;">B</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto2" value="c" style="display:none;">C</md-radio>                          
                        </div>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Grado di parentela</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Gradodiparentela3" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Professione</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Professione3" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">C.F.</label>
                            <md-input v-model.lazy="form.formThree.pageOne.CF3" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <p>Sussidio scelto</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto3" value="a">A</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto3" value="b" style="display:none;">B</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto3" value="c" style="display:none;">C</md-radio>                        
                        </div>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Grado di parentela</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Gradodiparentela4" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Professione</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Professione4" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">C.F.</label>
                            <md-input v-model.lazy="form.formThree.pageOne.CF4" type="text"  md-dense/>
                        </md-field>
                    </div>
                        <div class="md-layout-item md-size-25 md-small-size-100">
                        <p>Sussidio scelto</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto4" value="a">A</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto4" value="b" style="display:none;">B</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto4" value="c" style="display:none;">C</md-radio>
                        </div>
                    </div>
                </div>
            </md-card-content>

            <md-card-content  v-if="form.pageTwo.sectionB.appartiene5">
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Grado di parentela</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Gradodiparentela5" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">Professione</label>
                            <md-input v-model.lazy="form.formThree.pageOne.Professione5" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">C.F.</label>
                            <md-input v-model.lazy="form.formThree.pageOne.CF5" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <p>Sussidio scelto</p>
                        <div class="text-center">
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto5" value="a">A</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto5" value="b" style="display:none;">B</md-radio>
                            <md-radio v-model.lazy="form.formThree.pageOne.Sussidioscelto5" value="c" style="display:none;">C</md-radio>                          
                        </div>
                    </div>
                </div>
            </md-card-content>

            <md-card-header  v-show='isShowHiddenFields==true'>
                <div class="md-title text-center"><h1>Codice IBAN del conto corrente <sup>(2)</sup></h1></div>
            </md-card-header>
            <!-- // page one -->
            <!-- page two -->
            <md-card-content  v-show='isShowHiddenFields==true'>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">codice paese</label>
                            <md-input v-model.lazy="form.formThree.pageThree.codicepaese" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">check digit</label>
                            <md-input v-model.lazy="form.formThree.pageThree.checkdigit" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">CIN</label>
                            <md-input v-model.lazy="form.formThree.pageThree.CIN" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-25 md-small-size-100">
                        <md-field>
                            <label for="firstName">ABI</label>
                            <md-input v-model.lazy="form.formThree.pageThree.ABI" type="text"  md-dense/>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">CAB</label>
                            <md-input v-model.lazy="form.formThree.pageThree.CAB" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-50 md-small-size-100">
                        <md-field>
                            <label for="firstName">Numero di conto corrente(il campo deve contenere 12 caratteri)</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Numerodiconto" type="text"  md-dense/>
                        </md-field>
                    </div>
                </div>
            </md-card-content>

            <md-card-header  v-show='isShowHiddenFields==true'>
                <div class="md-title text-center"><h1>Intestazione e indirizzo del Socio <sup>(3)</sup></h1></div>
            </md-card-header>

            <md-card-content  v-show='isShowHiddenFields==true'>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Nome e Cognome/ Ragione Sociale</label>
                            <md-input v-model.lazy="form.formThree.pageThree.NomeeCognome1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Indirizzo</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Indirizzo1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">CAP/Città</label>
                            <md-input v-model.lazy="form.formThree.pageThree.CAPCitta1" type="text"  md-dense/>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Codice fiscale</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Codicefiscale1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Email</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Email1" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Cellulare</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Cellulare1" type="text"  md-dense/>
                        </md-field>
                    </div>
                </div> 
            </md-card-content>


            <md-card-header v-show='isShowHiddenFields==true'>
                <div class="md-title text-center"><h1>Intestazione e indirizzo dell’intestatario del c/c di addebito <sup>(4)</sup></h1></div>
            </md-card-header>
            <div class="md-title text-left" v-show='isShowHiddenFields==true'><p>(da compilare solo nel caso in cui il correntista sia diverso dal socio)</p></div>
            <md-card-content v-show='isShowHiddenFields==true'>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Nome e Cognome/ Ragione Sociale</label>
                            <md-input v-model.lazy="form.formThree.pageThree.NomeeCognome2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Indirizzo</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Indirizzo2" type="text"  md-dense/>
                        </md-field>
                    </div>
                     <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">CAP/Città</label>
                            <md-input v-model.lazy="form.formThree.pageThree.CAPCitta2" type="text"  md-dense/>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Codice fiscale</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Codicefiscale2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Email</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Email2" type="text"  md-dense/>
                        </md-field>
                    </div>
                    <div class="md-layout-item md-size-33 md-small-size-100">
                        <md-field>
                            <label for="firstName">Cellulare</label>
                            <md-input v-model.lazy="form.formThree.pageThree.Cellulare2" type="text"  md-dense/>
                        </md-field>
                    </div>
                </div> 
            </md-card-content>
            <!-- // page two -->
            <!-- //form three -->
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

</script>
<script>
  import {FormWizard, TabContent} from 'vue-form-wizard';
  import SelectPackageStep from './SelectPackageStep.vue';
  import { validationMixin } from 'vuelidate'
  var IBAN = require('iban');
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
         showCollapse: false,
         isShowHiddenFields:false,
         errors:{
           isInvalidEmailMail1:false,
           isInvalidCodFisc1:false,
           isInvalidFiscColl:false,
           isInvalidIBAN:false,
           isInvalidEmailemail2:false,
           isInvalidCodFiscP2:false,
           isInvalidCodFisc4:false,
         },
        formArr:{
           pageOne:{
                sectionA: {
                    regions:[],
                    provinces:[],
                    provinces1:[],
                    countries:[],
                    dacommunes:[],
                    localcommunes:[],
                    doctypes:["Carta d'identità","Patente di guida","Passaporto"],
                }
           }, 
           pageTwo:{
               sectionB:{
                  collcommunes:[],
                  communes:[],
               },
               sectionC:{
                   countries:[],
               }
           },
           formTwo:{
             Contraente:{
                ecocategories:[],
            },
            Assicurato:{
                regions:[],
                provinces:[],
                province3:[],
                communes:[],
            },
            Assicurato2: {
                lacomunes:[],
                communes:[],     
            }, 
               pageThree:{
                   Autorizzazioneal:{
                       regions:[],
                       provinces:[],
                   }
               }
           }
        }, 
        form: {
            pageOne: {
                Tipodipersona:'',
                CodiceIntermediario : '',
                SottoCodice : '',
                PresenzafisicadelCliente: 'si',
                FirmaDigitale: '',
                CollegamentoAudio: '',
                sectionA: {
                    Cognomeenome1: '',
                    Datadinascita1: '',
                    Luogodinascita1:'--select--',
                    communes:'',
                    Regione:'--select--',
                    Provincia:'--select--',
                    Nazionalità1: 'Italia',
                    formCodFisc1: '',
                    Sesso1: 'm',
                    Tipodocdiidentita1: '',
                    tipodidentità:'',                 
                    N1: '',
                    Rilasciatoil1: '',
                    da1: '',
                    Localitadirilascio1: '',
                    Datascadenzadocidentita1: '',
                    Indirizzodiresidenza1: '',
                    CAP1: '',
                    Prov1: '--select--',
                    Stato21: '',
                    Telefono1: '',
                    Mail1: '',
                    PEP31: 'no',
                    inqualitadi1: '',
                    IncarichiPubblici4: 'no',
                    inquanto1: '',
                },
                sectionB: {
                    Cognomeenome1: '',
                    CodFisc1: '',
                    Datadinascita1: '',
                    Luogodinascita1: '',
                    identificare:'no',
                    pagatore:'no',
                    Italia1: '',
                    UE1: '',
                    PaesiTerzi1quale1: '',
                    appartiene1: '',
                    harapporti1: '',
                    noneri1: '',
                    PEP32: 'no',
                    Cognomeenome2: '',
                    CodFisc2: '',
                    Datadinascita2: '',
                    Luogodinascita2: '',
                    Italia2: '',
                    UE2: '',
                    PaesiTerzi1quale2: '',
                    appartiene2: '',
                    harapporti2: '',
                    noneri2: '',
                    PEP33: 'no',
                    Cognomeenome3: '',
                    CodFisc3: '',
                    Datadinascita3: '',
                    Luogodinascita3: '',
                    Italia3: '',
                    UE3: '',
                    PaesiTerzi1quale3: '',
                    appartiene3: '',
                    harapporti3: '',
                    noneri3: '',
                    PEP34: 'no',
                }
            },
            pageTwo: {
                sectionB: {
                    Cognomeenome4: '',
                    CodFisc4: '',
                    Datadinascita4: '',
                    Luogodinascita4: '',
                    Italia4: '',
                    UE4: '',
                    PaesiTerzi1quale4: '',
                    appartiene4: '',
                    harapporti4: '',
                    noneri4: '',
                    PEP35: 'no',
                    Cognomeenome5: '',
                    CodFisc5: '',
                    Datadinascita5: '',
                    Luogodinascita5: '',
                    Italia5: '',
                    UE5: '',
                    PaesiTerzi1quale5: '',
                    appartiene5: '',
                    harapporti5: '',
                    noneri5: '',
                    PEP36: 'no',
                    Cognomeenome6: '',
                    CodFisc6: '',
                    Datadinascita6: '',
                    Luogodinascita6: '',
                    Italia6: '',
                    UE6: '',
                    PaesiTerzi1quale6: '',
                    appartiene6: '',
                    harapporti6: '',
                    noneri6: '',
                    PEP37: 'no',
                },
                sectionC: {
                    Istitutodicredito: '',
                    TitolareEffettivo: 'Unico',
                    Cognomeenome: '',
                    CodiceFiscale: '',
                    Residenza: '',
                    PEP38: 'no',
                    Luogoedata: '',
                }
            },
            pageThree: {
                sectionD: {
                    Normale: '',
                    Riluttanza: '',
                    Interposizione: '',
                    Ilcliente: '',
                    Altreanomalie: '',
                    Leinformazioni: 'si',
                    Cognome: '',
                    Nome: '',
                    Codice: '',
                    Numiscrizione: '',
                    Regione: '',
                    Luogoedata: '',
                    Intermediario: '',
                    Luogoedata1: '',
                    Intermediario1: '',
                    TimbroFirma: '',
                    WCL: '',
                    Altro: '',
                }
            },
            formTwo: {
                PropostaNumero: '',
                Agenzia: '',
                Codiceagenzia: '',
                Codiceintermediario: '',
                Contraente:{
                    Sig: '',
                    Sigra: '',
                    Soc: '',
                    Cognome: '',
                    Nome: '',
                    Indirizzo: '',
                    Numero: '',
                    CAP: '',
                    Città: '',
                    Provincia: '',
                    Datadinascita: '',
                    Luogodinascita: '',
                    Provincia2: '',
                    Statodinascita: '',
                    Nazionalita: 'Italiana',
                    Professione: '',
                    Settoreeconomico: '',
                    Territorialita: 'Italia',
                    Specificarela: '',
                    Identificativo: '',
                    Codicefiscale: '',
                    PartitaIVA: '',
                    Indirizzo2: '',
                    Numero2: '',
                    CAP2: '',
                    Citta2: '',
                    Provincia3: '',
                    Telefonofisso2: '',
                    Telefonoufficio2: '',
                    Cellulare2: '',
                    email2: '',
                },
                Assicurato:{
                    Contraente3: '',
                    Personadiversadal: '',
                    Sig: '',
                    Sigra: '',
                    Cognome: '',
                    Nome: '',
                    Indirizzo: '',
                    Numero: '',
                    CAP: '',
                    Citta: '--select--',
                    Provincia: '--select--',
                    Datadinascita: '',
                    Luogodinascita: '',
                    Provincia3: '--select--',
                    Statodinascita: '',
                    Nazionalita2: 'Italiana',
                    Professione4: '',
                    Codicefiscale: '',
                    Telefonofisso4: '',
                    Telefonoufficio4: '',
                    Cellulare4: '',
                    email5: '',
                },
                Assicurato2: {
                    Altri: '',
                    Eredi: '',
                    Sig: '',
                    Sigra: '',
                    Soc: '',
                    Cognome: '',
                    Nome: '',
                    Datadinascita: '',
                    Luogodinascita: '',
                    Provincia: '',
                    Statodinascita: '',
                    Percentuale: '',
                    Relazione: '',
                    Codicefiscale: '',
                    PartitaIVA: '',
                    email: '',
                    IlBeneficiario: '',
                    Sig2: '',
                    Sigra2: '',
                    Cognome2: '',
                    Nome2: '',
                    Datadinascita2: '',
                    Luogodinascita2: '--select--',

                    Telefono2: '',
                    Comunicazioni2: '',
                },
                pageTwo: {
                    Beneficiarioincasodivita:{
                        Contraente: '',
                        Assicurato: '',
                        Altri: '',
                        Sig: '',
                        Sigra: '',
                        Soc: '',
                        Cognome: '',
                        Nome: '',
                        Datadinascita: '',
                        Luogodinascita: '',
                        Provincia: '',
                        Statodinascita: '',
                        Percentuale: '',
                        Relazione: '',
                        Codicefiscale: '',
                        PartitaIVA: '',
                        email1: '',
                        Richiestadiescludere: '',
                    },
                    Identificazionedel: {
                        Cartadidentita: '',
                        Patente: '',
                        Passaporto: '',
                        Relazioneconil: '',
                        Codicefiscaledel: '',
                        Datadiemissione: '',
                        Datadiscadenza: '',
                        Autoritaemittente: '',
                        Luogodiemissione: '',
                        Si: '',
                        No: '',
                        NomeCognome: '',
                    },
                    CapacitaDiRisparmio: {
                        Finoa600: '',
                        Tra600e5000: '',
                        Oltre5000: '',
                        Finoa20000: '',
                        Tra20000e35000: '',
                        Tra35000e50000: '',
                        Tra50000e65000: '',
                        Oltre65000: '',
                        Redditofisso: '',
                        Redditovariabilenoncerto: '',
                        Nessuno: '',
                        Finoa1000: '',
                        Tra1000e5000: '',
                        Superiorea5000: '',
                        Numero: '',
                        Dicuiacarico: '',
                    },
                    DecorrenzaEDurata: {
                        DatadiDecorrenza: '',
                        DuratadelContratto: '20',
                    },
                    Premio: {
                        Premioannuo: '',
                        money: '',
                        Opzionediincremento: '',
                        ImportoRatadiPremio: '',
                        money2: '',
                        PackageEmi:'m',
                        PackageEmi1:'t',
                        PrimaRata: '',
                        money3: '',
                    },
                    ModalitaDiPagamento: {
                        Primopremio: '>',
                        Primopremio2: '',
                        Premisuccessivi: '>',
                        Premisuccessivi2: '',
                    }
                },
                pageThree: {
                    Autorizzazioneal: {
                        numerodipolizza: '',
                        Pagamentoricorrente: '',
                        Sig: '',
                        Sigra: '',
                        Soc: '',
                        Cognome: '',
                        Nome: '',
                        Indirizzo: '',
                        Numero: '',
                        CAP: '',
                        Citta: '--select--',
                        Provincia: '',
                        Codicefiscale: '',
                        PartitaIVA: '',
                    },
                    Identificazionedel: {
                        Contraente: '',
                        Persona: '',
                        Sig: '',
                        Sigra: '',
                        Soc: '',
                        Cognome: '',
                        Nome: '',
                        Indirizzo: '',
                        Numero: '',
                        CAP: '',
                        Citta: '',
                        Provincia: '',
                        Datadinascita: '',
                        Luogodinascita: '',
                        Provincia2: '',
                        Statodinascita: '',
                        Codicefiscale: '',
                        PartitaIVA: '',
                        Relazioneconil: '',
                        Professione: '',
                        Settoreeconomico: '',
                        Cartadidentita: '',
                        Patente: '',
                        Passaporto: '',
                        Numerodeldocumento: '',
                        Datadiemissione: '',
                        Datadiscadenza: '',
                        Autoritaemittente: '',
                        Luogodiemissione: '',
                        Ilversamento: '',
                        Ilversamento2: '',
                        Sig2: '',
                        Sigra2: '',
                        Soc2: '',
                        Cognome2: '',
                        Nome2: '',
                        Indirizzo2: '',
                        Numero2: '',
                        CAP2: '',
                        Citta2: '',
                        Provincia3: '',
                        Datadinascita2: '',
                        Luogodinascita2: '',
                        Provincia4: '',
                        Statodinascita2: '',
                        Codicefiscale2: '',
                        PartitaIVA2: '',
                        Redditoprofessionale: '',
                        Risparmio: '',
                        Eredita: '',
                        Altro: '',
                        Specificarele: '',
                    }
                }
            },
            formThree: {
                pageOne: {
                    SocioOrdinario: 'socio1',
                    Domandadiadesione: '',
                    Convenzione: '',
                    CodInformatore: '',
                    CognomeRagioneSociale: '',
                    Nome: '',
                    Sesso: 'm',
                    Luogodinascita: '',
                    Prov: '',
                    Datadinascita: '',
                    Nazionalita: '',
                    CodiceFiscale: '',
                    Indirizzodomicilio: '',
                    CAP: '',
                    LocalitaFrazione: '',
                    Prov: '',
                    Telefono: '',
                    Cellulare: '',
                    email: '',
                    Professione: '',
                    Tipodocumento: 'ci',
                    Numerodocumento: '',
                    Entedirilasci: '',
                    Datadirilascio: '',
                    Datadiscadenza: '',
                    SussidiopresceltoA: '',
                    SussidiopresceltoB: '',
                    SussidiopresceltoC: '',
                    ContributoannuoA: '',
                    ContributoannuoB: '',
                    ContributoannuoC: '',
                    CoperturasceltaA: 's',
                    CoperturasceltaB: 's',
                    CoperturasceltaC: 's',
                    Frazionamentodelpagamento: 'm',
                    Quotaassociativadi: '30.00',
                    Contributoassociativodi: '30.00',
                    Quotaassociativasocio: '30.00',
                    Contributoaggiuntivodel: '30.00',
                    Contributovolontario: '30.00',
                    Totalequotada: '150.00',
                    AssegnoCircolareo: '',
                    richiedentechiede: 'se',
                    Familiare1: '',
                    DataeLuogodi1: '',
                    Familiare2: '',
                    DataeLuogodi2: '',
                    Familiare3: '',
                    DataeLuogodi3: '',
                    Familiare4: '',
                    DataeLuogodi4: '',
                    Familiare5: '',
                    DataeLuogodi5: '',
                    Gradodiparentela1: '',
                    Professione1: '',
                    CF1: '',
                    Sussidioscelto1: 'a',
                    Gradodiparentela2: '',
                    Professione2: '',
                    CF2: '',
                    Sussidioscelto2: 'a',
                    Gradodiparentela3: '',
                    Professione3: '',
                    CF3: '',
                    Sussidioscelto3: 'a',
                    Gradodiparentela4: '',
                    Professione4: '',
                    CF4: '',
                    Sussidioscelto4: 'a',
                    Gradodiparentela5: '',
                    Professione5: '',
                    CF5: '',
                    Sussidioscelto5: 'a',
                },
                pageThree: {
                    codicepaese: '',
                    checkdigit: '',
                    CIN: '',
                    ABI: '',
                    CAB: '',
                    Numerodiconto: '',
                    NomeeCognome1: '',
                    Indirizzo1: '',
                    CAPCitta1: '',
                    Codicefiscale1: '',
                    Email1: '',
                    Cellulare1: '',
                    NomeeCognome2: '',
                    Indirizzo2: '',
                    CAPCitta2: '',
                    Codicefiscale2: '',
                    Email2: '',
                    Cellulare2: '',
                }
            }
        },
        
        
    }),
       beforeMount(){
      axios.post('/registered_userDetails').then((response)=>{
                if(response.data.success)
                    this.addAgentDetails(response.data.agentdetails);
            });
    },
    async mounted(){
        axios.post('/country_details').then((response)=>{
                if(response.data.success)
                    this.addCountries(response.data);
            });
        axios.post('/regions_details').then((response)=>{
                if(response.data.success)
                    this.addRegions(response.data);
            });

        axios.post('/categories_details').then((response)=>{
            if(response.data.success)
                this.addCategories(response.data);
        });
        this.addNextMnt();
        this.addPackagePrice('e1');       
        this.addPackagePrice('e2');   
    },
    methods: {
        getPackageCookies:function(cname){
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }
            return "";    
        },
        calculateEmi:function(type){
            var price = this.getPackageCookies('__PR');
            var newPrice = 0;
             switch(type){
                case 'm':
                    newPrice = parseFloat(price/12).toFixed(2);
                    break;
                case 't':
                     newPrice = parseFloat(price/4).toFixed(2);
                    break; 
                    
                case 's':
                    newPrice = parseFloat(price/2).toFixed(2);
                    break; 
                    
                 case 'y':
                     newPrice = parseFloat(price).toFixed(2);
                    break;    
             }

             return newPrice;
        },
         addPackagePrice:function(section){
             var type = '';
             var newPrice = 0;
             if(section == 'e1'){
              type = this.form.formTwo.pageTwo.Premio.PackageEmi;
              newPrice = this.calculateEmi(type);
              this.form.formTwo.pageTwo.Premio.money2 = newPrice;
             }else{
                type = this.form.formTwo.pageTwo.Premio.PackageEmi1;
                newPrice = this.calculateEmi(type);
                this.form.formTwo.pageTwo.Premio.money3 = newPrice;
             }
         },
         setErrorVariables:function(fieldName,value){
           switch(fieldName){
              case 'sec1email':
                 this.errors.isInvalidEmailMail1 = value;
                break;
              case 'f3email':
                 this.errors.isInvalidEmailMail3 = value;
                break;
              case 'f2e1':
                 this.errors.isInvalidEmailemail2 = value;
                break;
               case 'collemail':
                 this.errors.isInvalidCollEmail = value;
                break;
               case 'sec1Fisc':
                 this.errors.isInvalidCodFisc1 = value;
                 break;
               case 'secBFisc':
                   this.errors.isInvalidCodFisc6 = value;
                   break;
               case 'CodFisc4':
                   this.errors.isInvalidCodFisc4 = value;
                   break;
               case 'collFisc':
                  this.errors.isInvalidFiscColl = value;
                  break;        
               case 'coll3Fisc':
                  this.errors.isInvalidCodFisc3 = value;
                  break;        
               case 'form2email':
                  this.errors.isInvalidEmailMail5 = value;
                  break;        
               case 'ascFisc':
                  this.errors.isInvalidCodFiscAsc = value;
                  break;        
               case 'P2Fisc':
                  this.errors.isInvalidCodFiscP2 = value;
                  break;        
               case 'f2Fisc4':
                  this.errors.isInvalidCodFisc4 = value;
                  break;        
           }  
        },
        isContraente:function(){
         if(this.form.formTwo.pageThree.iscontraente == '>'){
           
            this.form.formTwo.pageThree.Autorizzazioneal.Cognome = this.form.pageOne.sectionA.Cognomeenome1;
            this.form.formTwo.pageThree.Autorizzazioneal.Nome = this.form.formTwo.Contraente.Nome;
            this.form.formTwo.pageThree.Autorizzazioneal.Indirizzo =this.form.pageOne.sectionA.Indirizzodiresidenza1;
            this.form.formTwo.pageThree.Autorizzazioneal.Numero = this.form.pageOne.sectionA.Telefono1;
            this.form.formTwo.pageThree.Autorizzazioneal.CAP = this.form.pageOne.sectionA.CAP1;
            this.form.formTwo.pageThree.Autorizzazioneal.Citta = this.form.pageOne.sectionA.Regione;
            this.form.formTwo.pageThree.Autorizzazioneal.Provincia = this.form.pageOne.sectionA.Provincia;
            this.form.formTwo.pageThree.Autorizzazioneal.Codicefiscale = this.form.pageOne.sectionA.formCodFisc1;
            this.form.formTwo.pageThree.Autorizzazioneal.PartitaIVA = '';
         }else{
            this.form.formTwo.pageThree.Autorizzazioneal.Cognome = '';
            this.form.formTwo.pageThree.Autorizzazioneal.Nome = '';
            this.form.formTwo.pageThree.Autorizzazioneal.Indirizzo = '';
            this.form.formTwo.pageThree.Autorizzazioneal.Numero = '';
            this.form.formTwo.pageThree.Autorizzazioneal.CAP = '';
            this.form.formTwo.pageThree.Autorizzazioneal.Citta = '';
            this.form.formTwo.pageThree.Autorizzazioneal.Provincia = '';
            this.form.formTwo.pageThree.Autorizzazioneal.Codicefiscale = '';
            this.form.formTwo.pageThree.Autorizzazioneal.PartitaIVA = '';
         }
        },
        addNextMnt:function(){
         let d = new Date();
         let month = d.getMonth();
         month = month+1;
         if(month< 10){
             month = '0'+month;
         }
         let year = d.getFullYear();
         this.form.formTwo.pageTwo.DecorrenzaEDurata.DatadiDecorrenza = year+'-'+month+'-01';
        },
        addPackageValues:function(){
        var packageType = this.getPackageCookies('__PT');
        var packagePrice = this.getPackageCookies('__PR');
        if(packageType == 1){
           packageType = 'Oro';
        }else if(packageType == 2){
           packageType = 'Argento';
        }else{
           packageType = 'Platino';
        }
          this.form.formTwo.pageTwo.Premio.Premioannuo = packageType;
          this.form.formTwo.pageTwo.Premio.money = packagePrice;
          this.form.formThree.pageOne.SussidiopresceltoA = packageType;
          this.form.formThree.pageOne.SussidiopresceltoB = packageType;
          this.form.formThree.pageOne.SussidiopresceltoB = packageType;  
          this.form.formThree.pageOne.SussidiopresceltoB = packageType;  
        },
        checkEmail:function(value,fieldName){
         let emailpatt = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/;
         let result = emailpatt.test(value);
         if(!result){
             this.setErrorVariables(fieldName,true);
           }else{
             this.setErrorVariables(fieldName,false);
              
         }
        },
        checkIBAN:function(value,fieldName){
          let result = IBAN.isValid(value)
          if(!result){
              this.errors.isInvalidIBAN = true;
          }else{
              this.errors.isInvalidIBAN = false;
          }
        },
        copyFormValues:function(){
            this.form.formTwo.Contraente.Indirizzo = this.form.pageOne.sectionA.Indirizzodiresidenza1;
            this.form.formTwo.Contraente.Numero = this.form.pageOne.sectionA.Telefono1;
            this.form.formTwo.Contraente.CAP = this.form.pageOne.sectionA.CAP1;
            this.form.formTwo.Contraente.Città = this.form.pageOne.sectionA.Regione;
            this.form.formTwo.Contraente.Provincia = this.form.pageOne.sectionA.Provincia;

            this.form.formTwo.Contraente.Datadinascita = this.form.pageOne.sectionA.Datadinascita1;
            this.form.formTwo.Contraente.Luogodinascita=this.form.pageOne.sectionA.Luogodinascita1;
            this.form.formTwo.Contraente.Provincia2=this.form.pageOne.sectionA.Provincia;
            this.form.formTwo.Contraente.Statodinascita = this.form.pageOne.sectionA.Datascadenzadocidentita1;

            this.form.formThree.pageThree.Indirizzo2 = this.form.pageOne.sectionA.Indirizzodiresidenza1;
            this.form.formThree.pageThree.CAPCitta2  = this.form.pageOne.sectionA.CAP1;
            this.form.formThree.pageThree.Codicefiscale2 = this.form.pageOne.sectionA.formCodFisc1;
            this.form.formThree.pageThree.Email2   = this.form.pageOne.sectionA.Mail1;
            this.form.formThree.pageThree.Cellulare2 =	this.form.pageOne.sectionA.Telefono1;

            this.form.formTwo.Contraente.Codicefiscale = this.form.pageOne.sectionA.formCodFisc1
            this.form.formTwo.Contraente.PartitaIVA   = '';
            this.form.formTwo.Contraente.Indirizzo2   = this.form.pageOne.sectionA.Indirizzodiresidenza1
            this.form.formTwo.Contraente.Numero2 =	this.form.pageOne.sectionA.Telefono1;
            this.form.formTwo.Contraente.CAP2 = this.form.pageOne.sectionA.CAP1;
            this.form.formTwo.Contraente.Citta2 = this.form.pageOne.sectionA.CAP1;
            this.form.formTwo.Contraente.Provincia2 = this.form.pageOne.sectionA.Provincia;
            this.form.formTwo.Contraente.Telefonofisso2 =	this.form.pageOne.sectionA.Telefono1;
            this.form.formTwo.Contraente.Telefonoufficio2 =	this.form.pageOne.sectionA.Telefono1;
            this.form.formTwo.Contraente.Cellulare2 =	this.form.pageOne.sectionA.Telefono1;
            this.form.formTwo.Contraente.email2 = this.form.pageOne.sectionA.Mail1;
        },
        checkFiscalCode:function(value,fieldName){
           let patt = /^([A-Za-z]{6}[0-9lmnpqrstuvLMNPQRSTUV]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9lmnpqrstuvLMNPQRSTUV]{2}[A-Za-z]{1}[0-9lmnpqrstuvLMNPQRSTUV]{3}[A-Za-z]{1})$|([0-9]{11})$/;
           let res = patt.test(value); 
           if(!res){
           this.setErrorVariables(fieldName,true);
           }else{
            this.setErrorVariables(fieldName,false);
           }
        },
        addAgentDetails:function(data){
            this.form.pageOne.CodiceIntermediario = data.codiceintermediario;
            this.form.pageOne.SottoCodice = data.sotto_codice;
            this.form.pageThree.sectionD.Cognome = data.last_name;
            this.form.formTwo.Contraente.Cognome = data.last_name;
            this.form.formTwo.Contraente.Nome = data.first_name;
            this.form.pageThree.sectionD.Nome = data.first_name;
            this.form.pageThree.sectionD.Codice = data.codiceintermediario;
            this.form.pageThree.sectionD.Intermediario = data.first_name;
            this.form.pageThree.sectionD.Intermediario1 = data.first_name;
        },
        addCountries:function(data){
             this.formArr.pageOne.sectionA.countries = data.countries;
             this.formArr.pageTwo.sectionC.countries = data.countries;
        },
        addCategories:function(data){
             this.formArr.formTwo.Contraente.ecocategories = data.catagories;
        },
        addRegions:function(data){
             this.formArr.pageOne.sectionA.regions = data.regions;
             this.formArr.formTwo.Assicurato.regions = data.regions;             
             this.formArr.formTwo.pageThree.Autorizzazioneal.regions = data.regions;

        },
        addProvinces:function(data){
             this.formArr.pageOne.sectionA.provinces = data.provinces;
             this.formArr.pageOne.sectionA.provinces1 = data.provinces;
             this.formArr.formTwo.Assicurato.provinces = data.provinces;
             this.formArr.formTwo.Assicurato.provinces3 = data.provinces;
             this.formArr.formTwo.pageThree.Autorizzazioneal.provinces = data.provinces;
        },
        addCommunes:function(data){
             this.formArr.pageOne.sectionA.communes = data.communes;
             this.formArr.pageOne.sectionA.dacommunes = data.communes;
             this.formArr.pageOne.sectionA.localcommunes = data.communes;
             this.formArr.pageOne.sectionA.collcommunes = data.communes;
             this.formArr.pageTwo.sectionB.communes = data.communes;
             this.formArr.formTwo.Assicurato.communes = data.communes;
        },
        onRegioneChange:function(data){
                 if(data != '--select--' &&  data != ''){    
                axios.post('/provinces_details', {value:data}).then((response)=>{
                    if(response.data.success)
                        this.addProvinces(response.data);
                });
            }      
          
        },
        onProvinciaChange:function(data){  
         
        if(data != '--select--' && data != ''){
             axios.post('/commune_details', {value:data}).then((response)=>{
                if(response.data.success){
                    this.addCommunes(response.data);
                }
            });
           }       
        },
        haltContract:function(){
          if( this.form.pageOne.sectionA.PEP31 == 'si'||
              this.form.pageTwo.sectionB.PEP35 == 'si'||
              this.form.pageTwo.sectionB.PEP36 == 'si'||
              this.form.pageTwo.sectionB.PEP37 == 'si'||
              this.form.pageTwo.sectionC.PEP38 == 'si'){
                alert("Selezionare No nella persona esposta politicamente per procedere."); 
                return false;
              }  
        },    
        copyInformation:function(){
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
        getValidationClass(fieldName) {
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
        },
        validateFields:function(){
             this.copyFormValues();
             if(!this.form.pageThree.sectionD.Normale ||
                !this.form.formTwo.pageTwo.CapacitaDiRisparmio.Tra600e5000 ||
                !this.form.formTwo.pageTwo.CapacitaDiRisparmio.Redditofisso||
                !this.form.formTwo.pageTwo.CapacitaDiRisparmio.Finoa1000 ||
                !this.form.formTwo.pageTwo.CapacitaDiRisparmio.Tra20000e35000||
                 this.errors.isInvalidEmailMail1||
                 this.errors.isInvalidCodFisc1||
                 this.errors.isInvalidFiscColl ||
                 this.errors.isInvalidCodFisc6){
                 return true; 
                 }
        }
    }
  }
</script>
<style scoped>
  .mandatory-field{
    color: rgb(130, 60, 60)
}
.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
    color: #000 !important;
    border: transparent;
    font-weight: 700;
    background: transparent !important;
}

</style>
