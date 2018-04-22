<template>
  <div class="wizard">
    <div class="steps">
      <div v-if="confFileProperties.notWritable">
        You need to change permissions on your filesystem.
      </div>
      <div v-if="savingConfigFileError">
        Error occured while writing config file.
      </div>
      <init-wizard-step-one v-if="currentStep === 1" v-model="confFileState"></init-wizard-step-one>
      <init-wizard-step-two v-if="currentStep === 2" v-model="confFileState"></init-wizard-step-two>
      <init-wizard-step-three v-if="currentStep === 3" v-model="confFileState"></init-wizard-step-three>
      <button 
        v-if="currentStep !== 3" 
        v-bind:disabled="currentStep === 1"
        v-on:click="currentStep--"
      >Previous</button>
      <button 
        v-if="currentStep < 2"
        v-on:click="currentStep++"
      >Next</button>
      <button 
        v-if="currentStep === 2"
        v-on:click="saveConfigFile()"
      >Finish</button>
      <button v-if="currentStep === 3">Log in</button>
    </div>
  </div>
</template>

<script>
import InitWizardStepOne from './InitWizardStepOne.vue';
import InitWizardStepTwo from './InitWizardStepTwo.vue';
import InitWizardStepThree from './InitWizardStepThree.vue';

export default {
  name: 'InitWizard',
  props: [ 'confFileProperties' ],
  data() {
    return {
      currentStep: 1,
      confFileProperties: this.confFileProperties,
      confFileState: {},
      savingConfigFileError: false
    }
  },
  components: {
    InitWizardStepOne,
    InitWizardStepTwo,
    InitWizardStepThree
  },
  methods: {
    saveConfigFile() {
      var status;
      fetch(window.location.protocol + "//" + window.location.hostname + "/sloth-admin-api/config-file/", {
        body: JSON.stringify(this.confFileState),
        cache: 'no-cache',
        headers: {
          'content-type' : 'application/json'
        },
        method: 'POST',
        redirect: 'follow',
        referrer: 'no-referrer'
      })
      .then((response) => {
        status = response.status;
        return response.json();
      })
      .then((data) => {
        console.log(status);
        if (status === 201) {
          this.currentStep++;
        } else {
          this.savingConfigFileError = true;
          this.currentStep = 1;
        }
      });
      
    }
  }
}
</script>

<style>
  .wizard {
    display: grid;
    grid-template-rows: 1fr auto 1fr;
    grid-template-columns: 1fr auto 1fr;
    background: purple;
    height: 100%;
    width: 100%;
  }

 .wizard .steps {
   background: white;
   grid-column: 2 / 3;
   grid-row: 2 / 3;
   display: grid;
    grid-template-columns: 1fr 1fr;
    padding: 1rem;
    grid-row-gap: 0.5rem;
 }

  .wizard .steps .step {
    display: grid;
    grid-template-columns: 1fr 1fr;    
    grid-column: 1 / 3;
  }
</style>