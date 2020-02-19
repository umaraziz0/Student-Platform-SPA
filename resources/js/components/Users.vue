<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#addNew">
                                <i class="fas fa-user-plus"></i>
                            </button>
                            <!-- <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <!-- <th>Student ID</th> -->
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
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td v-if="user.is_admin">True</td>
                            <td v-else>False</td>
                            <td>{{ user.created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info">
                                        <i class="fas fa-edit text-white"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger">
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create New User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form @submit.prevent="createUser">
              <div class="modal-body">
                  <div class="form-group">
                    <label for="inputName">Name:</label>
                    <input type="text" v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" id="inputName" placeholder="Name" field="name">
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail">Email address:</label>
                    <input type="email" v-model="form.email" class="form-control" :class="{ 'is-invalid': form.errors.has('email')}" id="inputEmail" placeholder="Email" field="email">
                    <has-error :form="form" field="email"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword">Password:</label>
                    <input type="password" v-model="form.password" class="form-control" :class="{ 'is-invalid': form.errors.has('password')}" id="inputPassword" placeholder="Password" field="password">
                    <has-error :form="form" field="password"></has-error>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isAdmin" v-model="form.is_admin">
                    <label class="form-check-label" for="isAdmin">Admin</label>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
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
        data (){
            return {
                users: {},
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    is_admin: false
                })
            }
        },

        methods: {
            loadUsers(){
                axios.get("api/user").then(({ data }) => (this.users = data.data));
            },

            createUser(){
                this.form.post('api/user');
            }
        },

        created() {
            this.loadUsers();
        }
    }
</script>
