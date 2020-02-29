<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-block btn-success" v-on:click="createModal">
                <i class="fas fa-user-plus"></i>
              </button>
              <!-- <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
              </div>-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Admin</th>
                  <th>Registered at</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.student_id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td v-if="user.is_admin">True</td>
                  <td v-else>False</td>
                  <td>{{ user.created_at | myDate}}</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-info" v-on:click="editModal(user)">
                        <i class="fas fa-edit text-white"></i>
                      </button>
                      <button type="button" class="btn btn-danger" v-on:click="deleteUser(user.id)">
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
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{ editMode ? 'Edit User' : 'Create New User'}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? editUser() : createUser()">
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
                <label for="studentId">Student ID:</label>
                <input
                  type="integer"
                  v-model="form.student_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('student_id')}"
                  id="studentId"
                  placeholder="Student ID"
                  field="student_id"
                />
                <has-error :form="form" field="student_id"></has-error>
              </div>
              <div class="form-group">
                <label for="inputEmail">Email address:</label>
                <input
                  type="email"
                  v-model="form.email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email')}"
                  id="inputEmail"
                  placeholder="Email"
                  field="email"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <label for="inputPassword">Password:</label>
                <input
                  type="password"
                  v-model="form.password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password')}"
                  id="inputPassword"
                  placeholder="Password"
                  field="password"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
              <div class="form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="isAdmin"
                  v-model="form.is_admin"
                />
                <label class="form-check-label" for="isAdmin">Admin</label>
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
      users: {},
      form: new Form({
        id: "",
        student_id: "",
        name: "",
        email: "",
        password: "",
        is_admin: false
      })
    };
  },

  methods: {
    createModal() {
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#addNew").modal("show");
    },

    editModal(user) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },

    loadUsers() {
      //Send request to fetch data of all users
      axios.get("api/user").then(({ data }) => (this.users = data.data));
    },

    createUser() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          this.form.post("api/student");
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: "User created successfully"
          });
          Fire.$emit("refresh");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },

    editUser() {
      this.$Progress.start();
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
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

    deleteUser(id) {
      Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          // Send request to delete user
          this.form
            .delete("api/user/" + id)
            .then(() => {
              this.$Progress.start();
              Swal.fire("Deleted!", "User deleted.", "success");
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
    this.loadUsers();
    Fire.$on("refresh", () => {
      this.loadUsers();
    });
    this.$Progress.finish();
  },

  mounted() {}
};
</script>
