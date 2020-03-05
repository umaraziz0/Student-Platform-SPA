<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center">Teachers</h2>
                <hr />
                <data-table
                    :data="dataTaken"
                    :columns="columnsTaken"
                    @onTablePropsChanged="reloadTable"
                >
                </data-table>
            </div>
            <div class="col-md-10">
                <h2 class="text-center">Teachers List</h2>
                <hr />
                <data-table
                    :data="data"
                    :columns="columns"
                    @onTablePropsChanged="reloadTable"
                >
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: false,
            url: "api/teacher/",
            urlTaken: "api/takenteacher/",
            data: {},
            dataTaken: {},
            formData: {},
            tableProps: {
                search: "",
                length: 10,
                column: "teacher_id",
                dir: "asc"
            },
            form: new Form({
                id: "",
                teacher_id: "",
                teacher_name: "",
                credits: "",
                teacher: ""
            }),
            columns: [
                {
                    label: "Teacher ID",
                    name: "teacher_id",
                    columnName: "teacher_id",
                    orderable: true
                },
                {
                    label: "Name",
                    name: "teacher_name",
                    columnName: "teacher_name",
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
                    label: "Take Teacher",
                    name: "take_teacher",
                    orderable: false,
                    classes: {
                        btn: true,
                        "btn-primary": true,
                        "btn-sm": true
                    },
                    event: "click",
                    handler: this.takeTeacher,
                    component: ButtonCheck
                }
            ],
            columnsTaken: [
                {
                    label: "Teacher ID",
                    name: "teacher_id",
                    columnName: "teacher_id",
                    orderable: true
                },
                {
                    label: "Name",
                    name: "teacher_name",
                    columnName: "teacher_name",
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
                    handler: this.deleteTeacher,
                    component: ButtonDelete
                }
            ]
        };
    },
    created() {
        this.getData(this.url);
        this.getDataTaken(this.urlTaken);
        this.getForm(this.url);
    },

    components: {
        ButtonCheck,
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

        getDataTaken(urlTaken = this.urlTaken, options = this.tableProps) {
            axios
                .get(urlTaken, {
                    params: options
                })
                .then(response => {
                    this.dataTaken = response.data;
                })
                // eslint-disable-next-line
                .catch(errors => {
                    //Handle Errors
                });
        },

        getForm(url = this.url) {
            axios.get(url).then(({ data }) => (this.formData = data.data));
        },

        reloadTable(tableProps) {
            this.getData(this.url, tableProps);
            this.getDataTaken(this.urlTaken, tableProps);
        },

        displayRow(data) {
            alert(`You clicked teacher ${data.id}`);
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
                        title: "Teacher created successfully"
                    });
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(errors => {
                    this.$Progress.fail();
                    console.log(errors);
                });
        },

        editModal(formData) {
            this.editMode = true;
            this.form.clear();
            this.form.reset();
            $("#newModal").modal("show");
            this.form.fill(formData);
        },

        editTeacher() {
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

        takeTeacher(formData) {
            this.form.fill(formData);
            this.form
                .post(this.urlTaken)
                .then(() => {
                    this.$Progress.start();
                    Swal.fire({
                        icon: "success",
                        title: "Teacher taken."
                    });
                    this.reloadTable();
                    this.$Progress.finish();
                })
                .catch(errors => {
                    this.$Progress.fail();
                    Swal.fire({
                        icon: "error",
                        title: "An error occurred.",
                        text: "Teacher has already been taken."
                    });
                    console.log(errors);
                });
        },

        deleteTeacher(dataTaken) {
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
                        .delete(this.urlTaken + `${dataTaken.id}`)
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
