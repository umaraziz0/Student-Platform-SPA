<template>
  <div class="card">
    <div class="card-header p-2">
      <div class="input-group input-group-sm" style="width: 150px;">
        <input
          type="text"
          name="table_search"
          class="form-control float-right"
          placeholder="Search"
        />

        <div class="input-group-append">
          <button type="submit" class="btn btn-default">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" id="settings">
          <form class="form-horizontal">
            <div class="form-group-row">
              <div class="text-center mb-4">
                <img
                  class="img-circle elevation-2"
                  style="max-width:100%; height: 10em"
                  src="/img/me-cropped.png"
                  alt
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputName" placeholder="Name" />
              </div>
            </div>
            <div class="form-group row">
              <label for="studentId" class="col-sm-2 col-form-label">Student ID</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="studentId" placeholder="Student ID" />
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
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
