<script>

const validationMethods = {
    firstName: function (value) {
        const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
        return regex.test(value);
    },
    lastName: function (value) {
        const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
        return regex.test(value);
    },
    patr: function (value) {
        const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
        return regex.test(value);
    },
    email: function (value) {
        if (value.length == 0) return true;
        const regex = RegExp("^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}){1,2}\.[-A-Za-z]{2,7})$");
        return regex.test(value);
    },
    phone: function (value) {
        if (value.length == 0) return true;
        const regex = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
        return regex.test(value);
    }
}

export default {
    name: "ResumeInput",
    props: ["fieldName", "label", "errorMessage", "fieldType"],
    emits: ['isValidEvent', 'isInvalidEvent'],
    data() {
        return {
            value: "",
            isValid: false,
        }
    },
    computed: {
        fieldValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.value = newValue;
                
                let method = validationMethods[this.fieldName]; 

                this.isValid = (!method || (method && method(newValue)));

                if (this.isValid) {
                    this.$emit('isValidEvent', this.value);
                } else {
                    this.$emit('isInvalidEvent', this.fieldName);
                }
            }
        }
    }
}

</script>

<template>
    <div class="col-md-6">
        <label class="form-label">{{label}}</label>
        <input v-bind:type="fieldType" class="form-control" v-model="fieldValue">
        <div v-if="!isValid">
            <label class="form-check-label error">
                {{ errorMessage }}
            </label>
        </div>
    </div>
</template>

<style>
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
