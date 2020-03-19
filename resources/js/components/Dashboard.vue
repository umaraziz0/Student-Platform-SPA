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
        <div class="row justify-content center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Upcoming</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="upcomingItem in upcomingItems"
                                    :key="upcomingItem.id"
                                >
                                    <td>{{ upcomingItem.name }}</td>
                                    <td>{{ upcomingItem.type }}</td>
                                    <td>
                                        {{ upcomingItem.due_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <FullCalendar
                        defaultView="upcomingWeek"
                        :plugins="calendarPlugins"
                        :header="{
                            left: 'title',
                            center: '',
                            right: 'today prev next'
                        }"
                        :events="events"
                        :views="{
                            upcomingWeek: {
                                type: 'listWeek',
                                duration: { days: 7 },
                                visibleRange: range
                            }
                        }"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {
        FullCalendar
    },

    data() {
        return {
            calendarPlugins: [listPlugin, interactionPlugin],
            url: "/api/dashboard/",
            range: "",
            items: "",
            eventExample: [
                {
                    title: "test",
                    start: "2020-03-16",
                    allDay: true
                }
            ],
            events: "",
            upcomingItems: ""
        };
    },

    created() {
        this.getInfo();
        this.dateRange();
        this.getEvents();
        this.getUpcoming();
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
        },

        dateRange() {
            var startDate = new Date();
            var endDate = new Date();

            startDate.setDate(startDate.getDate());
            endDate.setDate(startDate.getDate() + 7);

            this.range = {
                start: startDate,
                end: endDate
            };
        },

        getEvents() {
            axios
                .get("/api/calendar")
                .then(res => {
                    this.events = res.data.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },

        getUpcoming() {
            axios
                .get("/api/upcoming")
                .then(res => {
                    this.upcomingItems = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }
};
</script>
