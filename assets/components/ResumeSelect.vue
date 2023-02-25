<script>
export default {
    name: "ResumeSelect",
    props: ["label", "values", 'isSelectFirst'],
    emits: ["changed"],
    data() {
        return {
            value: this.isSelectFirst=='true' ? Object.keys(this.values)[0] : ''//this.isSelectFirst == "true" ? Object.keys(this.values)[0] ?? ''
        }
    },
    computed: {
        selectedValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                //console.log(values["defaultValue"]);
                this.value = newValue;
                this.$emit('changed', newValue);
            }
        }
    },
}
</script>

<!-- 25.02.2023 пыталась добавить поле статус. Изменения в BaseResume и тут.
    Решила вынести в отдельный компонент - так будет удобнее данные обрабатывать в будущем -->

<template>
    <div class="col-md-6">
        <label class="form-label">{{ label }}</label>
        <select v-model="selectedValue" class="form-select">
            <!-- <option v-if="1" selected> {{ Новое }} </option> -->
            <option v-for="(value, key) in values" v-bind:value="key">{{ value }}</option>
        </select>
    </div>
</template>
