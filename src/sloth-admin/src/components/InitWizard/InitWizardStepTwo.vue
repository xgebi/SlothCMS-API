<template>
  <div class="step step-2">
    <label for="page-name">Admin username:</label>
    <input id="page-name" v-model="value.adminUsername" />
    <label for="page-subtitle">Admin password:</label>
    <input id="page-subtitle" v-model="value.adminPassword" type="password"/>
    <label for="page-name">Full name:</label>
    <input id="page-name" v-model="value.adminName" />
    <label for="page-name">Admin email:</label>
    <input id="page-name" v-model="value.adminEmail" />
  </div>
</template>

<script>
export default {
  name: 'init-wizard-step-two',
  props: [ 'value' ]
}
</script>

<style>

</style>
