<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="error-page">
                    <h2 class="headline text-warning">404</h2>

                    <div class="error-content">
                        <h3>
                            <i
                                class="fas fa-exclamation-triangle text-warning"
                            ></i>
                            Page not found.
                        </h3>

                        <p>
                            We could not find the page you were looking for.
                            <br />
                            <router-link to="/home"
                                >Return to Dashboard</router-link
                            >
                        </p>
                    </div>
                    <!-- /.error-content -->
                </div>
                <!-- /.error-page -->
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
