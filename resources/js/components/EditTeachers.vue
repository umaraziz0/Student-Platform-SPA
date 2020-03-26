<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center">Teachers List</h2>
                <hr />
                <br />
                <data-table
                    :data="data"
                    :columns="columns"
                    @onTablePropsChanged="reloadTable"
                >
                    <div slot="filters" slot-scope="{ tableData, perPage }">
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
                                        <i class="fas fa-plus"> </i> Add Teacher
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{
                                editMode ? "Edit Teacher" : "Create New Teacher"
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
                            editMode ? editTeacher() : createTeacher()
                        "
                    >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-primary">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img
                                                    class="profile-user-img img-fluid
                                                img-circle"
                                                    :src="getPhoto()"
                                                    @error="defaultPhoto"
                                                />
                                            </div>

                                            <h3
                                                class="profile-username text-center"
                                            >
                                                {{
                                                    form.name
                                                        ? form.name
                                                        : "Name"
                                                }}
                                            </h3>

                                            <p class="text-muted text-center">
                                                {{
                                                    form.title
                                                        ? form.title
                                                        : "Title"
                                                }}
                                            </p>

                                            <ul
                                                class="list-group list-group-unbordered mb-3"
                                            >
                                                <li class="list-group-item">
                                                    <i
                                                        class="fa fa-hashtag"
                                                        aria-hidden="true"
                                                    ></i
                                                    >&nbsp;
                                                    <label for="inputTeacherID"
                                                        >Teacher ID:</label
                                                    >
                                                    <br />
                                                    <input
                                                        type="number"
                                                        v-model="
                                                            form.teacher_id
                                                        "
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid': form.errors.has(
                                                                'teacher_id'
                                                            )
                                                        }"
                                                        id="inputTeacherID"
                                                        field="teacher_id"
                                                    />
                                                    <has-error
                                                        :form="form"
                                                        field="teacher_id"
                                                    ></has-error>
                                                </li>
                                                <li class="list-group-item">
                                                    <i
                                                        class="fa fa-phone"
                                                        aria-hidden="true"
                                                    ></i
                                                    >&nbsp;
                                                    <label for="inputPhone"
                                                        >Phone:</label
                                                    >
                                                    <input
                                                        type="number"
                                                        v-model="form.phone"
                                                        class="custom-select"
                                                        :class="{
                                                            'is-invalid': form.errors.has(
                                                                'phone'
                                                            )
                                                        }"
                                                        id="inputPhone"
                                                        name="phone"
                                                    />
                                                    <has-error
                                                        :form="form"
                                                        field="phone"
                                                    ></has-error>
                                                </li>
                                                <li class="list-group-item">
                                                    <i
                                                        class="fa fa-envelope"
                                                        aria-hidden="true"
                                                    ></i
                                                    >&nbsp;
                                                    <label for="inputEmail"
                                                        >Email:</label
                                                    >
                                                    <input
                                                        type="email"
                                                        v-model="form.email"
                                                        name="email"
                                                        id="inputEmail"
                                                        placeholder=""
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid': form.errors.has(
                                                                'email'
                                                            )
                                                        }"
                                                    />
                                                    <has-error
                                                        :form="form"
                                                        field="email"
                                                    ></has-error>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <label for="inputName">Name:</label>
                                        <input
                                            type="text"
                                            v-model="form.name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'name'
                                                )
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
                                        <label for="inputTitle">Title:</label>
                                        <input
                                            type="text"
                                            v-model="form.title"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'title'
                                                )
                                            }"
                                            id="inputTitle"
                                            placeholder=""
                                            field="title"
                                        />
                                        <has-error
                                            :form="form"
                                            field="title"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputOfficeAddress"
                                            >Office Address:</label
                                        >
                                        <input
                                            type=""
                                            v-model="form.office_address"
                                            name="office_address"
                                            id="inputOfficeAddress"
                                            placeholder=""
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'office_address'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="office_address"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputOfficeHours"
                                            >Office Hours:</label
                                        >
                                        <input
                                            type="text"
                                            v-model="form.office_hours"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'office_hours'
                                                )
                                            }"
                                            id="inputOfficeHours"
                                            placeholder=""
                                            field="office_hours"
                                        />
                                        <has-error
                                            :form="form"
                                            field="office_hours"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPhoto"
                                            >Profile Picture:</label
                                        >

                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input
                                                    class="custom-file-input"
                                                    type="file"
                                                    @change="updatePhoto"
                                                    id="inputPhoto"
                                                    name="photo"
                                                />
                                                <label
                                                    class="custom-file-label"
                                                    for="inputPhoto"
                                                    >{{ getFileName() }}</label
                                                >
                                            </div>
                                            <div class="input-group-append">
                                                <span
                                                    class="input-group-text"
                                                    style="cursor:pointer"
                                                    @click.prevent="
                                                        removePhoto(form.id)
                                                    "
                                                    >Remove
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    </div>
    <!-- Modal End -->
</template>

<script>
export default {
    data() {
        return {
            fileName: "",
            editMode: false,
            url: "/api/teacher/",
            data: {},
            tableProps: {
                search: "",
                length: 10,
                column: "teacher_id",
                dir: "asc"
            },
            form: new Form({
                id: "",
                teacher_id: "",
                photo: "",
                name: "",
                title: "",
                phone: "",
                email: "",
                office_address: "",
                office_hours: ""
            }),
            columns: [
                {
                    label: "Teacher ID",
                    name: "teacher_id",
                    columnName: "teacher_id",
                    orderable: true
                },
                {
                    label: "Photo",
                    name: "photo",
                    columnName: "photo",
                    component: PhotoIcon
                },
                {
                    label: "Name",
                    name: "name",
                    columnName: "name",
                    orderable: true
                },
                {
                    label: "Title",
                    name: "title",
                    columnName: "title",
                    orderable: true
                },
                {
                    label: "Phone",
                    name: "phone",
                    columnName: "phone",
                    orderable: true
                },
                {
                    label: "Email",
                    name: "email",
                    columnName: "email",
                    orderable: true
                },
                {
                    label: "Office Address",
                    name: "office_address",
                    columnName: "office_address",
                    orderable: true
                },
                {
                    label: "Office Hours",
                    name: "office_hours",
                    columnName: "office_hours",
                    orderable: true
                },
                {
                    label: "Courses Taught",
                    name: "course_name",
                    columnName: "course_name",
                    orderable: true,
                    component: CourseNames
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
                    handler: this.deleteTeacher,
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
        ButtonDelete,
        PhotoIcon,
        CourseNames
    },

    methods: {
        getData(url = this.url, options = this.tableProps) {
            this.fileName = "";
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

        getFileName() {
            return this.fileName.length !== 0 ? this.fileName : "Choose file";
        },

        getPhoto() {
            let photo;

            if (!this.form.photo) {
                photo = "/img/profile/default.png";
            } else if (this.form.photo.length > 128) {
                photo = this.form.photo;
            } else {
                photo = "/img/teachers/" + this.form.photo;
            }

            return photo;
        },

        defaultPhoto(e) {
            e.target.src = "/img/profile/default.png";
        },

        updatePhoto(e) {
            // change file to base64 then append to form for submit

            let photoName = document.getElementById("inputPhoto").value;
            this.fileName = photoName.split("\\").pop();

            let file = e.target.files[0];
            let reader = new FileReader();
            if (file["size"] < 2111775) {
                //change the file to base64
                reader.onloadend = file => {
                    // console.log("RESULT", reader.result);
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "File size too large. Maximum size is 2MB."
                });
            }
        },

        removePhoto(id) {
            this.$Progress.start();
            this.form
                .delete("/api/removeTeacherPhoto/" + id)
                .then(() => {
                    this.$Progress.finish();
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Picture removed.",
                        timer: "1000"
                    }).then(() => {
                        this.$Progress.finish();
                        location.reload();
                    });
                })
                .catch(errors => {
                    this.$Progress.fail();
                    let response = JSON.parse(errors.request.response);
                    Toast.fire({
                        icon: "error",
                        title: response["message"]
                    });
                });
        },

        createModal() {
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
        },

        createTeacher() {
            this.$Progress.start();
            this.form
                .post(this.url)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Teacher created."
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

        editTeacher() {
            this.$Progress.start();
            this.form
                .put(this.url + this.form.id)
                .then(() => {
                    $("#newModal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Teacher updated.",
                        timer: 1000
                    }).then(() => {
                        this.$Progress.finish();
                        location.reload();
                    });
                })
                .catch(errors => {
                    this.$Progress.fail();
                    console.log(errors);
                });
        },

        deleteTeacher(data) {
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
                            Swal.fire(
                                "Deleted!",
                                "Teacher deleted.",
                                "success"
                            );
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
