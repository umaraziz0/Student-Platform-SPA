<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center">Assignments List</h2>
                <hr />
                <br />
                <data-table
                    :data="data"
                    :columns="columns"
                    @onTablePropsChanged="reloadTable"
                >
                    <div slot="filters" slot-scope="{ tableData, perPage }">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <select
                                    class="form-control custom-select"
                                    v-model="tableData.length"
                                >
                                    <option
                                        :key="page"
                                        v-for="page in perPage"
                                        >{{ page }}</option
                                    >
                                </select>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="list-inline-item">
                                    <button
                                        type="button"
                                        class="btn btn-block btn-success"
                                        v-on:click="createModal()"
                                    >
                                        <i class="fas fa-plus"> </i> Add
                                        Assignment
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input
                                    name="name"
                                    class="form-control"
                                    v-model="tableData.search"
                                    placeholder="Search Table"
                                />
                            </div>
                        </div>
                    </div>
                </data-table>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="newModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="newModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{
                                editMode
                                    ? "Edit Assignment"
                                    : "Create New Assignment"
                            }}
                        </h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form
                        @submit.prevent="
                            editMode ? editAssignment() : createAssignment()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputName">Name:</label>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
                                    id="inputName"
                                    placeholder=""
                                    field="name"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputCourseName"
                                    >Course Name:</label
                                >
                                <select
                                    name="course_name"
                                    id="inputCourseName"
                                    class="form-control custom-select"
                                    v-model="form.course_id"
                                    field="course_name"
                                >
                                    <option
                                        v-for="course in courses"
                                        :key="course.course_id"
                                        :value="course.course_id"
                                        >{{
                                            course.course_name | toString
                                        }}</option
                                    >
                                </select>
                                <has-error
                                    :form="form"
                                    field="course_name"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputDueDate">Due Date:</label>
                                <input
                                    type="date"
                                    v-model="form.due_date"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'due_date'
                                        )
                                    }"
                                    id="inputDueDate"
                                    name="due_date"
                                />
                                <has-error
                                    :form="form"
                                    field="due_date"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputDetails">Details:</label>
                                <textarea
                                    v-model="form.details"
                                    name="details"
                                    id="inputDetails"
                                    placeholder=""
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('details')
                                    }"
                                ></textarea>
                                <has-error
                                    :form="form"
                                    field="details"
                                ></has-error>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn"
                                :class="{
                                    'btn-success': !editMode,
                                    'btn-primary': editMode
                                }"
                            >
                                {{ editMode ? "Update" : "Create" }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal End -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: false,
            url: "/api/assignment/",
            data: {},
            courseName: "",
            courses: {},
            tableProps: {
                search: "",
                length: 10,
                column: "due_date",
                dir: "asc"
            },
            form: new Form({
                id: "",
                student_id: "",
                name: "",
                course_id: "",
                due_date: "",
                details: ""
            }),
            columns: [
                {
                    label: "Name",
                    name: "name",
                    columnName: "name",
                    orderable: true
                },
                {
                    label: "Course Name",
                    name: "course_name",
                    columnName: "course_name",
                    orderable: true
                },
                {
                    label: "Due Date",
                    name: "due_date",
                    columnName: "due_date",
                    orderable: true
                },
                {
                    label: "Details",
                    name: "details",
                    columnName: "details",
                    orderable: true
                },
                {
                    label: "Edit",
                    name: "Edit",
                    orderable: false,
                    width: 1,
                    classes: {
                        btn: true,
                        "btn-primary": true,
                        "btn-sm": true
                    },
                    event: "click",
                    handler: this.editModal,
                    component: ButtonEdit
                },
                {
                    label: "Complete",
                    name: "Complete",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-danger": true
                    },
                    event: "click",
                    handler: this.deleteAssignment,
                    component: ButtonCheck
                }
            ]
        };
    },
    created() {
        this.getData(this.url);
        this.getCourses();
    },

    components: {
        ButtonEdit,
        ButtonCheck
    },

    methods: {
        getData(url = this.url, options = this.tableProps) {
            axios
                .get(url, {
                    params: options
                })
                .then(response => {
                    this.data = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        getCourses() {
            axios
                .get("/api/takenCourses/")
                .then(response => {
                    this.courses = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },

        displayRow(data) {
            alert(`You clicked assignment ${data.id}`);
        },

        createModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
        },

        createAssignment() {
            this.$Progress.start();
            this.form
                .post(this.url)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Assignment created."
                    });
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(errors => {
                    this.$Progress.fail();
                    console.log(errors);
                });
        },

        editModal(data) {
            this.editMode = true;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
            this.form.fill(data);
        },

        editAssignment() {
            this.$Progress.start();
            this.form
                .put(this.url + this.form.id)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Assignment updated."
                    });
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        deleteAssignment(data) {
            this.form
                .delete(this.url + `${data.id}`)
                .then(() => {
                    this.$Progress.start();
                    Swal.fire("Completed!", "Assignment completed.", "success");
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(errors => {
                    this.$Progress.fail();
                    Swal.fire({
                        icon: "error",
                        title: "An error occurred.",
                        text: `${errors}`
                    });
                });
        }
    }
};
</script>
