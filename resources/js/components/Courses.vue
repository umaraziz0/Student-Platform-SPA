<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <data-table :data="data" :columns="columns" @onTablePropsChanged="reloadTable"></data-table>
        <tbody slot="body" slot-scope="{ data }">
          <tr :key="item.id" @click="showRowNumber(item.id)" v-for="item in data">
            <td :key="column.name" v-for="column in columns">
              <data-table-cell
                :value="item"
                :name="column.name"
                :meta="column.meta"
                :comp="column.component"
                :classes="column.classes"
              ></data-table-cell>
            </td>
          </tr>
        </tbody>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      url: "api/course",
      data: {},
      tableProps: {
        search: "",
        length: 10,
        column: "id",
        dir: "asc"
      },
      columns: [
        {
          label: "ID",
          name: "id",
          orderable: true
        },
        {
          label: "Course ID",
          name: "course_id",
          orderable: true
        },
        {
          label: "Course Name",
          name: "course_name",
          orderable: true
        },
        {
          label: "Credits",
          name: "credits",
          orderable: true
        },
        {
          label: "Teacher",
          name: "teacher",
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
          this.data.data = response.data;
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
