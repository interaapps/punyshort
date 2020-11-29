<template>
  <div>
    a
    <Navigation />
    <div id="page" :class="{'sidebar-contents-hidden': $route.meta.hideSidebarContents}">
      <router-view/>
    </div>
  </div>
</template>
<script>
import Navigation from "./components/Navigation.vue";
export default {
  components: {
    Navigation
  }
}
</script>
<style lang="scss" scoped>
@import './assets/scss/variables';

#app {
  height: 100%;
}


</style>