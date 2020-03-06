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
            url: "api/teachers",
            data: {},
            formData: {},
            studentId: "",
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
        this.getTeachers();
    },

    components: {
        ButtonEdit,
        ButtonDelete
    },

    methods: {
        getTeachers(
            url = this.url,
            options = this.tableProps,
            studentId = this.studentId
        ) {
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

        displayRow(data) {
            alert(`You clicked teacher ${data.id}`);
        }
    }
};
</script>
