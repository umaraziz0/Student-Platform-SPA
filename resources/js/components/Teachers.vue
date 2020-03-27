<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img
                                class="profile-user-img img-fluid img-circle"
                                src="/img/profile/default.png"
                            />
                        </div>

                        <h3 class="profile-username text-center">
                            Mohamad Aziz
                        </h3>

                        <p class="text-muted text-center">
                            Associate Professor
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Phone</b>
                                <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Courses</b>
                                <a class="float-right"
                                    >Algorithms, Data Structures</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!-- card -->
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: false,
            url: "/api/teachers/",
            data: {},
            title: "",
            photo: "",
            tableProps: {
                search: "",
                length: 10,
                column: "teacher_id",
                dir: "asc"
            },
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
                }
            ]
        };
    },
    created() {
        this.getTeachers();
    },

    components: {
        ButtonEdit,
        ButtonDelete,
        PhotoIcon,
        CourseNames
    },

    methods: {
        getTeachers(url = this.url, options = this.tableProps) {
            axios
                .get(url, {
                    params: options
                })
                .then(response => {
                    this.data = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        },

        reloadTable(tableProps) {
            this.getTeachers(this.url, tableProps);
        }
    }
};
</script>
