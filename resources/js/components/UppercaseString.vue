<template>
    <p>{{ data.is_admin ? "Yes" : "No" }}</p>
</template>

<script>
export default {
    props: {
        data: {}
    }
};
</script>
