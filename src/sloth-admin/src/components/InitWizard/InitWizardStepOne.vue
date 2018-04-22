<template>
  <div class="step step-1">
    <label for="page-name">Web site name:</label>
    <input id="page-name" v-model="value.sitename" />
    <label for="page-subtitle">Web site sub title:</label>
    <input id="page-subtitle" v-model="value.subtitle" />
  </div>
</template>

<script>
export default {
  name: 'init-wizard-step-one',
  props: [ 'value' ]
}
</script>

<style>

</style>
