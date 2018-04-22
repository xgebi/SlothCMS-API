import Vue from 'vue'
import Router from 'vue-router'

import FirstRunChecker from '@/components/FirstRunChecker'
import InitWizard from '@/components/InitWizard/InitWizard'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'FirstRunChecker',
      component: FirstRunChecker
    },
    {
      path: '/init-wizard/',
      name: 'InitWizard',
      component: InitWizard,
      props: true
    }
  ]
})
