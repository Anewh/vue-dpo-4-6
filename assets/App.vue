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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link id="logo" :to="{ name: 'resumeStatusLists' }" class="nav-link">
                  Главная страница
                </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'resumeAdd' }" class="btn btn-outline-success me-2">
                  Новое резюме
                </router-link>
            </li>
            </ul>
            </div>
          </div>
        </nav>



            <!-- <ul class="nav">
              <li class="nav-item mt-auto">
                
                <router-link id="logo" :to="{ name: 'resumeStatusLists' }" class="btn btn-outline-primary">
                  Главная страница
                </router-link>
              </li>
              <li class="nav-item ms-4 mt-auto">
                <router-link :to="{ name: 'resumeAdd' }" class="btn btn-outline-primary">
                  Новое резюме
                </router-link>
              </li>
            </ul> -->
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
