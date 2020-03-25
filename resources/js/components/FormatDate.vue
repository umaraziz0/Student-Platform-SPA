<template>
    <p>{{ data.created_at | formatDate }}</p>
</template>

<script>
export default {
    props: {
        data: {}
    }
};
</script>
