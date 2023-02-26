<script>
//import ResumeSelect from './ResumeSelect.vue'
// import ResumeListItem from './ResumeListItem.vue'
import ResumeEducation from './ResumeEducation.vue'

const EMPTY_EDUCATION_DATA = { index: 0, type: '', institute: '', faculty: '', specialization: '', endYear: '', isComplex: '' }

export default {
    name: "ResumeList",
    components: { ResumeEducation },
    props: ["educations"],
    data() {
        return {
            // newTodoText: '',
            // todos: [
            //     {
            //         id: 1,
            //         title: 'Помыть посуду'
            //     },
            //     {
            //         id: 2,
            //         title: 'Вынести мусор'
            //     },
            //     {
            //         id: 3,
            //         title: 'Подстричь газон'
            //     }
            // ],
        }
    },
    methods: {
        // addNewTodo: function () {
        //     this.todos.push({
        //         id: this.nextTodoId++,
        //         title: this.newTodoText
        //     })
        //     this.newTodoText = ''
        // },
        addEduc() {
            let newEducation = structuredClone(EMPTY_EDUCATION_DATA);
            newEducation.index = this.educations[this.educations.length - 1].index + 1;
            this.educations.push(newEducation);
            // this.todos.push({
            //     id: this.nextTodoId++,
            //     title: this.newTodoText
            // })
            // this.newTodoText = ''
        },
        removeEduc(educationIndex) {
            this.educations.splice(this.educations.findIndex((education) => education.index === educationIndex), 1)
        }
    }
}
</script>

<template>
    <!-- <div id="todo-list-example">
                    <form v-on:submit.prevent="addNewTodo">
                        <label for="new-todo">Добавить задачу</label>
                        <input v-model="newTodoText" id="new-todo" placeholder="Например, покормить кота">
                        <button>Добавить</button>
                    </form>
                    <ul>
                        <ResumeListItem is="todo-item" v-for="(todo, index) in todos" v-bind:key="todo.id" v-bind:title="todo.title"
                            v-on:remove="todos.splice(index, 1)"> {{ todo.title }}
                        </ResumeListItem>
                    </ul> 
                </div>-->

    <div class="bd-example">
        <label for="new-todo">Добавить образование</label>
        <!-- <input v-model="newTodoText" id="new-todo" placeholder="Например, покормить кота"> -->
        <button v-on:click="addEduc">Добавить</button>
        <hr>
        
        <div v-for="education in educations" v-bind:key="education.index">
            <ResumeEducation v-bind:educationData="education" v-on:remove="removeEduc" />
            <hr>
        </div>
    </div>
    <!-- <ResumeListItem /> -->
</template>