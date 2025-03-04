<template>
  <header>
    <div class="logo">TEST DATA</div>
    <nav>
      <router-link :to="{ name: 'Review' }">Обзор</router-link>
      <router-link :to="{ name: 'Upload' }">Добавить данные</router-link>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'Header',
};
</script>

<style scoped>
header {
  background-color: #333;
  color: white;
  padding: 10px 20px;
  display: flex;
  align-items: center;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  margin-right: 20px;
}

nav {
  display: flex;
}

nav a {
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  margin-right: 20px;
  background-color: #444;
  border-radius: 5px;
  transition: background-color 0.3s;
}

nav a:hover {
  background-color: #555;
}
</style>
