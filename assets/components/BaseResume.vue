<script>
import ResumeInput from './ResumeInput.vue'
import ResumeSelect from './ResumeSelect.vue'
import ResumeEducation from './ResumeEducation.vue'
import ResumeGenerator from './ResumeGenerator.vue'
import ResumeEducationList from './ResumeEducationList.vue'
import ResumeInputCity from './ResumeInputCity.vue'
import { resumeApi } from "../controllers/ResumeApiController";

export const RESUME_STATUSES = { level0: "Новое", level1: "Назначено собеседование", level2: "Принят", level3: "Отказ" };

/* Корневой компонент для резюме
* Дерево компонентов:
* - baseResume
* -- resumeInput
* -- resumeInputCity
* -- resumeSelect
* -- resumeEducationList
* --- resumeEducation
* ---- educOrganizationInput
* ---- resumeInput
* ---- resumeSelect
* -- resumeGenerator
*
* data():
* - values - значения полей resume
* - vkData - данные, полученные из API vk.com 
* -- список всех городов в РФ
* -- список обарзовательных организаций(ОО) в выбранном городе (по умолчанию - ОО по всей стране)
* -- выбранный город
*
* methods():
* - saveResume - добавление и изменение резюме
*/

export default {
    name: "BaseResume",
    components: { ResumeInput, ResumeGenerator, ResumeSelect, ResumeEducationList, ResumeInputCity },
    data() {
        return {
            values: {
                firstName: '',
                lastName: '',
                patronymic: '',
                city: '',
                profession: '',
                email: '',
                birthdate: '',
                phone: '',
                expectedSalary: '',
                experience: '',
                skills: '',
                about: '',

                status: "level0",
                educations: [],

                imagePreview: '', //путь к картинке
            },

            formValues: {},

            resumeStatuses: RESUME_STATUSES,

            vkData: {
                russiaId: undefined,
                cities: [],
                universities: [],
                selectedCity: undefined,
            },
        }
    },
    mounted() {
        if (this.$route.params.id) {
            resumeApi
                .getById(parseInt(this.$route.params.id))
                .then((response) => {
                    if (response.status === 200) {
                        // const data = processResponse(response.data);
                        response.data['birthdate'] = response.data['birthdate'].substring(0, 10);
                        this.values = response.data;
                        this.formValues = structuredClone(response.data);
                    }
                });
        }
    },
    methods: {
        saveFormValue(fieldName, value, isValid = true) {
            this.formValues[fieldName] = isValid ? value : "";
        },
        sendResume() {
            this.formValues.status = this.values.status;

            if (this.$route.name === "resumeAdd") {
                resumeApi.add(this.formValues);
            } else if (this.$route.name === "resumeEdit") {
                resumeApi.edit(parseInt(this.$route.params.id), this.formValues);
            }
        }
    }
}
</script>

<template>
    <div class="position-relative overflow-hidden p-1 p-md-3 m-md-1 text-center bcground">
        <div class="col-md-3 p-lg-3 mx-auto my-3">
            <p class="lead fw-normal pb-4 mb-4 border-bottom">Заполните поля</p>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
    <div class="container">
        <div class="container text-center">
            <div id="resume">
                <div class="row">
                    <div class="col">
                        <div class="row g-3">
                            <ResumeInput fieldType="text" fieldName="firstName" label="Имя" v-model="values.firstName"
                                errorMessage="Введите корректное имя" v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="lastName" label="Фамилия" v-model="values.lastName"
                                errorMessage="Введите корректную фамилию" v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="patronymic" label="Отчество"
                                v-model="values.patronymic" errorMessage="Введите корректное отчество"
                                v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="email" label="Email" v-model="values.email"
                                errorMessage="Введите корректный email" v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="date" fieldName="birthdate" label="Дата рождения"
                                v-model="values.birthdate" errorMessage="Введите дату рождения"
                                v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="phone" label="Телефон" v-model="values.phone"
                                errorMessage="Введите корректный номер телефона" v-on:afterValidate="saveFormValue" />

                            <ResumeInputCity label="Город" type="text" fieldName="city" v-model="values.city"
                                v-bind:vkData="vkData" v-on:afterValidate="saveFormValue" />

                            <ResumeEducationList v-bind:modelValue="values.educations"
                                v-on:update:modelValue="(value) => saveFormValue('educations', value)"
                                v-bind:vkData="vkData" />

                            <ResumeSelect isSelectFirst="true" label="Статус" fieldName="status" v-model="values.status"
                                v-bind:values="resumeStatuses" />

                            <ResumeInput fieldType="text" fieldName="profession" label="Желаемая профессия"
                                v-model="values.profession" errorMessage="Введите корректную профессию"
                                v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="number" fieldName="expectedSalary" label="Ожидаемая зарплата"
                                v-model="values.expectedSalary" v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="experience" label="Опыт работы"
                                v-model="values.experience" v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="skills" label="Навыки" v-model="values.skills"
                                v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="about" label="О себе" v-model="values.about"
                                v-on:afterValidate="saveFormValue" />

                            <ResumeInput fieldType="text" fieldName="imagePreview" label="Аватар"
                                v-model="values.imagePreview" v-on:afterValidate="saveFormValue" />
                        </div>
                        <hr>
                        <button class="btn btn-primary" v-on:click="sendResume">
                            Применить
                        </button>
                    </div>
                    <ResumeGenerator v-bind:resume="formValues" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
input,
textarea,
select {
    box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25),
        -8px -8px 12px 0 rgba(255, 255, 255, 0.3);
}

.convex {
    background: linear-gradient(-45deg, rgba(0, 0, 0, 0.22), rgba(255, 255, 255, 0.25));
}

.concave {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.22), rgba(255, 255, 255, 0.25));
}

.error {
    font-size: 10px;
    color: red;
}
</style>