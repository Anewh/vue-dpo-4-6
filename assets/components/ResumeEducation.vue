<script>
import ResumeSelect from './ResumeSelect.vue'
import ResumeInput from './ResumeInput.vue'

export default {
    name: "ResumeEducation",
    components: [ResumeSelect, ResumeInput],
    props: ["educationData"],

    data() {
        return {
            educationTypes: {
                level0: 'Среднее',
                level1: 'Среднее специальноее',
                level2: 'Неоконченное высшее',
                level3: 'Высшее',
            }
        }
    },
    computed: {
        isComplexEduc() { // Проверка выбранного образования
            return this.educationData.type === this.educationTypes.level1 ||
                this.educationData.type === this.educationTypes.level2 ||
                this.educationData.type === this.educationTypes.level3;
        },
    },
    methods: {
        resetField(field) {
            this.values[field] = '';
        },
    }
}
</script>

<template>
    <ResumeSelect label="Образование" v-bind:values="educationTypes" 
        v-on:changed="(value) => educationData.type = value" />

    <div v-if="isComplexEduc">
        <ResumeInput fieldType="text" fieldName="institute" label="Учебное учреждение"
            v-on:isValidEvent="(value) => educationData.institute = value"
            v-on:isInvalidEvent="resetField" />

        <ResumeInput fieldType="text" fieldName="faculty" label="Факультет"
            v-on:isValidEvent="(value) => educationData.faculty = value"
            v-on:isInvalidEvent="resetField" />

        <ResumeInput fieldType="number" fieldName="endYear" label="Год окончания"
            v-on:isValidEvent="(value) => educationData.endYear = value"
            v-on:isInvalidEvent="resetField" />

        <ResumeInput fieldType="text" fieldName="specialization" label="Специализация"
            v-on:isValidEvent="(value) => educationData.specialization = value"
            v-on:isInvalidEvent="resetField" />
    </div>
</template>
