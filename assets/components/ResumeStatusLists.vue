<script>
import {RESUME_STATUSES} from './BaseResume'
import draggable from "vuedraggable";
import {resumeApi} from "../controllers/ResumeApiController";

export default {
  name: "ResumeStatusLists",
  components: {draggable},
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
    }
  }
}
</script>

<template>
  <div class="d-flex flex-row">
    <div
        v-for="(resumes, status) in resumeStatusLists"
        :key="status"
        class="card-list d-flex flex-column p-3 pb-0 border rounded-3 mx-2"
    >
      <p class="text-center border-bottom mb-3 pb-3">
        {{ resumeStatuses[status] + ' (' + resumes.length + ')' }}
      </p>
      <draggable :list="resumeStatusLists[status]" :component-data="{status: status}"
                 group="cards" itemKey="id"
                 @end="sendStatusUpdate"
      >
        <template #item="{ element }">
          <div class="card rounded-3 mb-3">
            <img v-if="element.imagePreview" :src="element.imagePreview" class="card-img-top" alt="">

            <div class="card-body">
              <h5 class="card-title">
                {{ element.profession }}
              </h5>

              <p class="card-text">
                ФИО: {{ element.lastName + ' ' + element.firstName + ' ' + element.patronymic }}
              </p>
              <p class="card-text text-sm-start">
                Возраст: {{ new Date().getFullYear() - new Date(element.birthdate).getFullYear() }}
              </p>

              <router-link :to="{name: 'resumeEdit', params: {id: element.id}}">
                Редактировать
              </router-link>
            </div>
          </div>
        </template>
      </draggable>
    </div>
  </div>
</template>



<style scoped>

</style>