<script>
import BaseResume from './components/BaseResume.vue'

export default {
  name: "App",
  components: {
    BaseResume
  }
}

</script>

<template>
  <header>
    <div class="wrapper">
    </div>
  </header>

  <main>
    <BaseResume />
  </main>
</template>

<style scoped>
header {
  line-height: 1.5;
}
</style>
