<script>
export default {
    data() {
        return {
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
            photo: '',
            errors: "",
            file: '',
            showPreview: false, //флаг наличия картинки
            imagePreview: '',   //путь к картинке 

            institute: '',
            faculty: '',
            specialization: '',
            endYear: '',
            selectedEduc: '', // выбранное образование
            educ: [
                { level: 'Среднее' },
                { level: 'Среднее специальноее' },
                { level: 'Неоконченное высшее' },
                { level: 'Высшее' }
            ]
        }
    },
    computed: {
        fullName: {    // Получить полное имя создателя резюме
            get: function () {
                return this.lastName + " " + this.firstName + " " + this.patronymic;
            },
            set: function (newValue) {
                return newValue;
            }
        },
        isCorrectFirstName: { // Проверка корректности значения в поле для ввода имени
            get: function () {
                const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
                return regex.test(this.firstName);
            },
            set: function (newValue) {
                this.profession = newValue;
            }
        },
        isCorrectLastName: { // Проверка корректности значения в поле для ввода фамилии
            get: function () {
                const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
                return regex.test(this.lastName);
            },
            set: function (newValue) {
                this.profession = newValue;
            }
        },
        isCorrecrPatr: { // Проверка корректности значения в поле для ввода отчества
            get: function () {
                const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
                return regex.test(this.patronimyc);
            },
            set: function (newValue) {
                this.profession = newValue;
            }
        },
        isCorrectEmail: { // Проверка корректности значения в поле для ввода почты 
            get: function () {
                if (this.email.length == 0) return true;
                const regex = RegExp("^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$");
                console.log(regex.test(this.email));
                return regex.test(this.email);
            },
            set: function (newValue) {
                this.profession = newValue;
            }
        },
        isCorrectPhone: { // Проверка корректности значения в поле для ввода телефона
            get: function () {
                if (this.phone.length == 0) return true;
                const regex = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
                return regex.test(this.phone);
            },
            set: function (newValue) {
                this.profession = newValue;
            }
        },
        isComplexEduc: { // Проверка выбранного образования
            get: function () {
                return this.selectedEduc === this.educ[1].level ||
                    this.selectedEduc === this.educ[2].level ||
                    this.selectedEduc === this.educ[3].level;
            },
            set: function (newValue) {

            }
        },
    },
    methods: {
        handleFileUpload() { // загрузка файла и отображение фотографии резюме
            this.file = this.$refs.file.files[0];
            let reader = new FileReader();
            reader.addEventListener("load", function () {
                this.showPreview = true;
                this.imagePreview = reader.result;
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
                        <div id="resume-app">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="inputName" class="form-label">Имя</label>
                                    <input type="text" class="form-control" id="inputName" v-model="firstName"
                                        pattern="^[А-Яа-яЁё\s\-]+$">
                                    <div v-if="!isCorrectFirstName">
                                        <label class="form-check-label error" for="inputName">
                                            Введите корректное имя
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputLastname" class="form-label">Фамилия</label>
                                    <input type="text" class="form-control" id="inputLastname" v-model="lastName">
                                    <div v-if="!isCorrectLastName">
                                        <label class="form-check-label error" for="inputLastName">
                                            Введите корректную фамилию
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputNameP" class="form-label">Отчество</label>
                                    <input type="text" class="form-control" id="inputNameP" v-model="patronymic">
                                    <div v-if="!isCorrecrPatr">
                                        <label class="form-check-label error" for="inputNameP">
                                            Введите отчество
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail" v-model="email">
                                </div>
                                <div v-if="!isCorrectEmail">
                                    <label class="form-check-label error" for="inputEmail">
                                        Введите корректный email
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCity" class="form-label" id="inputEmail">Город</label>
                                    <input type="text" class="form-control" id="inputCity" v-model="city">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputDate" class="form-label">Дата рождения</label>
                                    <input type="date" class="form-control" id="inputDate" v-model="birthdate">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPhone" class="form-label">Телефон</label>
                                    <input type="phone" class="form-control" id="inputPhone" v-model="phone"
                                        placeholder=" 8 900 555 55 55">
                                    <div v-if="!isCorrectPhone">
                                        <label class="form-check-label error" for="inputPhone">
                                            Введите корректный номер телефона
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputEduc" class="form-label" id="inputEduc">Образование</label>
                                    <select v-model="selectedEduc" class="form-select">
                                        <option v-for="elem in educ" v-bind:value="elem.level">{{ elem.level }}</option>
                                    </select>
                                </div>
                                <div v-if="isComplexEduc">
                                    <div class="col-12">
                                        <label for="inputInst" class="form-label">Учебное учреждение</label>
                                        <input type="text" class="form-control" id="inputInst" v-model="institute"
                                            placeholder="Какой-то там универ">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputFacult" class="form-label">Факультет</label>
                                        <input type="text" class="form-control" id="inputFacult" v-model="faculty">
                                    </div>
                                    <!-- <div class="input-group mb-3"> -->
                                    <div class="col-md-6">
                                        <label for="inputYear" class="form-label">Год окончания</label>
                                        <input type="text" class="form-control" id="inputYear" v-model="endYear">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputSpecial" class="form-label">Специализация</label>
                                        <input type="text" class="form-control" id="inputSpecial"
                                            v-model="specialization">
                                    </div>
                                </div>
                                <!-- </div> -->


                                <div class="col-12">
                                    <label for="inputProfession" class="form-label">Желаемая профессия</label>
                                    <input type="text" class="form-control" id="inputProfession" v-model="profession"
                                        placeholder="Разработчик всякой фигни">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputSalary" class="form-label">Ожидаемая зарплата</label>
                                    <input type="text" class="form-control" id="inputSalary" v-model="expectedSalary">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputExp" class="form-label">Опыт работы</label>
                                    <input type="text" class="form-control" id="inputExp" v-model="experience">
                                </div>
                                <div class="col-12">
                                    <label for="inputSkills" class="form-label">Навыки</label>
                                    <input type="text" class="form-control" id="inputSkills" v-model="skills"
                                        placeholder="Умею воровать код">
                                </div>
                                <div class="col-12">
                                    <label for="inputAbout" class="form-label">О себе</label>
                                    <input type="text" class="form-control" id="inputAbout" v-model="about"
                                        placeholder="...">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="container">
                                        <div class="large-12 medium-12 small-12 cell">
                                            <label>File Preview
                                                <input type="file" class="form-control" id="file" ref="file"
                                                    accept="image/*" v-on:change="handleFileUpload()" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div
                                    class="row g-0 border rounded overflow-hidden flex-md-row mb-9 shadow-sm h-md-250 position-relative">
                                    <div class="col-auto d-lg-block">
                                        <div id="photo"
                                            class="py-5 text-center container row col-lg-6 col-md-8 mx-auto">
                                            <img v-bind:src="imagePreview" v-show="showPreview" width="200"
                                                height="auto" class="img text-center"
                                                aria-label="Placeholder: Thumbnail" />
                                        </div>
                                    </div>
                                    <div class="col p-4 d-flex flex-column position-static">
                                        <h3 class="mb-0">{{ fullName }}</h3>
                                        <div class="mb-0 text-muted">{{ profession }}</div>
                                        <div class="mb-1 text-muted"> Опыт работы: {{ experience }}</div>

                                        <div v-if="isComplexEduc">
                                            <p class="card-text mb-auto">Образование: {{ secectedEduc }}</p>
                                            <p class="card-text mb-auto">Специальность: {{ specialization }}</p>
                                            <p class="card-text mb-auto">Факультет: {{ faculty }}</p>
                                            <p class="card-text mb-auto">Год окончания: {{ endYear }}</p>
                                        </div>

                                        <div class="mb-1 text-muted"> Ожидаемая зарплата: {{ expectedSalary }}</div>
                                    </div>
                                    <div class="mb-1 text-muted"> Почтовый адрес для связи - {{ email }}.</div>
                                    <div class="mb-1 text-muted"> Контактный телефон - {{ phone }}.</div>
                                    <div class="mb-1 text-muted"> Дата рождения: {{ birthdate }}</div>

                                    <p class="card-text mb-auto" id="infoSkills">Обладаю следующими навыками: {{
                                        skills
                                    }}
                                    </p>
                                    <p class="card-text mb-auto">Город проживания - {{ city }}</p>
                                    <p class="card-text mb-auto">О себе - {{ about }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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