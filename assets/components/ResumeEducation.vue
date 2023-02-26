<script>
import ResumeSelect from './ResumeSelect.vue'
import ResumeInput from './ResumeInput.vue'

export default {
    name: "ResumeEducation",
    components: { ResumeSelect, ResumeInput },
    props: ["educationData"],
    emits: ["remove"],

    data() {
        return {
            educationTypes: {
                level0: 'Среднее',
                level1: 'Среднее специальное',
                level2: 'Неоконченное высшее',
                level3: 'Высшее',
            }
        }
    },
    computed: {
        isComplexEduc: {   // Проверка выбранного образования
            get() {
                return this.educationData.isComplex = this.educationData.type === this.educationTypes.level1 ||
                    this.educationData.type === this.educationTypes.level2 ||
                    this.educationData.type === this.educationTypes.level3;
            },
            set(newValue) {
                this.value = newValue;
                this.$emit('changed', newValue);
            }
        }
    },
    methods: {
        resetField(field) {
            this.values[field] = '';
        }
    }
}
</script>

<template>
    <div class="row">
        <ResumeSelect isSelectFirst='false' label="Образование" v-bind:values="educationTypes"
            v-on:changed="(value) => educationData.type = this.educationTypes[value]" />
        <div class="bd-example">
            <!-- <hr> -->
            <br/>
        </div>
        <div class="row" v-if="isComplexEduc">
            <!-- <br> -->
            <ResumeInput fieldType="text" fieldName="institute" label="Учебное учреждение"
                v-on:isValidEvent="(value) => educationData.institute = value" v-on:isInvalidEvent="resetField" />

            <ResumeInput fieldType="text" fieldName="faculty" label="Факультет"
                v-on:isValidEvent="(value) => educationData.faculty = value" v-on:isInvalidEvent="resetField" />

            <ResumeInput fieldType="number" fieldName="endYear" label="Год окончания"
                v-on:isValidEvent="(value) => educationData.endYear = value" v-on:isInvalidEvent="resetField" />

            <ResumeInput fieldType="text" fieldName="specialization" label="Специализация"
                v-on:isValidEvent="(value) => educationData.specialization = value" v-on:isInvalidEvent="resetField" />
        </div>
        <div></div>
        <button class="btn btn-primary" style="margin: 1em; width: 150px" v-on:click="$emit('remove', educationData.index)">
            Удалить </button>
    </div>
</template>
