<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                }
            ]
        };
    },
    created() {
        this.getData(this.url);
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
        }
    }
};
</script>
