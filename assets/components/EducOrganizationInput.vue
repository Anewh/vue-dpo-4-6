<script>
import { vkApi } from "../controllers/VkApiController.js";
export default {
    name: "EducOrganizationInput",
    props: ['fieldName', 'vkData'],
    emits: ['isValidEvent', 'isInvalidEvent'],
    data() {
        return {
            value: ''
        }
    },
    computed: {
        inputValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.value = newValue;
                if (this.vkData.selectedCity) {
                    this.queryUniversities(this.value);
                }
                this.$emit('isValidEvent', this.fieldName, this.value);
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
            this.value = university.title;
            this.vkData.universities = [];
            this.$emit('isValidEvent', university.title);
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