<script>
import {RESUME_STATUSES} from "./BaseResume";
import {EDUCATION_TYPES, isComplexEducation} from "./ResumeEducation";

export default {
    name: "ResumeGenerator",
    props: ["resume"],
    data() {
        return {
            resumeStatuses: RESUME_STATUSES,
            educationTypes: EDUCATION_TYPES,
            isComplexEducation: isComplexEducation
        };
    }
}
</script>

<template>
    <div class="col">
        <div class="row mb-1">
            <div class="col-md-12">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-9 shadow-sm h-md-250 position-relative">
                    <div class="col-auto d-lg-block">
                        <div id="photo" class="py-5 text-center container row col-lg-6 col-md-8 mx-auto">
                            <img v-if="resume.imagePreview" v-bind:src="resume.imagePreview" width="200"
                                 class="img text-center" aria-label="Placeholder: Thumbnail"/>
                        </div>
                    </div>
                    <div class="col p-4 d-flex flex-column position-static">
                        <p class="card-text mb-auto">Статус: {{ resumeStatuses[resume.status] }}</p>
                        <h3 class="mb-0">{{ resume.lastName }}</h3>
                        <h3 class="mb-0">{{ resume.firstName }}</h3>
                        <h3 class="mb-0">{{ resume.patronymic }}</h3>
                        <div class="mb-0 text-muted">{{ resume.profession }}</div>
                        <div class="mb-1 text-muted"> Опыт работы: {{ resume.experience }}</div>

                        <div v-for="education in resume.educations">
                            <p class="card-text mb-auto">Образование: {{ educationTypes[education.type] }}</p>

                            <div v-if="isComplexEducation(education)">
                                <p class="card-text mb-auto">Учебное учреждение: {{ education.institute }}</p>
                                <p class="card-text mb-auto">Специальность: {{ education.specialization }}</p>
                                <p class="card-text mb-auto">Факультет: {{ education.faculty }}</p>
                                <p class="card-text mb-auto">Год окончания: {{ education.endYear }}</p>
                            </div>
                            <br>
                        </div>
                        <div class="mb-1 text-muted"> Ожидаемая зарплата: {{ resume.expectedSalary }}</div>
                    </div>
                    <div class="mb-1 text-muted"> Почтовый адрес для связи - {{ resume.email }}.</div>
                    <div class="mb-1 text-muted"> Контактный телефон - {{ resume.phone }}.</div>
                    <div class="mb-1 text-muted"> Дата рождения: {{ (resume.birthdate??'').substr(0, 10) }}</div>

                    <p class="card-text mb-auto" id="infoSkills">Обладаю следующими навыками: {{
                            resume.skills
                        }}
                    </p>
                    <p class="card-text mb-auto">Город проживания - {{ resume.city }}</p>
                    <p class="card-text mb-auto">О себе - {{ resume.about }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
