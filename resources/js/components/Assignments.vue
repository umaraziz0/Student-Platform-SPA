<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Assignments</h3>
            <div class="card-tools">
              <button
                type="button"
                class="btn btn-block btn-success"
                v-on:click="createModal"
              >New Assignment</button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Course</th>
                  <th>Due Date</th>
                  <th>Details</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="assignment in assignments" :key="assignment.id">
                  <td>{{ assignment.name }}</td>
                  <td>{{ assignment.course_name }}</td>
                  <td>{{ assignment.due_date }}</td>
                  <td>{{ assignment.details }}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info" v-on:click="editModal(assignment)">
                        <i class="fas fa-edit text-white"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger"
                        v-on:click="deleteAssignment(assignment.id)"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
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
            <h4 class="modal-title">{{ editMode ? 'Edit Assignment' : 'Create New Assignment'}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? editAssignment() : createAssignment()">
            <div class="modal-body">
              <div class="form-group">
                <label for="inputName">Name:</label>
                <input
                  type="text"
                  v-model="form.name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                  id="inputName"
                  placeholder="Name"
                  field="name"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <label for="inputCourse">Course Name:</label>
                <select
                  v-model="form.course_name"
                  class="custom-select"
                  :class="{ 'is-invalid': form.errors.has('course_name') }"
                  id="inputCourse"
                  name="course_name"
                >
                  <option value="Data Structures">Data Structures</option>
                  <option value="Algorithms">Algorithms</option>
                  <option value="Intro to Python">Intro to Python</option>
                </select>
                <has-error :form="form" field="course_name"></has-error>
              </div>
              <div class="form-group">
                <label for="inputDate">Due Date:</label>
                <input
                  type="date"
                  v-model="form.due_date"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('due_date')}"
                  id="inputDate"
                  field="due_date"
                />
                <has-error :form="form" field="due_date"></has-error>
              </div>
              <div class="form-group">
                <label for="inputDetails">Details:</label>
                <textarea
                  v-model="form.details"
                  name="details"
                  id="inputDetails"
                  placeholder="Input details"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('details') }"
                ></textarea>
                <has-error :form="form" field="details"></has-error>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button
                type="submit"
                class="btn"
                :class="{ 'btn-success': !editMode, 'btn-primary' : editMode }"
              >{{ editMode ? 'Update' : 'Create'}}</button>
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
      assignments: {},
      form: new Form({
        id: "",
        student_id: "",
        name: "",
        course_name: "",
        due_date: "",
        details: ""
      })
    };
  },

  methods: {
    loadAssignments() {
      axios
        .get("api/assignment")
        .then(({ data }) => (this.assignments = data.data));
    },

    createModal() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#newModal").modal("show");
    },

    editModal(assignment) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      $("#newModal").modal("show");
      this.form.fill(assignment);
    },

    createAssignment() {
      this.$Progress.start();
      this.form
        .post("api/assignment")
        .then(() => {
          $("#newModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Assignment created successfully"
          });
          Fire.$emit("refresh");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },

    editAssignment() {
      this.$Progress.start();
      this.form
        .put("api/assignment/" + this.form.id)
        .then(() => {
          $("#newModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Update success"
          });
          Fire.$emit("refresh");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },

    deleteAssignment(id) {
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
            .delete("api/assignment/" + id)
            .then(() => {
              this.$Progress.start();
              Swal.fire("Deleted!", "Assignment deleted.", "success");
              Fire.$emit("refresh");
              this.$Progress.finish();
            })
            .catch(() => {
              this.$Progress.fail();
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!"
              });
            });
        }
      });
    }
  },

  created() {
    this.$Progress.start();
    this.loadAssignments();
    Fire.$on("refresh", () => {
      this.loadAssignments();
    });
    this.$Progress.finish();
  }
};
</script>
