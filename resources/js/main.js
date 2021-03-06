import Vue from 'vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import {PrajaxClient} from "cajaxjs";
import App from "./App.vue";
require("babel-polyfill");
require("./assets/scss/app.scss")

Vue.config.productionTip = false

let punyshortClient = new PrajaxClient({
  baseUrl: "/"
});

punyshortClient.get("user")
    .then(res=>res.json())
    .then(res=>{
      store.state.user = res
    })
    
punyshortClient.get("user/links")
  .then(res=>{
    store.state.links = res.json()
  })

punyshortClient.get("user/domains")
  .then(res=>{
    store.state.domains = res.json()
  })

Vue.mixin({
  data: function(){
    return {
      punyshortClient
    }
  }
})

const app = new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app")
