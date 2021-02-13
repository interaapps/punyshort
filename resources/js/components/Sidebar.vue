<template>
  <div id="sidebar">
    <div id="sidebar-actions">
      <div id="navigation-icons">
        <router-link to="/" :class="{selected: $route.name == 'Home'}">
          <svg viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/><path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/></svg>
          <span>HOME</span>
        </router-link>
        <router-link to="/links" :class="{selected: $route.name == 'Links'}" v-if="$store.state.user.loggedIn">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-link-45deg" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/><path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/></svg>
          <span>LINKS</span>
        </router-link>
      </div>
    </div>
    <div id="sidebar-contents" v-if="!$route.meta.hideSidebarContents">
      <div id="top">
        <input id="search" type="text" placeholder="Search..." v-model="search">
      </div>
      <div id="entries">
        <router-link v-if="link.link.toLowerCase().includes(search.toLowerCase()) || link.shorten.toLowerCase().includes(search.toLowerCase())"
                     class="entry" v-for="link in $store.state.links" :key="link.shorten" :to="'/links/'+encodeURIComponent(link.name)+'?domain='+encodeURIComponent(link.domain)">
          <h1>{{link.shorten}}</h1>
          <h3>{{link.link}}</h3>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: ()=>({
    search: ""
  })
}
</script>
<style lang="scss" scoped>
@import '../assets/scss/variables';

#sidebar {
  z-index: 700;
  max-width: 100%;
  #sidebar-actions {
    position: fixed;
    background: #000230;
    top: 65px;
    left: 0px;
    width: 67px;
    height: 100%;
    z-index: 703;
    overflow: auto;



    hr {
      border: $borderColor 1px solid;
      width: 50%;
      border-radius: 2px;
      margin: auto;
      margin-bottom: 25px;
    }

    #navigation-icons {
      a, a:visited {
        color: #FFF;
        display: block;
        text-decoration: none;
        cursor: pointer;

        svg {
          margin: auto;
          margin-top: 10px;
          margin-bottom: 6px;
          width:  34px;
          height: 34px;
          display: block;
        }

        span {
          font-size: 12.5px;
          text-align: center;
          display: block;
        }

        &.selected {
          color: $primary
        }

        &:hover {
          background: #FFFFFF11;
        }
      }
    }

    padding-bottom: 75px;

    &::-webkit-scrollbar {
      width: 0px;
    }
  }

  #sidebar-contents {
    position: fixed;
    background: #0D0F3B;
    top:  65px;
    left: 67px;
    width: 280px;
    height: 100%;
    box-shadow: 0px 4px 8px 0px #00000022;
    z-index: 702;

    overflow: auto;


    #entries {

      .label {
        display: block;
        font-size: 16px;
        color: $labelColor;
        margin-left: 12px;
        margin-top: 20px;
        margin-bottom: 15px;

        img, svg {
          width: 21px;
          height: 21px;
          vertical-align: middle;
          margin-right: 14px;
        }

        span {
          vertical-align: middle;
        }
      }

      .entry, .entry:visited {
        padding: 7px 10px;
        font-size: 18px;
        color: #FFFFFF;
        text-decoration: none;
        display: block;
        transition: 0.3s;


        width: 100%;
        overflow: hidden;

        &:hover {
          background: #FFFFFF11;
        }

        &.router-link-exact-active {
          background: #FFFFFF22;
        }

        h1 {
          font-size: 18.8px;
          white-space: nowrap;
        }
        h3 {
          font-size: 15px;
          overflow: hidden;
          width: 100%;
          margin-top: 5px;
          white-space: nowrap;
        }

        img, svg {
          width: 21px;
          height: 21px;
          vertical-align: middle;
          margin-right: 14px;
        }

        span {
          vertical-align: middle;
        }
      }
    }
  }

  #top {
    padding: 10px;
    #search {
      padding: 8px 10px;
      width: 100%;
      border: none;
      background: #FFFFFF22;
      color: #FFF;
      border-radius: 5px;
    }
  }
}
</style>