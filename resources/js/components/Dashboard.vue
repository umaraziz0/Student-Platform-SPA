<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ items.tasks }}</h3>

                        <p>Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <router-link
                        to="/agenda/todo"
                        class="small-box-footer"
                        style=""
                    >
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ items.assignments }}</h3>

                        <p>Assignments</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <router-link
                        to="/agenda/assignments"
                        class="small-box-footer"
                        style=""
                    >
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ items.exams }}</h3>

                        <p>Exams</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <router-link
                        to="/agenda/exams"
                        class="small-box-footer"
                        style=""
                    >
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ items.events }}</h3>

                        <p>Events</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <router-link
                        to="/calendar"
                        class="small-box-footer"
                        style=""
                    >
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: "api/dashboard/",
            items: ""
        };
    },

    created() {
        this.getInfo();
    },

    methods: {
        getInfo(url = this.url) {
            axios
                .get(url)
                .then(res => {
                    this.items = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }
};
</script>
