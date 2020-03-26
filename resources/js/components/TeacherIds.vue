<template>
    <p>{{ teacherId }}</p>
</template>

<script>
export default {
    props: {
        data: {}
    },

    data() {
        return {
            teacherId: this.data.teacher_id.join(", ")
        };
    }
};
</script>
