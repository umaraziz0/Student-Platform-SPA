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
        <!-- /.widget-user -->
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
