<script>

const validationMethods = {
    firstName: value => {
        const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
        return regex.test(value);
    },
    lastName: value => {
        const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
        return regex.test(value);
    },
    patronymic: value => {
        if (value.length === 0) return true;
        const regex = /^[А-ЯA-Zа-яa-z\s-ё]*$/;
        return regex.test(value);
    },
    email: value => {
        if (value.length === 0) return false;
        const regex = /^((([\dA-Za-z]{1}[-\dA-z.]+[\dA-Za-z])|([\dА-Яа-я][-\dА-я.]+[\dА-Яа-я]{1}))@([-A-Za-z]+){1,2}\.[-A-Za-z]{2,7})$/;
        return regex.test(value);
    },
    phone: value => {
        if (value.length === 0) return false;
        const regex = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
        return regex.test(value);
    },
  profession: value => value.length !== 0,
  birthdate: value => value.length !== 0,
  imagePreview: value => {
    if (value.length === 0) return true;
    const regex = /(\b(https?):\/\/)?[-A-Za-z\d+&@#/%?=~_|!:,.;]+[-A-Za-z\d+&@#/%=~_|](\.(jpe?g|png))/;
    return regex.test(value);
  },
}

export default {
    name: "ResumeInput",
    props: ["modelValue", "fieldName", "label", "errorMessage", "fieldType"],
    emits: ["update:modelValue", "afterValidate"],
    data() {
        return {
            isValid: false,
        }
    },
    watch: {
        modelValue(newValue, oldValue) {
            let method = validationMethods[this.fieldName];
            this.isValid = (!method || method(newValue));
        }
    },
    computed: {
        fieldValue: {
            get() {
                return this.modelValue;
            },
            set(newValue) {
                this.$emit("update:modelValue", newValue);

                let method = validationMethods[this.fieldName];
                this.isValid = (!method || method(newValue));
                this.$emit("afterValidate", this.fieldName, newValue, this.isValid);
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
