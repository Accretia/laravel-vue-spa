import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import BootstrapVue from 'bootstrap-vue'
import Lightbox from 'vue-easy-lightbox'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(Lightbox)
/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
