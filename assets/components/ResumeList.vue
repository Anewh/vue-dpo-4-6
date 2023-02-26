<script>
import ResumeEducation from './ResumeEducation.vue'

const EMPTY_EDUCATION_DATA = { index: 0, type: '', institute: '', faculty: '', specialization: '', endYear: '', isComplex: '' }

export default {
    name: "ResumeList",
    components: { ResumeEducation },
    props: ["educations", "vkData"],
    methods: {
        addEduc() {
            let newEducation = structuredClone(EMPTY_EDUCATION_DATA);
            newEducation.index = this.educations.length > 0 ? this.educations[this.educations.length - 1].index + 1 : 0;
            this.educations.push(newEducation);
        },
        removeEduc(educationIndex) {
            this.educations.splice(this.educations.findIndex((education) => education.index === educationIndex), 1)
        }
    }
}
</script>

<template>
    <div class="bd-example">
        <hr>
        <div v-for="education in educations" v-bind:key="education.index">
            <ResumeEducation v-bind:educationData="education" v-bind:vkData="vkData" v-on:remove="removeEduc" />
            <hr>
        </div>
        <label for="new-todo" class="form-label"></label>
        <button v-on:click="addEduc" class="btn btn-primary" style="margin: 1em; width: 300px">Добавить образование</button>
        <hr>
    </div>
</template>