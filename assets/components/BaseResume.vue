<script>
import ResumeInput from './ResumeInput.vue'
import ResumeSelect from './ResumeSelect.vue'
import ResumeEducation from './ResumeEducation.vue'
import ResumeGenerator from './ResumeGenerator.vue'
import ResumeList from './ResumeList.vue'
import ResumeInputCity from './ResumeInputCity.vue'

const RESUME_STATUSES = { level0: 'Новое', level1: 'Назначено собеседование', level2: 'Принят', level3: 'Отказ' };
const EMPTY_EDUCATION_DATA = { index: 0, type: '', institute: '', faculty: '', specialization: '', endYear: '', isComplex: '', };

export default {
    name: "BaseResume",
    components: { ResumeInput, ResumeEducation, ResumeGenerator, ResumeSelect, ResumeList, ResumeInputCity },

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

                status: RESUME_STATUSES['level0'],
                educations: [structuredClone(EMPTY_EDUCATION_DATA)],

                imagePreview: '', //путь к картинке
                isImageLoaded: false,

                resumeStatuses: RESUME_STATUSES
            },

            file: '',

            // institute: '',
            // faculty: '',
            // specialization: '',
            // endYear: '',
        }
    },
    methods: {
        resetField(field) {
            this.values[field] = '';
        },
        handleFileUpload() { // загрузка файла и отображение фотографии резюме
            this.file = this.$refs.file.files[0];
            let reader = new FileReader();
            reader.addEventListener("load", function () {
                this.values.isImageLoaded = true;
                this.values.imagePreview = reader.result;
            }.bind(this), false);
            if (this.file) {
                if (/\.(jpe?g|png|gif)$/i.test(this.file.name)) {
                    reader.readAsDataURL(this.file);
                }
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
                        <!-- <div id="resume-app"> -->
                        <div class="row g-3">
                            <ResumeInput fieldType="text" fieldName="firstName" label="Имя"
                                errorMessage="Введите корректное имя"
                                v-on:isValidEvent="(value) => values.firstName = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="lastName" label="Фамилия"
                                errorMessage="Введите корректную фамилию"
                                v-on:isValidEvent="(value) => values.lastName = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="patronymic" label="Отчество"
                                errorMessage="Введите отчество" v-on:isValidEvent="(value) => values.patronymic = value"
                                v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="email" label="Email"
                                errorMessage="Введите корректный email" v-on:isValidEvent="(value) => values.email = value"
                                v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="date" fieldName="birthdate" label="Дата рождения"
                                v-on:isValidEvent="(value) => values.birthdate = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="phone" label="Телефон"
                                errorMessage="Введите корректный номер телефона"
                                v-on:isValidEvent="(value) => values.phone = value" v-on:isInvalidEvent="resetField" />

                            <ResumeList v-bind:educations="values.educations" />

                            <ResumeSelect isSelectFirst='true' label="Статус" v-bind:values="values.resumeStatuses"
                                v-on:changed="(value) => values.status = values.resumeStatuses[value]" />

                            <ResumeInput fieldType="text" fieldName="profession" label="Желаемая профессия"
                                v-on:isValidEvent="(value) => values.profession = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="number" fieldName="expectedSalary" label="Ожидаемая зарплата"
                                v-on:isValidEvent="(value) => values.expectedSalary = value"
                                v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="experience" label="Опыт работы"
                                v-on:isValidEvent="(value) => values.experience = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="skills" label="Навыки"
                                v-on:isValidEvent="(value) => values.skills = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInput fieldType="text" fieldName="about" label="О себе"
                                v-on:isValidEvent="(value) => values.about = value" v-on:isInvalidEvent="resetField" />

                            <ResumeInputCity label="Город" type="text"
                                @city-selected="(city) => values.city = city"
                                v-on:isInvalidEvent="resetField">
                            </ResumeInputCity>
                            <div class="input-group mb-3">
                                <div class="container">
                                    <div class="large-12 medium-12 small-12 cell">
                                        <label>Аватар
                                            <input type="file" class="form-control" id="file" ref="file" accept="image/*"
                                                v-on:change="handleFileUpload()" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ResumeGenerator v-bind:resume="values" />
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