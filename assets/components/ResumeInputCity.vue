<script>
import {vkApi} from "../controllers/VkApiController.js";

export default {
    name: "ResumeInputCity",
    props: ["label", "fieldName", "type", "help", "vkData", "modelValue"],
    emits: ["update:modelValue", 'afterValidate'],
    data() {
        return {}
    },
    mounted() {
        this.queryRussiaCountryId();
    },
    computed: {
        inputValue: {
            get() {
                return this.modelValue;
            },
            set(newValue) {
                this.$emit("update:modelValue", newValue);
                this.queryCities(newValue);
                this.$emit("afterValidate", this.fieldName, newValue, true);
            }
        }
    },
    methods: {
        queryCities(query) {
            this.queryRussiaCountryId();
            vkApi
                .get(vkApi.methods.database.getCities, {
                    country_id: this.vkData.russiaId,
                    q: query.substr(0, 15),
                    need_all: 1,
                    count: 10
                }, (function (err, data) {
                    this.vkData.cities = data.response.items;
                }).bind(this));
        },
        queryRussiaCountryId() { // получение кода страны - конкретно для РФ
            if (this.vkData.russiaId !== undefined) {
                return;
            }
            vkApi
                .get(vkApi.methods.database.getCountries, {
                    code: "RU",
                    count: 1
                }, (function (err, data) {
                    this.vkData.russiaId = data.response.items[0].id;
                }).bind(this));
        },
        formatCityData(city) { // мапит данные для аккуратного вывода информации о каждом городе 
            let s = city.title;
            let additionalData = [];
            if (city.area) {
                additionalData.push(city.area);
            }
            if (city.region) {
                additionalData.push(city.region);
            }
            if (additionalData.length > 0) {
                s += " (" + additionalData.join(", ") + ")";
            }
            return s;
        },
        selectCity(cityId) {
            let city = this.vkData.cities.find((city) => city.id === cityId);
            this.value = city.title;
            this.vkData.selectedCity = city;
            this.vkData.cities = [];
            this.$emit("update:modelValue", city.title);
            this.$emit("afterValidate", this.fieldName, city.title, true);
        }
    }
}
</script>

<template>
    <div class="mb-3">
        <label class="mb-2">{{ label }}</label>
        <div class="field">
            <input v-bind:type="type" v-model="inputValue" class="form-control"
                   style="width: 350px; margin-left:85px;">
            <div v-if="help" class="form-text mt-2">{{ help }}</div>
            <ul v-show="vkData.cities.length > 0" class="field__helpers list-group">
                <li v-for="city in vkData.cities" :key="city.id" @click="selectCity(city.id)"
                    class="list-group-item list-group-item-action">
                    {{ formatCityData(city) }}
                </li>
            </ul>
        </div>
    </div>
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