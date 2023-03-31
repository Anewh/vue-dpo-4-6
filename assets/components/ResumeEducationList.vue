<script>
import ResumeEducation from './ResumeEducation.vue'

// Компонент, содержащий список форм для образований
// Добавление, удаление образования. Изменение полей формы образования - в resumeEducation

const EMPTY_EDUCATION_DATA = {
    index: 0,
    type: '',
    institute: '',
    faculty: '',
    specialization: '',
    endYear: '',
    isComplex: ''
}

export default {
    name: "ResumeEducationList",
    components: {ResumeEducation},
    props: ["modelValue", "vkData"],
    data() {
        return {
            isValid: false,
            educationsData: undefined
        }
    },
    watch: {
        modelValue(newValue, oldValue) {
            this.educationsData = structuredClone(newValue);
            let index = 0;
            for (const education of this.educationsData) {
                education.index = index++;
            }
        }
    },
    methods: {
        addEducation() {
            let newEducation = structuredClone(EMPTY_EDUCATION_DATA);
            if(!this.educationsData) this.educationsData = [];
            newEducation.index = this.educationsData.length > 0 ?
                this.educationsData[this.educationsData.length - 1].index + 1 : 0;

            this.educationsData.push(newEducation);
            this.$emit("update:modelValue", this.educationsData);
        },
        removeEducation(educationIndex) {
            this.educationsData.splice(this.educationsData.findIndex((education) => education.index === educationIndex), 1)
            this.$emit("update:modelValue", this.educationsData);
        },
        educationChanged(index, education) {
            this.educationsData[index] = education;
            this.$emit("update:modelValue", this.educationsData);
        },
    }
}
</script>

<template>
    <div class="bd-example">
        <hr>
        <div v-for="(education, index) in educationsData" v-bind:key="education.id">
            <ResumeEducation v-bind:modelValue="education"
                             v-on:update:modelValue="(value) => educationChanged(index, value)"
                             v-bind:vkData="vkData" v-on:remove="removeEducation"/>
            <hr>
        </div>
        <label for="new-todo" class="form-label"></label>
        <button v-on:click="addEducation" class="btn btn-primary" style="margin: 1em; width: 300px">Добавить образование
        </button>
        <hr>
    </div>
</template>