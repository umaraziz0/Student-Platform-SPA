<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-info">
            <h3 class="widget-user-username">{{ form.name }}</h3>
            <h5 class="widget-user-desc">{{ form.student_id }}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle elevation-2" src="/img/me-cropped.png" alt />
          </div>
          <div class="card-footer">
            <div class="row justify-content-center">
              <div class="col-sm-3 border-right">
                <div class="description-block">
                  <h5 class="description-header">2016</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3">
                <div class="description-block">
                  <h5 class="description-header">{{ form2.major }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3">
                <div class="description-block">
                  <h5 class="description-header">{{ form.email }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <div class="col-sm-3">
                <div class="description-block">
                  <h5 class="description-header">{{ form2.phone }}</h5>
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
      <!-- /.widget-user -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2 pl-3">Edit Profile</div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="settings">
                <form class="form-horizontal">
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input
                        type="email"
                        class="form-control"
                        id="inputEmail"
                        v-model="form.email"
                        placeholder="Email"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input
                        type="number"
                        class="form-control"
                        v-model="form2.phone"
                        id="inputPhone"
                        placeholder="Phone Number"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input
                        type="password"
                        class="form-control"
                        v-model="form.password"
                        id="inputPassword"
                        placeholder="Password"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="photo" class="col-sm-2 col-form-label">Profile Picture</label>
                    <div class="col-sm-10">
                      <input type="file" @change="updatePhoto" name="photo" class="form-input" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button
                        type="submit"
                        @click.prevent="updateInfo"
                        class="btn btn-danger"
                      >Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    infos: {
    }
    return {
      form: new Form({
        id: "",
        student_id: "",
        name: "",
        email: "",
        password: ""
      }),
      form2: new Form({
        photo: "",
        major: "",
        year: "",
        phone: ""
      })
    };
  },

  mounted() {
    console.log("Component mounted.");
  },

  methods: {
    updatePhoto(e) {
      // console.log("uploading");
      let file = e.target.files[0];
      let reader = new FileReader();
      reader.onloadend = file => {
        // console.log("RESULT", reader.result);
        this.form2.photo = reader.result;
      };
      reader.readAsDataURL(file);
    },

    updateInfo() {
      this.form.put("api/profile");
      this.form2
        .put("api/extra")
        .then(() => {})
        .catch(() => {});
    }
  },

  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
    axios.get("api/extra").then(({ data }) => this.form2.fill(data));
    // axios.get("api/profile").then(({ data }) => {this.form2.fill(data)});
  }
};
</script>
