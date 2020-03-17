<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center">Grades List</h2>
                <hr />
                <br />
                <data-table
                    :data="data"
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
                            <div class="col-md-4 text-center">
                                <div class="list-inline-item">
                                    <button
                                        type="button"
                                        class="btn btn-block btn-success"
                                        v-on:click="createModal()"
                                    >
                                        <i class="fas fa-plus"> </i> Add Grade
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
                            {{ editMode ? "Edit Grade" : "Create New Grade" }}
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
                        @submit.prevent="editMode ? editGrade() : createGrade()"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputStudentID">Student ID:</label>
                                <input
                                    type="number"
                                    v-model="form.student_id"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'student_id'
                                        )
                                    }"
                                    id="inputStudentID"
                                    field="student_id"
                                />
                                <has-error
                                    :form="form"
                                    field="student_id"
                                ></has-error>
                            </div>
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
                                    field="course_id"
                                />
                                <has-error
                                    :form="form"
                                    field="course_id"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="inputGrade">Grade:</label>
                                <input
                                    type="text"
                                    v-model="form.grade"
                                    name="grade"
                                    id="inputGrade"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('grade')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="grade"
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
            url: "/api/grade/",
            data: {},
            tableProps: {
                search: "",
                length: 10,
                column: "id",
                dir: "asc"
            },
            form: new Form({
                id: "",
                student_id: "",
                course_id: "",
                grade: ""
            }),
            columns: [
                {
                    label: "Grade ID",
                    name: "id",
                    columnName: "grades.id",
                    orderable: true
                },
                {
                    label: "Student ID",
                    name: "student_id",
                    columnName: "student_id",
                    orderable: true
                },
                {
                    label: "Student Name",
                    name: "name",
                    columnName: "name",
                    orderable: true
                },
                {
                    label: "Course ID",
                    name: "course_id",
                    columnName: "course_id",
                    orderable: true
                },
                {
                    label: "Course Name",
                    name: "course_name",
                    columnName: "course_name",
                    orderable: true
                },
                {
                    label: "Grade",
                    name: "grade",
                    columnName: "grade",
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
                    handler: this.deleteGrade,
                    component: ButtonDelete
                }
            ]
        };
    },
    created() {
        this.getData(this.url);
    },

    components: {
        ButtonEdit,
        ButtonDelete
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

        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
        },

        createModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
        },

        createGrade() {
            this.$Progress.start();
            this.form
                .post(this.url)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Grade added!"
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

        editGrade() {
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

        deleteGrade(data) {
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
                        .delete(this.url + `${data.id}`)
                        .then(() => {
                            this.$Progress.start();
                            Swal.fire("Deleted!", "Grade deleted.", "success");
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
