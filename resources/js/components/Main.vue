<template>
    <div>
        <header-block></header-block>
        <div class="content mt-4">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import HeaderBlock from './partials/HeaderBlock';

export default {
    name: 'Main',
    components: {
        HeaderBlock
    },
    methods: {

    }
}
</script>