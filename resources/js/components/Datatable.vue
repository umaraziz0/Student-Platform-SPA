<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Exams Table</h2>

            <div class="card-tools"></div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th
                    v-for="column in columns"
                    :key="column.id"
                    @click="$emit('sort', column.id)"
                    :class="sortKey === column.id ? (sortOrders[column.id] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                    :style="'width:'+column.width+';'+'cursor:pointer;'"
                  >{{column.label}}</th>
                </tr>
              </thead>
              <slot></slot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["columns", "sortKey", "sortOrders"]
};
</script>
