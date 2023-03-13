<script>
import ResumeSelect from './ResumeSelect.vue'
import ResumeInput from './ResumeInput.vue'
import EducOrganizationInput from './EducOrganizationInput.vue';


// Компонент, содержащий форму для ввода данных об образовательной организации
export const EDUCATION_TYPES = {
    level0: "Среднее",
    level1: "Среднее специальное",
    level2: "Неоконченное высшее",
    level3: "Высшее",
}

export function isComplexEducation(education) {
    return education.isComplex =
        education.type === "level1" ||
        education.type === "level2" ||
        education.type === "level3";
}

export default {
    name: "ResumeEducation",
    components: {ResumeSelect, ResumeInput, EducOrganizationInput},
    props: ["modelValue", "vkData"],
    emits: ["update:modelValue", "remove"],

    data() {
        return {
            educationTypes: EDUCATION_TYPES,
            isComplexEducation: isComplexEducation
        }
    },
    methods: {
        educationChanged(field, value) {
            this.educationData = structuredClone(this.modelValue);
            this.educationData[field] = value;
            this.$emit("update:modelValue", this.educationData);
        }
    }
}
</script>

<template>
    <div class="row">
        <ResumeSelect isSelectFirst='false' label="Образование" fieldName="type"
                      v-bind:modelValue="modelValue.type"
                      v-on:update:modelValue="(value) => educationChanged('type', value)"
                      v-bind:values="educationTypes"/>
        <button class="btn btn-primary" style="margin: 1em; width: 150px; margin-top: 30px"
                v-on:click="$emit('remove', modelValue.index)">
            Удалить
        </button>
        <div class="bd-example">
            <!-- <hr> -->
            <br/>
        </div>
        <div class="row" v-if="isComplexEducation(modelValue)">
            <!-- <br> -->
            <EducOrganizationInput fieldName="institute" v-bind:vkData="vkData"
                                   v-bind:modelValue="modelValue.institute"
                                   v-on:afterValidate="educationChanged"/>

            <ResumeInput fieldType="text" fieldName="faculty" label="Факультет"
                         v-bind:modelValue="modelValue.faculty"
                         v-on:afterValidate="educationChanged"/>

            <ResumeInput fieldType="number" fieldName="endYear" label="Год окончания"
                         v-bind:modelValue="modelValue.endYear"
                         v-on:afterValidate="educationChanged"/>

            <ResumeInput fieldType="text" fieldName="specialization" label="Специализация"
                         v-bind:modelValue="modelValue.specialization"
                         v-on:afterValidate="educationChanged"/>
        </div>
        <div></div>
    </div>
</template>
