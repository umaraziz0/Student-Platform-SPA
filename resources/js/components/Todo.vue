<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-edit"></i>
                            To-Do List
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="New Todo"
                                v-model="newTodo"
                                @keyup.enter="addTodo()"
                            />
                            <div class="input-group-append" @click="addTodo()">
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
                        <transition-group
                            name="fade"
                            enter-active-class="animated fadeInDown"
                            leave-active-class="animated fadeOutRight"
                        >
                            <ul
                                class="todo-list ui-sortable"
                                style="animation-duration: 0.5s"
                                data-widget="todo-list"
                                v-for="todo in todosFiltered"
                                :key="todo.id"
                            >
                                <li
                                    class="form-check"
                                    :class="{ done: todo.isCompleted }"
                                >
                                    <!-- drag handle -->
                                    <span class="handle ui-sortable-handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <!-- checkbox -->
                                    <div class="d-inline ml-4">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            v-model="todo.isCompleted"
                                            name="todo1"
                                            id="todoCheck"
                                            @change="checkTodo(todo)"
                                        />
                                        <label for="todoCheck" class=""></label>

                                        <!-- todo text -->
                                        <span class="text">
                                            <div
                                                v-if="!todo.editing"
                                                class="form-check-label"
                                                @dblclick="editTodo(todo)"
                                            >
                                                {{ todo.title }}
                                            </div>
                                            <input
                                                v-if="todo.editing"
                                                type="text"
                                                v-model="todo.title"
                                                @blur="cancelEdit(todo)"
                                                @keyup.enter="doneEdit(todo)"
                                                @keyup.escape="cancelEdit(todo)"
                                                v-focus
                                            />
                                        </span>
                                        <!-- Emphasis label -->
                                        <!-- <small class="badge badge-danger"
                                            ><i class="far fa-clock"></i> 2
                                            mins</small
                                        > -->
                                        <!-- General tools such as edit or delete-->
                                        <div class="tools">
                                            <i
                                                class="fas fa-edit"
                                                @click="editTodo(todo)"
                                            ></i>
                                            <i
                                                class="fas fa-trash"
                                                @click="removeTodo(todo.id)"
                                            ></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </transition-group>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="checkAll"
                                        id=""
                                        class="form-check-input"
                                        :checked="!anyRemaining"
                                        @click="checkAll()"
                                    />
                                    <label
                                        for="checkAll"
                                        class="form-check-label"
                                        >Check All</label
                                    >
                                </div>
                            </div>
                            <div class="col-sm-6 text-center">
                                <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary btn-sm"
                                        :class="{ active: filter == 'all' }"
                                        @click="filter = 'all'"
                                    >
                                        All
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary btn-sm"
                                        :class="{ active: filter == 'active' }"
                                        @click="filter = 'active'"
                                    >
                                        Active
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary btn-sm"
                                        :class="{
                                            active: filter == 'completed'
                                        }"
                                        @click="filter = 'completed'"
                                    >
                                        Completed
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-3 text-right">
                                {{ remaining }} items left.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center mt-2">
                                <button
                                    class="btn btn-success btn-sm"
                                    v-if="showClearCompletedButton"
                                    @click="clearCompleted"
                                >
                                    <i
                                        class="fa fa-check mr-1"
                                        aria-hidden="true"
                                    ></i
                                    >Clear Completed
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "todo-list",
    data() {
        return {
            todos: [],
            newTodo: "",
            url: "api/todo/",
            beforeEditCache: "",
            filter: "all",
            studentId: ""
        };
    },

    created() {
        this.getTodos();
        Fire.$on("refresh", () => {
            this.getTodos();
        });
    },

    computed: {
        remaining() {
            return this.todos.filter(todo => !todo.isCompleted).length;
        },

        anyRemaining() {
            return this.remaining != 0;
        },
        todosFiltered() {
            if (this.filter == "all") {
                return this.todos;
            } else if (this.filter == "active") {
                return this.todos.filter(todo => !todo.isCompleted);
            } else if (this.filter == "completed") {
                return this.todos.filter(todo => todo.isCompleted);
            } else {
                return this.todos;
            }
        },
        showClearCompletedButton() {
            return this.todos.filter(todo => todo.isCompleted).length > 0;
        }
    },

    directives: {
        focus: {
            // directive definition
            inserted: function(el) {
                el.focus();
            }
        }
    },

    methods: {
        log() {
            console.log("test");
        },
        getTodos(url = this.url) {
            axios
                .get(url)
                .then(response => {
                    this.todos = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },

        addTodo(url = this.url, newTodo = this.newTodo) {
            //check for empty string
            if (this.newTodo.trim().length == 0) {
                return;
            }

            axios
                .post(url, {
                    student_id: "",
                    title: newTodo,
                    isCompleted: false
                })
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });

            this.newTodo = "";
            Fire.$emit("refresh");
        },

        checkTodo(todo, url = this.url) {
            axios
                .put(url + todo.id, {
                    title: todo.title,
                    isCompleted: todo.isCompleted
                })
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });

            Fire.$emit("refresh");
        },

        checkAll(url = "api/todoCheckAll") {
            this.todos.forEach(todo => {
                todo.isCompleted = event.target.checked;
            });

            axios
                .put(url, {
                    isCompleted: !document.getElementById("todoCheck").checked
                })
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });
        },

        clearCompleted(todos, url = "api/todoClearCompleted") {
            const completed = this.todos
                .filter(todo => todo.isCompleted)
                .map(todo => todo.id);

            axios
                .delete(url, {
                    data: {
                        todos: completed
                    }
                })
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });

            Fire.$emit("refresh");
        },

        editTodo(todo) {
            this.beforeEditCache = todo.title;
            todo.editing = todo.editing ? false : true;
        },

        doneEdit(todo, url = this.url) {
            //check for empty string
            if (todo.title.trim() == "") {
                todo.title = this.beforeEditCache;
            }

            todo.editing = false;

            axios
                .put(url + todo.id, {
                    title: todo.title,
                    isCompleted: todo.isCompleted
                })
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });

            Fire.$emit("refresh");
        },

        cancelEdit(todo) {
            todo.editing = false;
            todo.title = this.beforeEditCache;
        },

        removeTodo(id, url = this.url) {
            axios
                .delete(url + id)
                .then(response => {
                    console.log(response);
                })
                .catch(errors => {
                    console.log(errors);
                });
            Fire.$emit("refresh");
        }
    }
};
</script>
