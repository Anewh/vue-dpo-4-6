import { createApp } from 'vue'
import App from './App.vue';
import './main.scss';
import {createRouter, createWebHistory} from "vue-router/dist/vue-router";
import ResumeStatusLists from "./components/ResumeStatusLists";
import BaseResume from "./components/BaseResume";
import NotFound from "./components/NotFound";

const routes = [
    {path: '/', name: 'resumeStatusLists', component: ResumeStatusLists},
    {path: '/add', name: 'resumeAdd', component: BaseResume},
    {path: '/edit/:id', name: 'resumeEdit', component: BaseResume},
    {path: '/:path(.*)*', name: 'notFound', component: NotFound},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App)
    .use(router)
    .mount('#app')