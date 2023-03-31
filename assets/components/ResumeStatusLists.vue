<script>
import { RESUME_STATUSES } from './BaseResume'
import draggable from "vuedraggable";
import { resumeApi } from "../controllers/ResumeApiController";

// Получение и отображение списков резюме в зависимости от статуса
export default {
  name: "ResumeStatusLists",
  components: { draggable },
  data() {
    return {
      resumeStatuses: RESUME_STATUSES,
      resumeStatusLists: {},
    };
  },
  mounted() {
    for (const status of Object.keys(this.resumeStatuses)) {
      this.resumeStatusLists[status] = [];
    }
    
    // получение и группировка всех резюме по статусу  
    resumeApi.getAll()
      .then((response) => {
        for (const resume of response.data) {
          this.resumeStatusLists[resume.status].push(resume);
        }
      });
  },
  methods: {
    sendStatusUpdate(e) {
      const newStatus = e.to.getAttribute('status');
      resumeApi.statusUpdate(
        this.resumeStatusLists[newStatus][e.newIndex].id,
        newStatus
      );
    },
  }
}
</script>

<template>
  <div class="d-flex flex-row">
    <div v-for="(resumes, status) in resumeStatusLists" :key="status" class="container text-center">
      <p class="text-center border-bottom mb-3 pb-3">
        {{ resumeStatuses[status] + ' (' + resumes.length + ')' }}
      </p>
      <!-- Drag-and-drop -->
      <draggable :list="resumeStatusLists[status]" :component-data="{ status: status }" group="cards" itemKey="id"
        @end="sendStatusUpdate">
        <!-- не переименовывать element!!! -->
        <template #item="{ element }">
          <div class="card rounded-2 mb-5">
            <img v-if="element.imagePreview" :src="element.imagePreview" class="card-img-top" alt="">
            <div class="card-body">
              <h5 class="card-title">
                {{ element.profession }}
              </h5>
              <p class="card-text">
                {{ element.lastName + ' ' + element.firstName + ' ' + element.patronymic }}
              </p>
              <p class="card-text text-sm">
                Полных лет - {{ new Date().getFullYear() - new Date(element.birthdate).getFullYear() }}
              </p>
              <router-link :to="{ name: 'resumeEdit', params: { id: element.id } }" class="btn btn-outline-secondary">
                Редактировать
              </router-link>
            </div>
          </div>
        </template>
      </draggable>
    </div>
  </div>
</template>



<style scoped></style>