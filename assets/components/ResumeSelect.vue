<script>
export default {
    name: "ResumeSelect",
    props: ["label", "fieldName", "values", "modelValue"],
    emits: ["update:modelValue"],
    data() {
        return {
        }
    },
    computed: {
        selectedValue: {
            get() {
                return this.modelValue;
            },
            set(newValue) {
                this.$emit("update:modelValue", newValue);
            }
        }
    },
}
</script>

<template>
    <div class="col-md-6">
        <label class="form-label">{{ label }}</label>
            <select v-model="selectedValue" class="form-select md-5">
            <option v-for="(value, key) in values" v-bind:value="key">{{ value }}</option>
        </select>
    </div>
</template>
