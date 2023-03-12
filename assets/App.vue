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
    <ul class="nav">
      <li class="nav-item mt-auto">
        <!--      <a class="nav-link active" aria-current="page" href="#">Active</a>-->
        <router-link id="logo" :to="{name: 'resumeStatusLists'}">
          Главная страница
        </router-link>
      </li>
      <li class="nav-item ms-4 mt-auto">
        <router-link :to="{name: 'resumeAdd'}">
          Новое резюме
        </router-link>
      </li>
    </ul>
  </header>

  <main>
    <div class="container mb-5">
      <router-view></router-view>
    </div>
  </main>
</template>

<style scoped>
header {
  line-height: 1.5;
}
</style>
