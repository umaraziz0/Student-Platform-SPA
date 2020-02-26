<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-info">
            <h3 class="widget-user-username">Full Name</h3>
            <h5 class="widget-user-desc">Student ID</h5>
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
                  <h5 class="description-header">Computer Science and Technology</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3">
                <div class="description-block">
                  <h5 class="description-header">mu.aziz97@yahoo.com</h5>
                </div>
                <!-- /.description-block -->
              </div>
              <div class="col-sm-3">
                <div class="description-block">
                  <h5 class="description-header">+86 15851820879</h5>
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
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="studentId" class="col-sm-2 col-form-label">Student ID</label>
                    <div class="col-sm-10">
                      <input
                        type="number"
                        class="form-control"
                        id="studentId"
                        placeholder="Student ID"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputYear" class="col-sm-2 col-form-label">Year</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="inputYear" placeholder="Year" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputMajor" class="col-sm-2 col-form-label">Major</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputMajor" placeholder="Major" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input
                        type="number"
                        class="form-control"
                        id="inputPhone"
                        placeholder="Phone Number"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input
                        type="number"
                        class="form-control"
                        id="inputPassword"
                        placeholder="Password"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="photo" class="col-sm-2 col-form-label">Profile Picture</label>
                    <div class="col-sm-10">
                      <input type="file" @change="updateProfile" name="photo" class="form-input" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
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
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
