import Vue from 'vue'
import Router from 'vue-router'

import FirstRunChecker from '@/components/FirstRunChecker'
import InitWizard from '@/components/InitWizard/InitWizard'
import LoginScreen from '@/components/LoginScreen'

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
    },
    {
      path: '/login-screen/',
      name: 'LoginScreen',
      component: LoginScreen
    }
  ]
})
