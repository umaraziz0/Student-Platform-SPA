<template>
    <p>{{ courseName }}</p>
</template>

<script>
export default {
    props: {
        data: {}
    },

    data() {
        return {
            courseName: this.data.courses_taught.join(", ")
        };
    }
};
</script>
