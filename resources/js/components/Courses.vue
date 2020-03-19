<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center">Courses Taken</h2>
                <hr />
                <data-table
                    :data="coursesTaken"
                    :columns="columnsTaken"
                    @onTablePropsChanged="reloadTable"
                    ><div slot="filters" slot-scope="{ tableData, perPage }">
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
                            <div class="col-md-4 text-center"></div>
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
                            <div class="col-md-4 text-center"></div>
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
                            {{ editMode ? "Edit Course" : "Create New Course" }}
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
                                <label for="inputCourseName"
                                    >Course Name:</label
                                >
                                <input
                                    type="text"
                                    v-model="form.course_name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'course_name'
                                        )
                                    }"
                                    id="inputCourseName"
                                    placeholder="Course Name"
                                    field="course_name"
                                />
                                <has-error
                                    :form="form"
                                    field="course_name"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputCredits">Credits</label>
                                <input
                                    type="number"
                                    v-model="form.credits"
                                    class="custom-select"
                                    :class="{
                                        'is-invalid': form.errors.has('credits')
                                    }"
                                    id="inputCredits"
                                    name="credits"
                                />
                                <has-error
                                    :form="form"
                                    field="credits"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputTeacher">Teacher:</label>
                                <input
                                    type="text"
                                    v-model="form.teacher"
                                    name="teacher"
                                    id="inputTeacher"
                                    placeholder=""
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('teacher')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="teacher"
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
            urlTaken: "/api/takencourse/",
            courses: {},
            coursesTaken: {},
            tableProps: {
                search: "",
                length: 10,
                column: "course_id",
                dir: "asc"
            },
            form: new Form({
                id: "",
                course_id: "",
                course_name: "",
                credits: "",
                teacher: ""
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
                },
                {
                    label: "Teacher",
                    name: "teacher",
                    columnName: "teacher",
                    orderable: true
                },
                {
                    label: "Take Course",
                    name: "take_course",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-primary": true,
                        "btn-sm": true
                    },
                    event: "click",
                    handler: this.takeCourse,
                    component: ButtonCheck
                }
            ],
            columnsTaken: [
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
                    label: "Teacher",
                    name: "teacher",
                    columnName: "teacher",
                    orderable: true
                },
                {
                    label: "Delete",
                    name: "delete",
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
        this.getCoursesTaken(this.urlTaken);
    },

    components: {
        ButtonCheck,
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

        getCoursesTaken(urlTaken = this.urlTaken, options = this.tableProps) {
            axios
                .get(urlTaken, {
                    params: options
                })
                .then(response => {
                    this.coursesTaken = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        reloadTable(tableProps) {
            this.getCourses(this.url, tableProps);
            this.getCoursesTaken(this.urlTaken, tableProps);
        },

        displayRow(data) {
            alert(`You clicked course ${data.id}`);
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
                .post(this.url)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Course created successfully"
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
                .put(this.url + this.form.id)
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
                .post(this.urlTaken)
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

        deleteCourse(coursesTaken) {
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
                        .delete(this.urlTaken + `${coursesTaken.id}`)
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
