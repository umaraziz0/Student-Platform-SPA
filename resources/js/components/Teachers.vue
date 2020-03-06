<template>
    <div class="container">
        <div class="row justify-content-center">
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
                name: "",
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
                    name: "name",
                    columnName: "name",
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
                    name: "courses_taught",
                    columnName: "courses_taught",
                    orderable: true
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
