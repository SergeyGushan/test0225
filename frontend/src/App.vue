<template>
  <div id="app">
    <Header />
    <router-view />
  </div>
</template>

<script>
import Header from './components/Header.vue';
import Table from './components/Table.vue';

export default {
  name: 'App',
  components: {
    Header,
    Table
  }
};
</script>

<style>
/* Стили для основного контейнера, если нужны */
#app {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}
</style>
