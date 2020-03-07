<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title text-center">
                            <i class="fas fa-edit mr-1"></i>
                            To-Do List
                        </h3>

                        <!-- <div class="card-tools">
                            <ul class="pagination pagination-sm">
                                <li class="page-item">
                                    <a href="#" class="page-link">«</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">1</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">3</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">»</a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="New Todo"
                                v-model="newTodo"
                            />
                            <div class="input-group-append" @click="addTodo">
                                <span
                                    class="input-group-text"
                                    style="cursor: pointer;"
                                >
                                    <i
                                        class="fa fa-plus"
                                        aria-hidden="true"
                                    ></i>
                                </span>
                            </div>
                        </div>
                        <!-- <ul
                            class="todo-list ui-sortable"
                            data-widget="todo-list"
                        >
                        </ul> -->
                        <ul
                            class="todo-list ui-sortable"
                            data-widget="todo-list"
                            v-for="(todo, index) in todos"
                            :key="todo.id"
                        >
                            <li class="" v-bind:class="{done:todo.isCompleted}">
                                <!-- drag handle -->
                                <span class="handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </span>
                                <!-- checkbox -->
                                <div class="icheck-primary d-inline ml-2">
                                    <input
                                        type="checkbox"
                                        v-model="todo.isCompleted"
                                        name="todo1"
                                        id="todoCheck1"
                                        value=""
                                        checked = ""
                                    />
                                    <label for="todoCheck1"></label>
                                </div>
                                <!-- todo text -->
                                <span class="text">{{ todo.title }}</span>
                                <!-- Emphasis label -->
                                <small class="badge badge-danger"
                                    ><i class="far fa-clock"></i> 2 mins</small
                                >
                                <!-- General tools such as edit or delete-->
                                <div class="tools">
                                    <i class="fas fa-edit" @click="editTodo(index)"></i>
                                    <i class="fas fa-trash" @click="removeTodo(index)"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->


                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "todo-list",
    data() {
        return {
            newTodo: "",
            idForTodo: 3,
            todos: [
                {
                    id: 1,
                    title: "finish todo list",
                    isCompleted: false
                },
                {
                    id: 2,
                    title: "finish thesis",
                    isCompleted: false
                }
            ]
        };
    },

    created() {
        //
    },

    methods: {
        addTodo() {
            if (this.newTodo.trim() == 0) {
                return;
            }

            this.todos.push({
                id: this.idForTodo,
                title: this.newTodo,
                isCompleted: false
            });
            (this.newTodo = ""), this.idForTodo++;
        },

        editTodo(index){
            //
        },

        removeTodo(index){
            this.todos.splice(index, 1);
        }
    }
};
</script>
