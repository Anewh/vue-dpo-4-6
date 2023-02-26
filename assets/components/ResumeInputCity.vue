<script>
import { vkApi } from "../controllers/VkApiController.js";
export default {
    name: "ResumeInputCity",
    props: ['name', 'label', 'type', 'help', 'vkData'],
    emits: ['city-selected', 'validated', 'isInvalidEvent'],
    data() {
        return {
            hasChanged: false,
            value: ''
        }
    },
    mounted() {
        this.queryRussiaCountryId();
    },
    computed: {
        inputValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.value = newValue;
                this.hasChanged = true;
                this.queryCities(newValue);
                this.$emit('validated', this.name, newValue);
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
        queryRussiaCountryId() {
            if (this.vkData.russiaId !== undefined) {
                return;
            }
            vkApi
                .get(vkApi.methods.database.getCountries, {
                    code: 'RU',
                    count: 1
                }, (function (err, data) {
                    this.vkData.russiaId = data.response.items[0].id;
                }).bind(this));
        },
        formatCityData(city) {
            let s = city.title;
            let additionalData = [];
            if (city.area) {
                additionalData.push(city.area);
            }
            if (city.region) {
                additionalData.push(city.region);
            }
            if (additionalData.length > 0) {
                s += ' (' + additionalData.join(', ') + ')';
            }
            return s;
        },
        selectCity(cityId) {
            let city = this.vkData.cities.find((city) => city.id === cityId);
            this.value = city.title;
            this.vkData.cities = [];
            this.vkData.selectedCity = city;
            this.$emit('city-selected', city);
            this.$emit('validated', this.name, city.title);
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