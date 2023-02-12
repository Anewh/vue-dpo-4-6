<script>
export default {
    name: "ResumeSelect",
    props: ["label", "values"],
    emits: ["changed"],
    data() {
        return {
            value: ""
        }
    },
    computed: {
        selectedValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.value = newValue;
                this.$emit('changed', newValue);
            }
        }
    },
}
</script>

<template>
    <div class="col-md-6">
        <label class="form-label">{{ label }}</label>
        <select v-model="selectedValue" class="form-select">
            <option v-for="(value, key) in values" v-bind:value="key">{{ value }}</option>
        </select>
    </div>
</template>

<style>
</style>