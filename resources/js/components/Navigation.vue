<template>
  <div>
    <Sidebar v-if="manuallyOpened || !mobile" />
    <div id="navigation">
      <svg v-if="mobile" @click="manuallyOpened = !manuallyOpened" id="open-menu-button" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg>

      <router-link to="/" id="logo">    
          <svg width="218" height="218" viewBox="0 0 218 218" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M125.73 42.3204C126.421 42.1377 127.157 42.3374 127.66 42.8442L174.757 90.2444C175.26 90.7513 175.455 91.4884 175.268 92.1779L157.766 156.665C157.579 157.354 157.038 157.892 156.348 158.075L91.7499 175.161C91.0591 175.344 90.3233 175.144 89.8197 174.637L42.7234 127.237C42.2197 126.73 42.0248 125.993 42.2119 125.303L59.7136 60.8166C59.9007 60.127 60.4415 59.5896 61.1323 59.4069L125.73 42.3204Z" stroke="#0A61FB" stroke-width="14"/><path d="M115.692 86.8872L130.614 101.905C131.117 102.412 131.312 103.149 131.125 103.838L125.58 124.27C125.393 124.96 124.852 125.497 124.161 125.68L103.694 131.093C103.004 131.276 102.268 131.076 101.764 130.569L86.8425 115.551C86.3389 115.045 86.1439 114.307 86.3311 113.618L91.8762 93.1866C92.0633 92.497 92.6041 91.9597 93.2949 91.777L113.762 86.3634C114.453 86.1807 115.188 86.3804 115.692 86.8872Z" stroke="#0A61FB" stroke-width="14"/><path d="M133.2 32.6632L184.859 84.6553C186.747 86.5561 187.478 89.32 186.777 91.906L167.579 162.64C166.878 165.226 164.85 167.241 162.259 167.926L91.403 186.668C88.8126 187.353 86.0534 186.604 84.1648 184.704L32.506 132.711C30.6174 130.811 29.8863 128.047 30.5882 125.461L49.7853 54.7267C50.4871 52.1408 52.5152 50.1257 55.1056 49.4405L125.962 30.6987C128.552 30.0136 131.311 30.7624 133.2 32.6632Z" stroke="#0A61FB" stroke-width="3"/><path d="M121.885 75.9952L142.152 96.3927C144.04 98.2935 144.771 101.058 144.07 103.644L136.538 131.394C135.836 133.98 133.808 135.995 131.218 136.68L103.42 144.033C100.829 144.718 98.0701 143.97 96.1815 142.069L75.9147 121.671C74.0262 119.77 73.2951 117.006 73.9969 114.421L81.5282 86.6697C82.23 84.0838 84.2582 82.0687 86.8486 81.3835L114.647 74.0307C117.237 73.3456 119.996 74.0944 121.885 75.9952Z" stroke="#0A61FB" stroke-width="3"/><path d="M78.0001 54.5C78.8335 61.3333 84.3001 74 99.5001 70C114.7 66 140.833 71.3333 152 74.5C147 92.1667 141.3 130.6 158.5 143C163 146.244 163.333 153.167 155 150.5C130.167 149.167 80.0001 149.3 78.0001 160.5C75.5001 174.5 75.0001 117.5 55.5001 86C39.9001 60.8 67.5001 77.5 57.5001 83.5C62.1668 80 72.3002 69.9 75.5002 57.5" stroke="#0A61FB" stroke-opacity="0.21"/></svg>
      </router-link>

      <div id="user" v-if="$store.state.user.loggedIn">

        <div id="pb">
          <span class="letter">
            {{$store.state.user.name.substr(0,1)}}
          </span>
        </div>
      </div>
      <a href="/ia/auth/user/login" v-else id="login-button">
        LOGIN
      </a>
    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar.vue';
import EventBus from "../EventBus";
export default {
  data: function(){ return{
    mobile: false,
    manuallyOpened: false
  }},
  mounted(){
    this.checkMobile()
    window.addEventListener("resize", ()=>{
      this.checkMobile()
    });
    EventBus;
  },
  methods: {
    checkMobile(){
      this.mobile = window.innerWidth < 720
    }
  },
  components: {
    Sidebar
  }
}
</script>

<style lang="scss" scoped>
  @import '../assets/scss/variables';
  #navigation {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 65px;
    background: #000230;
    box-shadow: 6px 0px 8px 0px #00000022;
    z-index: 701;

    #open-menu-button {
      display: inline-block;
      color: #FFF;
      height: 40px;
      width:  40px;
      margin-bottom: 12px;
      margin-left: 20px;
      margin-right: 10px;
    }

    #logo,
    #logo:visited {
        padding: 7.5px;
        display: inline-block;
        color: $primary;
        text-decoration: none;
        margin-left: 2.5px;
        svg, img {
            width: 50px;
            display: block;
            height: 50px;
        }
    }

    #user {
      position: fixed;
      display: inline-block;
      right: 30px;
      #pb {
        padding: 5px;
        border-radius: 5px;
        background: $primaryAlpha;
        color: $primary;
        margin-top: 10px;
        .letter {
          height: 35px;
          text-align: center;
          line-height: 1;
          width: 35px;
          font-size: 35px;
          display: block;
        }
      }
    }

    #login-button, #login-button:visited {
      float: right;
      display: inline-block;
      color: #FFF;
      margin: 14px;
      font-size: 15px;
      padding: 9px 20px;
      border-radius: 4px;
      text-decoration: none;
      background: linear-gradient(268.27deg, #000483 1.09%, #00036A 100.73%);
    }
  }

@media screen and (max-width: 720px) {
    #navigation {
      #logo {
        border-right: none;
      }
    }
}
</style>