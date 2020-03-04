<template>
    <div class="btn-group">
        <button type="button" class="btn btn-danger" @click="click(data)">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        data: {},
        name: {},
        click: {
            type: Function,
            default: () => {}
        },
        classes: {
            type: Object,
            default: () => ({
                btn: true,
                "btn-primary": true,
                "btn-sm": true
            })
        }
    }
};
</script>
