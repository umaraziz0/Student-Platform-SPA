<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="text-center">Courses List</h2>
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
                                    class="form-control"
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
                                        v-on:click="testFunc"
                                    >
                                        <i class="fas fa-plus"> </i> Add Course
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: "api/test",
            data: {},
            tableProps: {
                search: "",
                length: 10,
                column: "course_id",
                dir: "asc"
            },
            columns: [
                {
                    label: "ID",
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
                    handler: this.displayRow,
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
                    handler: this.logRow,
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

        displayRow(data) {
            alert(`You clicked course ${data.id}`);
        },

        logRow(data) {
            console.log(`Course' ${data.id}`);
        },

        testFunc() {
            alert("all good");
        }
    }
};
</script>
