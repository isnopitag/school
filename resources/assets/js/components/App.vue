<template>
    <toolbar>
        <router-view></router-view>
    </toolbar>
</template>

<script>

import Toolbar from '@components/shared/Toolbar.vue'

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components:{
            Toolbar
        }
    }
</script>


<style>
  /*@import '@node_modules/vuetify/dist/vuetify.min.css';*/

  main{
      padding: 16px;
  }
</style>