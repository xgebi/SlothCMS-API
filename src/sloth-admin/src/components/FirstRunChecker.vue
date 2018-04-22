<template>
  <div>
    First run checker
  </div>
</template>

<script>
export default {
  name: 'FirstRunChecker',
  mounted() {
    this.findConfFile()
  },
  data() {
    return {
      firstRun: true,
    }
  },
  methods: {
    findConfFile() {
      var status;
      fetch(window.location.protocol + "//" + window.location.hostname + "/sloth-admin-api/config/")
        .then((response) => {
          status = response.status;
          return response.json();
        })
        .then((data) => {           
          if (status === 404) {
            this.$router.push({ name: 'InitWizard', params: { confFileProperties: data } });
          } else {
            this.$router.push('LoginPage');
          }
        })                
    }
  },
}
</script>

<style>

</style>