<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center">Courses Taught</h2>
                <hr />
                <data-table
                    :data="coursesTaught"
                    :columns="columnsTaught"
                    @onTablePropsChanged="reloadTable"
                    ><div slot="filters" slot-scope="{ tableData, perPage }">
                        <div class="row mb-2">
                            <div class="col-md-2">
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
                            <div class="col-md-2"></div>
                            <div class="col-md-4 text-center">
                                <div class="list-inline-item">
                                    <button
                                        type="button"
                                        class="btn btn-block btn-success"
                                        v-on:click="createModal()"
                                    >
                                        <i class="fas fa-plus"> </i> Add New
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
            <div class="col-md-10">
                <h2 class="text-center">Courses List</h2>
                <hr />
                <data-table
                    :data="courses"
                    :columns="columns"
                    @onTablePropsChanged="reloadTable"
                    ><div slot="filters" slot-scope="{ tableData, perPage }">
                        <div class="row mb-2">
                            <div class="col-md-2">
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
                            <div class="col-md-6 text-center"></div>
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
                            {{ editMode ? "Edit" : "Create New" }}
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
                            editMode ? editCourse() : createCourse()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputCourseID">Course ID:</label>
                                <input
                                    type="number"
                                    v-model="form.course_id"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'course_id'
                                        )
                                    }"
                                    id="inputCourseID"
                                    placeholder="Course ID"
                                    field="course_id"
                                />
                                <has-error
                                    :form="form"
                                    field="course_id"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputTeacherID">Teacher ID:</label>
                                <input
                                    type="number"
                                    v-model="form.teacher_id"
                                    name="teacher_id"
                                    id="inputTeacherID"
                                    placeholder=""
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'teacher_id'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="teacher_id"
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
            url: "/api/course/",
            urlTaught: "/api/taughtCourse/",
            courses: {},
            coursesTaught: {},
            tableProps: {
                search: "",
                length: 10,
                column: "course_id",
                dir: "asc"
            },
            form: new Form({
                id: "",
                course_id: "",
                teacher_id: ""
            }),
            columns: [
                {
                    label: "Course ID",
                    name: "course_id",
                    columnName: "course_id",
                    orderable: true
                },
                {
                    label: "Name",
                    name: "course_name",
                    columnName: "course_name",
                    orderable: true
                },
                {
                    label: "Credits",
                    name: "credits",
                    columnName: "credits",
                    orderable: true
                }
            ],
            columnsTaught: [
                {
                    label: "Course ID",
                    name: "course_id",
                    columnName: "course_id",
                    orderable: true
                },
                {
                    label: "Name",
                    name: "course_name",
                    columnName: "course_name",
                    orderable: true
                },
                {
                    label: "Credits",
                    name: "credits",
                    columnName: "credits",
                    orderable: true
                },
                {
                    label: "Teacher ID",
                    name: "teacher_id",
                    columnName: "teacher_id",
                    orderable: true
                },
                {
                    label: "Teacher",
                    name: "teacher_name",
                    columnName: "teacher_name",
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
                    label: "Delete",
                    name: "Delete",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-primary": true,
                        "btn-sm": true
                    },
                    event: "click",
                    handler: this.deleteCourse,
                    component: ButtonDelete
                }
            ]
        };
    },
    created() {
        this.getCourses(this.url);
        this.getCoursesTaught(this.urlTaught);
    },

    components: {
        ButtonEdit,
        ButtonDelete
    },

    methods: {
        getCourses(url = this.url, options = this.tableProps) {
            axios
                .get(url, {
                    params: options
                })
                .then(response => {
                    this.courses = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        getCoursesTaught(
            urlTaught = this.urlTaught,
            options = this.tableProps
        ) {
            axios
                .get(urlTaught, {
                    params: options
                })
                .then(response => {
                    this.coursesTaught = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        reloadTable(tableProps) {
            this.getCourses(this.url, tableProps);
            this.getCoursesTaught(this.urlTaught, tableProps);
        },

        createModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
        },

        createCourse() {
            this.$Progress.start();
            this.form
                .post(this.urlTaught)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Course created."
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

        editCourse() {
            this.$Progress.start();
            this.form
                .put(this.urlTaught + this.form.id)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Update success"
                    });
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        takeCourse(data) {
            this.form.fill(data);
            this.form
                .post(this.urlTaught)
                .then(() => {
                    this.$Progress.start();
                    Swal.fire({
                        icon: "success",
                        title: "Course taken."
                    });
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(errors => {
                    this.$Progress.fail();
                    Swal.fire({
                        icon: "error",
                        title: "An error occurred.",
                        text: "Course has already been taken."
                    });
                    console.log(errors);
                });
        },

        deleteCourse(coursesTaught) {
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.value) {
                    this.form
                        .delete(this.urlTaught + `${coursesTaught.id}`)
                        .then(() => {
                            this.$Progress.start();
                            Swal.fire("Deleted!", "Course deleted.", "success");
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
            });
        }
    }
};
</script>
