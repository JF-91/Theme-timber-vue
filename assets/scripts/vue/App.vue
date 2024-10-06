<template>
  <div>
    <h1 class="test-class">test vue</h1>
  </div>
</template>

<script>
export default {
  name: 'App',
  // Agrega tus datos, métodos, etc. aquí
};
</script>

<style scoped lang="scss">
/* Tus estilos aquí */
.test-class {
  color: red;
  &:hover {
    color: blue;
  }
}
</style>
