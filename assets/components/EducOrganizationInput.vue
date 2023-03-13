<script>
import { vkApi } from "../controllers/VkApiController.js";

// компонент для выбора образовательного учреждения из списка из API vk
export default {
    name: "EducOrganizationInput",
    props: ["modelValue", "fieldName", "vkData"],
    emits: ["update:modelValue", "afterValidate"],
    data() {
        return {
        }
    },
    computed: {
        inputValue: {
            get() {
                return this.modelValue;
            },
            set(newValue) {
                this.$emit("update:modelValue", newValue);

                if (this.vkData.selectedCity) {
                    this.queryUniversities(newValue);
                }
                this.$emit("afterValidate", this.fieldName, newValue, true);
            }
        }
    },
    methods: {
        queryUniversities(query) {
            vkApi
                .get(vkApi.methods.database.getUniversities, {
                    country_id: this.vkData.russiaId,
                    city_id: this.vkData.selectedCity.id,
                    q: query,
                    count: 10
                }, (function (_, data) {
                    this.vkData.universities = data.response.items;
                }).bind(this));
        },

        selectUniversity(cityId) {
            let university = this.vkData.universities.find((city) => city.id === cityId);

            this.vkData.universities = [];
            this.$emit("update:modelValue", university.title);
            this.$emit("afterValidate", this.fieldName, university.title, true);
        },
    }
}
</script>

<template>
    <!-- <div class="mb-3"> -->
        <label class="mb-2">Учебное учреждение</label>
        <div class="field">
            <input type="text" v-model="inputValue" class="form-control">
            <!-- style="width: 350px; margin-left:85px;" -->
            <ul v-show="vkData.universities.length > 0" class="field__helpers list-group">
                <li v-for="university in vkData.universities" :key="university.id"
                    v-on:click="selectUniversity(university.id)" class="list-group-item list-group-item-action">
                    {{ university.title }}
                </li>
            </ul>
        </div>
    <!-- </div> -->
</template>

<style scoped>
.field {
    position: relative;
    z-index: 99;
}

.field__helpers {
    position: absolute;
    z-index: 100;
    top: 20px;
    left: 0;
}
</style>