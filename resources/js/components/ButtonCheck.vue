<template>
    <div class="btn-group">
        <button type="button" class="btn btn-success" @click="click(data)">
            <i class="fas fa-check text-white"></i>
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
                "btn-success": true
            })
        }
    }
};
</script>
